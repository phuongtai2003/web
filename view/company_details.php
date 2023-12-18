<div class="container company-detail-container">
  <?php
    if(!empty($error)){
      ?>
        <div class = "alert"><?=$error?></div>
      <?php
    }
    else if(!empty($msg)){
      ?>
        <div class = "alert"><?=$msg?></div>
      <?php
    }
  ?>
  <div class="company-detail-header">
    <div class="img-container">
      <img src="<?=$company_info['CompanyImage'] == null ? "./images/defaultCompany.png" : $company_info['CompanyImage'] ?>" alt="" />
    </div>
    <div class="company-name">
      <h1><?=$company_info['CompanyName']?></h1>
      <div class="employee-site">
        <p>Established on <?=date("d/m/Y",strtotime($company_info['DateCreated']))?></p>
        <a href="https://google.com">Website</a>
      </div>
    </div>
    <button class="btn btn-fill btn-follow-company">Follow Company</button>
  </div>
  <div class="company-description-container">
    <div class="row">
      <div class="col-wrapper col-8">
        <div class="company-introduction">
          <h2>Company Introduction</h2>
            <?php
              $paragraph = explode(".",str_replace("<br />","",$company_info['CompanyDescription']));
              ?>
                <ul>
              <?php
              foreach($paragraph as $p){
                if(!empty($p)){
                ?>
                  <li><?=$p?></li>
                <?php
                }
              }
              ?>
                </ul>
              <?php
            ?>
        </div>
      </div>
      <div class="col-wrapper col-4">
        <div class="company-basic-info">
          <h2>Basic Information</h2>
          <div class="info-row">
            <strong>Country: </strong>
            <p><?=$company_info['CompanyCountry']?></p>
          </div>
          <div class="info-row">
            <strong>Province: </strong>
            <p><?=$company_info['CompanyProvince']?></p>
          </div>
          <div class="info-row">
            <strong>Job Vacancies: </strong>
            <p><?=count($job_info)." Jobs"?></p>
          </div>
          <div class="info-row">
            <strong>Type: </strong>
            <p><?=$company_info['CompanyTypeName']?></p>
          </div>
        </div>
        <div class="company-review">
          <h2>Review</h2>
          <div class="overall-rating">
            <strong>Overall Rating:</strong>
            <?php
              for($star = 0; $star<5; $star++){
                if($star < $company_rating){
                  ?>
                    <span class="fa fa-star checked"></span>
                  <?php
                }
                else{
                  ?>
                    <span class="fa fa-star"></span>
                  <?php
                }
              }
            ?>
          </div>
          <button type = "button" class = "btn btn-outline btn-review">Add Review</button>
        </div>
      </div>
    </div>
  </div>
  <div class = "company-vacancies-container">
    <h3 id = "job-vacancies-title">Company Job Vacancies</h3>
    <div class = "company-job-listing">
      <?php
        for($i = 0; $i < count($job_info); $i++){
          ?>
            <div class = "company-job-item">
              <div class = "job-item-header">
                <img src="<?=$company_info['CompanyImage'] == null ? "./images/defaultCompany.png" : $company_info['CompanyImage'] ?>" alt="<?=$company_info['CompanyName']?> Image">
                <div class = "company-job-title">
                  <h4><?=$company_info['CompanyName']?></h4>
                  <p><?=$job_info[$i]['JobName']?></p>
                </div>
                <?php
                  if($role===''){
                    ?>
                      <a style = "margin-left:auto;" href = "?page=login" class = "btn btn-outline">Login</a>
                    <?php
                  }
                  else if($role === 'seeker' & !$bookmark_data[$i]){
                    ?>
                      <form style ="margin-left:auto" method ="post">
                        <input type = "hidden" name = "action" value ="bookmark-job">
                        <input type = "hidden" name = "job" value = "<?=$job_info[$i]['JobId']?>">
                        <button type = "submit" class = "btn btn-save-job save">
                          <i class="fa-regular fa-bookmark"></i>
                        </button>
                      </form>
                    <?php
                  }
                  else if($role === 'seeker' && $bookmark_data[$i]){
                    ?>
                      <form style ="margin-left:auto" method ="post">
                        <input type = "hidden" name = "action" value ="remove-bookmark">
                        <input type = "hidden" name = "job" value = "<?=$job_info[$i]['JobId']?>">
                        <button type = "submit" class = "btn btn-save-job">
                          <i class="fa-regular fa-bookmark"></i>
                        </button>
                      </form>
                    <?php
                  }
                ?>
              </div>
              <div class = "company-job-description">
                <ul style = "margin-left: 20px">
                  <?php   
                    $paragraph = explode(".",str_replace("<br />", " ",$job_info[$i]['JobDescription']));
                    foreach($paragraph as $p){
                      if(!empty($p)){
                        ?>
                          <li><?=$p?></li>
                        <?php
                      }
                    }
                  ?>
                </ul>
              </div>
              <div class = "skill-requirements">
                <div class = "skill-wrapper"></div>
                <?php
                  for($j = 0; $j<count($job_skills[$i]); $j++){
                    ?>
                      <div class = "btn job-skill"><?=$job_skills[$i][$j]['SkillName']?></div>
                    <?php
                  }
                ?>
                <div class = "btn job-salary"><?=(($job_info[$i]['JobMinSalary'] + $job_info[$i]['JobMaxSalary'])/2)." USD/Year"?></div>
                <div class = "btn-utility-group">
                  <a href="?job_details=<?=$job_info[$i]['JobId']?>" class = "btn btn-job-details">View Details</a>
                  <?php
                    if($role === 'seeker' &&  !$application_data[$i]){
                      ?>
                        <form style ="flex: 1 1 auto;" method ="post">
                          <input type = "hidden" name = "action" value = "apply-job">
                          <input type = "hidden" name = "job" value = "<?=$job_info[$i]['JobId']?>">
                          <button type = "submit" class = "btn btn-job-apply">Apply</button>
                        </form>
                      <?php
                    }
                    else if($role === 'seeker' && $application_data[$i]){
                      ?>
                        <form style ="flex: 1 1 auto;" method ="post">
                          <input type = "hidden" name = "action" value = "remove-apply">
                          <input type = "hidden" name = "job" value = "<?=$job_info[$i]['JobId']?>">
                          <button type = "submit" class = "btn btn-job-apply">Unapply</button>
                        </form>
                      <?php
                    }
                    if($role === ''){
                      ?>
                        <a style = "flex: 1 1 auto; text-align:center" href = "?page=login" class = "btn btn-fill">Login Now</a>
                      <?php
                    }
                  ?>
                </div>
              </div>
            </div>
          <?php
        }
      ?>
    </div>
  </div>
  <div id = "review-company-modal" class = "modal">
      <form method = "post">
          <div class = "modal-header">
              <h4>Company Review</h4>
              <span class="close">&times;</span>
          </div>
          <div class="modal-content">
              <div class = "form-group">
                <label for = "rating-field">Rating</label>
                <input min = 1 max = 5 required type = "number" name = "rating" id = "rating-field" placeholder = "Rate between 1 and 5">
              </div>
              <div class = "form-group">
                <label for = "comments-field">Review Comments</label>
                <textarea rows="10" name = "comment" id = "comments-field" placeholder = "Review comments"></textarea>
              </div>
          </div>
          <div class="modal-footer">
              <input type="hidden" name = "action" value = "review-company">
              <button type = "submit" class = "btn btn-fill btn-confirm">Yes</button>
              <button type = "button" class= "btn btn-outline btn-close-modal">No</button>
          </div>
      </form>
  </div>
</div>