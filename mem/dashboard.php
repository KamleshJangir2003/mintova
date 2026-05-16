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

// Fetch the first row from settings table
$sql = "SELECT tele, utube FROM imaksoft_settings_social LIMIT 1";
$res = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($res);

$tele = $data['tele'] ?? "#";
$utube = $data['utube'] ?? "#";

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
    <link rel="shortcut icon" href="assets/images/favicon.ico" type="image/png" />
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
            <h4 class="title">Dashboard</h4>
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
      <div class="container-fluid content-inner pb-0">
       
         
        <div class="row pt-2">
        
          
                <div class="col-xl-12">
            <div class="row">
<div align="center" style="background:#fff;color:#000;border-radius:10px;margin:0 10px;width:95%;">
        <script src="https://widgets.coingecko.com/gecko-coin-price-marquee-widget.js"></script>
<gecko-coin-price-marquee-widget locale="en" dark-mode="true" outlined="true" coin-ids="" initial-currency="usd"></gecko-coin-price-marquee-widget></div>
<div>&nbsp;</div>
</div></div>
<?php
$userid = getMember($conn, $_SESSION['mid'], 'userid');

// Get latest investment
$sql = "SELECT package 
        FROM imaksoft_member_investment 
        WHERE userid='$userid' 
        ORDER BY id DESC 
        LIMIT 1";

$res = query($conn, $sql);
$row = mysqli_fetch_assoc($res);

$latestPackage = $row['package'] ?? "No Investment";
?>

<div class="d-flex justify-content-center"> 
  <div class="col-lg-4">
    <div class="card user-info-card" style="border-radius: 12px;">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
          <div class="d-flex align-items-center gap-2">
            <img
              src="assets/images/avatars/01.png"
              class="img-fluid avatar avatar-30 avatar-rounded"
              alt="img60"
            />
            <span class="fs-5 me-2">Your Profile</span>
          </div>
        </div>

        <div class="pt-3">
          <p class="mb-1"><strong>User ID:</strong> <?=getMember($conn,$_SESSION['mid'],'userid')?></p>

          <p class="mb-1"><strong>Name:</strong> <?=getMember($conn,$_SESSION['mid'],'name')?></p>

          <p class="mb-1"><strong>Joining Date:</strong> 
            <?=date("d M Y", strtotime(getMember($conn,$_SESSION['mid'],'date')))?>
          </p>

          <p class="mb-1"><strong>Pay Status:</strong>
            <?php
              $status = getMember($conn,$_SESSION['mid'],'paystatus');
              if($status == "A"){ echo "Paid"; }
              else if($status == "P"){ echo "Pending"; }
              else { echo "Unknown"; }
            ?>
          </p>

          <p class="mb-1"><strong>Rank:</strong>
              <?=$latestPackage?>

          </p>
        </div>
<div class="social-links mt-3 text-center">
    <a href="<?= $tele ?>" target="_blank" class="s-btn s-telegram">
        <img src="https://cdn-icons-png.flaticon.com/512/2111/2111646.png" />
        Telegram
    </a>

    <a href="<?= $utube ?>" target="_blank" class="s-btn s-youtube">
        <img src="https://cdn-icons-png.flaticon.com/512/1384/1384060.png" />
        YouTube
    </a>
</div>

      </div>
    </div>
  </div>
</div>



<style>
.user-info-card {
  border: 1px solid transparent;
  background-image: linear-gradient(#0d0d0d, #0d0d0d),
                    linear-gradient(45deg, #007bff, #00c6ff);
  background-origin: border-box;
  background-clip: padding-box, border-box;
}


.social-links {
    display: flex;
    justify-content: center;
    gap: 12px;
}

.s-btn {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    transition: 0.25s;
    border: 1px solid rgba(0,0,0,0.08);
    background: #f7f7f7;
    color: #222;
}

.s-btn img {
    width: 18px;
    height: 18px;
}

.s-btn:hover {
    transform: translateY(-2px);
    background: #fff;
    box-shadow: 0 3px 8px rgba(0,0,0,0.08);
}

/* Telegram theme */
.s-telegram:hover {
    border-color: #0088cc;
    color: #0088cc;
}

/* YouTube theme */
.s-youtube:hover {
    border-color: #ff0000;
    color: #ff0000;
}

</style>




        <div class="col-xl-12">
            <div class="row">
                

                
                 <div class="col-lg-4">
                    <div class="card shining-card">
                      <div class="card-body">
                        <div
                          class="d-flex justify-content-between align-items-center"
                        >
                          <div class="d-flex align-items-center gap-2">
                            <img
                              src="assets/images/coins/01.png"
                              class="img-fluid avatar avatar-30 avatar-rounded"
                              alt="img60"
                            />
                            <span class="fs-5 me-2">Direct Income</span>
                            <svg
                              width="36"
                              height="35"
                              viewBox="0 0 36 35"
                              fill="none"
                              xmlns="http://www.w3.org/2000/svg"
                            >
                              <path
                                d="M3.86124 21.6224L11.2734 16.8577C11.6095 16.6417 12.041 16.6447 12.3718 16.8655L18.9661 21.2663C19.2968 21.4871 19.7283 21.4901 20.0644 21.2741L27.875 16.2534"
                                stroke="#1aa053"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                              />
                              <path
                                d="M26.7847 13.3246L31.6677 14.0197L30.4485 18.7565L26.7847 13.3246ZM30.2822 19.4024C30.2823 19.4023 30.2823 19.4021 30.2824 19.402L30.2822 19.4024ZM31.9991 14.0669L31.9995 14.0669L32.0418 13.7699L31.9995 14.0669C31.9994 14.0669 31.9993 14.0669 31.9991 14.0669Z"
                                fill="#1aa053"
                                stroke="#1aa053"
                              />
                            </svg>
                            </div></div>
                          
                        <div class="pt-3">
                          <h4 class="counter" style="visibility: visible">
                            $ <?=getDirectBonusMember($conn,$userid)?>
                          </h4>
                          <div class="pt-3">
                            <small class="text-success">+ 0.8%</small>
                            <small class="ms-2">(Lifetime Earnings)</small>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
        

                  <div class="col-lg-4">
                    <div class="card shining-card">
                      <div class="card-body">
                        <div
                          class="d-flex justify-content-between align-items-center"
                        >
                          <div class="d-flex align-items-center gap-2">
                            <img
                              src="assets/images/coins/01.png"
                              class="img-fluid avatar avatar-30 avatar-rounded"
                              alt="img60"
                            />
                            <span class="fs-5 me-2">Daily Income</span>
                            <svg
                              width="36"
                              height="35"
                              viewBox="0 0 36 35"
                              fill="none"
                              xmlns="http://www.w3.org/2000/svg"
                            >
                              <path
                                d="M3.86124 21.6224L11.2734 16.8577C11.6095 16.6417 12.041 16.6447 12.3718 16.8655L18.9661 21.2663C19.2968 21.4871 19.7283 21.4901 20.0644 21.2741L27.875 16.2534"
                                stroke="#1aa053"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                              />
                              <path
                                d="M26.7847 13.3246L31.6677 14.0197L30.4485 18.7565L26.7847 13.3246ZM30.2822 19.4024C30.2823 19.4023 30.2823 19.4021 30.2824 19.402L30.2822 19.4024ZM31.9991 14.0669L31.9995 14.0669L32.0418 13.7699L31.9995 14.0669C31.9994 14.0669 31.9993 14.0669 31.9991 14.0669Z"
                                fill="#1aa053"
                                stroke="#1aa053"
                              />
                            </svg>
                            </div></div>
                          
                        <div class="pt-3">
                          <h4 class="counter" style="visibility: visible">
                            $ <?=getROIBonus($conn,$userid)?>
                          </h4>
                          <div class="pt-3">
                            <small class="text-success">+ 0.8%</small>
                            <small class="ms-2">(Lifetime Earnings)</small>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="card shining-card">
                      <div class="card-body">
                        <div
                          class="d-flex justify-content-between align-items-center"
                        >
                          <div class="d-flex align-items-center gap-2">
                            <img
                              src="assets/images/coins/01.png"
                              class="img-fluid avatar avatar-30 avatar-rounded"
                              alt="img60"
                            />
                            <span class="fs-5 me-2">Level Income</span>
                            <svg
                              width="36"
                              height="35"
                              viewBox="0 0 36 35"
                              fill="none"
                              xmlns="http://www.w3.org/2000/svg"
                            >
                              <path
                                d="M3.86124 21.6224L11.2734 16.8577C11.6095 16.6417 12.041 16.6447 12.3718 16.8655L18.9661 21.2663C19.2968 21.4871 19.7283 21.4901 20.0644 21.2741L27.875 16.2534"
                                stroke="#1aa053"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                              />
                              <path
                                d="M26.7847 13.3246L31.6677 14.0197L30.4485 18.7565L26.7847 13.3246ZM30.2822 19.4024C30.2823 19.4023 30.2823 19.4021 30.2824 19.402L30.2822 19.4024ZM31.9991 14.0669L31.9995 14.0669L32.0418 13.7699L31.9995 14.0669C31.9994 14.0669 31.9993 14.0669 31.9991 14.0669Z"
                                fill="#1aa053"
                                stroke="#1aa053"
                              />
                            </svg>
                            </div></div>
                          
                        <div class="pt-3">
                          <h4 class="counter" style="visibility: visible">
                            $ <?=getLevelROIBonus($conn,$userid)?>
                          </h4>
                          <div class="pt-3">
                            <small class="text-success">+ 0.8%</small>
                            <small class="ms-2">(Lifetime Earnings)</small>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>


  <div class="col-lg-4">
                    <div class="card shining-card">
                      <div class="card-body">
                        <div
                          class="d-flex justify-content-between align-items-center"
                        >
                          <div class="d-flex align-items-center gap-2">
                            <img
                              src="assets/images/coins/01.png"
                              class="img-fluid avatar avatar-30 avatar-rounded"
                              alt="img60"
                            />
                            <span class="fs-5 me-2">Reward Income</span>
                            <svg
                              width="36"
                              height="35"
                              viewBox="0 0 36 35"
                              fill="none"
                              xmlns="http://www.w3.org/2000/svg"
                            >
                              <path
                                d="M3.86124 21.6224L11.2734 16.8577C11.6095 16.6417 12.041 16.6447 12.3718 16.8655L18.9661 21.2663C19.2968 21.4871 19.7283 21.4901 20.0644 21.2741L27.875 16.2534"
                                stroke="#1aa053"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                              />
                              <path
                                d="M26.7847 13.3246L31.6677 14.0197L30.4485 18.7565L26.7847 13.3246ZM30.2822 19.4024C30.2823 19.4023 30.2823 19.4021 30.2824 19.402L30.2822 19.4024ZM31.9991 14.0669L31.9995 14.0669L32.0418 13.7699L31.9995 14.0669C31.9994 14.0669 31.9993 14.0669 31.9991 14.0669Z"
                                fill="#1aa053"
                                stroke="#1aa053"
                              />
                            </svg>
                            </div></div>
                          
                        <div class="pt-3">
                          <h4 class="counter" style="visibility: visible">
                            $ <?=getRewardddBonus($conn,$userid)?>
                          </h4>
                          <div class="pt-3">
                            <small class="text-success">+ 0.8%</small>
                            <small class="ms-2">(Lifetime Earnings)</small>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                 

                  <div class="col-lg-4">
                    <div class="card shining-card">
                      <div class="card-body">
                        <div
                          class="d-flex justify-content-between align-items-center"
                        >
                          <div class="d-flex align-items-center gap-2">
                            <img
                              src="assets/images/coins/01.png"
                              class="img-fluid avatar avatar-30 avatar-rounded"
                              alt="img60"
                            />
                            <span class="fs-5 me-2">Total Income</span>
                            <svg
                              width="36"
                              height="35"
                              viewBox="0 0 36 35"
                              fill="none"
                              xmlns="http://www.w3.org/2000/svg"
                            >
                              <path
                                d="M3.86124 21.6224L11.2734 16.8577C11.6095 16.6417 12.041 16.6447 12.3718 16.8655L18.9661 21.2663C19.2968 21.4871 19.7283 21.4901 20.0644 21.2741L27.875 16.2534"
                                stroke="#1aa053"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                              />
                              <path
                                d="M26.7847 13.3246L31.6677 14.0197L30.4485 18.7565L26.7847 13.3246ZM30.2822 19.4024C30.2823 19.4023 30.2823 19.4021 30.2824 19.402L30.2822 19.4024ZM31.9991 14.0669L31.9995 14.0669L32.0418 13.7699L31.9995 14.0669C31.9994 14.0669 31.9993 14.0669 31.9991 14.0669Z"
                                fill="#1aa053"
                                stroke="#1aa053"
                              />
                            </svg>
                            </div></div>
                          
                        <div class="pt-3">
                          <h4 class="counter" style="visibility: visible">
                            $ <?=geTotalCommission($conn,$userid)?>
                          </h4>
                          <div class="pt-3">
                            <small class="text-success">+ 0.8%</small>
                            <small class="ms-2">(Lifetime Earnings)</small>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  
                

                  <div class="col-lg-4">
                    <div class="card shining-card">
                      <div class="card-body">
                        <div
                          class="d-flex justify-content-between align-items-center"
                        >
                          <div class="d-flex align-items-center gap-2">
                            <img
                              src="assets/images/coins/01.png"
                              class="img-fluid avatar avatar-30 avatar-rounded"
                              alt="img60"
                            />
                            <span class="fs-5 me-2">Current Balance</span>
                            <svg
                              width="36"
                              height="35"
                              viewBox="0 0 36 35"
                              fill="none"
                              xmlns="http://www.w3.org/2000/svg"
                            >
                              <path
                                d="M3.86124 21.6224L11.2734 16.8577C11.6095 16.6417 12.041 16.6447 12.3718 16.8655L18.9661 21.2663C19.2968 21.4871 19.7283 21.4901 20.0644 21.2741L27.875 16.2534"
                                stroke="#1aa053"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                              />
                              <path
                                d="M26.7847 13.3246L31.6677 14.0197L30.4485 18.7565L26.7847 13.3246ZM30.2822 19.4024C30.2823 19.4023 30.2823 19.4021 30.2824 19.402L30.2822 19.4024ZM31.9991 14.0669L31.9995 14.0669L32.0418 13.7699L31.9995 14.0669C31.9994 14.0669 31.9993 14.0669 31.9991 14.0669Z"
                                fill="#1aa053"
                                stroke="#1aa053"
                              />
                            </svg>
                            </div></div>
                          
                        <div class="pt-3">
                          <h4 class="counter" style="visibility: visible">
                            $ <?=getAvailableFundWallet($conn,$userid)?>
                          </h4>
                          <div class="pt-3">
                            <small class="text-success">+ 0.8%</small>
                            <small class="ms-2">(Lifetime Earnings)</small>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  
                <div class="card overflow-hidden project-card shining-card card">
<div class="card-body" >
            <label>Your refferal link</label>
            <div class="input-group mb-3">
              <input
                type="text"
                id="refer-link"
                class="form-control copy-text border-primary"
                value="<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$base = rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/');
echo $protocol . '://' . $host . $base . '/ref?spon=' . getMember($conn,$_SESSION['mid'],'userid');
?>"
                placeholder="referallink.com/refer"
                aria-label="Recipient's username"
                aria-describedby="basic-addon2"
                readonly
              />
              <button
                type="button"
                class="input-group-text copy cmn-btn border-primary"
                id="basic-addon2"
              >
                Copy
              </button>
            </div>
          </div></div>
          </div></div>
</div>


               <div class="main-panel">
<div class="content">
<div class="page-inner">
<div class="row">




    <?php
$sqlc="SELECT * FROM `imaksoft_announcement` ORDER BY `id` DESC LIMIT 1";
$resc=query($conn,$sqlc);
$numc=numrows($resc);
if($numc>0)
{
$fetchc=fetcharray($resc);
?>
<!-- Include Font Awesome if not already included -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="row">
  <div style="background:#E0F0FF; color:#000; padding:10px; border-radius:10px; margin:0 10px; width:100%; display: flex; align-items: center;">
    
    <!-- Fixed Microphone Icon -->
    <div style="margin-right: 10px; font-size: 18px;">
      <i class="fas fa-volume-up"></i>
    </div>
    
    <!-- Scrolling Announcement Text -->
    <div style="flex: 1;">
      <marquee behavior="scroll" scrollamount="3">
        <?=stripslashes($fetchc['announcement'])?>
      </marquee>
    </div>
    
  </div>
</div>
</div>


<?php }?>

 <script>
      "use strict";
      var copyButton = document.querySelector(".copy");
      var copyInput = document.querySelector(".copy-text");
      copyButton.addEventListener("click", function (e) {
        e.preventDefault();
        var text = copyInput.select();
        document.execCommand("copy");
      });
      copyInput.addEventListener("click", function () {
        this.select();
      });
    </script>
                  
<br><br><br>

                  <div class="col-xl-12 col-lg-12 col-sm-12">
            <div class="card" style="height: 510px;">
                  <!-- TradingView Widget BEGIN -->
<div class="tradingview-widget-container" style="background-color: #000000;">
  <div class="tradingview-widget-container__widget"></div>
  <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-forex-heat-map.js" async>
  {
    "width": "100%",
    "height": "100%",
    "currencies": [
      "EUR",
      "USD",
      "JPY",
      "GBP",
      "CHF",
      "AUD",
      "CAD",
      "NZD",
      "CNY"
    ],
    "isTransparent": false,
    "colorTheme": "dark",
    "locale": "in",
    "backgroundColor": "#000000"
  }
  </script>
</div>
<!-- TradingView Widget END -->

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
