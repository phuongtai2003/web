<form method = "get" id = "search-form"></form>
  <div class="container job-container">
    <div class="row">
      <div class="col-3">
        <div class="user-profile-container">
          <img class="user-avatar" src="./images/person.png" alt="">
          <?php
            if($role !== 'seeker'){
              ?>
                <h3 class="user-name">Guess</h3>
                <p class="user-profession">Not Sign In</p>
                <a href="?page=login" class="btn btn-fill btn-edit-account">Sign In</a>
              <?php
            }
            else{
              ?>
                <h3 class="user-name"><?=$_SESSION['name']?></h3>
              <?php
            }
          ?>
        </div>
      </div>
      <div class="col-6">
        <div class="search-box">
          <h3 class="search-box-title">Search Jobs</h3>
          <div class="search-section">
            <input type = "hidden" name = "page" value="job" form = "search-form">
            <div class="search-input">
              <i class="fas fa-search"></i>
              <input type="text" name="job-title" id="job-search-input" value = '<?= $job_name?>' form = "search-form" />
            </div>
            <button type = "submit" class="btn btn-outline btn-search" form = "search-form" >Search</button>
          </div>
          <div class="container job-result-number">
            <p><?=count($job)?> Jobs Founded</p>
          </div>
        </div>
        <?php
          if(!empty($error)){
            ?>
              <div class = "alert"><?=$error?></div>
            <?php
          }
          else if(!empty($msg)){
            ?>
              <div class = "alert" ><?=$msg?></div>
            <?php
          }
        ?>
        <div class="job-listing">
          <?php
            for($i = 0; $i < count($display_job); $i++){
              ?>
              <form method = 'post'></form>
                <div class="job-item">
                  <div class="job-header">
                    <img src="<?=$display_job[$i]['CompanyImage'] ==null ?"./images/defaultCompany.png" : $display_job[$i]['CompanyImage'] ?>" alt="" />
                    <div class="job-company">
                      <a href="?job_details=<?=$display_job[$i]['JobId']?>" class="job-name"><?=$display_job[$i]['JobName']?></a>
                      <a style = "font-size: 18px; color: var(--primary-color); display:block" href = "?comp_details=<?=$display_job[$i]['CompanyId']?>"><?=$display_job[$i]['CompanyName']?></a>
                    </div>
                    <?php 
                      if($role === 'seeker' && !$bookmark_data[$i]){
                        ?>
                          <form style = "width: fit-content; margin-left:auto" method = "post">
                            <input type = "hidden" name = "action" value ="bookmark-job">
                            <input type = "hidden" name = "job" value = "<?=$display_job[$i]['JobId']?>">
                            <button type = "submit" class="btn save-icon un-save">
                              <i class="fa-regular fa-bookmark"></i>
                            </button>
                          </form>
                        <?php
                        }
                        else if($role === 'seeker' && $bookmark_data[$i]){
                          ?>
                            <form style = "width: fit-content; margin-left:auto" method = "post">
                              <input type = "hidden" name = "action" value ="remove-bookmark">
                              <input type = "hidden" name = "job" value = "<?=$display_job[$i]['JobId']?>">
                              <button type = "submit" class="btn save-icon">
                                <i class="fa-regular fa-bookmark"></i>
                              </button>
                            </form>
                          <?php
                        }
                        else if(empty($role)){
                          ?>
                            <a href = "?page=login" class="btn save-icon">
                              <i class="fa-regular fa-bookmark"></i>
                            </a>
                          <?php
                        }
                      ?>
                  </div>
                  <p class="job-description">
                      <?=str_replace("<br />","",$display_job[$i]['JobDescription'])?>
                  </p>
                  <div class="button-row-wrapper">
                    <?php
                      for($j = 0; $j < count($job_skills[$i]); $j++){
                        ?>
                          <div class="btn skill"><?=$job_skills[$i][$j]['SkillName']?></div>
                        <?php
                      }
                      if($role === 'seeker' && !$application_data[$i]){
                        ?>
                          <form style = "width: fit-content; margin-left:auto" method = "post">
                            <input type = "hidden" name = "action" value = "apply-job">
                            <input type = "hidden" name = "job" value = "<?=$display_job[$i]['JobId']?>">
                            <button type = "submit" class="btn btn-outline btn-apply">Apply</button>
                          </form>
                        <?php
                      }
                      else if($role === 'seeker' && $application_data[$i]){
                        ?>
                          <form style = "width: fit-content; margin-left:auto" method = "post">
                            <input type = "hidden" name = "action" value = "remove-apply">
                            <input type = "hidden" name = "job" value = "<?=$display_job[$i]['JobId']?>">
                            <button type = "submit" class="btn btn-outline btn-apply">Unapply</button>
                          </form>
                        <?php
                      }
                      else if(empty($role)){
                        ?>
                          <a href = "?page=login" class="btn btn-outline btn-apply">Login</a>
                        <?php
                      }
                    ?>
                  </div>
                </div>
            <?php 
          }
          ?>
        </div>
        <div class="page-row">
          <?php
            for($i = 1; $i <= $total_page; $i++){
                $anchor_href = "?page=job";
                if(isset($_GET['job-title'])){
                  $anchor_href .= "&job-title=".$_GET['job-title'];
                }
                if(isset($_GET['experience-level'])){
                  $anchor_href .= "&experience-level=".$_GET['experience-level'];
                }
                if(isset($_GET['job-field'])){
                  $anchor_href .= "&job-field=".$_GET['job-field'];
                }
                if(isset($_GET['job-location-type'])){
                  $anchor_href .= "&job-location-type=".$_GET['job-location-type'];
                }
                if(isset($_GET['job-level'])){
                  $anchor_href .= "&job-level=".$_GET['job-level'];
                }
                if(isset($_GET['company-type'])){
                  $anchor_href .= "&company-type=".$_GET['company-type'];
                }
                $anchor_href .= "&pageNum=$i";
              ?>
                <a href = "<?=$anchor_href?>" class="page-index"><?=$i?></a>
              <?php
            }
          ?>
        </div>
      </div>
      <div class="col-3">
        <div class="filter-reset-container">
          <h2 class="job-filter-title">Job Filter</h2>
          <button type = "button" class="btn btn-clear">Clear All</button>
        </div>
        <!--Experience level-->
        <div class="form-group" >
          <div class="form-group-header">
            <legend class="form-group-label">Experience Level</legend>
            <button type = "button" class="btn btn-clear">Clear</button>
          </div>
          <select id = "experience-level-field" name = "experience-level" form = "search-form">
            <option value = "-1">Not Specify</option>
          </select>
        </div>
        <!--Job Field-->
        <div class="form-group" >
          <div class="form-group-header">
            <legend class="form-group-label">Job Field</legend>
            <button type = "button" class="btn btn-clear">Clear</button>
          </div>
          <select id = "job-field-field" name = "job-field" form = "search-form">
            <option value = "-1">Not Specify</option>
          </select>
        </div>
        <!--Job Location Type-->
        <div class="form-group">
          <div class="form-group-header">
            <legend class="form-group-label">Job Location</legend>
            <button type = "button" class="btn btn-clear">Clear</button>
          </div>
          <select id = "job-location-type-field" name = "job-location-type" form = "search-form">
            <option value = "-1">Not Specify</option>
          </select>
        </div>
        <!--Job Level-->
        <div class="form-group">
          <div class="form-group-header">
            <legend class="form-group-label">Job Level</legend>
            <button type = "button" class="btn btn-clear">Clear</button>
          </div>
          <select id = "job-level-field" name = "job-level" form = "search-form">
            <option value = "-1">Not Specify</option>
          </select>
        </div>
        <!--Company Type-->
        <div class="form-group">
          <div class="form-group-header">
            <legend class="form-group-label">Company Type</legend>
            <button type = "button" class="btn btn-clear">Clear</button>
          </div>
          <select id = "company-type-field" name = "company-type" form = "search-form">
            <option value = "-1">Not Specify</option>
          </select>
        </div>
      </div>
    </div>
  </div>
<script>

  $.ajax({
    type: "get",
    url: "http://localhost/models/api/jobExperience/getData.php",
    success: function (response) {
      const data = response['data'];
      let optionList = '';
      data.forEach(dataElement => {
          optionList += `
            <option value="${dataElement['JobExperienceId']}">${dataElement['JobExperienceName']}</option>
          `
      });
      $("#experience-level-field").append(optionList);
    }
  });

  $.ajax({
    type: "get",
    url: "http://localhost/models/api/jobField/getData.php",
    success: function (response) {
      const data = response['data'];
      let optionList = '';
      data.forEach(dataElement => {
          optionList += `
            <option value="${dataElement['JobFieldId']}">${dataElement['JobFieldName']}</option>
          `
      });
      $("#job-field-field").append(optionList);
    }
  });

  $.ajax({
    type: "get",
    url: "http://localhost/models/api/jobLocationType/getData.php",
    success: function (response) {
      const data = response['data'];
      let optionList = '';
      data.forEach(dataElement => {
          optionList += `
          <option value="${dataElement['JobLocationTypeId']}">${dataElement['JobLocationTypeName']}</option>
          `
      });
      $("#job-location-type-field").append(optionList);
    }
  });

  $.ajax({
    type: "get",
    url: "http://localhost/models/api/jobLevel/getData.php",
    success: function (response) {
      const data = response['data'];
      let optionList = '';
      data.forEach(dataElement => {
          optionList += `
          <option value="${dataElement['JobLevelId']}">${dataElement['JobLevelName']}</option>
          `
      });
      $("#job-level-field").append(optionList);
    }
  });

  $.ajax({
    type: "get",
    url: "http://localhost/models/api/companyType/companyType.php",
    success: function (response) {
      const data = response['data'];
      let optionList = '';
      data.forEach(dataElement => {
          optionList += `
          <option value="${dataElement['CompanyTypeId']}">${dataElement['CompanyTypeName']}</option>
          `
      });
      $("#company-type-field").append(optionList);
    }
  });
</script>