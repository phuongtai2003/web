<?php
    if(!isset($_SESSION['comp_id']) || empty($_SESSION['comp_id'])){
        header("location: index.php?page=companies");
    }

    $msg = "";
    $error = "";

    if(isset($_POST['action']) && !empty($_POST['action'])){
        $action = $_POST['action'];
        if($action === 'bookmark-job'){
            $job_id = $_POST['job'] ?? '';
            if(empty($job_id)){
                $error = "No job was specified";
            }
            else{
                $ch = curl_init();
                $job_data = json_encode(array("jobId" => $job_id));
                curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/bookmark/bookmarkJob.php");
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $job_data);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'X-Auth-Token: '.$_SESSION['userId'],
                ));

                $return_res = json_decode(curl_exec($ch), true);
                if($return_res['status']){
                    $msg = $return_res['msg'];
                }
                else{
                    $error = $return_res['error'];
                }
                curl_close($ch);
            }
        }
        if($action === 'remove-bookmark'){
            $job_id = $_POST['job'] ?? '';
            if(empty($job_id)){
                $error = "No job was specified";
            }
            else{
                $ch = curl_init();
                $remove_data = array(
                    "jobId" => $job_id,
                );
                curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/bookmark/removeBookmark.php?".http_build_query($remove_data));
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'X-Auth-Token: '.$_SESSION['userId'],
                ));

                $return_res = json_decode(curl_exec($ch), true);
                if($return_res['status']){
                    $msg = $return_res['msg'];
                }
                else{
                    $error = $return_res['error'];
                }
                curl_close($ch);
            }
        }
        if($action === 'apply-job'){
            $job_id = $_POST['job'] ?? '';
            if(empty($job_id)){
                $error = "No job was specified";
            }
            else{
                $ch = curl_init();
                $apply_data = json_encode(array(
                    "jobId" => $job_id,
                ));
                curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/application/applyJob.php");
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $apply_data);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'X-Auth-Token: '.$_SESSION['userId'],
                ));

                $return_res = json_decode(curl_exec($ch), true);
                if($return_res['status']){
                    $msg = $return_res['msg'];
                }
                else{
                    $error = $return_res['error'];
                }
                curl_close($ch);
                
            }
        }
        if($action === 'remove-apply'){
            $job_id = $_POST['job'] ?? '';
            if(empty($job_id)){
                $error = "No job was specified";
            }
            else{
                $ch = curl_init();
                $remove_data = array(
                    "jobId" => $job_id,
                );
                curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/application/unapplyJob.php?".http_build_query($remove_data));
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'X-Auth-Token: '.$_SESSION['userId'],
                ));

                $return_res = json_decode(curl_exec($ch), true);
                if($return_res['status']){
                    $msg = $return_res['msg'];
                }
                else{
                    $error = $return_res['error'];
                }
                curl_close($ch);
            }
        }
        if($action === 'review-company'){
            $company = $_SESSION['comp_id'] ?? '';
            $comments = $_POST['comment'] ?? '';
            $rating = $_POST['rating'] ?? '';
            if(!isset($_SESSION['userId']) || empty($_SESSION['userId'])){
                $error = "Please log in to use the review feature";
            }
            else if(empty($comments) || empty($rating) || empty($company)){
                $error = "Please provide information for all of the review form";
            }
            else{
                $ch = curl_init();
                $review_data = json_encode(array(
                    "company" => $company,
                    "comment" => nl2br($comments),
                    "rating" => $rating,
                ));
                curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/review/reviewCompany.php");
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $review_data);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'X-Auth-Token: '.$_SESSION['userId'],
                ));

                $return_res = json_decode(curl_exec($ch), true);
                if($return_res['status']){
                    $msg = $return_res['msg'];
                }
                else{
                    $error = $return_res['error'];
                }
                curl_close($ch);
            }
        }
    }

    $company_info = array();
    $job_info = array();
    $ch = curl_init();
    $company_search = array("company" => $_SESSION['comp_id']);
    curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/company/getCompanyInfo.php?".http_build_query($company_search));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
    ));
    $res = json_decode(curl_exec($ch), true);
    if($res['status']){
        $company_info = $res['company'];
        $job_info = $res['jobs'];
        
        $application_data = array();
        $bookmark_data = array();
        $job_skills = array();
        $company_rating = array();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/review/getCompanyRating.php?company=".$company_info['CompanyId']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        $result = json_decode(curl_exec($ch),true);
        curl_close($ch);
        if($result['status']){
            $company_rating = $result['rating'];
        }
        else{
            $error = $result['error'];
        }

        foreach($job_info as $j){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/job/getData.php?jobId=".$j['JobId']);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
            ));
            $result = json_decode(curl_exec($ch),true);
            if($result['status']){
                $job_skills[] = $result['skills'];
            }
            else{
                $error = $result['error'];
                break;
            }
            curl_close($ch);
        }

        if(isset($_SESSION['userId']) && !empty($_SESSION['userId']) && $role === 'seeker'){
            foreach($job_info as $j){
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/bookmark/getBookmarkData.php?job=".$j['JobId']);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'X-Auth-Token: '.$_SESSION['userId']
                ));
                $return_res = json_decode(curl_exec($ch),true);
                if($return_res['status']){
                    $bookmark_data[] = $return_res['data'];
                }
                else{
                    $error = $return_res['error'];
                    break;
                }
                curl_close($ch);
            }
            foreach($job_info as $j){
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/application/getApplicationData.php?job=".$j['JobId']);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'X-Auth-Token: '.$_SESSION['userId']
                ));
                $return_res = json_decode(curl_exec($ch),true);
                if($return_res['status']){
                    $application_data[] = $return_res['data'];
                }
                else{
                    $error = $return_res['error'];
                    break;
                }
                curl_close($ch);
            }
        }
    }
    else{
        $error = $res['error'];
    }
    include_once("./view/company_details.php");
?>