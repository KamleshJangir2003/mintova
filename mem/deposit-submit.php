<?php
session_start();
include('../admin/inc/function.php');
if(!isset($_SESSION['mid'])) redirect('../index');

if($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('deposit');

$userid     = mysqli_real_escape_string($conn, trim($_POST['userid']));
$amount     = floatval($_POST['amount']);
$tranid     = mysqli_real_escape_string($conn, trim($_POST['tranid']));
$date       = date('Y-m-d');
$screenshot = '';

if($amount <= 0) redirect('deposit?e=1');

// Upload screenshot
if(isset($_FILES['screenshot']) && $_FILES['screenshot']['error'] == 0) {
    $ext     = strtolower(pathinfo($_FILES['screenshot']['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','gif','webp'];
    if(in_array($ext, $allowed)) {
        $filename = 'ss_' . time() . '_' . $userid . '.' . $ext;
        move_uploaded_file($_FILES['screenshot']['tmp_name'], __DIR__ . '/uploads/screenshots/' . $filename);
        $screenshot = $filename;
    }
}

// Check duplicate tranid
$chk = $conn->prepare("SELECT id FROM mi_member_payment WHERE tranid=?");
$chk->bind_param("s", $tranid);
$chk->execute();
$chk->store_result();
if($chk->num_rows > 0) redirect('deposit?dup=1');

// Get admin wallet address
$qr_res = $conn->query("SELECT wallet_address FROM imaksoft_settings_qr LIMIT 1");
$qr     = $qr_res ? $qr_res->fetch_assoc() : null;
$admin_wallet = $qr['wallet_address'] ?? '';

// -------------------------------------------------------
// TRON BLOCKCHAIN VERIFY via TronScan API
// -------------------------------------------------------
$verified = false;
$verify_note = 'Pending manual review';

if(!empty($tranid) && !empty($admin_wallet)) {
    $api_url = "https://apilist.tronscanapi.com/api/transaction-info?hash=" . urlencode($tranid);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);

    if($response) {
        $data = json_decode($response, true);

        // TronScan returns contractData for TRC20 transfers
        if(
            isset($data['contractData']) &&
            isset($data['contractType']) &&
            $data['contractType'] == 31  // TRC20 Transfer
        ) {
            $to_address   = $data['contractData']['to_address']   ?? '';
            $token_symbol = $data['tokenInfo']['tokenAbbr']        ?? '';
            $raw_amount   = floatval($data['contractData']['amount'] ?? 0);
            $decimals     = intval($data['tokenInfo']['tokenDecimal'] ?? 6);
            $tx_amount    = $raw_amount / pow(10, $decimals);
            $confirmed    = $data['confirmed'] ?? false;

            // Check: correct wallet, USDT, correct amount, confirmed
            if(
                strtolower($to_address)   == strtolower($admin_wallet) &&
                strtoupper($token_symbol) == 'USDT' &&
                $confirmed == true &&
                abs($tx_amount - $amount) < 0.01  // allow 0.01 tolerance
            ) {
                $verified    = true;
                $verify_note = 'Blockchain Verified';
            } else {
                $verify_note = 'Verification Failed: amount/address/token mismatch';
            }
        } else {
            $verify_note = 'Not a valid TRC20 USDT transaction';
        }
    } else {
        $verify_note = 'API unreachable - pending manual review';
    }
}

// -------------------------------------------------------
// Save record
// -------------------------------------------------------
$status = $verified ? 'C' : 'P';

$stmt = $conn->prepare("INSERT INTO mi_member_payment (userid, tranid, slip, amount, status, verify_note, date) VALUES (?,?,?,?,?,?,?)");
$stmt->bind_param("sssdsss", $userid, $tranid, $screenshot, $amount, $status, $verify_note, $date);
if(!$stmt->execute()) redirect('deposit?e=1');

// If verified, credit wallet immediately
if($verified) {
    $conn->query("INSERT INTO imaksoft_deposit (userid, amount, remarks, date) 
                  VALUES ('$userid', '$amount', 'USDT Deposit - $verify_note', '$date')");
    redirect('deposit?s=1&auto=1');
} else {
    redirect('deposit?s=1&pending=1');
}
?>
