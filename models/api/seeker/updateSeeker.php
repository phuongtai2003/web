<?php
    require_once("../../seekerDB.php");
    $seeker_db = new SeekerDB();
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


    if(!property_exists($input, "firstname") || !property_exists($input, "lastname") || !property_exists($input, "email") || !property_exists($input, "birthdate") || !property_exists($input,"nationality") || !property_exists($input, "province")){
        http_response_code(400);
        die(json_encode(array("status" => false, "error" => "Insufficient input")));
    }

    $id = $_GET['userId'] ?? '';
    if(empty($id)){
        http_response_code(400);
        die(json_encode(array("status" => false, "error" => "Insufficient input")));
    }
    $firstname = $input->firstname;
    $lastname = $input->lastname;
    $email = $input->email;
    $birth_date = $input->birthdate;
    $nationality = $input->nationality;
    $province = $input->province;
    
    $res = $seeker_db->update_seeker($id, $firstname, $lastname, $email, $birth_date, $nationality, $province);

    if($res['code'] != 0){
        http_response_code(500);
        die(json_encode(array("status" => false, "error" => $res['error'])));
    }
    else{
        die(json_encode(array("status" => true, "msg" => $res['msg'])));
    }
?>