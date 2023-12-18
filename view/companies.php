<div class="container companies-container">
  <?php
    if(!empty($error)){
      ?>
        <div class = "alert"><?=$error?></div>
      <?php
    }
  ?>
  <h1 id = "company-page-header">The very best need your help!</h1>
  <h3 id = "company-sub-title">See some of the most prominent companies out there waiting for you!</h3>
  <div class="row companies-listing">
    <?php
      foreach($companies_list as $company){
        ?>
          <div class="col-4">
            <div class="company-card">
              <div class="company-card-header">
                <img src="<?=$company['CompanyImage'] == null ? "./images/defaultCompany.png" : $company['CompanyImage'] ?>" alt="<?=$company['CompanyName']?> image" />
                <h3 class="company-name"><?=$company['CompanyName']?></h3>
              </div>
              <div class="company-card-body">
                <p>
                  <?=str_replace("<br />", " ",$company['CompanyDescription'])?>
                </p>
              </div>
              <div class="company-card-footer">
                <a class="btn btn-outline btn-company-detail" href="?comp_details=<?=$company['CompanyId']?>">View Detail</a>
                <a class="btn btn-fill btn-company-job" href="?comp_details=<?=$company['CompanyId']?>#job-vacancies-title">View Jobs</a>
              </div>
            </div>
          </div>
        <?php
      }
    ?>
  </div>
</div>
