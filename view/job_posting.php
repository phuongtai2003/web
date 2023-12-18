<div class = "container job-posting-container">
    <img class = "loading-image" src = "./images/loading-gif.gif">
    <div class = "job-posting-header">
        <h1 id = "job-posting-title">
            Let's get you up and running
        </h1>
        <h3 id = "job-posting-subtitle">
            Your company can hire the best talents around the world via our website!
        </h3>
    </div>
    <div class = "job-posting-body">
        <div class = "posting-body-header">
            <h1 class = "posting-body-title">
                Let's advertise a job
            </h1>
            <h3 class = "posting-body-subtitle">
                Your company can enter the job information in the form below
            </h3>
        </div>
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
        <div class = "job-posting-form">
            <form method = "post">
                <h1>Job Advertisement Form</h1>
                <div class = "form-group">
                    <label for = "job-name-field">Job Name</label>
                    <input value = "<?=$job_name?>" type = "text" id = "job-name-field" name = "job-name" placeholder = "Job Name" required>
                </div>
                <div class = "form-group">
                    <label for = "job-description-field">Job Description</label>
                    <textarea rows="10" id = "job-description-field" name = "job-description" placeholder = "Job Description" required><?=str_replace("<br />","\n",$job_desc)?></textarea>
                </div>
                <div class = "form-group">
                    <label for = "job-requirements-field">Job Requirements</label>
                    <textarea rows="10" id = "job-requirements-field" name = "job-requirements" placeholder = "Job Requirements" required><?=str_replace("<br />","\n",$job_req)?></textarea>
                </div>
                <div class = "form-group">
                    <label for = "job-benefits-field">Job Benefits</label>
                    <textarea rows="10" id = "job-benefits-field" name = "job-benefits" placeholder = "Job Benefits" required><?=str_replace("<br />","\n",$job_benefits)?></textarea>
                </div>
                <div class = "form-group">
                    <label for = "salary-range-option">Salary Range (Dollars per Year)</label>
                    <div id = "salary-range-option">
                        <input value = "<?=$min_salary?>" min="20000" max = "500000"type = "number" id = "min-salary-field" name = "min-salary" placeholder = "Min Salary" required>
                        <input value = "<?=$max_salary?>" min="20000" max = "500000" type = "number" id = "max-salary-field" name = "max-salary" placeholder = "Max Salary" required>
                    </div>
                </div>
                <div class = "form-group">
                    <label for = "job-candidates-field">Job Candidates Number</label>
                    <input value = "<?=$candidates?>" min="1" type = "number" id = "job-candidates-field" name = "job-candidates-number" placeholder = "Job Candidates Number" required>
                </div>
                <div class = "form-group">
                    <label for = "job-location-field">Job Location</label>
                    <input value = "<?=$location?>" type = "text" id = "job-location-field" name = "job-location" placeholder = "Job Location" required>
                </div>
                <div class = "form-group">
                    <label for = "job-expiry-field">Job Expiry Date</label>
                    <input value = "<?=$exp_date?>" type = "date" id = "job-expiry-field" name = "job-expiry" placeholder = "Job Expiry Date" required>
                </div>
                <div class = "form-group">
                    <label for="job-location-type-field">Job Location Type</label>
                    <select id = "job-location-type-field" name = "job-location-type">
                    </select>
                </div>
                <div class = "form-group">
                    <label for="job-employment-type-field">Form Of Employment</label>
                    <select id = "job-employment-type-field" name = "job-employment-type">
                    </select>
                </div>
                <div class = "form-group">
                    <label for="job-experience-level-field">Job Experience</label>
                    <select id = "job-experience-level-field" name = "job-experience-level">
                    </select>
                </div>
                <div class = "form-group">
                    <label for="job-level-field">Job Level</label>
                    <select id = "job-level-field" name = "job-level">

                    </select>
                </div>
                <div class = "form-group">
                    <label for="job-field-type-field">Job Field</label>
                    <select onchange="getSkills(this.value)" id = "job-field-type-field" name = "job-field-type">
                    </select>
                </div>
                <div class = "form-group">
                    <label for="job-skills-field">Job Skills</label>
                    <div id = "job-skills-field">                 
                    </div>
                </div>
                <div class = "button-group">
                    <input type = "hidden" name = "action" value = "job-posting">
                    <button type = "submit" class = "btn btn-fill">Create Job</button>
                    <button onclick = "resetAll()" type = "reset" class = "btn btn-outline">Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function displayMessage(msg){
        let messageAlert = $(".alert");
        if(messageAlert.length === 0){
            $(".seeker-panel-container .col-9").append(`<div class = "alert">${msg}</div>`);
        }
        else{
            messageAlert.html(msg);
        }
    }
    
    function resetAll(){
        $("#job-skills-field").html("");
    }
    

    function getSkills(jobFieldId){
        $.ajax({
        type: "GET",
        url: "http://localhost/models/api/jobSkill/getDataByField.php",
        data: {
            fieldId: jobFieldId,
        },
        success: function (response) {
            const data = response['data'];
            console.log(data);
            let optionList = '';
            data.forEach(dataElement => {
                optionList += `
                        <div class = "job-skill-option">
                            <label><input type = "checkbox" name = "skills[]" value = "${dataElement['SkillId']}" > ${dataElement['SkillName']}</label>
                        </div>
                `
            });
            $("#job-skills-field").html(optionList);
        },
        });
    }

    $.ajax({
        type: "GET",
        url: "http://localhost/models/api/jobLocationType/getData.php",
        success: function (response) {
            const data = response['data'];
            let optionList = '';
            data.forEach(dataElement => {
                optionList += `<option value="${dataElement['JobLocationTypeId']}">${dataElement['JobLocationTypeName']}</option>`
            });
            $("#job-location-type-field").html(optionList);
        }
    });

    $.ajax({
        type: "GET",
        url: "http://localhost/models/api/employmentForm/getData.php",
        success: function (response) {
            const data = response['data'];
            let optionList = '';
            data.forEach(dataElement => {
                optionList += `<option value="${dataElement['EmploymentTypeId']}">${dataElement['EmploymentTypeName']}</option>`
            });
            $("#job-employment-type-field").html(optionList);
        }
    });

    

    $.ajax({
        type: "GET",
        url: "http://localhost/models/api/jobExperience/getData.php",
        success: function (response) {
            const data = response['data'];
            let optionList = '';
            data.forEach(dataElement => {
                optionList += `<option value="${dataElement['JobExperienceId']}">${dataElement['JobExperienceName']}</option>`
            });
            $("#job-experience-level-field").html(optionList);
        }
    });
    

    $.ajax({
        type: "GET",
        url: "http://localhost/models/api/jobLevel/getData.php",
        success: function (response) {
            const data = response['data'];
            let optionList = '';
            data.forEach(dataElement => {
                optionList += `<option value="${dataElement['JobLevelId']}">${dataElement['JobLevelName']}</option>`
            });
            $("#job-level-field").html(optionList);
        }
    });
    

    $.ajax({
        type: "GET",
        url: "http://localhost/models/api/jobField/getData.php",
        success: function (response) {
            const data = response['data'];
            let optionList = '';
            data.forEach(dataElement => {
                optionList += `<option value="${dataElement['JobFieldId']}">${dataElement['JobFieldName']}</option>`
            });
            $("#job-field-type-field").html(optionList);
        }
    });
</script>