<div class = "container bookmark-job-container">
    <?php
        if(!empty($error)){
            ?>
                <div class = "alert"><?=$error?></div>
            <?php
        }
        else if(!empty($msg)){
            ?>
                <div class = "alert"><?=$msg?></div>
            <?php
        }
    ?>
    <h4>You are currently bookmarking <?=count($bookmark_job)?> jobs</h4>
    <div class = "bookmark-job-listing">
        <?php
            foreach($bookmark_job as $j){
                ?>
                    <div class = "bookmark-job-item">
                        <img src = "<?=$j['CompanyImage'] ==null ? "./images/defaultCompany.png" : $j['CompanyImage'] ?>" alt = "<?=$j['CompanyName']?> Image">
                        <div class = "bookmark-job-header">
                            <h3><?=$j['CompanyName']?></h3>
                            <p><?=$j['JobName']?></p>
                            <p>Expiry Date: <?=date("d/m/Y",strtotime($j['JobExpiryDate']))?></p>
                        </div>
                        <div class = "button-group">
                            <a href = "?job_details=<?=$j['JobId']?>" class = "btn btn-fill">View Details</a>
                            <button onclick = "removeBookmarkDialog(`<?=$j['JobName']?>`, <?=$j['JobId']?>)" class = "btn btn-outline btn-remove-bookmark">Remove Bookmark</button>
                        </div>
                    </div>
                <?php
            }
        ?>
    </div>
    <div id = "remove-bookmark-modal" class = "modal">
        <form method = "post">
            <div class = "modal-header">
                <h4>Remove Bookmark</h4>
                <span class="close">&times;</span>
            </div>
            <div class="modal-content">
                <p>Are you sure you want to remove bookmark of the <strong id = "remove-bookmark-job-name">Senior Kotlin Developer</strong> job ?</p>
            </div>
            <div class="modal-footer">
                <input type = "hidden" name = "job" value = "" id = "remove-bookmark-input">
                <input type = "hidden" name = "action" value = "remove-bookmark">
                <button type = "submit" class = "btn btn-fill btn-confirm">Yes</button>
                <button type = "button" class= "btn btn-outline btn-close-modal">No</button>
            </div>
        </form>
    </div>
</div>
<script>
    function removeBookmarkDialog(name, jobId){
        let jobName = $("#remove-bookmark-job-name");
        let jobInput = $("#remove-bookmark-input");
        jobName.html(name);
        jobInput.val(jobId);
    }
</script>