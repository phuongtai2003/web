<?php
    require_once("../../companyDB.php");
    require_once("../../jobDB.php");
    $company_db = new CompanyDB();
    $job_db = new JobDB();
    header("Content-Type: application/json; charset=utf-8");

    if($_SERVER['REQUEST_METHOD'] != 'GET'){
        http_response_code(405);
        die(json_encode(array("status" => false, "error" => "This API only support GET method")));
    }

    if(!isset($_GET['company'])){
        http_response_code(400);
        die(json_encode(array("status"=> false, "error" => "Company not specified")));
    }

    $id = $_GET['company'];
    $res = $company_db->get_company_data($id);

    if($res['code'] != 0){
        http_response_code(500);
        die(json_encode(array("status"=> false, "error" => $res['error'])));
    }
    $company_data = $res['data'];

    $res = $job_db->get_job_by_company($company_data['CompanyId']);
    if($res['code'] != 0){
        http_response_code(500);
        die(json_encode(array("status"=> false, "error" => $res['error'])));
    }

    $job_data = $res['data'];
    http_response_code(200);
    die(json_encode(array("status"=> true, "company" => $company_data, "jobs" => $job_data)));
?>