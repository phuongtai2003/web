<?php
    if($role === 'company'){
        header("location: index.php");
    }
    $bookmark_job = array();
    $msg = "";
    $error = "";

    if(isset($_POST['action']) && !empty($_POST['action'])){
        $action = $_POST['action'];
        if($action === 'remove-bookmark'){
            $job_id = $_POST['job'] ?? '';
            if(empty($job_id)){
                $error = "Job is not specified";
            }
            else{
                $ch = curl_init();
                $remove_data = array(
                    "jobId" => $job_id,
                );
                curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/bookmark/removeBookmark.php?".http_build_query($remove_data));
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'X-Auth-Token: '.$_SESSION['userId'],
                ));

                $return_res = json_decode(curl_exec($ch), true);
                if($return_res['status']){
                    $msg = $return_res['msg'];
                }
                else{
                    $error = $return_res['error'];
                }
                curl_close($ch);
            }
        }
    }

    if(isset($_SESSION['userId']) && !empty($_SESSION['userId'])){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/bookmark/getBookmarkByUser.php");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'X-Auth-Token: '.$_SESSION['userId']
        ));
        $return_res = json_decode(curl_exec($ch), true);
        if($return_res['status']){
            $bookmark_job = $return_res['data'];
        }
        else{
            $error = $return_res['error'];
        }
    }
    
    require_once("./view/bookmark_job.php");
?>