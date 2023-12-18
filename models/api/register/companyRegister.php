<?php 
    require_once("../../companyDB.php");
    $company_db = new CompanyDB();
    header("Content-Type: application/json; charset=utf-8");

    if($_SERVER['REQUEST_METHOD'] != 'POST'){
        http_response_code(405);
        die(json_encode(array("status" => false, "error" => "This API only support POST method")));
    }

    $input = json_decode(file_get_contents("php://input"));

    if(is_null($input)){
        http_response_code(403);
        die(json_encode(array("status" => false, "error" => "JSON format only")));
    }

    if(!property_exists($input, "companyName") || !property_exists($input, "email") || !property_exists($input, "description") || !property_exists($input, "dateCreated") || !property_exists($input, "password") || !property_exists($input,"country") || !property_exists($input, "province") || !property_exists($input, "companyType")){
        http_response_code(400);
        die(json_encode(array("status" => false, "error" => "Insufficient input")));
    }

    $company_name = $input->companyName;
    $email = $input->email;
    $description = nl2br($input->description);
    $date_created = $input->dateCreated;
    $password = $input->password;
    $country = $input->country;
    $province = $input->province;
    $companyType = $input->companyType;
    if(empty($company_name) || empty($description) || empty($email) || empty($password) || empty($date_created) || empty($country) || empty($province)){
        http_response_code(400);
        die(json_encode(array("status" => false, "error" => "Insufficient input")));
    }

    $res = $company_db->register($company_name, $email, $description, $date_created, $password, $country, $province, $companyType);

    if($res['code'] != 0){
        http_response_code(500);
        die(json_encode(array("status" => false, "error" => $res['error'])));
    }
    else{
        http_response_code(200);
        die(json_encode(array("status"=>true, "msg" => $res['msg'])));
    }
?>