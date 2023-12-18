<?php
    require_once("connection.php");
    class JobDB{
        private mysqli $conn;
        public function __construct(){
            $this->conn = get_connection();
        }
        public function insert_job($job_name, $job_desc, $job_requirement, $min_salary, $max_salary, $candidates, $location, $exp_date, $benefits ,$location_type, $employment_form, $experience_type, $level, $job_field, $job_skills, $company){
            foreach($job_skills as $s){
                $check_sql = "select * from jobskills where JobFieldId = ? and SkillId = ?";
                $stmt = $this->conn->prepare($check_sql);                
                $stmt->bind_param("ii", $job_field, $s);
                if(!$stmt -> execute()){
                    return array("code" => 1, "error" => "Something went wrong");
                }
                $check_res = $stmt->get_result();
                if($check_res->num_rows != 1){
                    return array("code" => 2, "error" => "Skill does not belong to the field");
                }
            }
            
            $sql = "insert into job (JobName, JobDescription, JobRequirements, JobMinSalary, JobMaxSalary, NumberOfCandidates, JobLocation, JobExpiryDate, JobBenefits, JobLevelId, JobFieldId, EmploymentTypeId, JobLocationTypeId, JobExperienceId, CompanyId) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sssiiisssiiiiii",$job_name, $job_desc, $job_requirement, $min_salary, $max_salary, $candidates, $location, $exp_date, $benefits, $level, $job_field, $employment_form, $location_type, $experience_type, $company);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            $newest_job = mysqli_insert_id($this->conn);
            foreach ($job_skills as $skill) {
                $sql = "insert into jobskillsrequirements values(?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("ii", $skill, $newest_job);
                if(!$stmt->execute()){
                    return array("code" => 1, "error" => "Something went wrong");
                }
            }
            return array("code" => 0, "msg" => "Create job successfully");
        }
        public function get_job_by_company($company){
            $sql = "select job.*, company.* from job, company where job.CompanyId = company.CompanyId and company.CompanyId = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $company);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Some thing went wrong");
            }
            $data = array();
            $res = $stmt->get_result();
            while($row = $res->fetch_assoc()){
                $data[] = $row;
            }
            return array("code" => 0, "msg" => "Fetch data successfully", "data" => $data);
        }

        public function get_recommend_by_company($company){
            $sql = "select job.*, company.* from job, company where job.CompanyId = company.CompanyId and company.CompanyId = ? LIMIT 5";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $company);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Some thing went wrong");
            }
            $data = array();
            $res = $stmt->get_result();
            while($row = $res->fetch_assoc()){
                $data[] = $row;
            }
            return array("code" => 0, "msg" => "Fetch data successfully", "data" => $data);
        }
        public function get_job($id){
            $sql = "select job.*, company.* from job, company where job.CompanyId = company.CompanyId and job.JobId = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Some thing went wrong");
            }
            $res = $stmt->get_result();
            if($res->num_rows != 1){
                return array("code" => 2, "error" => "Job does not exist");
            }
            $data = $res->fetch_assoc();
            return array("code" => 0, "msg" => "Fetch data successfully", "data" => $data);
        }
        public function get_skills_by_job($id){
            $sql = "select jobskills.*, jobskillsrequirements.* from jobskills, jobskillsrequirements WHERE jobskills.SkillId = jobskillsrequirements.SkillId and jobskillsrequirements.JobId = ?";
            $stmt= $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Some thing went wrong");
            }
            $res = $stmt->get_result();
            $data = array();
            while ($row = $res->fetch_assoc()) {
                $data[] = $row;
            }
            return array("code" => 0, "msg" => "Fetch data successfully", "data" => $data);
        }
        public function delete_job($job_id, $company){
            $sql = "select * from job where JobId = ? and CompanyId = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii", $job_id, $company);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            $res = $stmt->get_result();
            if($res->num_rows != 1){
                return array("code" => 2, "error" => "Job does not exist");
            }
            $sql = "delete from jobskillsrequirements where JobId = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $job_id);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }

            $sql = "delete from jobapplication where JobId = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $job_id);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }

            $sql = "delete from bookmarkjob where JobId = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $job_id);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }

            $sql = "delete from job where JobId = ? and CompanyId = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ii", $job_id, $company);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }

            return array("code" => 0, "msg" => "Delete job successfully");
        }
        public function get_all_jobs(){
            $sql = "select job.*, company.* from job, company where job.CompanyId = company.CompanyId  order by job.JobId Desc";
            $stmt = $this->conn->prepare($sql);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            $res = $stmt->get_result();
            $data = array();
            while($row = $res->fetch_assoc()){
                $data[] = $row;
            }
            return array("code" => 0, "msg" => "Get job successfully", "data" => $data);
        }
        public function get_job_by_page($initital){
            $sql = "select job.*, company.* from job, company where job.CompanyId = company.CompanyId  order by job.JobId Desc limit 5 offset ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i",$initital);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            $res = $stmt->get_result();
            $data = array();
            while($row = $res->fetch_assoc()){
                $data[] = $row;
            }
            return array("code" => 0, "msg" => "Get job successfully", "data" => $data);
        }
        public function search_jobs($title, $job_exp, $job_field, $job_location_type, $job_level, $job_company_type){
            $sql = "select job.*, company.* from job, company where job.CompanyId = company.CompanyId";
            if(!empty($title)){
                $sql .= " and JobName LIKE '%$title%'";
            }
            if($job_exp != -1){
                $sql .= " and JobExperienceId = $job_exp";
            }
            if($job_field != -1){
                $sql .= " and JobFieldId = $job_field";
            }
            if($job_location_type != -1){
                $sql .= " and JobLocationTypeId = $job_location_type";
            }
            if($job_level != -1){
                $sql .= " and JobLevelId = $job_level";
            }
            if($job_company_type != -1){
                $sql .= " and CompanyTypeId = $job_company_type";
            }
            $sql .= " order by job.JobId Desc";
            $stmt = $this->conn->prepare($sql);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            $res = $stmt->get_result();
            $data = array();
            while($row = $res->fetch_assoc()){
                $data[] = $row;
            }
            return array("code" => 0, "msg" => "Get job successfully", "data" => $data);
        }

        public function search_jobs_by_page($title, $job_exp, $job_field, $job_location_type, $job_level, $job_company_type, $initial){
            $sql = "select job.*, company.* from job, company where job.CompanyId = company.CompanyId";
            if(!empty($title)){
                $sql .= " and JobName LIKE '%$title%'";
            }
            if($job_exp != -1){
                $sql .= " and JobExperienceId = $job_exp";
            }
            if($job_field != -1){
                $sql .= " and JobFieldId = $job_field";
            }
            if($job_location_type != -1){
                $sql .= " and JobLocationTypeId = $job_location_type";
            }
            if($job_level != -1){
                $sql .= " and JobLevelId = $job_level";
            }
            if($job_company_type != -1){
                $sql .= " and CompanyTypeId = $job_company_type";
            }
            $sql .= " order by job.JobId Desc LIMIT 5 offset ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $initial);
            if(!$stmt->execute()){
                return array("code" => 1, "error" => "Something went wrong");
            }
            $res = $stmt->get_result();
            $data = array();
            while($row = $res->fetch_assoc()){
                $data[] = $row;
            }
            return array("code" => 0, "msg" => "Get job successfully", "data" => $data);
        }
    }
?>