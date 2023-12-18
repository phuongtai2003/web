<div class = "container job-details-container">
    <div class = "job-details-header">
        <div class = "img-container">
            <img src="<?=$job['CompanyImage']  ==  null ? "./images/defaultCompany.png" : $job['CompanyImage'] ?>" alt="<?=$job['CompanyName']?> Image">
        </div>
        <div class = "company-job-title">
            <h3><?=$job['JobName']?></h3>
            <a style = "color: var(--primary-color)" href = "?comp_details=<?=$job['CompanyId']?>"><h5><?=$job['CompanyName']?></h5></a>
            <p>Expiry Date: <?=date("d/m/Y",strtotime($job['JobExpiryDate']))?></p>
        </div>
        <div class = "button-group">
            <?php
                if($role === 'seeker' && !$seeker_application_data){
                    ?>
                        <form style = "width: 100%" method = "post">
                            <input type = "hidden" name = "action" value = "apply-job">
                            <input type = "hidden" name = "job" value = "<?=$job['JobId']?>">
                            <button style = "width: 100%" type = "submit" class = "btn btn-fill button-apply-now">
                                Apply Now
                            </button>
                        </form>
                    <?php
                }
                else if ($role === 'seeker' && $seeker_application_data){
                    ?>
                        <form style = "width: 100%" method = "post">
                            <input type = "hidden" name = "action" value = "unapply-job">
                            <input type = "hidden" name = "job" value = "<?=$job['JobId']?>">
                            <button style = "width: 100%" type = "submit" class = "btn btn-fill button-apply-now">
                                Unapply
                            </button>
                        </form>
                    <?php
                }
                if($role === 'seeker' && !$seeker_bookmark_data){
                    ?>
                        <form method = "post">
                            <input type = "hidden" name = "action" value = "bookmark-job">
                            <input type = "hidden" name = "job" value = "<?=$job['JobId']?>">
                            <button class = "btn btn-outline btn-bookmark-job">
                                Bookmark Job
                            </button>
                        </form>
                    <?php
                }
                else if($role === 'seeker' && $seeker_bookmark_data){
                    ?>
                        <form method = "post">
                            <input type = "hidden" name = "action" value = "remove-bookmark">
                            <input type = "hidden" name = "job" value = "<?=$job['JobId']?>">
                            <button class = "btn btn-outline btn-bookmark-job">
                                Remove Bookmark
                            </button>
                        </form>
                    <?php
                }
                else if($role === ''){
                    ?>
                        <a href = "?page=login" class =  "btn btn-fill">Login Now</a>
                    <?php
                }
            ?>
        </div>
    </div>
    <?php
        if(!empty($error)){
            ?>
                <div class = "alert" ><?=$error?></div>
            <?php
        }
        else if(!empty($msg)){
            ?>
                <div class = "alert" ><?=$msg?></div>
            <?php
        }
    ?>
    <div class = "job-details-body">
        <div class = "details-body-header">
            <h2>Job Details</h2>
        </div>
        <div class = "container">
            <div class = "row">
                <div class = "col-8 col-wrapper">
                    <div class = "general-info">
                        <p>General Information</p>
                        <div class = "items-box">
                            <div class = "box-item">
                                <img src="./images/salary.png" alt="">
                                <div>
                                    <h3>Salary</h3>
                                    <p><?=number_format($job['JobMinSalary'],0,",",".")?> - <?=number_format($job['JobMaxSalary'],0,",",".")?> $</p>
                                </div>
                            </div>
                            <div class = "box-item">
                                <img src="./images/man.png" alt="">
                                <div>
                                    <h3>Number of Candidates</h3>
                                    <p><?=$job['NumberOfCandidates']?> candidates</p>
                                </div>
                            </div>
                            <div class = "box-item">
                                <img src="./images/experience.png" alt="">
                                <div>
                                    <h3>Year Of Experience</h3>
                                    <p><?=$experience['JobExperienceName']?></p>
                                </div>
                            </div>
                            <div class = "box-item">
                                <img src="./images/position.png" alt="">
                                <div>
                                    <h3>Level</h3>
                                    <p><?=$level['JobLevelName']?></p>
                                </div>
                            </div>
                            <div class = "box-item">
                                <img src="./images/suitcase.png" alt="">
                                <div>
                                    <h3>Form Of Employment</h3>
                                    <p><?=$employment['EmploymentTypeName']?></p>
                                </div>
                            </div>
                            <div class = "box-item">
                                <img src="./images/work-location.png" alt="">
                                <div>
                                    <h3>Working Location Type</h3>
                                    <p><?=$location_type['JobLocationTypeName']?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = "location-container">
                        <p>Working Location</p>
                        <div>
                            <img src = "./images/location.png" alt = "">
                            <p><?=$job['JobLocation']?></p>
                        </div>
                    </div>
                    <div class = "job-description">
                        <h4>Job Description</h4>
                        <div class = "description-content">
                            <?php
                                $string_array = explode(".",str_replace("<br />","",$job['JobDescription']));
                                ?>
                                    <ul>
                                <?php
                                    foreach($string_array as $para){
                                        if(!empty($para)){
                                            ?>
                                                <li><?=$para?></li>
                                            <?php
                                        }
                                    }
                                    ?>
                                    </ul>
                                <?php
                            ?>
                        </div>
                    </div>
                    <div class = "job-requirements">
                        <h4>Job Requirements</h4>
                        <div class = "requirements-content">
                            <?php
                                $string_array = explode(".",str_replace("<br />","",$job['JobRequirements']));
                                ?>
                                    <ul>
                                <?php
                                    foreach($string_array as $para){
                                        if(!empty($para)){
                                            ?>
                                                <li><?=$para?></li>
                                            <?php
                                        }
                                    }
                                    ?>
                                    </ul>
                                <?php
                            ?>
                        </div>
                    </div>
                    <div class = "job-benefits">
                        <h4>Job Benefits</h4>
                        <div class = "benefits-content">
                            <?php
                                $string_array = explode(".",str_replace("<br />","",$job['JobBenefits']));
                                ?>
                                    <ul>
                                <?php
                                    foreach($string_array as $para){
                                        if(!empty($para)){
                                            ?>
                                                <li><?=$para?></li>
                                            <?php
                                        }
                                    }
                                    ?>
                                    </ul>
                                <?php
                            ?>
                        </div>
                    </div>
                    <div class = "application-section">
                        <h4>Application</h4>
                        <?php
                            if($role === 'company'){
                                ?>
                                    <p>There has been <?=count($application)?> applicants apply for the job</p>
                                <?php
                            }
                            else{
                                ?>
                                    <p>Applicants can apply to the job by pressing the "Apply Now" button below</p>
                                    <div class = "apply-button-group">
                                        <?php
                                            if($role === 'seeker' && !$seeker_application_data){
                                                ?>
                                                    <form method = "post">
                                                        <input type = "hidden" name = "action" value = "apply-job">
                                                        <input type = "hidden" name = "job" value = "<?=$job['JobId']?>">
                                                        <button type = "submit" class = "btn btn-fill button-apply-now">
                                                            Apply Now
                                                        </button>
                                                    </form>
                                                <?php
                                            }
                                            else if($role === 'seeker' && $seeker_application_data){
                                                ?>
                                                    <form method = "post">
                                                        <input type = "hidden" name = "action" value = "unapply-job">
                                                        <input type = "hidden" name = "job" value = "<?=$job['JobId']?>">
                                                        <button type = "submit" class = "btn btn-fill button-apply-now">
                                                            Unapply
                                                        </button>
                                                    </form>
                                                <?php
                                            }
                                            if($role === 'seeker' && !$seeker_bookmark_data){
                                                ?>
                                                    <form method = "post">
                                                        <input type = "hidden" name = "action" value = "bookmark-job">
                                                        <input type = "hidden" name = "job" value = "<?=$job['JobId']?>">
                                                        <button type = "submit" class = "btn btn-outline button-bookmark-job">
                                                            Bookmark Job
                                                        </button>
                                                    </form>
                                                <?php
                                            }
                                            else if($role === 'seeker' && $seeker_bookmark_data){
                                                ?>
                                                    <form method = "post">
                                                        <input type = "hidden" name = "action" value = "remove-bookmark">
                                                        <input type = "hidden" name = "job" value = "<?=$job['JobId']?>">
                                                        <button type = "submit" class = "btn btn-outline button-bookmark-job">
                                                            Remove Bookmark
                                                        </button>
                                                    </form>
                                                <?php
                                            }
                                            if($role === ''){
                                                ?>
                                                    <a href = "?page=login" class = "btn btn-fill">Login Now</a>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                <?php
                            }
                        ?>
                        <p>Application expiry date: <?=date("d/m/Y",strtotime($job['JobExpiryDate']))?></p>
                    </div>
                </div>
                <div class = "col-4 col-wrapper">
                    <div class = "share-job-info">
                        <h4>Share job information</h4>
                        <div class = "job-sharing-social">
                        <a href="https://twitter.com"><i class="fa-brands fa-twitter" ></i></a>
                        <a href="https://instagram.com"><i class="fa-brands fa-instagram" ></i></a>
                        <a href="https://fb.com"><i class="fa-brands fa-facebook" ></i></a>
                        <a href="https://linkedin.com"><i class="fa-brands fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class = "job-type">
                        <h4>Job Field</h4>
                        <p><?=$field['JobFieldName']?></p>
                    </div>
                    <div class = "job-skills">
                        <h4>Job Skills</h4>
                        <div class = "skills-card">
                            <?php
                                foreach($skills as $s){
                                    ?>
                                        <div class = "job-skill-card"><?=$s['SkillName']?></div>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                    <div class = "company-job-recommendation">
                        <h4>Company vacancies available</h4>
                        <?php
                            foreach($recommend as $r){
                                ?>
                                    <div class = "job-recommendation-card">
                                        <img src="<?=$job['CompanyImage'] == null ? "./images/defaultCompany.png" : $job['CompanyImage']?>" alt="">
                                        <div>
                                            <h4><?=$job['CompanyName']?></h4>
                                            <a href="?job_details=<?=$r['JobId']?>"><?=$r['JobName']?></a>
                                        </div>
                                    </div>
                                <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>