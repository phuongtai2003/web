<?php
    require_once("../../jobDB.php");
    $job_db = new JobDB();
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
    
    $id = $_GET['jobId'] ?? '';

    
    if(empty($id)){
        http_response_code(400);
        die(json_encode(array("status" => false, "error" => "Insufficient input")));
    }

    $company = $header_section['X-Auth-Token'];

    $res = $job_db->delete_job($id, $company);

    if($res['code'] != 0){
        http_response_code(500);
        die(json_encode(array("status" => false, "error" => $res['error'])));
    }
    else{
        die(json_encode(array("status" => true, "msg" => $res['msg'])));
    }
?>