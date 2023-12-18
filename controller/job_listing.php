<?php
    if(!isset($_SESSION['userId']) || empty($_SESSION['userId']) || $role !== 'company'){
        header("Location: index.php");
    }
    $job_listing_data = array();
    $application_details = array();
    $error = "";
    $msg = "";
    if(isset($_POST['action']) && !empty($_POST['action'])){
        $action = $_POST['action'];
        if($action === "delete-job"){
            $job_id = $_POST['job-id'] ?? '';
            if(empty($job_id)){
                $error = "Job is not specified";
            }
            else{
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/job/deleteJob.php?jobId=".$job_id);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'X-Auth-Token: '.$_SESSION['userId'], 
                ));
                $result = json_decode(curl_exec($ch), true);
                if($result['status']){
                    $msg = $result['msg'];
                }
                else{
                    $error = $result['error'];
                }
            }
            
        }
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/job/getCompanyJob.php?companyId=".$_SESSION['userId']);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
    ));
    $result = json_decode(curl_exec($ch),true);
    if($result['status']){
        $job_listing_data = $result['data'];
        $application_details = $result['application'];
    }
    else{
        $error = $result['error'];
    }
    require("./view/job_listing.php");
?>