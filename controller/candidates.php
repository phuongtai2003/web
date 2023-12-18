<?php
    if(!isset($_SESSION['userId']) || empty($_SESSION['userId']) || $role != 'company' || !isset($_SESSION['candidates']) || empty($_SESSION['candidates'])){
        header("location: index.php");
    }

    $msg = "";
    $error = "";

    if(isset($_POST['action']) && !empty($_POST['action'])){
        $action = $_POST['action'];
        if($action === 'book-interview'){
            $job = $_POST['job'] ?? '';
            $seeker = $_POST['seeker'] ?? '';
            $date = $_POST['interview-date'] ?? '';
            $time = $_POST['interview-time'] ?? '';
            if(empty($date) || empty($time)){
                $error = "Please specify the interview date and time";
            }
            else if(empty($job) || empty($seeker)){
                $error = "An error has occurred";
            }
            else{
                $ch = curl_init();
                $booking_data = json_encode(array(
                    "job" => $job,
                    "seeker" => $seeker,
                    "date" => $date,
                    "time" => $time,
                ));
                curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/application/bookInterview.php");
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $booking_data);
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
            }
        }
        if($action === 'dismiss-applicant'){
            $job = $_POST['job'] ?? '';
            $seeker = $_POST['seeker'] ?? '';
            if(empty($job) || empty($seeker)){
                $error = "An error occurred";
            }
            else{
                $ch = curl_init();
                $dismiss_data = array(
                    "job" => $job,
                    "seeker" => $seeker,
                );
                curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/application/dismissApplicant.php?".http_build_query($dismiss_data));
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
            }
        }
    }

    $candidates_info = array();
    $job = array();

    $ch = curl_init();
    $job_data = array("job" => $_SESSION['candidates']);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/application/getCandidatesByJob.php?".http_build_query($job_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'X-Auth-Token: '.$_SESSION['userId'],
    ));

    $result = json_decode(curl_exec($ch), true);
    curl_close($ch);

    if($result['status']){
        $candidates_info = $result['data'];

        $ch = curl_init();
        $job_data = array("jobId" => $_SESSION['candidates']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_URL, "http://localhost/models/api/job/getData.php?".http_build_query($job_data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'X-Auth-Token: '.$_SESSION['userId'],
        ));
        $return_res = json_decode(curl_exec($ch), true);
        if($return_res['status']){
            $job = $return_res['data'];
        }
        else{
            $error = $return_res['error'];
        }
    }
    else{
        $error = $result['error'];
    }

    require_once("./view/candidates.php");
?>