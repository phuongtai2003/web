<?php
    require_once("../../jobDB.php");
    $job_db = new JobDB();
    header("Content-Type: application/json; charset=utf-8");

    if($_SERVER['REQUEST_METHOD'] != 'GET'){
        http_response_code(405);
        die(json_encode(array("status" => false, "error" => "This API only support POST method")));
    }
    $title = $_GET['title'] ?? '';
    $job_exp = intval($_GET['exp'] ?? -1);
    $job_field = intval($_GET['field'] ?? -1);
    $job_location_type = intval($_GET['locationType'] ?? -1);
    $job_level = intval($_GET['level'] ?? -1);
    $job_company_type = intval($_GET['compType'] ?? -1);
    $initial = intval($_GET['pageNum'] ?? 0);

    $res = $job_db->search_jobs_by_page($title, $job_exp, $job_field, $job_location_type, $job_level, $job_company_type,  $initial);

    if($res['code']!=0){
        http_response_code(500);
        die(json_encode(array("status"=> false, "error" => $res['error'])));
    }
    die(json_encode(array("status"=> true, "data" => $res['data'])));
?>