<?php
include('admin/inc/function.php'); // must set $conn (mysqli) and optionally redirect()
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Mintova</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    :root{
      --bg:#070707 !important;
      --panel: rgba(255,255,255,0.04) !important;
      --glass: rgba(255,255,255,0.06) !important;
      --orange: #FB923C !important;
      --orange-dark: #D97706 !important;
      --orange-soft: rgba(251,146,60,0.15) !important;
      --radius:18px !important;
      --shadow: 0 10px 30px rgba(0,0,0,0.65) !important;
    }
    *{box-sizing:border-box;margin:0;padding:0}
    body{
      font-family:'Poppins',sans-serif;
      background: linear-gradient(180deg, #000 0%, #050505 55%) !important;
      color:#fff !important;
      display:flex;
      justify-content:center;
      align-items:center;
      min-height:100vh;
      padding:20px;
    }
    .register-card{
      background: var(--panel) !important;
      border:1px solid var(--orange-soft) !important;
      border-radius: var(--radius) !important;
      padding:40px 30px;
      width:100%;
      max-width:600px;
      backdrop-filter: blur(10px);
      box-shadow: var(--shadow) !important;
    }
    .register-card h2{
      font-size:28px;
      font-weight:700;
      margin-bottom:20px;
      background: linear-gradient(135deg, var(--orange), var(--orange-dark)) !important;
      -webkit-background-clip: text !important;
      -webkit-text-fill-color: transparent !important;
    }
    label{
      display:block;
      font-weight:600;
      margin-bottom:6px;
      color:#fff !important;
    }
    input{
      width:100%;
      padding:12px 14px;
      border-radius:12px;
      border:1px solid var(--orange-soft) !important;
      background: rgba(255,255,255,0.03) !important;
      color:#fff !important;
      margin-bottom:18px;
      font-weight:600;
    }
    input:focus{
      outline:none;
      border:1px solid var(--orange) !important;
      box-shadow: 0 0 10px var(--orange-soft) !important;
    }
    button{
      width:100%;
      padding:12px;
      border-radius:999px;
      border:none;
      font-weight:700;
      cursor:pointer;
      background: linear-gradient(90deg, var(--orange), var(--orange-dark)) !important;
      color:#0d0d0d !important;
      box-shadow:0 8px 30px var(--orange-soft) !important;
      transition:0.25s ease;
    }
    button:hover{
      transform: translateY(-2px);
      box-shadow:0 0 25px var(--orange-soft) !important;
    }
    .footer-links{
      margin-top:16px;
      font-size:14px;
      text-align:center;
      color: rgba(255,255,255,0.7) !important;
    }
    .footer-links a{
      color: var(--orange) !important;
      text-decoration:none;
      font-weight:600;
    }
    .footer-links a:hover{
      text-decoration:underline;
    }
    .grid{
      display:grid;
      gap:16px;
    }
    @media(min-width:640px){
      .grid-cols-2{
        grid-template-columns:repeat(2,1fr);
        gap:16px;
      }
    }
    .col-span-2{
      grid-column: span 2 / span 2;
    }
    
    /* Add this below your existing CSS */
select {
  width: 100%;
  padding: 12px 14px;
  border-radius: 12px;
  border: 1px solid var(--orange-soft) !important;
  background: rgba(255,255,255,0.03) !important;
  color: #fff !important;
  font-weight: 600;
  margin-bottom: 18px;
  appearance: none; /* remove default arrow for better styling */
}

select:focus {
  outline: none;
  border: 1px solid var(--orange) !important;
  box-shadow: 0 0 10px var(--orange-soft) !important;
}
select {
  background-image: url("data:image/svg+xml;utf8,<svg fill='%23fff' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>");
  background-repeat: no-repeat;
  background-position: right 12px center;
  background-size: 16px 16px;
  padding-right: 40px; /* space for the arrow */
}

  </style>
</head>
<body>
  <div class="register-card">
    <h2>Register Now</h2>
    
    <?php if(($_REQUEST['msg'] ?? null)==4){?>
<div align="center" style="margin:0;padding:0;color:#0033FF;font-size:15px;"><strong>Your registration is successfully completed!</strong></div>
<h6 align="center" style="color:#0033FF;font-size:15px; font-family:Arial, Helvetica, sans-serif;">User ID: <?=getMember($conn,$_REQUEST['id'],'userid')?>&nbsp; Password: <?=base64_decode(getMember($conn,$_REQUEST['id'],'password'))?></h6>
<?php }?>
<?php if(($_REQUEST['q'] ?? null)==4){?>
<div align="center" style="margin:0;padding:0;color:#FF0000; font-size:14px;"><strong>Invalid/Inactive Sponsor ID!</strong></div>
<?php }?>

<?php if(($_REQUEST['e'] ?? null)==1){?><p align="center" style="color:#FF0000;"><strong>Phone number or email id already used!</strong></p><?php }?>


<?php if(($_REQUEST['b'] ?? null)==1){?><p align="center" style="color:#FF0000;"><strong>Aadhar Card Or Pan Card is already used!</strong></p><?php }?>


   <form name="form1" action="registration-process" method="post">
  <div class="grid grid-cols-2 gap-6">
    <!-- Sponsor ID -->
    <div class="col-span-2">
      <label for="sponsor">Sponsor ID*</label>
      <input type="text" name="sponsor" id="sponsor" placeholder="Sponsor ID" value="<?=$_REQUEST['spon'] ?? ''?>" required readonly>
    </div>

    <!-- Name -->
    <div class="col-span-2">
      <label for="name">Enter Name*</label>
      <input type="text" name="name" id="name" placeholder="Enter Name" required>
    </div>

    <!-- Password -->
    <div class="col-span-2">
      <label for="password">Enter Password*</label>
      <input type="password" name="password" id="password" placeholder="Enter Password" required>
    </div>

    <!-- Country -->
    <div class="col-span-2">
      <label for="country">Select Country*</label>
     <select name="country" id="country" required class="w-full border rounded p-2">
  <option value="AF" data-code="+93">Afghanistan</option>
  <option value="AL" data-code="+355">Albania</option>
  <option value="DZ" data-code="+213">Algeria</option>
  <option value="AS" data-code="+1-684">American Samoa</option>
  <option value="AD" data-code="+376">Andorra</option>
  <option value="AO" data-code="+244">Angola</option>
  <option value="AI" data-code="+1-264">Anguilla</option>
  <option value="AQ" data-code="+672">Antarctica</option>
  <option value="AG" data-code="+1-268">Antigua and Barbuda</option>
  <option value="AR" data-code="+54">Argentina</option>
  <option value="AM" data-code="+374">Armenia</option>
  <option value="AW" data-code="+297">Aruba</option>
  <option value="AU" data-code="+61">Australia</option>
  <option value="AT" data-code="+43">Austria</option>
  <option value="AZ" data-code="+994">Azerbaijan</option>
  <option value="BS" data-code="+1-242">Bahamas</option>
  <option value="BH" data-code="+973">Bahrain</option>
  <option value="BD" data-code="+880">Bangladesh</option>
  <option value="BB" data-code="+1-246">Barbados</option>
  <option value="BY" data-code="+375">Belarus</option>
  <option value="BE" data-code="+32">Belgium</option>
  <option value="BZ" data-code="+501">Belize</option>
  <option value="BJ" data-code="+229">Benin</option>
  <option value="BM" data-code="+1-441">Bermuda</option>
  <option value="BT" data-code="+975">Bhutan</option>
  <option value="BO" data-code="+591">Bolivia</option>
  <option value="BA" data-code="+387">Bosnia and Herzegovina</option>
  <option value="BW" data-code="+267">Botswana</option>
  <option value="BR" data-code="+55">Brazil</option>
  <option value="BN" data-code="+673">Brunei</option>
  <option value="BG" data-code="+359">Bulgaria</option>
  <option value="BF" data-code="+226">Burkina Faso</option>
  <option value="BI" data-code="+257">Burundi</option>
  <option value="KH" data-code="+855">Cambodia</option>
  <option value="CM" data-code="+237">Cameroon</option>
  <option value="CA" data-code="+1">Canada</option>
  <option value="CV" data-code="+238">Cape Verde</option>
  <option value="KY" data-code="+1-345">Cayman Islands</option>
  <option value="CF" data-code="+236">Central African Republic</option>
  <option value="TD" data-code="+235">Chad</option>
  <option value="CL" data-code="+56">Chile</option>
  <option value="CN" data-code="+86">China</option>
  <option value="CX" data-code="+61">Christmas Island</option>
  <option value="CC" data-code="+61">Cocos Islands</option>
  <option value="CO" data-code="+57">Colombia</option>
  <option value="KM" data-code="+269">Comoros</option>
  <option value="CD" data-code="+243">Congo (DRC)</option>
  <option value="CG" data-code="+242">Congo (Republic)</option>
  <option value="CK" data-code="+682">Cook Islands</option>
  <option value="CR" data-code="+506">Costa Rica</option>
  <option value="CI" data-code="+225">Côte d’Ivoire</option>
  <option value="HR" data-code="+385">Croatia</option>
  <option value="CU" data-code="+53">Cuba</option>
  <option value="CY" data-code="+357">Cyprus</option>
  <option value="CZ" data-code="+420">Czech Republic</option>
  <option value="DK" data-code="+45">Denmark</option>
  <option value="DJ" data-code="+253">Djibouti</option>
  <option value="DM" data-code="+1-767">Dominica</option>
  <option value="DO" data-code="+1-809">Dominican Republic</option>
  <option value="EC" data-code="+593">Ecuador</option>
  <option value="EG" data-code="+20">Egypt</option>
  <option value="SV" data-code="+503">El Salvador</option>
  <option value="GQ" data-code="+240">Equatorial Guinea</option>
  <option value="ER" data-code="+291">Eritrea</option>
  <option value="EE" data-code="+372">Estonia</option>
  <option value="ET" data-code="+251">Ethiopia</option>
  <option value="FJ" data-code="+679">Fiji</option>
  <option value="FI" data-code="+358">Finland</option>
  <option value="FR" data-code="+33">France</option>
  <option value="GF" data-code="+594">French Guiana</option>
  <option value="PF" data-code="+689">French Polynesia</option>
  <option value="GA" data-code="+241">Gabon</option>
  <option value="GM" data-code="+220">Gambia</option>
  <option value="GE" data-code="+995">Georgia</option>
  <option value="DE" data-code="+49">Germany</option>
  <option value="GH" data-code="+233">Ghana</option>
  <option value="GI" data-code="+350">Gibraltar</option>
  <option value="GR" data-code="+30">Greece</option>
  <option value="GL" data-code="+299">Greenland</option>
  <option value="GD" data-code="+1-473">Grenada</option>
  <option value="GP" data-code="+590">Guadeloupe</option>
  <option value="GU" data-code="+1-671">Guam</option>
  <option value="GT" data-code="+502">Guatemala</option>
  <option value="GG" data-code="+44-1481">Guernsey</option>
  <option value="GN" data-code="+224">Guinea</option>
  <option value="GW" data-code="+245">Guinea-Bissau</option>
  <option value="GY" data-code="+592">Guyana</option>
  <option value="HT" data-code="+509">Haiti</option>
  <option value="HN" data-code="+504">Honduras</option>
  <option value="HK" data-code="+852">Hong Kong</option>
  <option value="HU" data-code="+36">Hungary</option>
  <option value="IS" data-code="+354">Iceland</option>
  <option value="IN" data-code="+91" selected>India</option>
  <option value="ID" data-code="+62">Indonesia</option>
  <option value="IR" data-code="+98">Iran</option>
  <option value="IQ" data-code="+964">Iraq</option>
  <option value="IE" data-code="+353">Ireland</option>
  <option value="IM" data-code="+44-1624">Isle of Man</option>
  <option value="IL" data-code="+972">Israel</option>
  <option value="IT" data-code="+39">Italy</option>
  <option value="JM" data-code="+1-876">Jamaica</option>
  <option value="JP" data-code="+81">Japan</option>
  <option value="JE" data-code="+44-1534">Jersey</option>
  <option value="JO" data-code="+962">Jordan</option>
  <option value="KZ" data-code="+7">Kazakhstan</option>
  <option value="KE" data-code="+254">Kenya</option>
  <option value="KI" data-code="+686">Kiribati</option>
  <option value="KW" data-code="+965">Kuwait</option>
  <option value="KG" data-code="+996">Kyrgyzstan</option>
  <option value="LA" data-code="+856">Laos</option>
  <option value="LV" data-code="+371">Latvia</option>
  <option value="LB" data-code="+961">Lebanon</option>
  <option value="LS" data-code="+266">Lesotho</option>
  <option value="LR" data-code="+231">Liberia</option>
  <option value="LY" data-code="+218">Libya</option>
  <option value="LI" data-code="+423">Liechtenstein</option>
  <option value="LT" data-code="+370">Lithuania</option>
  <option value="LU" data-code="+352">Luxembourg</option>
  <option value="MO" data-code="+853">Macau</option>
  <option value="MK" data-code="+389">North Macedonia</option>
  <option value="MG" data-code="+261">Madagascar</option>
  <option value="MW" data-code="+265">Malawi</option>
  <option value="MY" data-code="+60">Malaysia</option>
  <option value="MV" data-code="+960">Maldives</option>
  <option value="ML" data-code="+223">Mali</option>
  <option value="MT" data-code="+356">Malta</option>
  <option value="MH" data-code="+692">Marshall Islands</option>
  <option value="MQ" data-code="+596">Martinique</option>
  <option value="MR" data-code="+222">Mauritania</option>
  <option value="MU" data-code="+230">Mauritius</option>
  <option value="YT" data-code="+262">Mayotte</option>
  <option value="MX" data-code="+52">Mexico</option>
  <option value="FM" data-code="+691">Micronesia</option>
  <option value="MD" data-code="+373">Moldova</option>
  <option value="MC" data-code="+377">Monaco</option>
  <option value="MN" data-code="+976">Mongolia</option>
  <option value="ME" data-code="+382">Montenegro</option>
  <option value="MS" data-code="+1-664">Montserrat</option>
  <option value="MA" data-code="+212">Morocco</option>
  <option value="MZ" data-code="+258">Mozambique</option>
  <option value="MM" data-code="+95">Myanmar</option>
  <option value="NA" data-code="+264">Namibia</option>
  <option value="NR" data-code="+674">Nauru</option>
  <option value="NP" data-code="+977">Nepal</option>
  <option value="NL" data-code="+31">Netherlands</option>
  <option value="NC" data-code="+687">New Caledonia</option>
  <option value="NZ" data-code="+64">New Zealand</option>
  <option value="NI" data-code="+505">Nicaragua</option>
  <option value="NE" data-code="+227">Niger</option>
  <option value="NG" data-code="+234">Nigeria</option>
  <option value="NU" data-code="+683">Niue</option>
  <option value="KP" data-code="+850">North Korea</option>
  <option value="NO" data-code="+47">Norway</option>
  <option value="OM" data-code="+968">Oman</option>
  <option value="PK" data-code="+92">Pakistan</option>
  <option value="PW" data-code="+680">Palau</option>
  <option value="PA" data-code="+507">Panama</option>
  <option value="PG" data-code="+675">Papua New Guinea</option>
  <option value="PY" data-code="+595">Paraguay</option>
  <option value="PE" data-code="+51">Peru</option>
  <option value="PH" data-code="+63">Philippines</option>
  <option value="PL" data-code="+48">Poland</option>
  <option value="PT" data-code="+351">Portugal</option>
  <option value="PR" data-code="+1-787">Puerto Rico</option>
  <option value="QA" data-code="+974">Qatar</option>
  <option value="RO" data-code="+40">Romania</option>
  <option value="RU" data-code="+7">Russia</option>
  <option value="RW" data-code="+250">Rwanda</option>
  <option value="KN" data-code="+1-869">Saint Kitts and Nevis</option>
  <option value="LC" data-code="+1-758">Saint Lucia</option>
  <option value="VC" data-code="+1-784">Saint Vincent and the Grenadines</option>
  <option value="WS" data-code="+685">Samoa</option>
  <option value="SM" data-code="+378">San Marino</option>
  <option value="ST" data-code="+239">São Tomé and Príncipe</option>
  <option value="SA" data-code="+966">Saudi Arabia</option>
  <option value="SN" data-code="+221">Senegal</option>
  <option value="RS" data-code="+381">Serbia</option>
  <option value="SC" data-code="+248">Seychelles</option>
  <option value="SL" data-code="+232">Sierra Leone</option>
  <option value="SG" data-code="+65">Singapore</option>
  <option value="SK" data-code="+421">Slovakia</option>
  <option value="SI" data-code="+386">Slovenia</option>
  <option value="SB" data-code="+677">Solomon Islands</option>
  <option value="SO" data-code="+252">Somalia</option>
  <option value="ZA" data-code="+27">South Africa</option>
  <option value="KR" data-code="+82">South Korea</option>
  <option value="SS" data-code="+211">South Sudan</option>
  <option value="ES" data-code="+34">Spain</option>
  <option value="LK" data-code="+94">Sri Lanka</option>
  <option value="SD" data-code="+249">Sudan</option>
  <option value="SR" data-code="+597">Suriname</option>
  <option value="SE" data-code="+46">Sweden</option>
  <option value="CH" data-code="+41">Switzerland</option>
  <option value="SY" data-code="+963">Syria</option>
  <option value="TW" data-code="+886">Taiwan</option>
  <option value="TJ" data-code="+992">Tajikistan</option>
  <option value="TZ" data-code="+255">Tanzania</option>
  <option value="TH" data-code="+66">Thailand</option>
  <option value="TL" data-code="+670">Timor-Leste</option>
  <option value="TG" data-code="+228">Togo</option>
  <option value="TO" data-code="+676">Tonga</option>
  <option value="TT" data-code="+1-868">Trinidad and Tobago</option>
  <option value="TN" data-code="+216">Tunisia</option>
  <option value="TR" data-code="+90">Turkey</option>
  <option value="TM" data-code="+993">Turkmenistan</option>
  <option value="TV" data-code="+688">Tuvalu</option>
  <option value="UG" data-code="+256">Uganda</option>
  <option value="UA" data-code="+380">Ukraine</option>
  <option value="AE" data-code="+971">United Arab Emirates</option>
  <option value="GB" data-code="+44">United Kingdom</option>
  <option value="US" data-code="+1">United States</option>
  <option value="UY" data-code="+598">Uruguay</option>
  <option value="UZ" data-code="+998">Uzbekistan</option>
  <option value="VU" data-code="+678">Vanuatu</option>
  <option value="VA" data-code="+379">Vatican City</option>
  <option value="VE" data-code="+58">Venezuela</option>
  <option value="VN" data-code="+84">Vietnam</option>
  <option value="YE" data-code="+967">Yemen</option>
  <option value="ZM" data-code="+260">Zambia</option>
  <option value="ZW" data-code="+263">Zimbabwe</option>
</select>


    </div>

    <!-- Phone -->
    <div class="col-span-2">
      <label for="phone">Enter Phone*</label>
      <input type="text" name="phone" id="phone" placeholder="Enter Phone" required>
    </div>

    <!-- Email -->
    <div class="col-span-2">
      <label for="email">Enter Email*</label>
      <input type="text" name="email" id="email" placeholder="Enter Email" required>
    </div>

    <!-- Submit Button -->
    <div class="col-span-2">
      <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded">Register Now</button>
    </div>
  </div>
</form>

<script>
  const countrySelect = document.getElementById('country');
  const phoneInput = document.getElementById('phone');

  // Set default country code on page load
  window.addEventListener('DOMContentLoaded', () => {
    const selectedOption = countrySelect.options[countrySelect.selectedIndex];
    phoneInput.value = selectedOption.dataset.code + " ";
  });

  // Update phone prefix when country changes
  countrySelect.addEventListener('change', () => {
    const code = countrySelect.options[countrySelect.selectedIndex].dataset.code;
    // Remove any previous code and set new one
    const phoneParts = phoneInput.value.split(" ");
    phoneParts[0] = code; // update country code
    phoneInput.value = phoneParts.join(" ").trim() + " ";
    phoneInput.focus();
  });
</script>

    <div class="footer-links">
      Already have an account? <a href="login">Login</a><br>
      Go back to 
      <a href="index">Home</a> 
    </div>
  </div>
</body>
</html>
