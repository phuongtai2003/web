<div class = "container job-listing-container">
    <h1><?=count($job_listing_data)?> Jobs Are Currently Hiring</h1>
    <div class = "job-listing-body">
        <?php
            if(!empty($error)){
                ?>
                    <div class = "alert"><?=$error?></div>
                <?php
            }
            else{
                for($i = 0; $i < count($job_listing_data); $i++){
                    ?>
                        <div class = "job-listing-item">
                            <img src = "<?=$job_listing_data[$i]['CompanyImage'] == null ? './images/defaultCompany.png' : $job_listing_data[$i]['CompanyImage']?>" alt = "<?=$job_listing_data[$i]['CompanyName']?> image">
                            <div class = "job-item-wrapper">
                                <div class = "job-item-header">
                                    <div class = "job-title-company">
                                        <h3><?=$job_listing_data[$i]['CompanyName']?></h3>
                                        <p><?=$job_listing_data[$i]['JobName']?></p>
                                    </div>
                                    <div class = "job-listing-utility">
                                        <button onclick = "deleteJob(<?=$job_listing_data[$i]['JobId']?>, '<?=$job_listing_data[$i]['JobName']?>')" class = "btn job-delete-btn btn-fill"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                </div>
                                <div class = "job-item-body">
                                    <div class = "body-item-details">
                                        <p>Expired Date: <?=$job_listing_data[$i]['JobExpiryDate']?></p>
                                        <p><?=count($application_details[$i])?> applicant(s)</p>
                                    </div>
                                    <div class = "body-item-utility">
                                        <a href = "?candidate=<?=$job_listing_data[$i]['JobId']?>" class = "btn btn-fill">View Applicants</a>
                                        <a href = "?job_details=<?=$job_listing_data[$i]['JobId']?>" class = "btn btn-outline">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                }
            }
            if(!empty($msg)){
                ?>
                    <div class = "alert"><?=$msg?></div>
                <?php
            }
        ?>
    </div>
    <div id = "delete-job-modal" class = "modal">
        <form method = "post">
            <div class = "modal-header">
                <h4>Delete Job</h4>
                <span class="close">&times;</span>
            </div>
            <div class="modal-content">
                <p>Are you sure you want to delete the <strong id = "delete-job-name">Senior Kotlin Developer</strong> job ?</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id = "delete-job-id" value = "" name = "job-id">
                <input type="hidden" name = "action" value = "delete-job">
                <button type = "submit" class = "btn btn-fill btn-confirm">Yes</button>
                <button type = "button" class= "btn btn-outline btn-close-modal">No</button>
            </div>
        </form>
    </div>
</div>

<script>
    function deleteJob(jobId, jobName){
        let deleteJobName= $("#delete-job-name");
        let deleteJobId = $("#delete-job-id");
        deleteJobName.html(jobName);
        deleteJobId.val(jobId);
    }
</script>