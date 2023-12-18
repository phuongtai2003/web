<?php 
    function get_connection(){
        $username = "root";
        $hostName = "127.0.0.1";
        $password = "";
        $db = "final_project";
        $conn = new mysqli($hostName, $username, $password, $db);
        if($conn->error){
            die($conn->connect_error);
        }
        return $conn;
    }
?>