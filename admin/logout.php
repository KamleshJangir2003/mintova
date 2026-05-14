<?php
session_start();
include('inc/function.php');
unset($_SESSION['sid']);
session_destroy();

redirect('index');
?>