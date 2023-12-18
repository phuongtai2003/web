<?php
    require_once("connection.php");
    class BookmarkDB{
        private mysqli $conn;
        public function __construct(){
            $this->conn = get_connection();
        }
        public function check_bookmark($seeker_id, $job_id){
            $sql = "select * from bookmarkjob where SeekerId = ? and JobId = ?";
            $stmt=  $this->conn->prepare($sql);
            $stmt->bind_param("ii", $seeker_id, $job_id);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            $res = $stmt->get_result();
            $is_bookmarked = $res->num_rows == 1 ? true : false;
            return array("code" => 0, "msg" => "Fetch data successfully", "data" => $is_bookmarked);
        }
        public function bookmark_job($seeker_id, $job_id){
            $sql = "select * from bookmarkjob where SeekerId = ? and JobId = ?";
            $stmt=  $this->conn->prepare($sql);
            $stmt->bind_param("ii", $seeker_id, $job_id);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            $res = $stmt->get_result();
            if($res->num_rows == 1){
                return array("code" => 2, "error" => "Job has already been bookmarked");
            }
            $bookmark_date = date("Y-m-d");
            $sql = "insert into bookmarkjob (JobId, SeekerId, BookmarkDate) values (?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iis", $job_id, $seeker_id, $bookmark_date);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            return array("code" => 0, "msg" => "Bookmark job successfully");
        }
        public function remove_bookmark($seeker_id, $job_id){
            $sql = "select * from bookmarkjob where SeekerId = ? and JobId = ?";
            $stmt=  $this->conn->prepare($sql);
            $stmt->bind_param("ii", $seeker_id, $job_id);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            $res = $stmt->get_result();
            if($res->num_rows != 1){
                return array("code" => 2, "error" => "No jobs were bookmarked");
            }
            $sql = "delete from bookmarkjob where SeekerId = ? and JobId = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii", $seeker_id, $job_id);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            return array("code" => 0, "msg" => "Remove bookmark successfully");
        }
        public function get_bookmark_by_user($seeker_id){
            $sql = "select job.*, bookmarkjob.*, company.* from job, bookmarkjob, company where job.JobId = bookmarkjob.JobId and job.CompanyId = company.CompanyId and bookmarkjob.SeekerId = ?";
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
    }
?>