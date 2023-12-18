<?php
    require_once("../../companyDB.php");
    $company_db = new CompanyDB();
    header("Content-Type: application/json; charset=utf-8");

    if($_SERVER['REQUEST_METHOD'] != 'PUT'){
        http_response_code(405);
        die(json_encode(array("status" => false, "error" => "This API only support PUT method")));
    }

    $input = json_decode(file_get_contents("php://input"));

    if(is_null($input)){
        http_response_code(403);
        die(json_encode(array("status" => false, "error" => "JSON format only")));
    }


    if(!property_exists($input, "companyName") || !property_exists($input, "companyDesc") || !property_exists($input, "dateCreated") || !property_exists($input, "email") || !property_exists($input,"country") || !property_exists($input, "province") || !property_exists($input, "compType")){
        http_response_code(400);
        die(json_encode(array("status" => false, "error" => "Insufficient input")));
    }

    $id = $_GET['userId'] ?? '';
    if(empty($id)){
        http_response_code(400);
        die(json_encode(array("status" => false, "error" => "Insufficient input")));
    }
    $company_name = $input->companyName;
    $company_desc = $input->companyDesc;
    $company_date = $input->dateCreated;
    $company_email = $input->email;
    $company_country = $input->country;
    $company_province = $input->province;
    $company_type = $input->compType;
    
    $res = $company_db->update_company_data($id, $company_name, $company_desc, $company_email, $company_type, $company_date, $company_country, $company_province);


    if($res['code'] != 0){
        http_response_code(500);
        die(json_encode(array("status" => false, "error" => $res['error'])));
    }
    else{
        die(json_encode(array("status" => true, "msg" => $res['msg'])));
    }
?>