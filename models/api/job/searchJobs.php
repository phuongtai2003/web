<?php
    require_once("../../jobDB.php");
    $job_db = new JobDB();
    header("Content-Type: application/json; charset=utf-8");

    if($_SERVER['REQUEST_METHOD'] != 'GET'){
        http_response_code(405);
        die(json_encode(array("status" => false, "error" => "This API only support POST method")));
    }
    $title = $_GET['title'] ?? '';
    $job_exp = $_GET['exp'] ?? -1;
    $job_field = $_GET['field'] ?? -1;
    $job_location_type = $_GET['locationType'] ?? -1;
    $job_level = $_GET['level'] ?? -1;
    $job_company_type = $_GET['compType'] ?? -1;

    $res = $job_db->search_jobs($title, $job_exp, $job_field, $job_location_type, $job_level, $job_company_type);

    if($res['code']!=0){
        http_response_code(500);
        die(json_encode(array("status"=> false, "error" => $res['error'])));
    }
    die(json_encode(array("status"=> true, "data" => $res['data'])));
?>