<?php 
    require_once("../../jobDB.php");
    $job_db = new JobDB();
    header("Content-Type: application/json; charset=utf-8");

    if($_SERVER['REQUEST_METHOD'] != 'POST'){
        http_response_code(405);
        die(json_encode(array("status" => false, "error" => "This API only support POST method")));
    }

    $header_section = getallheaders();
    if(!isset($header_section['Company']) || empty($header_section['Company'])){
        http_response_code(403);
        die(json_encode(array("status" => false, "error" => "Not authenticated")));
    }
    $input = json_decode(file_get_contents("php://input"));

    if(is_null($input)){
        http_response_code(403);
        die(json_encode(array("status" => false, "error" => "JSON format only")));
    }

    if(!property_exists($input, "jobName") || !property_exists($input, "jobDesc") || !property_exists($input, "jobReq") || !property_exists($input, "jobBenefits")
    || !property_exists($input, "minSalary") || !property_exists($input, "maxSalary") || !property_exists($input, "candidates") || !property_exists($input, "jobLocation")
    || !property_exists($input, "expDate") || !property_exists($input, "locationType") || !property_exists($input, "employementForm") || !property_exists($input,"expLevel")
    || !property_exists($input, "jobLevel") || !property_exists($input, "jobField") || !property_exists($input, "skills")){
        http_response_code(400);
        die(json_encode(array("status" => false, "error" => "Insufficient input")));
    }

    $name = $input->jobName;
    $desc = $input->jobDesc;
    $req = $input->jobReq;
    $benefits = $input->jobBenefits;
    $min_salary = $input->minSalary;
    $max_salary = $input->maxSalary;
    $candidates = $input->candidates;
    $location = $input->jobLocation;
    $exp_date = $input->expDate;
    $location_type = $input->locationType;
    $employment_form = $input->employementForm;
    $experience_level = $input->expLevel;
    $job_level = $input->jobLevel;
    $job_field = $input->jobField;
    $skills = $input->skills;
    $company = $header_section['Company'];
    

    if(empty($name) || empty($desc) || empty($req) || empty($benefits) || empty($min_salary) || empty($max_salary) || empty($candidates) || empty($location) || 
    empty($exp_date) || empty($location_type) || empty($employment_form) || empty($experience_level) || empty($job_level) || empty($job_field)
    || empty($skills) || empty($company)){
        http_response_code(400);
        die(json_encode(array("status" => false, "error" => "Insufficient input")));
    }
    $res = $job_db->insert_job($name, $desc, $req, $min_salary, $max_salary, $candidates, $location, $exp_date, $benefits, $location_type, $employment_form, $experience_level, $job_level, $job_field, $skills, $company);
    
    if($res['code'] != 0){
        http_response_code(500);
        die(json_encode(array("status" => false, "error" => $res['error'])));
    }
    else{
        http_response_code(200);
        die(json_encode(array("status"=>true, "msg" => $res['msg'])));
    }
?>