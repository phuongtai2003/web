<?php
    require_once("../../companyDB.php");
    $company_db = new CompanyDB();
    header("Content-Type: application/json; charset=utf-8");

    if($_SERVER['REQUEST_METHOD'] != 'GET'){
        http_response_code(405);
        die(json_encode(array("status" => false, "error" => "This API only support POST method")));
    }

    if(!isset($_GET['userId'])){
        http_response_code(400);
        die(json_encode(array("status"=> false, "error" => "Seeker is not logged in")));
    }

    $id = $_GET['userId'];
    $res = $company_db->get_company_data($id);

    if($res['code'] != 0){
        http_response_code(500);
        die(json_encode(array("status"=> false, "error" => $res['error'])));
    }
    else{
        die(json_encode(array("status"=> true, "data" => $res['data'])));
    }
?>