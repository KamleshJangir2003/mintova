<?php
session_start();
include('inc/function.php');
if(!isset($_SESSION['sid'])) redirect('index');

if($_REQUEST['case'] == 'delete') {
    $sql = "DELETE FROM `mi_member_payment` WHERE `id`='".mysqli_real_escape_string($conn,$_REQUEST['id'])."'";
    query($conn, $sql);
    redirect('request');
}

if($_REQUEST['case'] == 'status') {
    $id = (int)$_REQUEST['id'];
    $row = fetcharray(query($conn, "SELECT * FROM mi_member_payment WHERE id='$id'"));

    if($row['status'] == 'P') {
        // Approve: status='C' se getPaymentApproved() wallet mein count hoga automatically
        $conn->query("UPDATE mi_member_payment SET status='C' WHERE id='$id'");
    } else {
        $conn->query("UPDATE mi_member_payment SET status='P' WHERE id='$id'");
    }
    redirect('request');
}
?>
