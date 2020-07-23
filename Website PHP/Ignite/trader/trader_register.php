<?php
include '../includes/form.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>IGNITE</title>
</head>
<body>
<div class="container logo-search-bar">
                    <div class="pd-6">
                        <a href="../index.php">
                            Logo here
                        </a>
                        
                    </div>
            </div>

            <div class="login-signup-container">
                <div class="login-signup-box">
                    <div class="form-title"> BECOME A TRADER</div>
                    <?php
                        if(count($errors)) {
                            

                            ?>

                                    <?php
                                    foreach($errors as $error) {
                                        ?>
                                        <div class="mt-20">
                                            <div style="width: 100%; display:block;" class="msg_error">
                                            <?php echo $error; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>


                            <?php
                        }
                        ?>


                    <form method="POST" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' enctype="multipart/form-data">
                    <label>Something that represents the products you sell(for example: Greengrocer)</label>    
                    <input type='text' name="name"  value="<?php echo (isset($_POST['name'])) ? $_POST['name']: '';?>" placeholder="TRADER NAME" required/>
                        <input type='text' name="mobile_num"  value="<?php echo (isset($_POST['mobile_num'])) ? $_POST['mobile_num']: '';?>" placeholder="MOBIE NUMBER" required/>
                        <input type='password' name="pass1"  value="<?php echo (isset($_POST['pass1'])) ? $_POST['pass1']: '';?>" placeholder="PASSWORD" required/>
                        <input type='password' name="pass2"  value="<?php echo (isset($_POST['pass2'])) ? $_POST['pass2']: '';?>" placeholder="CONFIRM PASSWORD" required/>
                        <textarea name="description" required> <?php echo (isset($_POST['description'])) ? $_POST['description']: 'Tell us about your products....';?></textarea>

                        <button type="submit" name="trader_register">SUBMIT</button><br>
                    </form>
                </div>

    </div>
</body>
</html>