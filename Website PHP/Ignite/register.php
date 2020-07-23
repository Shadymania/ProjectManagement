<?php
include 'includes/form.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <title>IGNITE</title>
</head>
<body>
<div class="container logo-search-bar">
        <div class="pd-6">
            <a href="index.php">
             <img src="img/ignite-logo.png">
            </a>

        </div>
</div>

<div class="login-signup-container">
    <div class="login-signup-box">
        <div class="form-title"> SIGN UP</div>
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
            <input type='text' name="f_name"  value="<?php echo (isset($_POST['f_name'])) ? $_POST['f_name']: '';?>" placeholder="First Name"/>
            <input type='text' name="l_name"  value="<?php echo (isset($_POST['l_name'])) ? $_POST['l_name']: '';?>" placeholder="LAST Name"/>
            <input type='email' name="email"  value="<?php echo (isset($_POST['email'])) ? $_POST['email']: '';?>" placeholder="EMAIL"/>
            <input type='password' name="pass1"  value="<?php echo (isset($_POST['pass1'])) ? $_POST['pass1']: '';?>" placeholder="PASSWORD"/>
            <input type='password' name="pass2"  value="<?php echo (isset($_POST['pass2'])) ? $_POST['pass2']: '';?>" placeholder="COMFIRM PASSWORD"/>
            <input type='date' name="dob"  value="<?php echo (isset($_POST['dob'])) ? $_POST['dob']: '';?>" placeholder="DATE OF BIRTH"/>

            <label>GENDER:</label>
            <input type="radio" value="M" name="gender"><span>MALE</span>
            <input type="radio" value="F" name="gender"><span>FEMALE</span><br>
            <label>PROFILE IMAGE:</label>
            <input type="file" name="thumbnail" /><br>
            <input type="checkbox" name="agree" value="1"><span>AGREE TO TERMS AND CONDITIONS.</span>
            <button type="submit" name="register_submit">SIGN UP</button><br>
            <div class="member">ALREADY A MEMBER? <a href="login.php">LOGIN</a></div>
        </form>
    </div>

</div>
</body>
</html>

