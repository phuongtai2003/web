<?php
    require_once("../../seekerDB.php");
    $seeker_db = new SeekerDB();
    header("Content-Type: application/json; charset=utf-8");

    if($_SERVER['REQUEST_METHOD'] != 'PUT'){
        http_response_code(405);
        die(json_encode(array("status" => false, "error" => "This API only support PUT method")));
    }
    $header_section = getallheaders();
    if(!isset($header_section['X-Auth-Token']) || empty($header_section['X-Auth-Token'])){
        http_response_code(403);
        die(json_encode(array("status" => false, "error" => "Not authenticated")));
    }


    $input = json_decode(file_get_contents("php://input"));


    if(is_null($input)){
        http_response_code(403);
        die(json_encode(array("status" => false, "error" => "JSON format only")));
    }



    if(!property_exists($input, "old_password") || !property_exists($input, "new_password") || !property_exists($input, "new_confirm_password") ){
        http_response_code(400);
        die(json_encode(array("status" => false, "error" => "Insufficient input")));
    }

    $id = $header_section['X-Auth-Token'];
    $old_password = $input->old_password;
    $new_password = $input->new_password;
    $new_confirm_password = $input->new_confirm_password;
    
    if($new_password !== $new_confirm_password){
        http_response_code(400);
        die(json_encode(array("status"=>false, "error" => "Wrong new password")));
    }


    $res = $seeker_db->change_password($id, $old_password, $new_password);

    if($res['code'] != 0){
        http_response_code(500);
        die(json_encode(array("status" => false, "error" => $res['error'])));
    }
    else{
        die(json_encode(array("status" => true, "msg" => $res['msg'])));
    }
?>