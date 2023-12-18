<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Job Fast - Activate</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="./css/style.css">
    </head>
    <body>
        <div class = "activate-body">
            <?php 
                if(!empty($error)){
                    ?>
                    <div class = "activate-alert">
                        <?=$error?>
                    </div>
                    <?php
                }
                else if(!empty($msg)){
                    ?>
                        <div class = "activate-alert">
                            <?=$msg?>
                        </div>
                    <?php
                }
            ?>
            
        </div>
    </body>
</html>
