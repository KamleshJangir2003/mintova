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
            <h4 class="title">Investment</h4>
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
          
    <?php if(($_REQUEST['case'] ?? '')==='new'){?>
    
    
<?php if(($_REQUEST['e'] ?? null)==1){?>
    <div class="alert alert-danger text-center" role="alert" style="border-radius: 12px;">Invalid investment amount!</div>
<?php }?>
<?php if(($_REQUEST['e'] ?? null)==3){?>
    <div class="alert alert-danger text-center" role="alert" style="border-radius: 12px;">Insufficient funds in your wallet!</div>
<?php }?>
<?php if(($_REQUEST['e'] ?? null)==4){?>
    <div class="alert alert-danger text-center" role="alert" style="border-radius: 12px;">Amount not within package limits!</div>
<?php }?>
<?php if(($_REQUEST['e'] ?? null)==5){?>
    <div class="alert alert-danger text-center" role="alert" style="border-radius: 12px;">Payment deduction failed!</div>
<?php }?>
<?php if(($_REQUEST['e'] ?? null)==6){?>
    <div class="alert alert-danger text-center" role="alert" style="border-radius: 12px;">Investment failed! Please try again.</div>
<?php }?>
<?php if(($_REQUEST['m'] ?? null)==2){?>
    <div class="alert alert-success text-center" role="alert" style="border-radius: 12px;">Investment successful! Daily returns will be credited to your wallet.</div>
<?php }?>

   <style>
    :root {
        --primary: #ff6b00;
        --secondary: #6c757d;
        --success: #ff8c00;
        --info: #ffa500;
        --warning: #ffc107;
        --danger: #ff4500;
        --dark: #212529;
        --light: #f8f9fa;
        --orange-dark: #e65c00;
        --orange-medium: #ff7700;
        --orange-light: #ff9447;
        --orange-glow: #ffaa33;
    }
    
    .crypto-card {
        background: rgba(30, 41, 59, 0.7);
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }
    
    .crypto-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(255, 107, 0, 0.2);
        border-color: rgba(255, 107, 0, 0.4);
    }
    
    .package-header {
        background: linear-gradient(135deg, var(--orange-dark), var(--orange-medium));
        padding: 20px;
        text-align: center;
        color: white;
    }
    
    .package-rank {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 5px;
    }
    
    .package-range {
        font-size: 1.1rem;
        opacity: 0.9;
    }
    
    .package-body {
        padding: 20px;
    }
    
    .package-details {
        margin-bottom: 20px;
    }
    
    .detail-item {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .detail-label {
        color: #94a3b8;
    }
    
    .detail-value {
        font-weight: 600;
        color: white;
    }
    
    .roi-badge {
        background: linear-gradient(135deg, var(--orange-medium), var(--orange-light));
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
        box-shadow: 0 4px 12px rgba(255, 119, 0, 0.3);
    }
    
    .invest-btn {
        background: linear-gradient(135deg, var(--orange-medium), var(--orange-light));
        border: none;
        color: white;
        padding: 12px;
        border-radius: 8px;
        font-weight: 600;
        width: 100%;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(255, 119, 0, 0.3);
    }
    
    .invest-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 119, 0, 0.5);
        background: linear-gradient(135deg, var(--orange-light), var(--orange-glow));
    }
    
    .bonus-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: linear-gradient(135deg, #ff8c00, #ff6b00);
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(255, 140, 0, 0.4);
    }
    
    .modal-content {
        background: rgba(30, 41, 59, 0.95);
        border-radius: 16px;
        border: 1px solid rgba(255, 107, 0, 0.3);
        backdrop-filter: blur(10px);
        color: #e2e8f0;
        box-shadow: 0 15px 35px rgba(255, 107, 0, 0.2);
    }
    
    .modal-header {
        border-bottom: 1px solid rgba(255, 107, 0, 0.2);
        background: linear-gradient(135deg, rgba(255, 107, 0, 0.1), rgba(255, 140, 0, 0.1));
    }
    
    .modal-title {
        color: white;
        font-weight: 700;
    }
    
    .close {
        color: #ffa500;
    }
    
    .form-control {
        background: rgba(15, 23, 42, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: white;
        border-radius: 8px;
        padding: 12px;
    }
    
    .form-control:focus {
        background: rgba(15, 23, 42, 0.9);
        border-color: var(--orange-medium);
        color: white;
        box-shadow: 0 0 0 0.25rem rgba(255, 119, 0, 0.25);
    }
    
    .return-display {
        background: linear-gradient(135deg, rgba(255, 107, 0, 0.1), rgba(255, 140, 0, 0.1));
        border-radius: 8px;
        padding: 15px;
        margin-top: 15px;
        border: 1px solid rgba(255, 107, 0, 0.2);
    }
    
    .return-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--orange-light);
        text-shadow: 0 2px 4px rgba(255, 107, 0, 0.3);
    }
    
    .crypto-icon {
        font-size: 1.5rem;
        margin-right: 10px;
        color: var(--orange-light);
    }
    
    .section-title {
        color: white;
        font-weight: 700;
        text-align: center;
        margin-bottom: 40px;
        position: relative;
    }
    
    .section-title:after {
        content: '';
        display: block;
        width: 100px;
        height: 4px;
        background: linear-gradient(135deg, var(--orange-medium), var(--orange-light));
        margin: 10px auto;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(255, 119, 0, 0.4);
    }
    
    .bonus-info {
        background: linear-gradient(135deg, rgba(255, 107, 0, 0.15), rgba(255, 140, 0, 0.15));
        border: 1px solid rgba(255, 107, 0, 0.3);
        border-radius: 8px;
        padding: 15px;
        margin-top: 30px;
        box-shadow: 0 4px 15px rgba(255, 107, 0, 0.2);
    }
    
    .bonus-icon {
        color: var(--orange-light);
        margin-right: 10px;
        filter: drop-shadow(0 2px 4px rgba(255, 107, 0, 0.3));
    }
    
    /* Additional orange accent elements */
    .btn-close {
        filter: invert(1) brightness(2);
    }
    
    .btn-secondary {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
    }
    
    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.3);
    }
    
    /* Glow effects for interactive elements */
    .invest-btn:focus,
    .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(255, 119, 0, 0.5) !important;
    }
    
    /* Orange pulse animation for attention */
    @keyframes orange-pulse {
        0% { box-shadow: 0 0 0 0 rgba(255, 119, 0, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(255, 119, 0, 0); }
        100% { box-shadow: 0 0 0 0 rgba(255, 119, 0, 0); }
    }
    
    .bonus-badge {
        animation: orange-pulse 2s infinite;
    }
</style>
</head>
<body>
    <div class="container py-5">
        <h1 class="section-title">CRYPTO INVESTMENT PACKAGES</h1>
        <p class="text-center mb-5 text-muted">Choose your investment plan and start earning daily returns</p>
        
        <div class="row g-4">
            <!-- Package 1: BASIC -->
            <div class="col-md-6 col-lg-4">
                <div class="crypto-card h-100 position-relative">
                    <div class="bonus-badge">+20% BONUS</div>
                    <div class="package-header">
                        <div class="package-rank">BASIC</div>
                        <div class="package-range">$10 to $199</div>
                    </div>
                    <div class="package-body">
                        <div class="package-details">
                            <div class="detail-item">
                                <span class="detail-label">Holding Time</span>
                                <span class="detail-value">15 Days</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Daily ROI</span>
                                <span class="roi-badge">0.7%</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Total Return</span>
                                <span class="detail-value">10.5%</span>
                            </div>
                        </div>
                        <button class="invest-btn" data-package="BASIC" data-min="10" data-max="199" data-roi="0.7">
                            <i class="fas fa-coins me-2"></i> INVEST NOW
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Package 2: BRONZE -->
            <div class="col-md-6 col-lg-4">
                <div class="crypto-card h-100 position-relative">
                    <div class="bonus-badge">+20% BONUS</div>
                    <div class="package-header">
                        <div class="package-rank">BRONZE</div>
                        <div class="package-range">$50 to $499</div>
                    </div>
                    <div class="package-body">
                        <div class="package-details">
                            <div class="detail-item">
                                <span class="detail-label">Holding Time</span>
                                <span class="detail-value">30 Days</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Daily ROI</span>
                                <span class="roi-badge">0.9%</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Total Return</span>
                                <span class="detail-value">27%</span>
                            </div>
                        </div>
                        <button class="invest-btn" data-package="BRONZE" data-min="50" data-max="499" data-roi="0.9">
                            <i class="fas fa-coins me-2"></i> INVEST NOW
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Package 3: SILVER -->
            <div class="col-md-6 col-lg-4">
                <div class="crypto-card h-100 position-relative">
                    <div class="bonus-badge">+20% BONUS</div>
                    <div class="package-header">
                        <div class="package-rank">SILVER</div>
                        <div class="package-range">$100 to $999</div>
                    </div>
                    <div class="package-body">
                        <div class="package-details">
                            <div class="detail-item">
                                <span class="detail-label">Holding Time</span>
                                <span class="detail-value">45 Days</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Daily ROI</span>
                                <span class="roi-badge">1.1%</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Total Return</span>
                                <span class="detail-value">49.5%</span>
                            </div>
                        </div>
                        <button class="invest-btn" data-package="SILVER" data-min="100" data-max="999" data-roi="1.1">
                            <i class="fas fa-coins me-2"></i> INVEST NOW
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Package 4: GOLD -->
            <div class="col-md-6 col-lg-4">
                <div class="crypto-card h-100 position-relative">
                    <div class="bonus-badge">+20% BONUS</div>
                    <div class="package-header">
                        <div class="package-rank">GOLD</div>
                        <div class="package-range">$200 to $1499</div>
                    </div>
                    <div class="package-body">
                        <div class="package-details">
                            <div class="detail-item">
                                <span class="detail-label">Holding Time</span>
                                <span class="detail-value">60 Days</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Daily ROI</span>
                                <span class="roi-badge">1.3%</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Total Return</span>
                                <span class="detail-value">78%</span>
                            </div>
                        </div>
                        <button class="invest-btn" data-package="GOLD" data-min="200" data-max="1499" data-roi="1.3">
                            <i class="fas fa-coins me-2"></i> INVEST NOW
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Package 5: PLATINUM -->
            <div class="col-md-6 col-lg-4">
                <div class="crypto-card h-100 position-relative">
                    <div class="bonus-badge">+20% BONUS</div>
                    <div class="package-header">
                        <div class="package-rank">PLATINUM</div>
                        <div class="package-range">$200 to $2499</div>
                    </div>
                    <div class="package-body">
                        <div class="package-details">
                            <div class="detail-item">
                                <span class="detail-label">Holding Time</span>
                                <span class="detail-value">90 Days</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Daily ROI</span>
                                <span class="roi-badge">1.5%</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Total Return</span>
                                <span class="detail-value">135%</span>
                            </div>
                        </div>
                        <button class="invest-btn" data-package="PLATINUM" data-min="200" data-max="2499" data-roi="1.5">
                            <i class="fas fa-coins me-2"></i> INVEST NOW
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Package 6: DIAMOND -->
            <div class="col-md-6 col-lg-4">
                <div class="crypto-card h-100 position-relative">
                    <div class="bonus-badge">+20% BONUS</div>
                    <div class="package-header">
                        <div class="package-rank">DIAMOND</div>
                        <div class="package-range">$250 to $4999</div>
                    </div>
                    <div class="package-body">
                        <div class="package-details">
                            <div class="detail-item">
                                <span class="detail-label">Holding Time</span>
                                <span class="detail-value">120 Days</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Daily ROI</span>
                                <span class="roi-badge">2.0%</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Total Return</span>
                                <span class="detail-value">240%</span>
                            </div>
                        </div>
                        <button class="invest-btn" data-package="DIAMOND" data-min="250" data-max="4999" data-roi="2.0">
                            <i class="fas fa-coins me-2"></i> INVEST NOW
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Package 7: STAR DIAMOND -->
            <div class="col-md-6 col-lg-4">
                <div class="crypto-card h-100 position-relative">
                    <div class="bonus-badge">+20% BONUS</div>
                    <div class="package-header">
                        <div class="package-rank">STAR DIAMOND</div>
                        <div class="package-range">$250 to $9999</div>
                    </div>
                    <div class="package-body">
                        <div class="package-details">
                            <div class="detail-item">
                                <span class="detail-label">Holding Time</span>
                                <span class="detail-value">150 Days</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Daily ROI</span>
                                <span class="roi-badge">2.5%</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Total Return</span>
                                <span class="detail-value">375%</span>
                            </div>
                        </div>
                        <button class="invest-btn" data-package="STAR DIAMOND" data-min="250" data-max="9999" data-roi="2.5">
                            <i class="fas fa-coins me-2"></i> INVEST NOW
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bonus-info mt-5">
            <div class="d-flex align-items-center">
                <i class="fas fa-gift bonus-icon fa-lg"></i>
                <div>
                    <h5 class="mb-1">Special Welcome Bonus!</h5>
                    <p class="mb-0">Activate a user ID to deposit any amount for the first time, and get a 20% extra fund of the deposit amount in the fund wallet instantly.</p>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4 text-muted">
            <p><i class="fas fa-info-circle me-2"></i> After the complete holding time, you will get your invested amount back</p>
        </div>
    </div>
    
<!-- Investment Modal -->
<div class="modal fade" id="investmentModal" tabindex="-1" aria-labelledby="investmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="investmentModalLabel">INVESTMENT DETAILS</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="investmentForm" action="investment-fund-process" method="POST">
                    <input type="hidden" id="selectedPackage" name="package">
                    <input type="hidden" id="selectedROI" name="roi">
                    <input type="hidden" id="selectedDays" name="days">
                    
                    <div class="mb-3">
                        <label for="packageName" class="form-label">Selected Package</label>
                        <input type="text" class="form-control" id="packageName" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label for="investmentAmount" class="form-label">Investment Amount ($)</label>
                        <input type="number" class="form-control" id="investmentAmount" name="amount" placeholder="Enter amount" min="0" step="0.01" required>
                        <div class="form-text text-muted" id="amountRange"></div>
                        <div class="invalid-feedback" id="amountError"></div>
                    </div>
                    
                    <div class="return-display">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Daily Return:</span>
                            <span class="return-value" id="dailyReturn">$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span>Total Return (Full Period):</span>
                            <span class="return-value" id="totalReturn">$0.00</span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn invest-btn" id="confirmInvestment">Confirm Investment</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const investButtons = document.querySelectorAll('.invest-btn');
        const investmentModal = new bootstrap.Modal(document.getElementById('investmentModal'));
        const packageNameInput = document.getElementById('packageName');
        const amountRangeText = document.getElementById('amountRange');
        const investmentAmountInput = document.getElementById('investmentAmount');
        const dailyReturnDisplay = document.getElementById('dailyReturn');
        const totalReturnDisplay = document.getElementById('totalReturn');
        const selectedPackageInput = document.getElementById('selectedPackage');
        const selectedROIInput = document.getElementById('selectedROI');
        const selectedDaysInput = document.getElementById('selectedDays');
        const confirmInvestmentBtn = document.getElementById('confirmInvestment');
        const amountErrorDiv = document.getElementById('amountError');
        
        let currentPackage = null;
        let holdingDays = {
            'BASIC': 15,
            'BRONZE': 30,
            'SILVER': 45,
            'GOLD': 60,
            'PLATINUM': 90,
            'DIAMOND': 120,
            'STAR DIAMOND': 150
        };
        
        // Add event listeners to investment buttons
        investButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Get data attributes using dataset
                const packageName = this.dataset.package;
                const minAmount = this.dataset.min;
                const maxAmount = this.dataset.max;
                const roiPercent = this.dataset.roi;
                
                console.log('Package Data from dataset:', { 
                    package: packageName, 
                    min: minAmount, 
                    max: maxAmount, 
                    roi: roiPercent 
                });
                
                if (!packageName || !minAmount || !maxAmount || !roiPercent) {
                    console.error('Missing data attributes on button');
                    amountErrorDiv.textContent = 'Error: Package data missing';
                    return;
                }
                
                currentPackage = {
                    name: packageName,
                    min: parseFloat(minAmount),
                    max: parseFloat(maxAmount),
                    roi: parseFloat(roiPercent),
                    days: holdingDays[packageName] || 30
                };
                
                console.log('Current Package:', currentPackage);
                
                // Set modal values
                packageNameInput.value = currentPackage.name;
                amountRangeText.textContent = `Amount range: $${currentPackage.min} - $${currentPackage.max}`;
                investmentAmountInput.min = currentPackage.min;
                investmentAmountInput.max = currentPackage.max;
                investmentAmountInput.value = '';
                
                // Set hidden inputs
                selectedPackageInput.value = currentPackage.name;
                selectedROIInput.value = currentPackage.roi;
                selectedDaysInput.value = currentPackage.days;
                
                // Reset displays
                dailyReturnDisplay.textContent = '$0.00';
                totalReturnDisplay.textContent = '$0.00';
                
                // Clear any previous errors
                amountErrorDiv.textContent = '';
                investmentAmountInput.classList.remove('is-invalid');
                
                // Show the modal
                investmentModal.show();
            });
        });
        
        // Calculate returns when amount changes
        investmentAmountInput.addEventListener('input', function() {
            if (!currentPackage) {
                amountErrorDiv.textContent = 'Please select a package first';
                return;
            }
            
            const amount = parseFloat(this.value) || 0;
            
            // Validate amount
            if (amount > 0) {
                if (amount < currentPackage.min || amount > currentPackage.max) {
                    amountErrorDiv.textContent = `Amount must be between $${currentPackage.min} and $${currentPackage.max}`;
                    this.classList.add('is-invalid');
                    dailyReturnDisplay.textContent = '$0.00';
                    totalReturnDisplay.textContent = '$0.00';
                    return;
                } else {
                    amountErrorDiv.textContent = '';
                    this.classList.remove('is-invalid');
                }
                
                // Calculate returns
                const dailyReturn = (amount * currentPackage.roi) / 100;
                const totalReturn = dailyReturn * currentPackage.days;
                
                // Update displays
                dailyReturnDisplay.textContent = `$${dailyReturn.toFixed(2)}`;
                totalReturnDisplay.textContent = `$${totalReturn.toFixed(2)}`;
            } else {
                dailyReturnDisplay.textContent = '$0.00';
                totalReturnDisplay.textContent = '$0.00';
            }
        });
        
        // Handle investment confirmation
        confirmInvestmentBtn.addEventListener('click', function() {
            if (!currentPackage) {
                amountErrorDiv.textContent = 'Please select a package first';
                return;
            }
            
            const amount = parseFloat(investmentAmountInput.value) || 0;
            
            if (amount === 0 || amount < currentPackage.min || amount > currentPackage.max) {
                amountErrorDiv.textContent = `Please enter a valid amount between $${currentPackage.min} and $${currentPackage.max}`;
                investmentAmountInput.classList.add('is-invalid');
                return;
            }
            
            // Submit the form
            document.getElementById('investmentForm').submit();
        });
    });
</script>

<?php }else if(($_REQUEST['case'] ?? '')==='history'){?>
<div class="main-panel">
<div class="content">
<div class="page-inner">

<div class="row">

<div class="col-md-12">

<div class="card">
<div class="card-header"  >
<div class="card-title">Investment History</div>
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
$query = "SELECT amount,percentage,bonus,nodays, date FROM imaksoft_member_roi WHERE userid = ?  ORDER BY id DESC LIMIT ?, ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("sii", $userid, $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();
?>
<table class="table table-bordered table-striped">
<thead>
<tr >
<th align="center" >Sl_No</th>
<th align="center" >Amount</th>
<th align="center" >Percentage</th>
<th align="center" >Bonus</th>
<th align="center" >No_Days</th>
<th align="center" >Date</th>
</tr>
</thead>
<tbody>
  <?php
                    $i = $offset + 1; // Start serial number correctly
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle;"><polygon points="12 2 2 19 22 19"/><line x1="12" y1="2" x2="12" y2="19"/><line x1="2" y1="19" x2="12" y2="10"/><line x1="22" y1="19" x2="12" y2="10"/></svg>';
                            echo "<tr>\r\n                                    <td>{$i}</td>\r\n                                    <td>{$svg} {$row['amount']}</td>\r\n                                    <td>{$row['percentage']} %</td>\r\n                                    <td>{$svg} {$row['bonus']}</td>\r\n                                    <td>{$row['nodays']}</td>\r\n                                    <td>{$row['date']}</td>\r\n                                  </tr>";
                            $i++;
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
