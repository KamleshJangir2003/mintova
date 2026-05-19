<?php
session_start();
include('../admin/inc/function.php');
if(!isset($_SESSION['mid']))
{
redirect('../index');
}
$userid=getMember($conn,$_SESSION['mid'],'userid');
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
            <h4 class="title">Income</h4>
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
          
       
<?php if(($_REQUEST['inc'] ?? '')==='roi'){?>
<div class="main-panel">
<div class="content">
<div class="page-inner">

<div class="row">

<div class="col-md-12">

<div class="card">
<div class="card-header"  >
<div class="card-title">Roi Income Statement</div>
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
$query = "SELECT bonus, date FROM imaksoft_commission_roi WHERE userid = ? AND status = 'R' ORDER BY id DESC LIMIT ?, ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("sii", $userid, $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();
?>
<table class="table table-bordered table-striped">
<thead>
<tr >
<th>Sl_No.</th>
<th>Bonus</th>
<th>Date</th>
</tr>
</thead>
<tbody>
  <?php
                    $i = $offset + 1; // Start serial number correctly
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle;"><polygon points="12 2 2 19 22 19"/><line x1="12" y1="2" x2="12" y2="19"/><line x1="2" y1="19" x2="12" y2="10"/><line x1="22" y1="19" x2="12" y2="10"/></svg>';

                            echo "<tr>
                                    <td>{$i}</td>
                                    <td>{$svg} {$row['bonus']}</td>
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


<?php }else if(($_REQUEST['inc'] ?? '')==='direct'){?>

<div class="main-panel">
<div class="content">
<div class="page-inner">

<div class="row">

<div class="col-md-12">

<div class="card">
<div class="card-header"  >
<div class="card-title">Direct Income Statement</div>
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
$query = "SELECT bonus, date FROM imaksoft_commission_direct WHERE userid = ? ORDER BY id DESC LIMIT ?, ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("sii", $userid, $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();
?>
<table class="table table-bordered table-striped">
<thead>
<tr >
<th>Sl_No.</th>
<th>Bonus</th>
<th>Date</th>
</tr>
</thead>
<tbody>
  <?php
                    $i = $offset + 1; // Start serial number correctly
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle;"><polygon points="12 2 2 19 22 19"/><line x1="12" y1="2" x2="12" y2="19"/><line x1="2" y1="19" x2="12" y2="10"/><line x1="22" y1="19" x2="12" y2="10"/></svg>';

                            echo "<tr>
                                    <td>{$i}</td>
                                    <td>{$svg} {$row['bonus']}</td>
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




<?php }else if(($_REQUEST['inc'] ?? '')==='levelroi'){?>
<div class="main-panel">
<div class="content">
<div class="page-inner">

<div class="row">

<div class="col-md-12">

<div class="card">
<div class="card-header"  >
<div class="card-title">Level Roi Income Statement</div>
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
$query = "SELECT fromid, bonus, date, level FROM imaksoft_commission_level_roi WHERE userid = ? ORDER BY id DESC LIMIT ?, ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("sii", $userid, $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();
?>
<table class="table table-bordered table-striped">
<thead>
<tr>
<th>Sl_No.</th>
<th>From_ID</th>
<th>Level</th>
<th>Bonus</th>
<th>Date</th>
</tr>
</thead>
<tbody>
<?php
                    $i = $offset + 1; // Start serial number correctly
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle;"><polygon points="12 2 2 19 22 19"/><line x1="12" y1="2" x2="12" y2="19"/><line x1="2" y1="19" x2="12" y2="10"/><line x1="22" y1="19" x2="12" y2="10"/></svg>';

                            echo "<tr>
                                    <td>{$i}</td>
                                    <td>{$row['fromid']}</td>
                                    <td>{$row['level']}</td>
                                    <td>{$svg} {$row['bonus']}</td>
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
</div>
<div align="center"><?=$pagination ?? ''?></div>
</div>
</div>
</div>
</div>
</div>
</div>



<?php }else if(($_REQUEST['inc'] ?? '')==='task'){?>
<div class="main-panel">
    <div class="content">
        <div class="page-inner">

            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Task Income Statement</div>
                        </div>

                        <div class="card-body" style="overflow:auto;">

<?php
// ===================== COLLECT HANDLER ======================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['collect_task'])) {

    $task_key = trim(mysqli_real_escape_string($conn, $_POST['collect_task']));
    $amount   = floatval($_POST['collect_amount'] ?? 0);
    $userid   = getMember($conn, $_SESSION['mid'], 'userid');

    // Prevent duplicate
    $chk = "SELECT id FROM imaksoft_task_collection WHERE userid='$userid' AND task_key='$task_key' LIMIT 1";
    $rchk = query($conn, $chk);

    if (numrows($rchk) == 0) {
        $ins = "INSERT INTO imaksoft_task_collection (userid, task_key, amount) 
                VALUES ('$userid', '$task_key', '$amount')";
        query($conn, $ins);
    }

    // SAFE RELOAD (no header error)
    echo "<script>window.location.href = window.location.pathname + window.location.search;</script>";
exit;

}

// ===================== PREPARE DATA ==========================
$userid = getMember($conn, $_SESSION['mid'], 'userid');
$approved_date = getMember($conn, $_SESSION['mid'], 'approved');
$startDateFormatted = date("d M Y", strtotime($approved_date));
$today = date('Y-m-d');

function addDaysRaw($date, $days) { return date("Y-m-d", strtotime("$date +$days days")); }
function addDaysPretty($date, $days) { return date("d M Y", strtotime("$date +$days days")); }

// Directs count
$activeDirects = getNoOfActiveSponsor($conn, $userid);

// Count direct sponsorees by their latest package
function getDirectsWithPackageCount($conn, $userid, $packageName) {
    $sql = "
      SELECT COUNT(DISTINCT m.userid) AS total
      FROM imaksoft_member m
      JOIN imaksoft_member_investment inv ON inv.userid = m.userid
      WHERE m.sponsor = '$userid'
        AND inv.id = (SELECT id FROM imaksoft_member_investment ii 
                      WHERE ii.userid = m.userid ORDER BY ii.id DESC LIMIT 1)
        AND inv.package = '$packageName'
    ";
    $res = query($conn, $sql);
    $r = fetcharray($res);
    return intval($r['total']);
}

// Already collected rewards
$collectedMap = [];
$rc = query($conn, "SELECT task_key FROM imaksoft_task_collection WHERE userid='$userid'");
while ($row = fetcharray($rc)) $collectedMap[$row['task_key']] = true;

// ================= TASKS =================
$tasks = [
    ['key'=>'t1_10any',        'label'=>'10 DIRECT (ANY AMOUNT)', 'days'=>7,  'amount'=>50,   'target'=>10, 'type'=>'direct'],

    ['key'=>'t2_7silver',      'label'=>'7 SILVER DIRECT',        'days'=>7,  'amount'=>100,  'target'=>7,  'type'=>'package','package'=>'Silver'],

    ['key'=>'t3_5gold',        'label'=>'5 GOLD DIRECT',          'days'=>7,  'amount'=>250,  'target'=>5,  'type'=>'package','package'=>'Gold'],

    ['key'=>'t4_5platinum',    'label'=>'5 PLATINUM DIRECT',      'days'=>15, 'amount'=>399,  'target'=>5,  'type'=>'package','package'=>'Platinum'],

    ['key'=>'t5_20diamond',    'label'=>'20 DIAMOND WITH ALL LEVELS INCLUDING',
                               'days'=>30,'amount'=>1000,'target'=>20,'type'=>'package','package'=>'Diamond'],

    ['key'=>'t6_50stardiamond','label'=>'50 STAR DIAMOND WITH ALL LEVELS INCLUDING',
                               'days'=>70,'amount'=>1750,'target'=>50,'type'=>'package','package'=>'Star Diamond'],
];

// Build package count & achievement
$packageAchievedAny = false;
$packageAchievedMap = [];

foreach ($tasks as $t) {
    if ($t['type'] === 'package') {
        $count = getDirectsWithPackageCount($conn, $userid, $t['package']);
        $achieved = ($count >= $t['target']);
        $packageAchievedMap[$t['key']] = ['achieved'=>$achieved, 'count'=>$count];
        if ($achieved) $packageAchievedAny = true;
    }
}

// Direct task achieved?
$directAchieved = ($activeDirects >= $tasks[0]['target']);

// Rule: If any package task achieved, disable t1 reward
if ($packageAchievedAny) $directAchieved = false;

?>

<table class="table table-bordered table-striped" style="width:100%; text-align:center;">
    <thead style="background:#0a0f87; color:#fff; font-weight:bold;">
        <tr>
            <th>SI. NO.</th>
            <th>TASK</th>
            <th>START DATE</th>
            <th>END DATE</th>
            <th>DAYS LEFT</th>
            <th>STATUS</th>
            <th>ACHIEVED</th>
            <th>ACTION</th>
        </tr>
    </thead>

    <tbody>
<?php
$si = 1;
foreach ($tasks as $t):

    $endDate = addDaysRaw($approved_date, $t['days']);
    $endPretty = addDaysPretty($approved_date, $t['days']);

    $diff = (strtotime($endDate) - strtotime($today)) / 86400;
    $daysLeft = ($diff >= 0) ? intval($diff) : 0;
    $status = ($diff < 0) ? "Expired" : "Active";

    // Determine achievement
    if ($t['type'] === 'direct') {
        $achieved = $directAchieved ? "YES" : "NO";
        $count = $activeDirects;
    } else {
        $m = $packageAchievedMap[$t['key']];
        $achieved = $m['achieved'] ? "YES" : "NO";
        $count = $m['count'];
    }

    $collected = !empty($collectedMap[$t['key']]);

?>
<tr>
    <td><?= $si ?></td>
    <td><?= $t['label'] ?></td>
    <td><?= $startDateFormatted ?></td>
    <td><?= $endPretty ?></td>
    <td><?= $daysLeft ?></td>
    <td style="color:<?= ($status=='Expired'?'red':'green') ?>;font-weight:bold;">
        <?= $status ?>
    </td>

    <!-- Achieved -->
    <td style="font-weight:bold;color:<?= ($achieved=='YES'?'green':'#d9534f') ?>;">
        <?= $achieved ?><br>
        <small><?= $count ?>/<?= $t['target'] ?>
            <?= ($t['type']=='direct'?'directs':$t['package'].' directs') ?>
        </small>
    </td>

    <!-- ACTION -->
    <td>
        <?php if ($collected): ?>

            <span style="background:#e9ecef;padding:6px 10px;border-radius:6px;">Collected</span>

        <?php elseif ($achieved == "YES"): ?>

            <form method="post" style="display:inline-block;">
                <input type="hidden" name="collect_task" value="<?= $t['key'] ?>">
                <input type="hidden" name="collect_amount" value="<?= $t['amount'] ?>">
                <button class="btn btn-sm btn-success">
                    Collect $<?= number_format($t['amount'],2) ?>
                </button>
            </form>

        <?php else: ?>

            <span style="color:#777;">Not achieved</span>

        <?php endif; ?>
    </td>
</tr>

<?php
$si++;
endforeach;
?>
    </tbody>
</table>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


<?php }?>
                 
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
