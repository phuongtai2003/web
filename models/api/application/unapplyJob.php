<?php 
    require_once("../../jobApplicationDB.php");
    $job_application_db = new JobApplicationDB();
    header("Content-Type: application/json; charset=utf-8");

    if($_SERVER['REQUEST_METHOD'] != 'DELETE'){
        http_response_code(405);
        die(json_encode(array("status" => false, "error" => "This API only support DELETE method")));
    }

    $header_section = getallheaders();
    if(!isset($header_section['X-Auth-Token']) || empty($header_section['X-Auth-Token'])){
        http_response_code(403);
        die(json_encode(array("status" => false, "error" => "Not authenticated")));
    }
    
    $seeker = $header_section['X-Auth-Token'];
    $job_id = $_GET['jobId'] ?? '';

    if(empty($job_id)){
        http_response_code(400);
        die(json_encode(array("status" => false, "error" => "Insufficient input")));
    }

    $res = $job_application_db->unapply_job($seeker, $job_id);
    
    if($res['code'] != 0){
        http_response_code(500);
        die(json_encode(array("status" => false, "error" => $res['error'])));
    }
    else{
        http_response_code(200);
        die(json_encode(array("status"=>true, "msg" => $res['msg'])));
    }
?>