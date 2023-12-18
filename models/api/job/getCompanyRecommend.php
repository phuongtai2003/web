<?php
    require_once("../../jobDB.php");
    require_once("../../jobApplicationDB.php");
    $job_db = new JobDB();
    $job_application_db = new JobApplicationDB();
    header("Content-Type: application/json; charset=utf-8");

    if($_SERVER['REQUEST_METHOD'] != 'GET'){
        http_response_code(405);
        die(json_encode(array("status" => false, "error" => "This API only support POST method")));
    }

    $id = $_GET['companyId'] ?? '';
    if(empty($id)){
        http_response_code(400);
        die(json_encode(array("status" => false, "error" => "Insufficient input")));
    }

    $res = $job_db->get_recommend_by_company($id);

    if($res['code']!=0){
        http_response_code(500);
        die(json_encode(array("status"=> false, "error" => $res['error'])));
    }

    $data = $res['data'];
    $application_data = array();
    foreach($data as $job){
        $result = $job_application_db->get_application_by_job($job['JobId']);
        if($result['code'] != 0){
            http_response_code(500);
            die(json_encode(array("status"=> false, "error" => $result['error'])));
        }
        $application_data[] = $result['data'];
    }
    

    die(json_encode(array("status"=> true, "data" => $data, "application" => $application_data)));
?>