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


    if(!property_exists($input, "cv")){
        http_response_code(400);
        die(json_encode(array("status" => false, "error" => "Insufficient input")));
    }

    if(!isset($_GET['userId']) || empty($_GET['userId'])){
        http_response_code(400);
        die(json_encode(array("status" => false, "error" => "Insufficient input")));
    }
    

    $id = $_GET['userId'];
    $cv = $input->cv;
    
    $res = $seeker_db->upload_cv($cv, $id);

    if($res['code'] != 0){
        http_response_code(500);
        die(json_encode(array("status" => false, "error" => $res['error'])));
    }
    else{
        die(json_encode(array("status" => true, "msg" => $res['msg'])));
    }

?>