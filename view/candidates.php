<div class = "container candidates-container">
    <h1>There has been <?=count($candidates_info)?> candidates applied for the <?=$job['JobName']?> job</h1>
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
    <div class = "candidates-list-container">
        <?php
            foreach($candidates_info as $candidate){
                ?>
                    <div class = "candidate-card">
                        <div class = "candidate-personal-info">
                            <h4><?=$candidate['SeekerFirstName'].' '.$candidate['SeekerLastName']?></h4>
                            <p>Birth Date: <?=date("d/m/Y",strtotime($candidate['SeekerBirthDate']))?></p>
                            <p>Nationality: <?=$candidate['SeekerNationality']?></p>
                            <p>Province: <?=$candidate['SeekerProvince']?></p>
                        </div>
                        <div class = "candidate-button-group">
                            <a target="_blank" rel="noopener noreferrer" href = "<?=$candidate['SeekerCV'] == null ? "":  $candidate['SeekerCV']?>" class = "btn btn-fill view-cv-btn"><?=$candidate['SeekerCV'] == null ? "Seeker has no CV":  "View CV" ?></a>
                            <form style = "width: 100%;" method = "post">
                                <input type = "hidden" name = "action" value = "dismiss-applicant">
                                <input type = "hidden" name = "seeker" value = "<?=$candidate['SeekerId']?>">
                                <input type = "hidden" name = "job" value = <?=$candidate['JobId']?>>
                                <button style = "width: 100%;" type = "submit" class = "btn btn-outline">Dismiss</button>
                            </form>
                            <?php
                                if(!$candidate['ApplyStatus']){
                                    ?>
                                        <button onclick = "bookInterview(<?=$candidate['JobId']?>, <?=$candidate['SeekerId']?>, `<?=$candidate['SeekerFirstName'].' '.$candidate['SeekerLastName']?>`)" type = "button" class = "btn btn-fill btn-book-interview">Book An Interview</button>
                                    <?php
                                }
                                else{
                                    ?>
                                        <button onclick = "bookInterview(<?=$candidate['JobId']?>, <?=$candidate['SeekerId']?>, `<?=$candidate['SeekerFirstName'].' '.$candidate['SeekerLastName']?>`)" class = "btn btn-fill btn-book-interview">Already Booked</button>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                <?php
            }
        ?>
    </div>
    <div id = "interview-job-modal" class = "modal">
        <form method = "post">
            <div class = "modal-header">
                <h4>Book an interview for <strong id = "candidate-name">Candidate name</strong></h4>
                <span class="close">&times;</span>
            </div>
            <div class="modal-content">
                <div class = 'form-group'>
                    <label for = "interview-date">Book a date</label>
                    <input type = "date" name = "interview-date" id = "interview-date">
                </div>
                <div class = "form-group">
                    <label for = 'interview-time'>Interview Time</label>
                    <input type = "time" name = "interview-time" id = "interview-time">
                </div>
            </div>
            <div class="modal-footer">
                <input type = "hidden" name = "job" value = "" id = "job-id-input">
                <input type = "hidden" name  = "seeker" value = "" id = "seeker-id-input">
                <input type = "hidden" name = "action" value = "book-interview">
                <button type = "submit" class = "btn btn-fill btn-confirm">Yes</button>
                <button type = "button" class= "btn btn-outline btn-close-modal">No</button>
            </div>
        </form>
    </div>
</div>
<script>
    function bookInterview(job, candidateNum, candidateName){
        let jobInput = $("#job-id-input");
        let seekerInput = $("#seeker-id-input");
        jobInput.val(job);
        seekerInput.val(candidateNum);
        let candidateNameField = $("#candidate-name");
        candidateNameField.html(candidateName);
    }
</script>