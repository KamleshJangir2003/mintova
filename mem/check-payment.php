<?php
session_start();
include('../admin/inc/function.php');
if(!isset($_SESSION['mid'])) { echo json_encode(['status'=>'error','msg'=>'Not logged in']); exit; }

header('Content-Type: application/json');

$userid  = getMember($conn, $_SESSION['mid'], 'userid');
$amount  = floatval($_POST['amount'] ?? 0);
$network = 'trc20'; // TRX only
$date    = date('Y-m-d');

if($amount <= 0) { echo json_encode(['status'=>'error','msg'=>'Invalid amount']); exit; }

$qr_res = $conn->query("SELECT * FROM imaksoft_settings_qr LIMIT 1");
$qr = $qr_res ? $qr_res->fetch_assoc() : null;
$trc20_wallet = $qr['wallet_address'] ?? '';

if(empty($trc20_wallet)) {
    echo json_encode(['status'=>'error','msg'=>'Wallet not configured']);
    exit;
}

// ── TRX Native Transfer Detection via TronGrid ─────────────────────────────
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL            => "https://api.trongrid.io/v1/accounts/{$trc20_wallet}/transactions?limit=20&only_confirmed=true&only_to=true",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 15,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_USERAGENT      => 'Mozilla/5.0',
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_HTTPHEADER     => ['Accept: application/json'],
]);
$res = curl_exec($ch);
$err = curl_error($ch);
curl_close($ch);

if($err || !$res) {
    echo json_encode(['status'=>'waiting','msg'=>'API error, retrying...']);
    exit;
}

$data = json_decode($res, true);
$txs  = $data['data'] ?? [];

foreach($txs as $tx) {
    // Only TransferContract (native TRX transfer)
    $contract = $tx['raw_data']['contract'][0] ?? null;
    if(!$contract) continue;
    if(($contract['type'] ?? '') !== 'TransferContract') continue;

    $to_address = $contract['parameter']['value']['to_address'] ?? '';
    $trx_amount = floatval($contract['parameter']['value']['amount'] ?? 0) / 1000000; // sun to TRX
    $tranid     = $tx['txID'] ?? '';
    $tx_time    = intval(($tx['raw_data']['timestamp'] ?? 0) / 1000);
    $ret_code   = $tx['ret'][0]['contractRet'] ?? '';

    // Only successful confirmed TRX to our wallet in last 24 hours
    if(strtolower($to_address) !== strtolower($trc20_wallet)) continue;
    if($ret_code !== 'SUCCESS') continue;
    if((time() - $tx_time) > 86400) continue;
    if(abs($trx_amount - $amount) >= 0.5) continue; // 0.5 TRX tolerance

    // Check duplicate
    $chk = $conn->prepare("SELECT id FROM mi_member_payment WHERE tranid=?");
    $chk->bind_param("s", $tranid);
    $chk->execute();
    $chk->store_result();
    if($chk->num_rows > 0) {
        echo json_encode(['status'=>'already','msg'=>'Already processed']);
        exit;
    }

    // Save + credit
    $verify_note = 'Auto Verified - TRX';
    $status      = 'C';
    $screenshot  = '';
    $stmt = $conn->prepare("INSERT INTO mi_member_payment (userid, tranid, slip, network, amount, status, verify_note, date) VALUES (?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssdsss", $userid, $tranid, $screenshot, $network, $amount, $status, $verify_note, $date);
    $stmt->execute();

    $conn->query("INSERT INTO imaksoft_deposit (userid, amount, remarks, date) VALUES ('$userid', '$amount', 'TRX Deposit - Auto Verified', '$date')");
    $conn->query("UPDATE imaksoft_member SET paystatus='A', status='A' WHERE userid='$userid' AND paystatus='I'");

    echo json_encode(['status'=>'success','msg'=>'TRX Payment verified!','amount'=>$trx_amount,'hash'=>$tranid]);
    exit;
}

echo json_encode(['status'=>'waiting','msg'=>'Waiting for TRX payment...']);
