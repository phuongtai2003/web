<?php
    require_once("connection.php");
    class ReviewDB{
        private mysqli $conn;
        public function __construct(){
            $this->conn = get_connection();
        }
        public function review_company($seeker, $company, $rating, $comments){
            if($rating < 1 || $rating > 5){
                return array("code" => 2, "error" => "Invalid review ratings");
            }
            $sql = "select * from companyreview where SeekerId = ? and CompanyId = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii",$seeker, $company);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            
            $res = $stmt->get_result();
            $has_already_reviewed = $res->num_rows == 1 ? true : false;
            $date = date("Y-m-d");
            
            if($has_already_reviewed){
                $sql = "update companyreview set ReviewRating = ?, ReviewComment = ?, DateReview = ? where SeekerId = ? and CompanyId = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("issii", $rating, $comments, $date, $seeker, $company);
                if(!$stmt->execute()){
                    return array("code" => 1, "error" => "Something went wrong");
                }
                else{
                    return array("code" => 0, "msg" => "Update review completed");
                }
            }
            else{
                $sql = "insert into companyreview(CompanyId, SeekerId, ReviewRating, ReviewComment, DateReview) values (?,?,?,?,?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("iiiss", $company, $seeker, $rating, $comments, $date);
                if(!$stmt->execute()){
                    return array("code" => 1, "error" => "Something went wrong");
                }
                else{
                    return array("code" => 0, "msg" => "Review company successfully");
                }
            }
        }
        public function get_rating_by_company($company){
            $sql = "SELECT CompanyId, avg(ReviewRating) as Average from companyreview where CompanyId = ? group by CompanyId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $company);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            $res = $stmt->get_result();
            $rating = 0;
            if($res->num_rows != 0){
                $rating = $res->fetch_assoc()['Average'];
            }
            return array("code" => 0, "msg" => "Fetch data successfully", "rating" => $rating);
        }
        public function get_top_three(){
            $sql = "select company.*, IFNULL(AVG(companyreview.ReviewRating),0) as Average FROM company LEFT JOIN companyreview ON company.CompanyId = companyreview.CompanyId group by companyreview.CompanyId order by Average desc limit 3";
            $stmt = $this->conn->prepare($sql);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            $res = $stmt->get_result();
            $data = array();
            while($row = $res->fetch_assoc()){
                $data[] = $row;
            }
            return array("code" => 0, "msg" => "Fetch data successfully", "data" => $data);
        }
    }
?>