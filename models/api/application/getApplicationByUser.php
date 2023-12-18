<?php
    require_once("../../jobApplicationDB.php");
    $job_application_db = new JobApplicationDB();
    header("Content-Type: application/json; charset=utf-8");

    if($_SERVER['REQUEST_METHOD'] != 'GET'){
        http_response_code(405);
        die(json_encode(array("status" => false, "error" => "This API only support GET method")));
    }

    $header_section = getallheaders();
    if(!isset($header_section['X-Auth-Token']) || empty($header_section['X-Auth-Token'])){
        http_response_code(403);
        die(json_encode(array("status" => false, "error" => "Not authenticated")));
    }

    $seeker_id = $header_section['X-Auth-Token'];

    $res = $job_application_db->get_seeker_application($seeker_id);

    if($res['code']!=0){
        http_response_code(500);
        die(json_encode(array("status"=> false, "error" => $res['error'])));
    }
    http_response_code(200);
    die(json_encode(array("status"=> true, "data" => $res['data'])));
?>