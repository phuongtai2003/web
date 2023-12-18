<?php
    require_once("../../jobDB.php");
    require_once("../../jobApplicationDB.php");
    require_once("../../jobExperienceDB.php");
    require_once("../../jobLevelDB.php");
    require_once("../../employmentFormDB.php");
    require_once("../../jobLocationTypeDB.php");
    require_once("../../jobFieldDB.php");
    $job_db = new JobDB();
    $job_application_db = new JobApplicationDB();
    $job_experience_db = new JobExperienceDB();
    $job_level_db = new JobLevelDB();
    $employment_form_db = new EmploymentFormDB();
    $location_type_db = new JobLocationTypeDB();
    $job_field_db = new JobFieldDB();
    header("Content-Type: application/json; charset=utf-8");

    if($_SERVER['REQUEST_METHOD'] != 'GET'){
        http_response_code(405);
        die(json_encode(array("status" => false, "error" => "This API only support POST method")));
    }

    $id = $_GET['jobId'] ?? '';
    if(empty($id)){
        http_response_code(400);
        die(json_encode(array("status" => false, "error" => "Insufficient input")));
    }

    $res = $job_db->get_job($id);

    if($res['code']!=0){
        http_response_code(500);
        die(json_encode(array("status"=> false, "error" => $res['error'])));
    }

    $data = $res['data'];


    $result = $job_application_db->get_application_by_job($data['JobId']);

    if($result['code'] != 0){
        http_response_code(500);
        die(json_encode(array("status"=> false, "error" => $result['error'])));
    }
    $application_data = $result['data'];
    

    $result = $job_experience_db->get_experience($data['JobExperienceId']);
    if($result['code'] != 0){
        http_response_code(500);
        die(json_encode(array("status"=> false, "error" => $result['error'])));
    }
    $experience = $result['data'];

    $result = $job_level_db->get_level($data['JobLevelId']);
    if($result['code'] != 0){
        http_response_code(500);
        die(json_encode(array("status"=> false, "error" => $result['error'])));
    }
    $level = $result['data'];

    $result = $employment_form_db->get_form($data['EmploymentTypeId']);
    if($result['code'] != 0){
        http_response_code(500);
        die(json_encode(array("status"=> false, "error" => $result['error'])));
    }
    $employment_form = $result['data'];

    $result = $location_type_db->get_location_by_id($data['JobLocationTypeId']);
    if($result['code'] != 0){
        http_response_code(500);
        die(json_encode(array("status"=> false, "error" => $result['error'])));
    }
    $location_type = $result['data'];

    $result = $job_field_db->get_field($data['JobFieldId']);
    if($result['code'] != 0){
        http_response_code(500);
        die(json_encode(array("status"=> false, "error" => $result['error'])));
    }
    $field = $result['data'];

    $result = $job_db->get_skills_by_job($data['JobId']);
    if($result['code'] != 0){
        http_response_code(500);
        die(json_encode(array("status"=> false, "error" => $result['error'])));
    }
    $skills = $result['data'];

    die(json_encode(array("status"=> true, "data" => $data, "application" => $application_data, "experience" => $experience, "level" => $level, "employment" => $employment_form, "locationType" => $location_type, "field" => $field, "skills" => $skills)));
?>