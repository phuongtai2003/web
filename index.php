<?php
    if(session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $role = '';
    if(isset($_SESSION['userId']) && !empty($_SESSION['userId']) && isset($_SESSION['accountType']) && !empty($_SESSION['accountType'])){
        $role = $_SESSION['accountType'];
        if($role === 'seeker'){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/seeker/getData.php?userId=".$_SESSION['userId']);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
            ));
            $res = json_decode(curl_exec($ch));
            if($res->status){
                $_SESSION['name'] = $res->data->SeekerFirstName.' '.$res->data->SeekerLastName;
            }
        }
        else if($role ==='company'){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/company/getData.php?userId=".$_SESSION['userId']);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
            ));
            $res = json_decode(curl_exec($ch));
            if($res->status){
                $_SESSION['name'] = $res->data->CompanyName;
            }
        }
    }
    $page_name = "Home";
    $page_url = "./controller/home.php";
    if(isset($_GET['page']) && isset($_GET['page'])!=""){
        $page_name = ucfirst($_GET['page']);
        $page_url = "./controller/".$_GET['page'].".php";
        if(!file_exists($page_url)){
            $page_url = "./controller/home.php";
        }
    }
    if($page_url == "./controller/activate.php"){
        include_once($page_url);
    }
    else{
        include_once("./view/header.php");
        include_once($page_url);
        include_once("./view/footer.php");
    }
?>