<?php 
    require_once("../../reviewDB.php");
    $review_db = new ReviewDB();
    header("Content-Type: application/json; charset=utf-8");

    if($_SERVER['REQUEST_METHOD'] != 'POST'){
        http_response_code(405);
        die(json_encode(array("status" => false, "error" => "This API only support POST method")));
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

    if(!property_exists($input, "company") || !property_exists($input, "comment") || !property_exists($input, "rating")){
        http_response_code(400);
        die(json_encode(array("status" => false, "error" => "Insufficient input")));
    }
    
    $seeker = $header_section['X-Auth-Token'];
    $company = $input->company;
    $comment = $input->comment;
    $rating = $input->rating;


    $res = $review_db->review_company($seeker, $company, $rating, $comment);

    if($res['code'] != 0){
        http_response_code(500);
        die(json_encode(array("status" => false, "error" => $res['error'])));
    }
    else{
        http_response_code(200);
        die(json_encode(array("status"=>true, "msg" => $res['msg'])));
    }
?>