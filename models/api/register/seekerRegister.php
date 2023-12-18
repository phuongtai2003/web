<?php 
    require_once("../../seekerDB.php");
    $seeker_db = new SeekerDB();
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

    if(!property_exists($input, "firstname") || !property_exists($input, "lastname") || !property_exists($input, "email") || !property_exists($input, "birth_date") || !property_exists($input, "password") || !property_exists($input,"nationality") || !property_exists($input, "province")){
        http_response_code(400);
        die(json_encode(array("status" => false, "error" => "Insufficient input")));
    }

    $firstname = $input->firstname;
    $lastname = $input->lastname;
    $email = $input->email;
    $password = $input->password;
    $birth_date = $input->birth_date;
    $nationality = $input->nationality;
    $province = $input->province;

    if(empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($birth_date) || empty($nationality) || empty($province)){
        http_response_code(400);
        die(json_encode(array("status" => false, "error" => "Insufficient input")));
    }

    $res = $seeker_db->register($email, $password, $firstname, $lastname, $birth_date, $nationality, $province);

    if($res['code'] != 0){
        http_response_code(500);
        die(json_encode(array("status" => false, "error" => $res['error'])));
    }
    else{
        http_response_code(200);
        die(json_encode(array("status"=>true, "msg" => $res['msg'])));
    }
?>