<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Mintova</title>
  <link rel="icon" type="image/x-icon" href="/mintova/mem/assets/images/favicon.ico">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/mintova/tailwind.min.css" />
  <style>
    body { font-family: 'Inter', sans-serif; }

    /* MOBILE SIDEBAR */
    #mobileMenu {
      position: fixed;
      top: 0;
      left: 0;
      width: 260px;
      height: 100%;
      background: rgba(10, 10, 10, 0.96);
      border-right: 1px solid rgba(255,255,255,0.05);
      backdrop-filter: blur(12px);
      padding: 26px 22px;
      display: flex;
      flex-direction: column;
      z-index: 1001;
      transform: translateX(-100%);
      transition: transform .28s ease;
    }

    body.menu-open #mobileMenu {
      transform: translateX(0%);
    }

    #menuOverlay {
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.6);
      backdrop-filter: blur(6px);
      z-index: 1000;
      pointer-events: none;
      opacity: 0;
      transition: opacity .28s ease;
    }

    body.menu-open #menuOverlay {
      opacity: 1;
      pointer-events: auto;
    }

    @media (min-width: 780px) {
      #mobileMenu, #menuOverlay { display: none; }
    }

    .mn-section {
      position: relative;
      padding: 60px 0;
      z-index: 1;
    }

    .mn-section:nth-of-type(odd)  { background: rgba(0,0,0,0.25); }
    .mn-section:nth-of-type(even) { background: rgba(255,255,255,0.02); }

    .mn-section::before,
    .mn-section::after {
      content: "";
      position: absolute;
      left: 0;
      width: 100%;
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(251,146,60,0.15), transparent);
    }
    .mn-section::before { top: 0; }
    .mn-section::after  { bottom: 0; }

    .card:hover, .plan:hover, .p-6:hover, .p-5:hover {
      transform: translateY(-4px);
      box-shadow: 0 0 25px rgba(251,146,60,0.12);
      transition: 0.25s ease;
    }
  </style>
</head>
<body class="bg-black text-white overflow-x-hidden">

<?php
include('menu.php');
?>

<!-- Hero Section -->
<section class="relative overflow-hidden">
  <div class="absolute inset-0 opacity-30">
    <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-orange-400 rounded-full blur-[200px]"></div>
    <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-orange-300 rounded-full blur-[200px]"></div>
  </div>

  <div class="max-w-5xl mx-auto px-6 py-24 relative z-10">
    <span class="px-5 py-1 bg-orange-400/20 text-orange-300 text-xs font-bold rounded-full tracking-wide">
      POWERED BY Mintova
    </span>

    <h1 class="text-4xl md:text-6xl font-extrabold leading-tight mt-5">
      Start Your Crypto Journey
      <span class="text-orange-400">With Just $10</span>
    </h1>

    <p class="text-gray-300 text-lg max-w-xl mt-4">
      Earn daily ROI, deposit bonuses, level rewards,
      and task-based income — all in one platform.
    </p>

    <div class="flex flex-wrap gap-4 mt-6">
      <a href="login" class="bg-orange-400 text-black font-bold px-7 py-3 rounded-full flex items-center gap-2">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
          <polyline points="10 17 15 12 10 7"/>
          <line x1="15" y1="12" x2="3" y2="12"/>
        </svg>
        Login
      </a>
      <a href="register" class="border border-white/20 px-7 py-3 rounded-full text-white flex items-center gap-2 hover:bg-white/10 transition">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="7" r="4"/>
          <path d="M5.5 21c1.5-4 5-6 6.5-6s5 2 6.5 6"/>
          <line x1="20" y1="12" x2="20" y2="18"/>
          <line x1="23" y1="15" x2="17" y2="15"/>
        </svg>
        Register
      </a>
    </div>

    <p class="text-gray-500 text-sm mt-6">
      USDT TRC20 • Daily ROI • Level Income • Fast Withdrawals
    </p>
  </div>
</section>


<!-- How it Works -->
<section id="how" class="mn-section max-w-6xl mx-auto px-6 py-16">
  <h2 class="text-2xl font-bold mb-6">How Mintova Works</h2>
  <div class="grid md:grid-cols-3 gap-6">
    <div class="p-6 bg-white/5 border border-white/10 rounded-xl">
      <h4 class="font-bold mb-2">Step 1 — Deposit & Activate</h4>
      <p class="text-gray-300 text-sm">Start with just $10 using USDT TRC20 and instantly activate your staking plan.</p>
    </div>
    <div class="p-6 bg-white/5 border border-white/10 rounded-xl">
      <h4 class="font-bold mb-2">Step 2 — Earn Daily ROI</h4>
      <p class="text-gray-300 text-sm">Receive daily returns automatically, plus level ROI from your growing network.</p>
    </div>
    <div class="p-6 bg-white/5 border border-white/10 rounded-xl">
      <h4 class="font-bold mb-2">Step 3 — Boost Income</h4>
      <p class="text-gray-300 text-sm">Earn extra through referrals, deposit bonuses, and task-based rewards.</p>
    </div>
  </div>
</section>


<!-- Income Types -->
<section id="income" class="mn-section max-w-6xl mx-auto px-6 py-16">
  <h2 class="text-2xl font-bold mb-6">Multiple Ways to Earn</h2>
  <div class="grid md:grid-cols-3 gap-6">
    <div class="p-6 bg-white/5 border border-white/10 rounded-xl">
      <h4 class="font-bold mb-2">1 — Daily ROI</h4>
      <p class="text-gray-300 text-sm">Earn fixed daily returns based on your staking amount. Earnings are credited automatically to your wallet.</p>
    </div>
    <div class="p-6 bg-white/5 border border-white/10 rounded-xl">
      <h4 class="font-bold mb-2">2 — Level Rewards</h4>
      <p class="text-gray-300 text-sm">Earn from your team's staking activity across multiple levels. Bigger network, bigger daily income.</p>
    </div>
    <div class="p-6 bg-white/5 border border-white/10 rounded-xl">
      <h4 class="font-bold mb-2">3 — Deposit Bonus</h4>
      <p class="text-gray-300 text-sm">Receive instant bonus credits whenever new users activate staking under your network.</p>
    </div>
    <div class="p-6 bg-white/5 border border-white/10 rounded-xl">
      <h4 class="font-bold mb-2">4 — Task Earnings</h4>
      <p class="text-gray-300 text-sm">Complete simple daily tasks to unlock extra earnings on top of your regular ROI.</p>
    </div>
    <div class="p-6 bg-white/5 border border-white/10 rounded-xl">
      <h4 class="font-bold mb-2">5 — Rank Rewards</h4>
      <p class="text-gray-300 text-sm">Achieve ranks based on your team volume and claim exclusive cash rewards, bonuses, and recognition.</p>
    </div>
  </div>
</section>


<!-- Staking Plans -->
<section id="pricing" class="max-w-6xl mx-auto px-6 py-16">
  <h2 class="text-2xl font-bold mb-6">Choose Your Staking Plan</h2>
  <div class="grid md:grid-cols-3 gap-6">
    <div class="p-6 bg-white/5 border border-white/10 rounded-xl flex flex-col gap-3">
      <h3 class="font-bold text-lg">Basic</h3>
      <div class="text-3xl font-extrabold text-orange-400">$10</div>
      <p class="text-gray-400 text-sm">Entry plan for beginners. Earn stable daily ROI + level income.</p>
      <a href="register" class="bg-orange-400 text-black font-bold px-4 py-2 rounded-full mt-auto text-center">Start Now</a>
    </div>
    <div class="p-6 bg-white/5 border border-white/10 rounded-xl flex flex-col gap-3">
      <h3 class="font-bold text-lg">Standard</h3>
      <div class="text-3xl font-extrabold text-orange-400">$50</div>
      <p class="text-gray-400 text-sm">Higher ROI + bigger level rewards. Ideal for consistent daily earnings.</p>
      <a href="register" class="bg-orange-400 text-black font-bold px-4 py-2 rounded-full mt-auto text-center">Upgrade</a>
    </div>
    <div class="p-6 bg-white/5 border border-white/10 rounded-xl flex flex-col gap-3">
      <h3 class="font-bold text-lg">Premium</h3>
      <div class="text-3xl font-extrabold text-orange-400">$100+</div>
      <p class="text-gray-400 text-sm">Max ROI, max level rewards, and access to premium task bonuses.</p>
      <a href="register" class="bg-orange-400 text-black font-bold px-4 py-2 rounded-full mt-auto text-center">Go Premium</a>
    </div>
  </div>
</section>


<!-- Why Choose Mintova -->
<section id="why" class="max-w-6xl mx-auto px-6 py-16">
  <h2 class="text-2xl font-bold mb-6">Why Choose Mintova?</h2>
  <div class="grid md:grid-cols-3 gap-6">
    <div class="p-6 bg-white/5 border border-white/10 rounded-xl">
      <h4 class="font-bold mb-2">Instant Activation</h4>
      <p class="text-gray-300 text-sm">Your staking plan activates immediately after depositing USDT TRC20.</p>
    </div>
    <div class="p-6 bg-white/5 border border-white/10 rounded-xl">
      <h4 class="font-bold mb-2">Automated Daily ROI</h4>
      <p class="text-gray-300 text-sm">Daily income is credited automatically with no manual actions required.</p>
    </div>
    <div class="p-6 bg-white/5 border border-white/10 rounded-xl">
      <h4 class="font-bold mb-2">Multi-Level Income</h4>
      <p class="text-gray-300 text-sm">Earn from multiple levels as your network grows, boosting passive earnings.</p>
    </div>
    <div class="p-6 bg-white/5 border border-white/10 rounded-xl">
      <h4 class="font-bold mb-2">Fast Withdrawals</h4>
      <p class="text-gray-300 text-sm">Withdraw earnings seamlessly with quick blockchain processing.</p>
    </div>
    <div class="p-6 bg-white/5 border border-white/10 rounded-xl">
      <h4 class="font-bold mb-2">Task Rewards</h4>
      <p class="text-gray-300 text-sm">Complete simple tasks daily to unlock extra reward income.</p>
    </div>
    <div class="p-6 bg-white/5 border border-white/10 rounded-xl">
      <h4 class="font-bold mb-2">Transparent Tracking</h4>
      <p class="text-gray-300 text-sm">Real-time dashboards for ROI, team income, bonuses, and wallet balance.</p>
    </div>
  </div>
</section>


<!-- About Us -->
<section id="about" class="max-w-6xl mx-auto px-6 py-16">
  <h2 class="text-2xl font-bold mb-6">About Mintova</h2>
  <div class="p-6 bg-white/5 border border-white/10 rounded-xl leading-relaxed text-gray-300 text-sm">
    <p>Mintova is a next-generation crypto earning platform built to make digital income simple, accessible, and transparent for everyone. Our ecosystem allows users to grow their wealth through automated staking, daily ROI, referral rewards, and structured team bonuses.</p>
    <p class="mt-4">Powered by USDT TRC20 technology, Mintova delivers fast transactions, real-time wallet tracking, and a smooth user experience. Whether you're a beginner starting with $10 or a leader building a global network, Mintova gives you the tools to earn smarter and scale faster.</p>
    <p class="mt-4">Our mission is simple: create a secure, reward-driven earning model where anyone can participate, grow, and achieve financial freedom through crypto.</p>
  </div>
</section>


<!-- FAQ -->
<section id="faq" class="max-w-6xl mx-auto px-6 py-16">
  <h2 class="text-2xl font-bold mb-6">Frequently Asked Questions</h2>
  <div class="space-y-4">
    <div class="p-5 bg-white/5 border border-white/10 rounded-xl">
      <h4 class="font-bold mb-2">How do I start earning?</h4>
      <p class="text-gray-300 text-sm">Create your account, deposit USDT (TRC20) and activate any staking plan starting from just $10.</p>
    </div>
    <div class="p-5 bg-white/5 border border-white/10 rounded-xl">
      <h4 class="font-bold mb-2">When will I get my daily ROI?</h4>
      <p class="text-gray-300 text-sm">Your ROI is credited automatically every 24 hours based on your active staking plan.</p>
    </div>
    <div class="p-5 bg-white/5 border border-white/10 rounded-xl">
      <h4 class="font-bold mb-2">Is referral income compulsory?</h4>
      <p class="text-gray-300 text-sm">No. You can earn daily ROI without referrals. Referrals simply unlock extra income streams.</p>
    </div>
    <div class="p-5 bg-white/5 border border-white/10 rounded-xl">
      <h4 class="font-bold mb-2">How fast are withdrawals processed?</h4>
      <p class="text-gray-300 text-sm">Withdrawals are processed quickly through USDT TRC20 for fast blockchain settlement.</p>
    </div>
    <div class="p-5 bg-white/5 border border-white/10 rounded-xl">
      <h4 class="font-bold mb-2">Is there a limit on how much I can earn?</h4>
      <p class="text-gray-300 text-sm">No limits. Your earnings scale with staking amount, team size, and task performance.</p>
    </div>
    <div class="p-5 bg-white/5 border border-white/10 rounded-xl">
      <h4 class="font-bold mb-2">Is Mintova beginner-friendly?</h4>
      <p class="text-gray-300 text-sm">Yes — even new users can start earning with just $10. The dashboard is simple, automated, and easy to track.</p>
    </div>
  </div>
</section>


<!-- Footer -->
<footer class="border-t border-white/10 py-8 text-center text-gray-400">
  © 2025 Mintova — Invest smarter.
</footer>

<script>
  (function () {
    const body = document.body;
    const menuBtn = document.getElementById('menuBtn');
    const overlay = document.getElementById('menuOverlay');
    const mobileMenu = document.getElementById('mobileMenu');

    if (!menuBtn || !overlay || !mobileMenu) return;

    const menuLinks = mobileMenu.querySelectorAll('a, button');

    menuBtn.addEventListener('click', () => body.classList.toggle('menu-open'));
    overlay.addEventListener('click', () => body.classList.remove('menu-open'));
    menuLinks.forEach(el => el.addEventListener('click', () => body.classList.remove('menu-open')));

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') body.classList.remove('menu-open');
    });
  })();
</script>

</body>
</html>
