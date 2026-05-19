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

<!-- Network Warning -->
<div class="alert alert-danger border border-danger" role="alert" style="border-radius: 8px; border-left: 4px solid #dc3545;">
    <div class="d-flex align-items-center">
        <i class="fas fa-exclamation-triangle me-3 fa-lg"></i>
        <div>
            <h6 class="alert-heading mb-1"><strong>IMPORTANT: USDT DEPOSIT ONLY</strong></h6>
            <p class="mb-0">
                • Deposit <strong>EXACTLY</strong> the amount you enter below<br>
                • Use <strong>ONLY USDT TRC20 or BEP20</strong> network<br>
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

<div class="mb-3">
    <label class="form-label fw-bold">Select Network</label>
    <div class="d-flex gap-3">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="networkSelect" id="netTRC20" value="trc20" checked>
            <label class="form-check-label" for="netTRC20">USDT TRC20 (TRON)</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="networkSelect" id="netBEP20" value="bep20">
            <label class="form-check-label" for="netBEP20">USDT BEP20 (BSC)</label>
        </div>
    </div>
</div>

<button class="btn btn-warning w-100" onclick="showQR()">Proceed to Pay</button>
</div>

<div id="step2" style="display:none;">
<div class="text-center mb-3">
    <p class="mb-1"><strong>Send exactly <span id="showAmt" class="text-warning"></span> USDT (<span id="showNetwork"></span>) to:</strong></p>
    <img id="qrImg" src="" style="width:200px;height:200px;border:2px solid #ffc107;display:none;" class="mb-2"><br>
    <div class="input-group mb-2">
        <input type="text" class="form-control" id="walletAddr" value="" readonly>
        <button class="btn btn-outline-warning" type="button" onclick="copyAddr()">Copy</button>
    </div>
</div>

<!-- Auto detection status -->
<div id="payStatus" class="alert alert-warning text-center mt-3" style="border-radius:12px;">
    <div class="spinner-border spinner-border-sm text-warning me-2" role="status"></div>
    <span id="payMsg">⏳ Waiting for your payment... (auto detecting)</span>
</div>

<div class="text-center mt-2">
    <small class="text-muted">Payment will be detected automatically within 1-2 minutes after blockchain confirmation.</small>
</div>

<button class="btn btn-secondary w-100 mt-3" onclick="cancelPayment()">Cancel / Go Back</button>
</div>

<script>
var trc20Wallet = "<?=htmlspecialchars($qr['wallet_address'] ?? '')?>";
var trc20QR     = "<?=!empty($qr['qr_image']) ? '../admin/uploads/qr/'.htmlspecialchars($qr['qr_image']) : ''?>";
var bep20Wallet = "<?=htmlspecialchars($qr['bep20_wallet_address'] ?? '')?>";
var bep20QR     = "<?=!empty($qr['bep20_qr_image']) ? '../admin/uploads/qr/'.htmlspecialchars($qr['bep20_qr_image']) : ''?>";
var pollTimer   = null;
var pollCount   = 0;
var maxPolls    = 60; // 10 min max (60 x 10s)
var currentAmt  = 0;
var currentNet  = '';

function showQR() {
    let amt = parseFloat(document.getElementById('enterAmount').value);
    if (isNaN(amt) || amt <= 0) { alert('Enter valid amount'); return; }
    let net = document.querySelector('input[name="networkSelect"]:checked').value;
    let wallet = net === 'bep20' ? bep20Wallet : trc20Wallet;
    let qrSrc  = net === 'bep20' ? bep20QR     : trc20QR;
    if(!wallet) { alert('This network is not configured yet. Please contact admin.'); return; }
    currentAmt = amt;
    currentNet = net;
    document.getElementById('showAmt').innerText = amt.toFixed(2);
    document.getElementById('showNetwork').innerText = net === 'bep20' ? 'BEP20' : 'TRC20';
    document.getElementById('walletAddr').value = wallet;
    let qrEl = document.getElementById('qrImg');
    if(qrSrc) { qrEl.src = qrSrc; qrEl.style.display = 'inline-block'; } else { qrEl.style.display = 'none'; }
    document.getElementById('step1').style.display = 'none';
    document.getElementById('step2').style.display = 'block';
    pollCount = 0;
    startPolling();
}

function startPolling() {
    pollTimer = setInterval(checkPayment, 10000);
    checkPayment(); // immediate first check
}

function checkPayment() {
    pollCount++;
    if(pollCount > maxPolls) {
        clearInterval(pollTimer);
        document.getElementById('payStatus').className = 'alert alert-danger text-center mt-3';
        document.getElementById('payMsg').innerHTML = '❌ Payment not detected in 10 minutes. Please contact support.';
        return;
    }
    fetch('check-payment', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'amount=' + currentAmt + '&network=' + currentNet
    })
    .then(r => r.json())
    .then(data => {
        if(data.status === 'success' || data.status === 'already') {
            clearInterval(pollTimer);
            document.getElementById('payStatus').className = 'alert alert-success text-center mt-3';
            document.getElementById('payMsg').innerHTML = '✅ Payment Verified & Approved! Redirecting...';
            setTimeout(() => { window.location.href = 'deposit?s=1&auto=1'; }, 2000);
        } else if(data.status === 'waiting') {
            document.getElementById('payMsg').innerHTML = '⏳ Waiting for payment... (check #' + pollCount + ')';
        } else {
            document.getElementById('payMsg').innerHTML = '⚠️ ' + (data.msg || 'Checking...');
        }
    })
    .catch(() => {
        document.getElementById('payMsg').innerHTML = '⏳ Checking... (attempt #' + pollCount + ')';
    });
}

function cancelPayment() {
    clearInterval(pollTimer);
    document.getElementById('step2').style.display = 'none';
    document.getElementById('step1').style.display = 'block';
    document.getElementById('enterAmount').value = '';
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

$query = "SELECT amount, remarks AS status, date FROM imaksoft_deposit WHERE userid = ? ORDER BY id DESC LIMIT ?, ?";
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
<th align="center">Remarks</th>
<th align="center">Date</th>
</tr>
</thead>
<tbody>
  <?php
                    $i = $offset + 1;
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle;"><polygon points="12 2 2 19 22 19"/><line x1="12" y1="2" x2="12" y2="19"/><line x1="2" y1="19" x2="12" y2="10"/><line x1="22" y1="19" x2="12" y2="10"/></svg>';
                            echo "<tr>
                                    <td>{$i}</td>
                                    <td>{$svg} {$row['amount']}</td>
                                    <td>{$row['status']}</td>
                                    <td>{$row['date']}</td>
                                  </tr>";
                            $i++;
                        }
                    } else {
                        echo '<tr><td colspan="4" class="text-danger">No Record Found!</td></tr>';
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
