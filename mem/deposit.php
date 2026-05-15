<?php
session_start();
include('../admin/inc/function.php');
if(!isset($_SESSION['mid']))
{
redirect('../index');
}
$userid=getMember($conn,$_SESSION['mid'],'userid');
include('calculate-roi-release.php');

$left=2;
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <title><?=$title?></title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" />
    <link rel="stylesheet" href="assets/css/core/libs.min.css" />
    <link rel="stylesheet" href="assets/css/coinex.min.css?v=1.0.0" />
    <link rel="stylesheet" href="assets/css/custom.min.css?v=1.0.0" /><link href="https://fonts.googleapis.com/css2?family=Outfit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  </head>
  <body class=" ">

<style>
    body {
    font-family: 'Outfit', sans-serif;
}

</style>



<?php include('sidebar.php') ?>
   
    <main class="main-content">
      <div class="position-relative">
        <!--Nav Start-->
        <nav
          class="nav navbar navbar-expand-lg navbar-light iq-navbar border-bottom pb-lg-3 pt-lg-3"
        >
          <div class="container-fluid navbar-inner">
            <a href="dashboard" class="navbar-brand"> </a>
            <div
              class="sidebar-toggle"
              data-toggle="sidebar"
              data-active="true"
            >
              <i class="icon">
                <svg width="20px" height="20px" viewBox="0 0 24 24">
                  <path
                    fill="currentColor"
                    d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z"
                  />
                </svg>
              </i>
            </div>
            <h4 class="title">Deposit</h4>
            <button
              class="navbar-toggler"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent"
              aria-expanded="false"
              aria-label="Toggle navigation"
            >
              <span class="navbar-toggler-icon">
                <span class="navbar-toggler-bar bar1 mt-2"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul
                class="navbar-nav ms-auto navbar-list mb-2 mb-lg-0 align-items-center"
              >
                
               
                <li class="nav-item dropdown">
                  <a
                    class="nav-link py-0 d-flex align-items-center"
                    href="#"
                    id="navbarDropdown"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                  >
                    <img
                      src="assets/images/avatars/01.png"
                      alt="User-Profile"
                      class="img-fluid avatar avatar-50 avatar-rounded"
                    />
                  </a>
                  <ul
                    class="dropdown-menu dropdown-menu-end"
                    aria-labelledby="navbarDropdown"
                  >
                    <li class="border-0">
                      <a
                        class="dropdown-item"
                        href="edit?case=profile"
                        >Edit Profile</a
                      >
                    </li>
                    <li class="border-0">
                      <a
                        class="dropdown-item"
                        href="edit?case=password"
                        >Change password</a
                      >
                    </li>
                    <li class="border-0">
                      <hr class="m-0 dropdown-divider" />
                    </li>
                    <li class="border-0">
                      <a
                        class="dropdown-item"
                        href="logout"
                        >Logout</a
                      >
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </nav>
        <!--Nav End-->
      </div>
      <div class="container-fluid content-inner pb-0">
       
        <div class="row pt-2">
          
        
<div class="main-panel">
<div class="content">
<div class="page-inner">

<div class="row">
<div class="col-md-2"></div>
<div class="col-md-8">

<div class="card">
<div class="card-header">
<div class="card-title">Deposit Fund</div>
</div>
<div class="card-body">
<br>
                   <?php if(($_REQUEST['s'] ?? null) == 1): ?>
    <?php if(($_REQUEST['auto'] ?? null) == 1): ?>
        <div class="alert alert-success text-center" role="alert" style="border-radius: 12px;">✅ Deposit Verified & Approved! Amount credited to your wallet.</div>
    <?php elseif(($_REQUEST['pending'] ?? null) == 1): ?>
        <div class="alert alert-warning text-center" role="alert" style="border-radius: 12px;">⏳ Deposit submitted. Transaction could not be auto-verified. Admin will review shortly.</div>
    <?php else: ?>
        <div class="alert alert-success text-center" role="alert" style="border-radius: 12px;">Your Deposit was submitted successfully!</div>
    <?php endif; ?>
<?php endif; ?>

 <?php if(($_REQUEST['p'] ?? null) == 2) { ?>
 <div class="alert alert-danger text-center" role="alert" style="border-radius: 12px;">Payment Failed!</div>
<?php } ?>

 <?php if(($_REQUEST['PR'] ?? null) == 1) { ?>
  <div class="alert alert-danger text-center" role="alert" style="border-radius: 12px;">Payment is under processing!</div>
<?php } ?>

 <?php if(($_REQUEST['dup'] ?? null) == 1) { ?>
  <div class="alert alert-danger text-center" role="alert" style="border-radius: 12px;">Duplicate Transaction ID! Already submitted.</div>
<?php } ?>

<!-- USDT TRC20 Warning -->
<div class="alert alert-danger border border-danger" role="alert" style="border-radius: 8px; border-left: 4px solid #dc3545;">
    <div class="d-flex align-items-center">
        <i class="fas fa-exclamation-triangle me-3 fa-lg"></i>
        <div>
            <h6 class="alert-heading mb-1"><strong>IMPORTANT: USDT TRC20 DEPOSIT ONLY</strong></h6>
            <p class="mb-0">
                • Deposit <strong>EXACTLY</strong> the amount you enter below<br>
                • Use <strong>ONLY USDT TRC20</strong> network for deposits<br>
                • Any other cryptocurrency or network will result in <strong>PERMANENT LOSS</strong><br>
                • Company is <strong>NOT RESPONSIBLE</strong> for wrong deposits
            </p>
        </div>
    </div>
</div>

<?php
$qr_res = $conn->query("SELECT * FROM imaksoft_settings_qr LIMIT 1");
$qr = $qr_res ? $qr_res->fetch_assoc() : null;
?>

<?php if(($_REQUEST['e'] ?? null) == 1): ?>
<div class="alert alert-danger text-center" role="alert" style="border-radius: 12px;">❌ Something went wrong. Please try again.</div>
<?php endif; ?>

<div id="step1">
<input type="number" step="0.01" id="enterAmount" class="form-control mb-3 border-warning" placeholder="Enter Amount (USDT)" min="1">
<button class="btn btn-warning w-100" onclick="showQR()">Proceed to Pay</button>
</div>

<div id="step2" style="display:none;">
<div class="text-center mb-3">
    <p class="mb-1"><strong>Send exactly <span id="showAmt" class="text-warning"></span> USDT (TRC20) to:</strong></p>
    <?php if($qr && $qr['qr_image']): ?>
    <img src="../admin/uploads/qr/<?=htmlspecialchars($qr['qr_image'])?>" style="width:200px;height:200px;border:2px solid #ffc107;" class="mb-2"><br>
    <?php endif; ?>
    <div class="input-group mb-2">
        <input type="text" class="form-control" id="walletAddr" value="<?=htmlspecialchars($qr['wallet_address'] ?? '')?>" readonly>
        <button class="btn btn-outline-warning" onclick="copyAddr()">Copy</button>
    </div>
</div>
<form method="post" action="deposit-submit" enctype="multipart/form-data">
    <input type="hidden" name="userid" value="<?=$userid?>">
    <input type="hidden" name="amount" id="hiddenAmt">
    <div class="mb-3">
        <label class="form-label">Transaction ID / UTR No.</label>
        <input type="text" name="tranid" class="form-control" placeholder="Enter Transaction ID" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Upload Payment Screenshot</label>
        <input type="file" name="screenshot" class="form-control" accept="image/*" required>
    </div>
    <button type="submit" class="btn btn-success w-100">Submit for Approval</button>
</form>
</div>

<script>
function showQR() {
    let amt = parseFloat(document.getElementById('enterAmount').value);
    if (isNaN(amt) || amt <= 0) { alert('Enter valid amount'); return; }
    document.getElementById('showAmt').innerText = amt.toFixed(2);
    document.getElementById('hiddenAmt').value = amt.toFixed(2);
    document.getElementById('step1').style.display = 'none';
    document.getElementById('step2').style.display = 'block';
}
function copyAddr() {
    let addr = document.getElementById('walletAddr');
    addr.select(); document.execCommand('copy'); alert('Address copied!');
}
</script>
</div>

</div>
</div>

</div>
</div>
</div>


<div class="main-panel">
<div class="content">
<div class="page-inner">

<div class="row">

<div class="col-md-12">

<div class="card">
<div class="card-header"  >
<div class="card-title">View Statement</div>
</div>
<div class="card-body" style="overflow:auto;">
<?php

// Define pagination settings
$limit = 100;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Get current user's ID
$userid = getMember($conn, $_SESSION['mid'], 'userid');

// Query to fetch data securely using prepared statements
$query = "SELECT amount,status, date FROM transaction WHERE userid = ? ORDER BY id DESC LIMIT ?, ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("sii", $userid, $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();
?>
<table class="table table-bordered table-striped">
<thead>
<tr >
<th align="center">Sl_No</th>
<th align="center">Amount</th>
<th align="center">Status</th>
<th align="center">Date</th>
</tr>
</thead>
<tbody>
  <?php
                    $i = $offset + 1; // Start serial number correctly
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$i}</td>
                                    <td>$ {$row['amount']}</td>
                                    <td>{$row['status']}</td>
                                    <td>{$row['date']}</td>
                                  </tr>";
                            $i++;
                        }
                    } else {
                        echo '<tr><td colspan="3" class="text-danger">No Record Found!</td></tr>';
                    }
                    ?>
</tbody>
</table>

<div align="center"><?=$pagination ?? ''?></div>
</div>

</div>
</div>
</div>
</div>
</div>
</div>

                 
    </main>

    <!-- Wrapper End-->
    <!-- offcanvas start -->

    <!-- Backend Bundle JavaScript -->
    <script src="assets/js/core/libs.min.js"></script>
    <script src="assets/js/core/external.min.js"></script>

    <!-- widgetchart JavaScript -->
    <script src="assets/js/charts/widgetcharts.js"></script>

    <!-- GSAP Animation JS-->
    <script src="assets/vendor/gsap/gsap.min.js"></script>
    <script src="assets/vendor/gsap/ScrollTrigger.min.js"></script>

    <!-- fslightbox JavaScript -->
    <script src="assets/js/fslightbox.js"></script>

    <!-- Mapchart JavaScript -->
    <script src="assets/js/charts/vector-chart.js"></script>
    <script src="assets/js/charts/dashboard.js"></script>

    <!-- app JavaScript -->
    <script src="assets/js/coinex.js"></script>

    <!-- apexchart JavaScript -->
    <script src="assets/js/charts/apexcharts.js"></script>

    <!-- Gsap Animation Init -->
    <script src="assets/js/gsap.js"></script>
  </body>
</html>
