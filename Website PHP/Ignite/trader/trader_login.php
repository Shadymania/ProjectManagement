<?php 
session_unset();
include '../includes/form.php';

?>
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
                        Logo here
                    </div>
            </div>

            <div class="login-signup-container">
                <div class="login-signup-box">
                    <div class="form-title">TRADER LOGIN</div>

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
                        <input type='text' name="name" placeholder="TRADER NAME"/>
                        <input type='password' name="password" placeholder="PASSWORD"/>
                        <input type="checkbox"><span>REMEMBER ME</span>
                        <button type="submit" name="trader_login_submit">LOGIN</button><br>
                        <div class="member">NOT A TRADER?<br> <a href="../login.php">LOGIN AS CUSTOMER</a></div>
                    </form>
                </div>

    </div>
</body>
</html>
