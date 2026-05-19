<?php
session_start();
include('../admin/inc/function.php');
if(!isset($_SESSION['mid'])) { echo json_encode(['status'=>'error','msg'=>'Not logged in']); exit; }

header('Content-Type: application/json');

$userid     = getMember($conn, $_SESSION['mid'], 'userid');
$amount     = floatval($_POST['amount'] ?? 0);
$start_time = intval($_POST['start_time'] ?? 0);
$network    = 'trc20';
$date       = date('Y-m-d');

if($amount <= 0) { echo json_encode(['status'=>'error','msg'=>'Invalid amount']); exit; }

$qr_res = $conn->query("SELECT * FROM imaksoft_settings_qr LIMIT 1");
$qr = $qr_res ? $qr_res->fetch_assoc() : null;
$trc20_wallet = trim($qr['wallet_address'] ?? '');

if(empty($trc20_wallet)) {
    echo json_encode(['status'=>'error','msg'=>'Wallet not configured']);
    exit;
}

$trc20_wallet = preg_replace('/[^A-Za-z0-9]/', '', $trc20_wallet); // remove any hidden chars

if(strlen($trc20_wallet) < 30) {
    echo json_encode(['status'=>'error','msg'=>'Wallet address invalid: ' . $trc20_wallet]);
    exit;
}

// TronGrid API - fetch last 20 confirmed incoming transactions
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL            => "https://api.trongrid.io/v1/accounts/{$trc20_wallet}/transactions?limit=20&only_confirmed=true&only_to=true",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT        => 15,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_USERAGENT      => 'Mozilla/5.0',
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_HTTPHEADER     => ['Accept: application/json', 'TRON-PRO-API-KEY: 4fb6fd9d-7473-4d9d-8672-7e437f946cf2'],
]);
$res = curl_exec($ch);
$err = curl_error($ch);
curl_close($ch);

if($err || !$res) {
    echo json_encode(['status'=>'waiting','msg'=>'API error, retrying...']);
    exit;
}

$data = json_decode($res, true);

if(isset($data['success']) && $data['success'] === false) {
    echo json_encode(['status'=>'waiting','msg'=>'API: ' . ($data['error'] ?? 'Unknown error')]);
    exit;
}

$txs = $data['data'] ?? [];

foreach($txs as $tx) {
    $contract = $tx['raw_data']['contract'][0] ?? null;
    if(!$contract) continue;
    if(($contract['type'] ?? '') !== 'TransferContract') continue;

    $value      = $contract['parameter']['value'] ?? [];
    $trx_amount = floatval($value['amount'] ?? 0) / 1000000;
    $tranid     = $tx['txID'] ?? '';
    $tx_time    = intval(($tx['raw_data']['timestamp'] ?? 0) / 1000);
    $ret_code   = $tx['ret'][0]['contractRet'] ?? '';

    if($ret_code !== 'SUCCESS') continue;
    if($start_time > 0 && $tx_time < $start_time) continue; // only after user clicked Proceed to Pay
    if((time() - $tx_time) > 900) continue; // only last 15 minutes
    if(abs($trx_amount - $amount) >= 0.5) continue;

    // Check duplicate
    $chk = $conn->prepare("SELECT id FROM mi_member_payment WHERE tranid=? LIMIT 1");
    $chk->bind_param("s", $tranid);
    $chk->execute();
    $chk->store_result();
    if($chk->num_rows > 0) {
        echo json_encode(['status'=>'success','msg'=>'Already processed']);
        exit;
    }
    $chk->close();

    // Insert with IGNORE to prevent race condition
    $verify_note = 'Auto Verified - TRON';
    $status      = 'C';
    $screenshot  = '';
    $stmt = $conn->prepare("INSERT IGNORE INTO mi_member_payment (userid, tranid, slip, network, amount, status, verify_note, date) VALUES (?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssdsss", $userid, $tranid, $screenshot, $network, $amount, $status, $verify_note, $date);
    $stmt->execute();

    if($stmt->affected_rows === 1) {
        $conn->query("INSERT INTO imaksoft_deposit (userid, amount, remarks, date) VALUES ('$userid', '$amount', 'TRX Deposit - Auto Verified - TRON', '$date')");
        $conn->query("UPDATE imaksoft_member SET paystatus='A', status='A' WHERE userid='$userid' AND paystatus='I'");
    }

    echo json_encode(['status'=>'success','msg'=>'TRX Payment verified!','amount'=>$trx_amount,'hash'=>$tranid]);
    exit;
}

echo json_encode(['status'=>'waiting','msg'=>'Waiting for TRX payment...']);
