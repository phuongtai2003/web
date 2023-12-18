<?php
    require_once("../../reviewDB.php");
    $review_db = new ReviewDB();
    header("Content-Type: application/json; charset=utf-8");

    if($_SERVER['REQUEST_METHOD'] != 'GET'){
        http_response_code(405);
        die(json_encode(array("status" => false, "error" => "This API only support GET method")));
    }

    $res = $review_db->get_top_three();

    if($res['code'] != 0){
        http_response_code(500);
        die(json_encode(array("status"=> false, "error" => $res['error'])));
    }
    else{
        die(json_encode(array("status"=> true, "data" => $res['data'])));
    }
?>