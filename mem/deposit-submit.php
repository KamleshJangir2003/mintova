<?php
session_start();
include('../admin/inc/function.php');
if(!isset($_SESSION['mid'])) redirect('../index');

if($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('deposit');

$userid     = mysqli_real_escape_string($conn, trim($_POST['userid']));
$amount     = floatval($_POST['amount']);
$tranid     = mysqli_real_escape_string($conn, trim($_POST['tranid']));
$network    = in_array($_POST['network'] ?? '', ['trc20','bep20']) ? $_POST['network'] : 'trc20';
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

// Get admin wallet addresses
$qr_res = $conn->query("SELECT * FROM imaksoft_settings_qr LIMIT 1");
$qr           = $qr_res ? $qr_res->fetch_assoc() : null;
$trc20_wallet = $qr['wallet_address'] ?? '';
$bep20_wallet = $qr['bep20_wallet_address'] ?? '';

$verified    = false;
$verify_note = 'Pending Admin Approval (' . strtoupper($network) . ')';

// -------------------------------------------------------
// TRC20 - TronScan API
// -------------------------------------------------------
if($network === 'trc20' && !empty($tranid) && !empty($trc20_wallet)) {
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL             => "https://apilist.tronscanapi.com/api/transaction-info?hash=" . urlencode($tranid),
        CURLOPT_RETURNTRANSFER  => true,
        CURLOPT_TIMEOUT         => 15,
        CURLOPT_FOLLOWLOCATION  => true,
        CURLOPT_USERAGENT       => 'Mozilla/5.0',
        CURLOPT_SSL_VERIFYPEER  => false,
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    if($response) {
        $data = json_decode($response, true);

        // Correct fields from actual TronScan API response
        $transfer     = $data['trc20TransferInfo'][0] ?? null;
        $contractType = $data['contractType'] ?? 0;
        $confirmed    = $data['confirmed'] ?? false;
        $contractRet  = $data['contractRet'] ?? '';

        if($transfer && $contractType == 31 && $contractRet === 'SUCCESS') {
            $to_address   = $transfer['to_address'] ?? '';
            $token_symbol = $transfer['symbol']     ?? '';
            $raw_amount   = floatval($transfer['amount_str'] ?? 0);
            $decimals     = intval($transfer['decimals']     ?? 6);
            $tx_amount    = $raw_amount / pow(10, $decimals);
            // confirmed can be bool true OR int 1 from TronScan
            $is_confirmed = !empty($confirmed);

            if(
                strtolower($to_address)   == strtolower($trc20_wallet) &&
                strtoupper($token_symbol) == 'USDT' &&
                $is_confirmed &&
                abs($tx_amount - $amount) < 0.01
            ) {
                $verified    = true;
            $verify_note = 'Auto Verified - TRON';
            } else {
                $verify_note = 'TRC20 Mismatch - Pending Admin Approval';
            }
        } else {
            $verify_note = 'Invalid TRC20 TX - Pending Admin Approval';
        }
    }
    // if curl fails, $verify_note stays as 'Pending Admin Approval'
}

// -------------------------------------------------------
// BEP20 - BSCScan API
// -------------------------------------------------------
elseif($network === 'bep20' && !empty($tranid) && !empty($bep20_wallet)) {
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL             => "https://api.bscscan.com/api?module=proxy&action=eth_getTransactionByHash&txhash=" . urlencode($tranid),
        CURLOPT_RETURNTRANSFER  => true,
        CURLOPT_TIMEOUT         => 15,
        CURLOPT_FOLLOWLOCATION  => true,
        CURLOPT_USERAGENT       => 'Mozilla/5.0',
        CURLOPT_SSL_VERIFYPEER  => false,
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    if($response) {
        $data = json_decode($response, true);
        $tx   = $data['result'] ?? null;

        if($tx && strtolower($tx['hash']) === strtolower($tranid)) {
            // Get receipt for confirmation status
            $ch2 = curl_init();
            curl_setopt_array($ch2, [
                CURLOPT_URL             => "https://api.bscscan.com/api?module=proxy&action=eth_getTransactionReceipt&txhash=" . urlencode($tranid),
                CURLOPT_RETURNTRANSFER  => true,
                CURLOPT_TIMEOUT         => 15,
                CURLOPT_FOLLOWLOCATION  => true,
                CURLOPT_USERAGENT       => 'Mozilla/5.0',
                CURLOPT_SSL_VERIFYPEER  => false,
            ]);
            $receipt_resp = curl_exec($ch2);
            curl_close($ch2);

            $receipt   = json_decode($receipt_resp, true);
            $confirmed = (($receipt['result']['status'] ?? '0x0') === '0x1');

            // USDT BEP20 contract address on BSC
            $usdt_contract = '0x55d398326f99059ff775485246999027b3197955';
            $to_contract   = strtolower($tx['to'] ?? '');

            if($confirmed && $to_contract === $usdt_contract) {
                $input = $tx['input'] ?? '';
                if(strlen($input) >= 138 && substr($input, 0, 10) === '0xa9059cbb') {
                    $to_hex    = '0x' . substr($input, 34, 40);
                    $amt_hex   = ltrim(substr($input, 74, 64), '0') ?: '0';
                    // Convert large hex to decimal safely using bcmath
                    $amt_dec   = '0';
                    $hex_chars = str_split($amt_hex);
                    foreach($hex_chars as $c) {
                        $amt_dec = bcadd(bcmul($amt_dec, '16'), (string)hexdec($c));
                    }
                    $tx_amount = bcdiv($amt_dec, bcpow('10', '18'), 8);

                    if(
                        strtolower($to_hex) == strtolower($bep20_wallet) &&
                        abs((float)$tx_amount - $amount) < 0.01
                    ) {
                        $verified    = true;
                        $verify_note = 'Auto Verified - BEP20';
                    } else {
                        $verify_note = 'BEP20 Mismatch - Pending Admin Approval';
                    }
                } else {
                    $verify_note = 'Invalid BEP20 TX - Pending Admin Approval';
                }
            } else {
                $verify_note = 'BEP20 Not Confirmed - Pending Admin Approval';
            }
        } else {
            $verify_note = 'BEP20 TX Not Found - Pending Admin Approval';
        }
    }
    // if curl fails, $verify_note stays as 'Pending Admin Approval'
}

// -------------------------------------------------------
// Save record
// -------------------------------------------------------
$status = $verified ? 'C' : 'P';

$stmt = $conn->prepare("INSERT INTO mi_member_payment (userid, tranid, slip, amount, status, verify_note, date) VALUES (?,?,?,?,?,?,?)");
$stmt->bind_param("sssdsss", $userid, $tranid, $screenshot, $amount, $status, $verify_note, $date);
if(!$stmt->execute()) redirect('deposit?e=1');

// Auto verified - credit wallet immediately
if($verified) {
    $remarks = 'TRX Deposit - ' . $verify_note;
    $conn->query("INSERT INTO imaksoft_deposit (userid, amount, remarks, date) VALUES ('$userid', '$amount', '$remarks', '$date')");
    $conn->query("UPDATE imaksoft_member SET paystatus='A', status='A' WHERE userid='$userid' AND paystatus='I'");
    redirect('deposit?s=1&auto=1');
} else {
    redirect('deposit?s=1&pending=1');
}
?>
