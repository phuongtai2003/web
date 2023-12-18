<?php
    $error = "";
    $msg = "";
    if(!isset($_SESSION['job_id']) || empty($_SESSION['job_id'])){
        $error = "Job not found";
    }
    $job_id = $_SESSION['job_id'];

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
        if($action === 'unapply-job'){
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
    }



    $job = array();
    $application = array();
    $experience = array();
    $level = array();
    $employment = array();
    $location_type = array();
    $field = array();
    $skills = array();
    $recommend = array();

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/job/getData.php?jobId=".$job_id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
    ));

    $result = json_decode(curl_exec($ch), true);
    curl_close($ch);
    if($result['status']){
        $job = $result['data'];
        $application = $result['application'];
        $experience = $result['experience'];
        $level = $result['level'];
        $employment = $result['employment'];
        $location_type = $result['locationType'];
        $field = $result['field'];
        $skills = $result['skills'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/job/getCompanyRecommend.php?companyId=".$job['CompanyId']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));

        $result = json_decode(curl_exec($ch), true);
        if($result['status']){
            $recommend = $result['data'];
        }
        else{
            $error = $result['error'];
        }
        curl_close($ch);
        $seeker_bookmark_data = array();
        $seeker_application_data = array();
        if(!empty($_SESSION['userId']) && isset($_SESSION['userId']) && $role === 'seeker'){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/application/getApplicationData.php?job=".$job_id);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'X-Auth-Token: '.$_SESSION['userId']
            ));
            $result = json_decode(curl_exec($ch),true);
            if($result['status']){
                $seeker_application_data = $result['data'];
            }
            else{
                $error = $result['error'];
            }
            curl_close($ch);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/bookmark/getBookmarkData.php?job=".$job_id);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'X-Auth-Token: '.$_SESSION['userId']
            ));
            $result = json_decode(curl_exec($ch),true);
            if($result['status']){
                $seeker_bookmark_data = $result['data'];
            }
            else{
                $error = $result['error'];
            }
            curl_close($ch);
        }
        
    }
    else{
        $error = $result['error'];
    }

    include_once("./view/job_details.php");
?>