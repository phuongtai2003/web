<?php
    require_once("connection.php");
    require_once("utils.php");
    class JobApplicationDB{
        private mysqli $conn;
        public function __construct(){
            $this->conn = get_connection();
        }
        public function get_application_by_job($job){
            $sql = "select * from jobapplication where JobId = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $job);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            $data = array();
            $res = $stmt->get_result();
            while($row = $res->fetch_assoc()){
                $data[] = $row;
            }
            return array("code" => 0, "msg" => "Fetch data successfully", "data" => $data);
        }
        public function get_application_data($seeker, $job){
            $sql = "select * from jobapplication where SeekerId = ? and JobId = ?";
            $stmt= $this->conn->prepare($sql);
            $stmt->bind_param("ii", $seeker, $job);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            $res = $stmt->get_result();
            $is_applied = $res->num_rows == 1 ? true: false;
            return array("code" => 0, "msg" => "Get data successfully", "data" => $is_applied);
        }
        public function apply_job($seeker, $job){
            $sql = "select * from jobapplication where SeekerId = ? and JobId = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii", $seeker, $job);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            $res = $stmt->get_result();
            if($res->num_rows != 0){
                return array("code" => 2, "error" => "Job has already been applied");
            }
            $apply_date = date("Y-m-d");
            $sql = "insert into jobapplication(JobId, SeekerId, ApplyDate) values (?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iis",$job, $seeker, $apply_date);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            return array("code" => 0, "msg" => "Apply for job successfully");
        }
        public function unapply_job($seeker_id, $job_id){
            $sql = "select * from jobapplication where SeekerId = ? and JobId = ?";
            $stmt=  $this->conn->prepare($sql);
            $stmt->bind_param("ii", $seeker_id, $job_id);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            $res = $stmt->get_result();
            if($res->num_rows != 1){
                return array("code" => 2, "error" => "No jobs were applied");
            }
            $sql = "delete from jobapplication where SeekerId = ? and JobId = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii", $seeker_id, $job_id);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            return array("code" => 0, "msg" => "Unapply job successfully");
        }
        public function get_seeker_application($seeker_id){
            $sql = "select job.*, jobapplication.*, company.* from job, jobapplication, company where job.JobId = jobapplication.JobId and job.CompanyId = company.CompanyId and jobapplication.SeekerId = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $seeker_id);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            $res = $stmt->get_result();
            $data = array();
            while($row = $res->fetch_assoc()){
                $data[] = $row;
            }
            return array("code" => 0, "msg" => "Get data successfully", "data" => $data);
        }

        public function get_job_candidates($company, $job){
            $sql = "select jobapplication.*, seeker.*, job.* from jobapplication, seeker, job WHERE seeker.SeekerId = jobapplication.SeekerId and job.JobId = jobapplication.JobId and job.CompanyId = ? and job.JobId = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii", $company, $job);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            $data = array();
            $res = $stmt->get_result();
            while($row = $res->fetch_assoc()){
                $data[] = $row;
            }
            return array("code" => 0, "data" => $data);
        }

        public function book_interview($job, $seeker, $date, $time, $company){
            $sql = "select jobapplication.*, seeker.*, job.* from jobapplication, seeker, job WHERE seeker.SeekerId = jobapplication.SeekerId and job.JobId = jobapplication.JobId and job.CompanyId = ? and job.JobId = ? and jobapplication.SeekerId = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iii",$company, $job, $seeker);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            $res = $stmt->get_result();
            if($res->num_rows != 1){
                return array("code" => 2, "error" => "Applicant does not exist");
            }
            $sql = "update jobapplication set ApplyStatus = 1, InterviewDate = ?, InterviewTime = ? Where JobId = ? and SeekerId = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssii", $date, $time, $job, $seeker);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            $send_mail_res = $this->send_interview_mail($job, $seeker, $company, $date, $time);
            if($send_mail_res['code'] != 0){
                return array("code" => 1, "error" => $send_mail_res['error']);
            }
            return array("code" => 0, "msg" => "Book interview successfully");
        }
        public function dismiss_application($job, $seeker, $company){
            $sql = "select jobapplication.*, seeker.*, job.* from jobapplication, seeker, job WHERE seeker.SeekerId = jobapplication.SeekerId and job.JobId = jobapplication.JobId and job.CompanyId = ? and job.JobId = ? and jobapplication.SeekerId = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iii", $company, $job, $seeker);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            $res = $stmt->get_result();
            if($res->num_rows != 1){
                return array("code" => 2, "error" => "Data does not exist");
            }
            $sql = "delete from jobapplication where SeekerId = ? and JobId = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii", $seeker, $job);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            $res = $this->send_dismiss_data($job, $seeker, $company);
            if($res['code'] != 0){
                return array("code" => $res['code'], "error" => $res['error']);
            }
            return array("code" => 0, "msg" => "Dismiss applicant successfully");
        }
        private function send_interview_mail($job, $seeker, $company, $date, $time){
            $sql = "select jobapplication.*, seeker.*, job.* from jobapplication, seeker, job WHERE seeker.SeekerId = jobapplication.SeekerId and job.JobId = jobapplication.JobId and job.CompanyId = ? and job.JobId = ? and jobapplication.SeekerId = ? and jobapplication.ApplyStatus = 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iii", $company, $job, $seeker);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            $res = $stmt->get_result();
            if($res->num_rows != 1){
                return array("code" => 2, "error" => "Applicant has not been book for an interview");
            }
            $data = $res->fetch_assoc();
            $seeker_email = $data['SeekerEmail'];
            $job_name = $data['JobName'];

            $sql = "select * from company where CompanyId = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $company);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            $res = $stmt->get_result();
            if($res->num_rows != 1){
                return array("code" => 2, "error" => "Company does not exist");
            }
            $data = $res->fetch_assoc();
            $company_name = $data['CompanyName'];
            send_interview_email($date, $time, $seeker_email, $job_name, $company_name);
            return array("code" => 0, "msg" => "Send email successfully");
        }
        private function send_dismiss_data($job, $seeker, $company){
            $sql = "select * from job where JobId = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $job);
            if(!$stmt->execute()){
                return array("code" => 1, "Something went wrong");
            }
            $res = $stmt->get_result();
            if($res->num_rows != 1){
                return array("code" => 2, "Job does not exist");
            }
            $data = $res->fetch_assoc();
            $job_name = $data['JobName'];

            $sql = "select * from company where CompanyId = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $company);
            if(!$stmt->execute()){
                return array("code" => 1, "Something went wrong");
            }
            $res = $stmt->get_result();
            if($res->num_rows != 1){
                return array("code" => 2, "Company does not exist");
            }
            $data = $res->fetch_assoc();
            $company_name = $data['CompanyName'];

            $sql = "select * from Seeker where SeekerId = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $seeker);
            if(!$stmt->execute()){
                return array("code" => 1, "Something went wrong");
            }
            $res = $stmt->get_result();
            if($res->num_rows != 1){
                return array("code" => 2, "Seeker does not exist");
            }
            $data = $res->fetch_assoc();
            $seeker_email = $data['SeekerEmail'];
            send_dismiss_email($seeker_email, $job_name, $company_name);
            return array("code" => 0, "msg" => "Send mail successfully");
        }
    }
?>