<div class="container register-container">
  <img class = "loading-image" src = "./images/loading-gif.gif">
  <div class="row">
    <div class="register-form-container">
      <?php
        if(!empty($error)){ 
        ?>
          <div class = "alert">
            <?=$error?>
          </div>
        <?php
        }
      ?>
      <form method = "post">
        <h3 id="register-form-header">What are you waiting for?<br/>Join us now!</h3>
        <div class="row name-row">
          <div style = "display:none" class="form-group col-12 company-group">
            <label for="company-field">Company Name</label>
            <input
              type="text"
              name="company"
              id="company-field"
              placeholder="Company Name"
            />
          </div>
          <div class="form-group col-6 name-group">
            <label for="firstname-field">First Name</label>
            <input
              type="text"
              name="firstname"
              id="firstname-field"
              placeholder="First Name"
            />
          </div>
          <div class="form-group col-6 name-group">
            <label for="lastname-field">Last Name</label>
            <input
              type="text"
              name="lastname"
              id="lastname-field"
              placeholder="Last Name"
            />
          </div>
        </div>
        <div class="form-group">
          <label for="email-field">Email Address</label>
          <input
            type="email"
            name="email"
            id="email-field"
            placeholder="Email"
          />
        </div>
        <div style = "display:none;" class = "form-group company-description-group">
          <label for="description-field">Company Description</label>
          <textarea rows = "10" name = "description" id = "description-field" placeholder = "Description"></textarea>
        </div>
        <div class="form-group">
          <label for="birth-date-field">Birth Date</label>
          <input
            type="date"
            name="birth-date"
            id="birth-date-field"
          />
        </div>
        <div class="form-group">
          <label for="password-field">Password</label>
          <input
            type="password"
            name="pwd"
            id="password-field"
            placeholder="Password"
          />
        </div>
        <div class="form-group">
          <label for="confirm-password-field">Confirm Password</label>
          <input
            type="password"
            name="confirm-pwd"
            id="confirm-password-field"
            placeholder="Password"
          />
        </div>
        <div class="form-group country-group">
          <label for="country-field">Nationality</label>
          <select id = "country-field" name = "country">
            <option value="None">None</option>
            <option value="Afghanistan">Afghanistan</option>
            <option value="Aland Islands">Aland Islands</option>
            <option value="Albania">Albania</option>
            <option value="Algeria">Algeria</option>
            <option value="American Samoa">American Samoa</option>
            <option value="Andorra">Andorra</option>
            <option value="Angola">Angola</option>
            <option value="Anguilla">Anguilla</option>
            <option value="Antarctica">Antarctica</option>
            <option value="Antigua and Barbuda">Antigua and Barbuda</option>
            <option value="Argentina">Argentina</option>
            <option value="Armenia">Armenia</option>
            <option value="Aruba">Aruba</option>
            <option value="Australia">Australia</option>
            <option value="Austria">Austria</option>
            <option value="Azerbaijan">Azerbaijan</option>
            <option value="Bahamas">Bahamas</option>
            <option value="Bahrain">Bahrain</option>
            <option value="Bangladesh">Bangladesh</option>
            <option value="Barbados">Barbados</option>
            <option value="Belarus">Belarus</option>
            <option value="Belgium">Belgium</option>
            <option value="Belize">Belize</option>
            <option value="Benin">Benin</option>
            <option value="Bermuda">Bermuda</option>
            <option value="Bhutan">Bhutan</option>
            <option value="Bolivia">Bolivia</option>
            <option value="Bonaire, Sint Eustatius and Saba">Bonaire, Sint Eustatius and Saba</option>
            <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
            <option value="Botswana">Botswana</option>
            <option value="Bouvet Island">Bouvet Island</option>
            <option value="Brazil">Brazil</option>
            <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
            <option value="Brunei Darussalam">Brunei Darussalam</option>
            <option value="Bulgaria">Bulgaria</option>
            <option value="Burkina Faso">Burkina Faso</option>
            <option value="Burundi">Burundi</option>
            <option value="Cambodia">Cambodia</option>
            <option value="Cameroon">Cameroon</option>
            <option value="Canada">Canada</option>
            <option value="Cape Verde">Cape Verde</option>
            <option value="Cayman Islands">Cayman Islands</option>
            <option value="Central African Republic">Central African Republic</option>
            <option value="Chad">Chad</option>
            <option value="Chile">Chile</option>
            <option value="China">China</option>
            <option value="Christmas Island">Christmas Island</option>
            <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
            <option value="Colombia">Colombia</option>
            <option value="Comoros">Comoros</option>
            <option value="Congo">Congo</option>
            <option value="Congo, Democratic Republic of the Congo">Congo, Democratic Republic of the Congo</option>
            <option value="Cook Islands">Cook Islands</option>
            <option value="Costa Rica">Costa Rica</option>
            <option value="Cote D'Ivoire">Cote D'Ivoire</option>
            <option value="Croatia">Croatia</option>
            <option value="Cuba">Cuba</option>
            <option value="Curacao">Curacao</option>
            <option value="Cyprus">Cyprus</option>
            <option value="Czech Republic">Czech Republic</option>
            <option value="Denmark">Denmark</option>
            <option value="Djibouti">Djibouti</option>
            <option value="Dominica">Dominica</option>
            <option value="Dominican Republic">Dominican Republic</option>
            <option value="Ecuador">Ecuador</option>
            <option value="Egypt">Egypt</option>
            <option value="El Salvador">El Salvador</option>
            <option value="Equatorial Guinea">Equatorial Guinea</option>
            <option value="Eritrea">Eritrea</option>
            <option value="Estonia">Estonia</option>
            <option value="Ethiopia">Ethiopia</option>
            <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
            <option value="Faroe Islands">Faroe Islands</option>
            <option value="Fiji">Fiji</option>
            <option value="Finland">Finland</option>
            <option value="France">France</option>
            <option value="French Guiana">French Guiana</option>
            <option value="French Polynesia">French Polynesia</option>
            <option value="French Southern Territories">French Southern Territories</option>
            <option value="Gabon">Gabon</option>
            <option value="Gambia">Gambia</option>
            <option value="Georgia">Georgia</option>
            <option value="Germany">Germany</option>
            <option value="Ghana">Ghana</option>
            <option value="Gibraltar">Gibraltar</option>
            <option value="Greece">Greece</option>
            <option value="Greenland">Greenland</option>
            <option value="Grenada">Grenada</option>
            <option value="Guadeloupe">Guadeloupe</option>
            <option value="Guam">Guam</option>
            <option value="Guatemala">Guatemala</option>
            <option value="Guernsey">Guernsey</option>
            <option value="Guinea">Guinea</option>
            <option value="Guinea-Bissau">Guinea-Bissau</option>
            <option value="Guyana">Guyana</option>
            <option value="Haiti">Haiti</option>
            <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
            <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
            <option value="Honduras">Honduras</option>
            <option value="Hong Kong">Hong Kong</option>
            <option value="Hungary">Hungary</option>
            <option value="Iceland">Iceland</option>
            <option value="India">India</option>
            <option value="Indonesia">Indonesia</option>
            <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
            <option value="Iraq">Iraq</option>
            <option value="Ireland">Ireland</option>
            <option value="Isle of Man">Isle of Man</option>
            <option value="Israel">Israel</option>
            <option value="Italy">Italy</option>
            <option value="Jamaica">Jamaica</option>
            <option value="Japan">Japan</option>
            <option value="Jersey">Jersey</option>
            <option value="Jordan">Jordan</option>
            <option value="Kazakhstan">Kazakhstan</option>
            <option value="Kenya">Kenya</option>
            <option value="Kiribati">Kiribati</option>
            <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
            <option value="Korea, Republic of">Korea, Republic of</option>
            <option value="Kosovo">Kosovo</option>
            <option value="Kuwait">Kuwait</option>
            <option value="Kyrgyzstan">Kyrgyzstan</option>
            <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
            <option value="Latvia">Latvia</option>
            <option value="Lebanon">Lebanon</option>
            <option value="Lesotho">Lesotho</option>
            <option value="Liberia">Liberia</option>
            <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
            <option value="Liechtenstein">Liechtenstein</option>
            <option value="Lithuania">Lithuania</option>
            <option value="Luxembourg">Luxembourg</option>
            <option value="Macao">Macao</option>
            <option value="Macedonia, the Former Yugoslav Republic of">Macedonia, the Former Yugoslav Republic of</option>
            <option value="Madagascar">Madagascar</option>
            <option value="Malawi">Malawi</option>
            <option value="Malaysia">Malaysia</option>
            <option value="Maldives">Maldives</option>
            <option value="Mali">Mali</option>
            <option value="Malta">Malta</option>
            <option value="Marshall Islands">Marshall Islands</option>
            <option value="Martinique">Martinique</option>
            <option value="Mauritania">Mauritania</option>
            <option value="Mauritius">Mauritius</option>
            <option value="Mayotte">Mayotte</option>
            <option value="Mexico">Mexico</option>
            <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
            <option value="Moldova, Republic of">Moldova, Republic of</option>
            <option value="Monaco">Monaco</option>
            <option value="Mongolia">Mongolia</option>
            <option value="Montenegro">Montenegro</option>
            <option value="Montserrat">Montserrat</option>
            <option value="Morocco">Morocco</option>
            <option value="Mozambique">Mozambique</option>
            <option value="Myanmar">Myanmar</option>
            <option value="Namibia">Namibia</option>
            <option value="Nauru">Nauru</option>
            <option value="Nepal">Nepal</option>
            <option value="Netherlands">Netherlands</option>
            <option value="Netherlands Antilles">Netherlands Antilles</option>
            <option value="New Caledonia">New Caledonia</option>
            <option value="New Zealand">New Zealand</option>
            <option value="Nicaragua">Nicaragua</option>
            <option value="Niger">Niger</option>
            <option value="Nigeria">Nigeria</option>
            <option value="Niue">Niue</option>
            <option value="Norfolk Island">Norfolk Island</option>
            <option value="Northern Mariana Islands">Northern Mariana Islands</option>
            <option value="Norway">Norway</option>
            <option value="Oman">Oman</option>
            <option value="Pakistan">Pakistan</option>
            <option value="Palau">Palau</option>
            <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
            <option value="Panama">Panama</option>
            <option value="Papua New Guinea">Papua New Guinea</option>
            <option value="Paraguay">Paraguay</option>
            <option value="Peru">Peru</option>
            <option value="Philippines">Philippines</option>
            <option value="Pitcairn">Pitcairn</option>
            <option value="Poland">Poland</option>
            <option value="Portugal">Portugal</option>
            <option value="Puerto Rico">Puerto Rico</option>
            <option value="Qatar">Qatar</option>
            <option value="Reunion">Reunion</option>
            <option value="Romania">Romania</option>
            <option value="Russian Federation">Russian Federation</option>
            <option value="Rwanda">Rwanda</option>
            <option value="Saint Barthelemy">Saint Barthelemy</option>
            <option value="Saint Helena">Saint Helena</option>
            <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
            <option value="Saint Lucia">Saint Lucia</option>
            <option value="Saint Martin">Saint Martin</option>
            <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
            <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
            <option value="Samoa">Samoa</option>
            <option value="San Marino">San Marino</option>
            <option value="Sao Tome and Principe">Sao Tome and Principe</option>
            <option value="Saudi Arabia">Saudi Arabia</option>
            <option value="Senegal">Senegal</option>
            <option value="Serbia">Serbia</option>
            <option value="Serbia and Montenegro">Serbia and Montenegro</option>
            <option value="Seychelles">Seychelles</option>
            <option value="Sierra Leone">Sierra Leone</option>
            <option value="Singapore">Singapore</option>
            <option value="Sint Maarten">Sint Maarten</option>
            <option value="Slovakia">Slovakia</option>
            <option value="Slovenia">Slovenia</option>
            <option value="Solomon Islands">Solomon Islands</option>
            <option value="Somalia">Somalia</option>
            <option value="South Africa">South Africa</option>
            <option value="South Georgia and the South Sandwich Islands">South Georgia and the South Sandwich Islands</option>
            <option value="South Sudan">South Sudan</option>
            <option value="Spain">Spain</option>
            <option value="Sri Lanka">Sri Lanka</option>
            <option value="Sudan">Sudan</option>
            <option value="Suriname">Suriname</option>
            <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
            <option value="Swaziland">Swaziland</option>
            <option value="Sweden">Sweden</option>
            <option value="Switzerland">Switzerland</option>
            <option value="Syrian Arab Republic">Syrian Arab Republic</option>
            <option value="Taiwan, Province of China">Taiwan, Province of China</option>
            <option value="Tajikistan">Tajikistan</option>
            <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
            <option value="Thailand">Thailand</option>
            <option value="Timor-Leste">Timor-Leste</option>
            <option value="Togo">Togo</option>
            <option value="Tokelau">Tokelau</option>
            <option value="Tonga">Tonga</option>
            <option value="Trinidad and Tobago">Trinidad and Tobago</option>
            <option value="Tunisia">Tunisia</option>
            <option value="Turkey">Turkey</option>
            <option value="Turkmenistan">Turkmenistan</option>
            <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
            <option value="Tuvalu">Tuvalu</option>
            <option value="Uganda">Uganda</option>
            <option value="Ukraine">Ukraine</option>
            <option value="United Arab Emirates">United Arab Emirates</option>
            <option value="United Kingdom">United Kingdom</option>
            <option value="United States">United States</option>
            <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
            <option value="Uruguay">Uruguay</option>
            <option value="Uzbekistan">Uzbekistan</option>
            <option value="Vanuatu">Vanuatu</option>
            <option value="Venezuela">Venezuela</option>
            <option value="Viet Nam">Viet Nam</option>
            <option value="Virgin Islands, British">Virgin Islands, British</option>
            <option value="Virgin Islands, U.s.">Virgin Islands, U.s.</option>
            <option value="Wallis and Futuna">Wallis and Futuna</option>
            <option value="Western Sahara">Western Sahara</option>
            <option value="Yemen">Yemen</option>
            <option value="Zambia">Zambia</option>
            <option value="Zimbabwe">Zimbabwe</option>
          </select>
        </div>
        <div class="form-group">
          <label for="province-field">Province</label>
          <select id = "province-field" name = "province">
            <option value="An Giang">An Giang</option>
            <option value="Bà Rịa-Vũng Tàu">Bà Rịa-Vũng Tàu</option>
            <option value="Bắc Giang">Bắc Giang</option>
            <option value="Bắc Kạn">Bắc Kạn</option>
            <option value="Bạc Liêu">Bạc Liêu</option>
            <option value="Bắc Ninh">Bắc Ninh</option>
            <option value="Bến Tre">Bến Tre</option>
            <option value="Bình Định">Bình Định</option>
            <option value="Bình Dương">Bình Dương</option>
            <option value="Bình Phước">Bình Phước</option>
            <option value="Bình Thuận">Bình Thuận</option>
            <option value="Cà Mau">Cà Mau</option>
            <option value="Cần Thơ">Cần Thơ</option>
            <option value="Cao Bằng">Cao Bằng</option>
            <option value="Đà Nẵng">Đà Nẵng</option>
            <option value="Đắk Lắk">Đắk Lắk</option>
            <option value="Đắk Nông">Đắk Nông</option>
            <option value="Điện Biên">Điện Biên</option>
            <option value="Đồng Nai">Đồng Nai</option>
            <option value="Đồng Tháp">Đồng Tháp</option>
            <option value="Gia Lai">Gia Lai</option>
            <option value="Hà Giang">Hà Giang</option>
            <option value="Hà Nam">Hà Nam</option>
            <option value="Hà Nội">Hà Nội</option>
            <option value="Hà Tĩnh">Hà Tĩnh</option>
            <option value="Hải Dương">Hải Dương</option>
            <option value="Hải Phòng">Hải Phòng</option>
            <option value="Hậu Giang">Hậu Giang</option>
            <option value="Hồ Chí Minh">Hồ Chí Minh</option>
            <option value="Hòa Bình">Hòa Bình</option>
            <option value="Hưng Yên">Hưng Yên</option>
            <option value="Khánh Hòa">Khánh Hòa</option>
            <option value="Kiên Giang">Kiên Giang</option>
            <option value="Kon Tum">Kon Tum</option>
            <option value="Lai Châu">Lai Châu</option>
            <option value="Lâm Đồng">Lâm Đồng</option>
            <option value="Lạng Sơn">Lạng Sơn</option>
            <option value="Lào Cai">Lào Cai</option>
            <option value="Long An">Long An</option>
            <option value="Nam Định">Nam Định</option>
            <option value="Nghệ An">Nghệ An</option>
            <option value="Ninh Bình">Ninh Bình</option>
            <option value="Ninh Thuận">Ninh Thuận</option>
            <option value="Phú Thọ">Phú Thọ</option>
            <option value="Phú Yên">Phú Yên</option>
            <option value="Quảng Bình">Quảng Bình</option>
            <option value="Quảng Nam">Quảng Nam</option>
            <option value="Quảng Ngãi">Quảng Ngãi</option>
            <option value="Quảng Ninh">Quảng Ninh</option>
            <option value="Quảng Trị">Quảng Trị</option>
            <option value="Sóc Trăng">Sóc Trăng</option>
            <option value="Sơn La">Sơn La</option>
            <option value="Tây Ninh">Tây Ninh</option>
            <option value="Thái Bình">Thái Bình</option>
            <option value="Thái Nguyên">Thái Nguyên</option>
            <option value="Thanh Hóa">Thanh Hóa</option>
            <option value="Thừa Thiên-Huế">Thừa Thiên-Huế</option>
            <option value="Tiền Giang">Tiền Giang</option>
            <option value="Trà Vinh">Trà Vinh</option>
            <option value="Tuyên Quang">Tuyên Quang</option>
            <option value="Vĩnh Long">Vĩnh Long</option>
            <option value="Vĩnh Phúc">Vĩnh Phúc</option>
            <option value="Yên Bái">Yên Bái</option>
          </select>
        </div>
        <div style = "display:none;" class="form-group company-type-group">
          <label for="company-type-field">Company Type</label>
          <select id = "company-type-field" name = "company-type">

          </select>
        </div>
        <div class = "option-row-wrapper">
          <h4>Account Type</h4>
          <div class="row option-row">
            <div class="form-group col-6">
              <input
                onchange = "changeMode()"
                type="radio"
                name="type"
                id="seeker-option"
                value="seeker"
                checked
              />
              <label for="seeker-option">Seeker</label>
            </div>
            <div class="form-group col-6">
                <input
                  onchange = "changeMode()"
                  type="radio"
                  name="type"
                  id="company-option"
                  value="company"
                />
                <label for="company-option">Company</label>
            </div>
            <div class = "btn-group">
              <input type = "hidden" name = "action" value = "register" id = "action-input-field">
              <button type = "button" class = "btn btn-fill btn-account-register">Submit</button>
              <button type = "reset" class = "btn btn-outline reset-info-btn" >Reset Information</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  $.ajax({
    type: "get",
    url: "http://localhost/models/api/companyType/companyType.php",
    contentType: "application/json",
    success: function (response) {
      let data = response['data'];
      let allOptions = '';
      data.forEach(dataElement => {
        allOptions += `<option value="${dataElement['CompanyTypeId']}">${dataElement['CompanyTypeName']}</option>`
      });
      $("#company-type-field").html(allOptions);
    }
  });
  function displayMessage(message){
    let messageAlert = $(".alert");
    if(messageAlert.length === 0){
      $(".register-container").append(`<div class = "alert">${message}</div>`);
    }
    else{
      messageAlert.html(message);
    }
  }
  $(".btn-account-register").on("click", function(){
    let typeOfAccount = $("input[name='type']:checked").val();
    if(typeOfAccount === "seeker"){
      let firstname = $("#firstname-field").val().trim();
      let lastname = $("#lastname-field").val().trim();
      let email = $("#email-field").val().trim();
      let birthdate = $("#birth-date-field").val();
      let password = $("#password-field").val().trim();
      let confirmPassword = $("#confirm-password-field").val().trim();
      let nationality = $("#country-field").val();
      let province = $("#province-field").val();
      if(!firstname || !lastname || !email || !birthdate || !password || !confirmPassword || !nationality || !province){
        displayMessage("Please enter all of the fields");
      }
      else if(firstname.length === 0 || lastname.length === 0 || email.length === 0 || password.length === 0 || confirmPassword.length === 0 || nationality.length === 0 || province.length === 0){
        displayMessage("Some fields are left empty");
      }
      else if(password !== confirmPassword){
        displayMessage("Passwords are not the same");
      }
      else{
        $.ajax({
          type: "post",
          url: "http://localhost/models/api/register/seekerRegister.php",
          data: JSON.stringify({
            firstname: firstname,
            lastname: lastname,
            email: email,
            password: password,
            birth_date:birthdate,
            nationality: nationality,
            province: province,
          }),
          contentType: "application/json",
          beforeSend: function(){
            $(".loading-image").show();
          },
          success: function (res) {
            displayMessage(res['msg']);
          },
          error: function(xhr, status, err){
            displayMessage(xhr.responseJSON['error']);
          },
          complete: function(){
            $(".loading-image").hide();
          },
        });
      }
    }
    else if(typeOfAccount === "company"){
      let companyName = $("#company-field").val().trim();
      let email = $("#email-field").val().trim();
      let description = $("#description-field").val();
      let dateCreated = $("#birth-date-field").val();
      let password = $("#password-field").val().trim();
      let confirmPassword = $("#confirm-password-field").val().trim();
      let country = $("#country-field").val();
      let province = $("#province-field").val();
      let companyType = $("#company-type-field").val();
      if(!companyName || !email || !description || !dateCreated || !password || !confirmPassword || !country || !province || !companyType){
        displayMessage("Please enter all of the fields");
      }
      else if(companyName.length === 0 || email.length === 0 || description.length === 0 || dateCreated.length === 0 || password.length === 0 || confirmPassword.length === 0 || country.length === 0 || province.length === 0){
        displayMessage("Some fields are left empty");
      }
      else if(password !== confirmPassword){
        displayMessage("Passwords are not the same");
      }
      else{
        $.ajax({
          type: "post",
          url: "http://localhost/models/api/register/companyRegister.php",
          data: JSON.stringify({
            companyName:companyName,
            email:email,
            description:description,
            dateCreated:dateCreated,
            password: password,
            country: country,
            province:province,
            companyType:companyType,
          }),
          contentType: "application/json",
          beforeSend: function(){
            $(".loading-image").show();
          },
          success: function (res) {
            displayMessage(res['msg']);
          },
          error:function(xhr, status, err){
            displayMessage(xhr.responseJSON['error']);
          },
          complete: function(){
            $(".loading-image").hide();
          }
        });
      }
    }
  });
</script>