<?php
session_start();
include('inc/function.php');
if(!isset($_SESSION['sid'])) redirect('index');

// Auto-add BEP20 columns if not exist
$conn->query("ALTER TABLE imaksoft_settings_qr ADD COLUMN IF NOT EXISTS bep20_wallet_address varchar(255) NOT NULL DEFAULT '' AFTER qr_image");
$conn->query("ALTER TABLE imaksoft_settings_qr ADD COLUMN IF NOT EXISTS bep20_qr_image varchar(255) NOT NULL DEFAULT '' AFTER bep20_wallet_address");

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $wallet      = mysqli_real_escape_string($conn, trim($_POST['wallet_address']));
    $bep20_wallet = mysqli_real_escape_string($conn, trim($_POST['bep20_wallet_address'] ?? ''));
    $existing    = fetcharray(query($conn, "SELECT * FROM imaksoft_settings_qr LIMIT 1"));
    $qr_image    = $existing['qr_image'] ?? '';
    $bep20_qr    = $existing['bep20_qr_image'] ?? '';

    // TRC20 QR upload
    if(isset($_FILES['qr_image']) && $_FILES['qr_image']['error'] == 0) {
        $ext = strtolower(pathinfo($_FILES['qr_image']['name'], PATHINFO_EXTENSION));
        if(in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
            $filename = 'qr_trc20_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['qr_image']['tmp_name'], __DIR__ . '/uploads/qr/' . $filename);
            $qr_image = $filename;
        }
    }

    // BEP20 QR upload
    if(isset($_FILES['bep20_qr_image']) && $_FILES['bep20_qr_image']['error'] == 0) {
        $ext = strtolower(pathinfo($_FILES['bep20_qr_image']['name'], PATHINFO_EXTENSION));
        if(in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
            $filename = 'qr_bep20_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['bep20_qr_image']['tmp_name'], __DIR__ . '/uploads/qr/' . $filename);
            $bep20_qr = $filename;
        }
    }

    if($existing) {
        $conn->query("UPDATE imaksoft_settings_qr SET 
            wallet_address='$wallet', qr_image='$qr_image',
            bep20_wallet_address='$bep20_wallet', bep20_qr_image='$bep20_qr'
            WHERE id='{$existing['id']}'");
    } else {
        $conn->query("INSERT INTO imaksoft_settings_qr (wallet_address, qr_image, bep20_wallet_address, bep20_qr_image) 
                      VALUES ('$wallet', '$qr_image', '$bep20_wallet', '$bep20_qr')");
    }
    redirect('settings?inc=qr&m=1');
}
redirect('settings?inc=qr');
?>
