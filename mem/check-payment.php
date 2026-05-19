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

// Convert base58 wallet to hex for comparison
function tron_base58_to_hex($address) {
    $alphabet = '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz';
    $base = strlen($alphabet);
    $bytes = [0];
    for($i = 0; $i < strlen($address); $i++) {
        $char = strpos($alphabet, $address[$i]);
        $carry = $char;
        for($j = count($bytes)-1; $j >= 0; $j--) {
            $carry += $base * $bytes[$j];
            $bytes[$j] = $carry % 256;
            $carry = intdiv($carry, 256);
        }
        while($carry > 0) {
            array_unshift($bytes, $carry % 256);
            $carry = intdiv($carry, 256);
        }
    }
    // Remove checksum (last 4 bytes)
    $bytes = array_slice($bytes, 0, count($bytes) - 4);
    $hex = '';
    foreach($bytes as $b) $hex .= str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
    return $hex;
}

$wallet_hex = tron_base58_to_hex($trc20_wallet);

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

    $to_hex     = $contract['parameter']['value']['to_address'] ?? '';
    $trx_amount = floatval($contract['parameter']['value']['amount'] ?? 0) / 1000000;
    $tranid     = $tx['txID'] ?? '';
    $tx_time    = intval(($tx['raw_data']['timestamp'] ?? 0) / 1000);
    $ret_code   = $tx['ret'][0]['contractRet'] ?? '';

    // Compare hex addresses
    if(strtolower($to_hex) !== strtolower($wallet_hex)) continue;
    if($ret_code !== 'SUCCESS') continue;
    if((time() - $tx_time) > 900) continue; // only last 15 minutes
    if(abs($trx_amount - $amount) >= 0.5) continue; // 0.5 TRX tolerance

    // Check duplicate by tranid
    $chk = $conn->prepare("SELECT id FROM mi_member_payment WHERE tranid=? LIMIT 1");
    $chk->bind_param("s", $tranid);
    $chk->execute();
    $chk->store_result();
    if($chk->num_rows > 0) {
        echo json_encode(['status'=>'success','msg'=>'Already processed']);
        exit;
    }
    $chk->close();

    // Save + credit using INSERT IGNORE to prevent race condition
    $verify_note = 'Auto Verified - TRON';
    $status      = 'C';
    $screenshot  = '';
    $stmt = $conn->prepare("INSERT IGNORE INTO mi_member_payment (userid, tranid, slip, network, amount, status, verify_note, date) VALUES (?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssdsss", $userid, $tranid, $screenshot, $network, $amount, $status, $verify_note, $date);
    $stmt->execute();

    // Only credit if row was actually inserted (affected_rows = 1)
    if($stmt->affected_rows === 1) {
        $conn->query("INSERT INTO imaksoft_deposit (userid, amount, remarks, date) VALUES ('$userid', '$amount', 'TRX Deposit - Auto Verified - TRON', '$date')");
        $conn->query("UPDATE imaksoft_member SET paystatus='A', status='A' WHERE userid='$userid' AND paystatus='I'");
    }

    echo json_encode(['status'=>'success','msg'=>'TRX Payment verified!','amount'=>$trx_amount,'hash'=>$tranid]);
    exit;
}

echo json_encode(['status'=>'waiting','msg'=>'Waiting for TRX payment...']);
