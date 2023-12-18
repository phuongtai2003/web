<?php 
    require_once("../../companyTypeDB.php");
    $company_type_db = new CompanyTypeDB();

    header("Content-Type: application/json; charset=utf-8");

    if($_SERVER['REQUEST_METHOD'] != 'GET'){
        http_response_code(405);
        die(json_encode(array("status" => false, "error" => "This API only support POST method")));
    }

    $res = $company_type_db->getAllCompTypes();
    if($res['code'] != 0 ){
        http_response_code(500);
        die(json_encode(array("status"=> false, "error" => $res['error'])));
    }
    else{
        http_response_code(200);
        die(json_encode(array("status"=> true, "data" => $res['data'])));
    }
?>