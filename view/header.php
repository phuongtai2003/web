<?php 
    $comp_id = $_GET['comp_details'] ?? '';
    $job_id = $_GET['job_details'] ?? '';
    $candidates = $_GET['candidate'] ?? '';
    if(!empty($comp_id)){
      $_SESSION['comp_id'] = $comp_id;
      header("Location: ?page=company_details");
    }
    if(!empty($job_id)){
      $_SESSION['job_id'] = $job_id;
      header("Location: ?page=job_details");
    }
    if(!empty($candidates)){
      $_SESSION['candidates'] = $candidates;
      header("Location: ?page=candidates");
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JobFast - <?=$page_name?></title>
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  </head>
  <body>
    <div class="navbar">
      <div class="navbar-brand">
        <a href = "/"><img src="./images/company.png" alt="" /></a>
      </div>
      <div class="nav-link">
      <?php
          if($role == "company"){
            ?>
              <ul class="navbar-list">
                <li class="navbar-li <?=$page_name=="Home" ? "active-link" : ""?>" ><a href="/">Home</a></li>
                <li class="navbar-li <?=$page_name=="Job_posting" ? "active-link" : ""?>" ><a href="?page=job_posting">Job Posting</a></li>
                <li class="navbar-li <?=$page_name=="Job_listing" ? "active-link" : ""?>" ><a href="?page=job_listing">Job Listing</a></li>

              </ul>
            <?php
          }
          else{
            ?>
              <ul class="navbar-list">
                <li class="navbar-li <?=$page_name=="Home" ? "active-link" : ""?>" ><a href="/">Home</a></li>
                <li class="navbar-li <?=$page_name=="Job" ? "active-link" : ""?>" ><a href="?page=job">Jobs</a></li>
                <li class="navbar-li <?=$page_name=="Companies" ? "active-link" : ""?>"><a href="?page=companies">Companies</a></li>
                <li class="navbar-li <?=$page_name=="Bookmark_job" ? "active-link" : ""?>"><a href="?page=bookmark_job">Bookmark Jobs</a></li>
              </ul>
            <?php
          }
        ?>
        
      </div>
      <div class="nav-button">
        <?php 
          if(empty($role)){
            ?>
              <a href="?page=register" class="btn btn-outline btn-register">Register</a>
              <a href="?page=login" class="btn btn-fill btn-login">Login</a>
            <?php
          }
          else{
            ?>
              <a href  ="?page=user_panel" class = "btn btn-outline"><?=$_SESSION['name']?></a>
            <?php
          }
        ?>
        
      </div>
      <div class="nav-collapse"><span class="navbar-bar"></span></div>
    </div>
    <div class = "body-container">


