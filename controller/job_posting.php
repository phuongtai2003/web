<?php
    if(!isset($_SESSION['userId']) || empty($_SESSION['userId']) || $role !== 'company'){
        header("location: index.php");
    }
    $error = '';
    $msg = '';
    
    $job_name = $_POST['job-name'] ?? '';
    $job_desc = nl2br($_POST['job-description'] ?? '');
    $job_req = nl2br($_POST['job-requirements'] ?? '');
    $job_benefits = nl2br($_POST['job-benefits'] ?? '');
    $min_salary = $_POST['min-salary'] ?? '';
    $max_salary = $_POST['max-salary'] ?? '';
    $candidates = $_POST['job-candidates-number'] ?? '';
    $location = $_POST['job-location'] ?? '';
    $exp_date = $_POST['job-expiry'] ?? '';
    $location_type = $_POST['job-location-type'] ?? '';
    $employment_form = $_POST['job-employment-type'] ?? '';
    $exp_level = $_POST['job-experience-level'] ?? '';
    $job_level = $_POST['job-level'] ?? '';
    $job_field = $_POST['job-field-type'] ?? '';
    $skills = $_POST['skills'] ?? '';

    if(isset($_POST['action']) && $_POST['action'] === 'job-posting'){
        
        if(empty($job_name) || empty($job_desc) || empty($job_req) || empty($job_benefits) || empty($min_salary) || empty($max_salary)
        || empty($candidates) || empty($location) || empty($exp_date) || empty($location_type) || empty($employment_form) || empty($exp_level)
        || empty($job_level) || empty($job_field) || empty($skills)){
            $error = "Please enter all of the fields";
        }
        else if($min_salary > $max_salary){
            $error = "Wrong salary range";
        }
        else if(strtotime($exp_date) <= strtotime(date("Y-m-d"))){
            $error = "Invalid date";
        }
        else{
            $ch = curl_init();
            $data = json_encode(array("jobName" => $job_name, "jobDesc" => $job_desc, "jobReq" => $job_req,
            "jobBenefits" => $job_benefits, "minSalary" => $min_salary, "maxSalary" => $max_salary, "candidates" => $candidates,
            "jobLocation" => $location, "expDate" => $exp_date, "locationType" => $location_type, "employementForm" => $employment_form,
            "expLevel" => $exp_level, "jobLevel" => $job_level, "jobField" => $job_field, "skills" => $skills,
        ));
            $header = array("Content-Type: application/json", "Company: ".$_SESSION['userId']);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/job/createJob.php");
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

            $res = json_decode(curl_exec($ch), true);
            if($res['status']){
                $msg = $res['msg'];
            }
            else{
                $error = $res['error'];
            }
        }
    }
    require_once("./view/job_posting.php");
?>