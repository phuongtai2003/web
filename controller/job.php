<?php
    if($role === 'company'){
        header("Location: index.php");
    }
    $error = "";
    $msg = "";
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
    }


    $job_name = $_GET['job-title'] ?? '';
    $job_exp = $_GET['experience-level'] ?? '';
    $job_field = $_GET['job-field'] ?? '';
    $job_location_type = $_GET['job-location-type'] ?? '';
    $job_level = $_GET['job-level'] ?? '';
    $job_company_type = $_GET['company-type'] ?? '';

    $page_num = 1;
    $limit_per_page = 5;
    if(isset($_GET['pageNum']) && !empty($_GET['pageNum'])){
        $page_num = $_GET['pageNum'];
    }
    $initial_page = ($page_num-1) * $limit_per_page;
    $total_row = 0;
    $total_page = 0;
    

    $job = array();
    $display_job = array();
    $bookmark_data = array();
    $application_data = array();

    if(empty($job_exp) && empty($job_field) && empty($job_location_type) && empty($job_level) && empty($job_company_type)){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/job/getAllJobs.php");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        $result = json_decode(curl_exec($ch),true);
        curl_close($ch);
        
        if($result['status']){
            $job = $result['data'];
            $total_row = count($job);
            $total_page = ceil($total_row/$limit_per_page);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/job/getJobByPage.php?pageNum=".$initial_page);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
            ));
            $res = json_decode(curl_exec($ch),true);
            curl_close($ch);
            if($res['status']){
                $display_job = $res['data'];
                $job_skills = array();
                $application = array();
                $employment = array();
                foreach($display_job as $j){
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
                        $application[] = $result['application'];
                        $employment[] = $result['employment'];
                    }
                    else{
                        $error = $result['error'];
                        break;
                    }
                    curl_close($ch);
                }
                if(isset($_SESSION['userId']) && !empty($_SESSION['userId'])){
                    foreach($display_job as $j){
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/bookmark/getBookmarkData.php?job=".$j['JobId']);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'Content-Type: application/json',
                            'X-Auth-Token: '.$_SESSION['userId']
                        ));
                        $result = json_decode(curl_exec($ch),true);
                        if($result['status']){
                            $bookmark_data[] = $result['data'];
                        }
                        else{
                            $error = $result['error'];
                            break;
                        }
                        curl_close($ch);
                    }
                    foreach($display_job as $j){
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/application/getApplicationData.php?job=".$j['JobId']);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'Content-Type: application/json',
                            'X-Auth-Token: '.$_SESSION['userId']
                        ));
                        $result = json_decode(curl_exec($ch),true);
                        if($result['status']){
                            $application_data[] = $result['data'];
                        }
                        else{
                            $error = $result['error'];
                            break;
                        }
                        curl_close($ch);
                    }
                }
            }
            else{
                $error = $res['error'];
            }
        }
        else{
            $error = $result['error'];
        }
    }
    else{
        $data = array(
            "title" => $job_name,
            "exp" => $job_exp,
            "field" => $job_field,
            "locationType" => $job_location_type ,
            "level"=> $job_level,
            "compType" => $job_company_type,
            "pageNum" => $initial_page,
        );
        $query_string = http_build_query($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/job/searchJobs.php?".$query_string);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        $result = json_decode(curl_exec($ch),true);

        curl_close($ch);
        if($result['status']){
            $job = $result['data'];
            $total_row = count($job);
            $total_page = ceil($total_row/$limit_per_page);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/job/searchJobByPage.php?".$query_string);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
            ));
            $res = json_decode(curl_exec($ch),true);
            curl_close($ch);
            if($res['status']){
                $display_job = $res['data'];
                $job_skills = array();
                $application = array();
                $employment = array();
                foreach($display_job as $j){
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
                        $application[] = $result['application'];
                        $employment[] = $result['employment'];
                    }
                    else{
                        $error = $result['error'];
                        break;
                    }
                    curl_close($ch);
                }
                if(isset($_SESSION['userId']) && !empty($_SESSION['userId'])){
                    foreach($display_job as $j){
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/bookmark/getBookmarkData.php?job=".$j['JobId']);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'Content-Type: application/json',
                            'X-Auth-Token: '.$_SESSION['userId']
                        ));
                        $result = json_decode(curl_exec($ch),true);
                        if($result['status']){
                            $bookmark_data[] = $result['data'];
                        }
                        else{
                            $error = $result['error'];
                            break;
                        }
                        curl_close($ch);
                    }
                    foreach($display_job as $j){
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/application/getApplicationData.php?job=".$j['JobId']);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'Content-Type: application/json',
                            'X-Auth-Token: '.$_SESSION['userId']
                        ));
                        $result = json_decode(curl_exec($ch),true);
                        if($result['status']){
                            $application_data[] = $result['data'];
                        }
                        else{
                            $error = $result['error'];
                            break;
                        }
                        curl_close($ch);
                    }
                }
            }
            else{
                $error = $res['error'];
            }
        }
        else{
            $error = $result['error'];
        }
    }
    include_once("./view/job.php");
?>