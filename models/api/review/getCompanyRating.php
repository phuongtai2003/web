<?php
    require_once("../../reviewDB.php");
    $review_db = new ReviewDB();
    header("Content-Type: application/json; charset=utf-8");

    if($_SERVER['REQUEST_METHOD'] != 'GET'){
        http_response_code(405);
        die(json_encode(array("status" => false, "error" => "This API only support GET method")));
    }

    if(!isset($_GET['company'])){
        http_response_code(400);
        die(json_encode(array("status"=> false, "error" => "Company is not specified")));
    }

    $id = $_GET['company'];
    $res = $review_db->get_rating_by_company($id);

    if($res['code'] != 0){
        http_response_code(500);
        die(json_encode(array("status"=> false, "error" => $res['error'])));
    }
    else{
        die(json_encode(array("status"=> true, "rating" => $res['rating'])));
    }
?>