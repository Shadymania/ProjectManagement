<?php
session_start();
include 'includes/crud.php';
$errors= [];
if(isset($_GET['product_id'])) {

    $_SESSION['product_id'] = $_GET['product_id'];
}
else {
    //ends the session
    session_destroy();
    session_start();
}

/**
 * LOGIN FORM
 */
if(isset($_POST['login_submit'])) {
    

    $data = "";
    $email = "";
    $pass = "";
    if(!empty($_POST['email']) && !empty($_POST['password'])) {
        if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $email = strtoupper($_POST['email']);
            $pass = md5($_POST['password']);

            if($data = $crud->fetch_login_user($email, $pass)) {
                if($data['ACTIVE']==1) {
                    array_push($errors, "User has been deactivated!");
                }
            }

        }
        else{
            array_push($errors, "Invalid email!");
        } 

        

    }
    else array_push($errors, "Field left empty!");
    if(count($errors) == 0) {
        if($data) {
            
            $_SESSION['user_id'] = $data['USER_ID'];
            $_SESSION['username'] = $data['FIRST_NAME'];
            $_SESSION['is_admin'] = $data['IS_ADMIN'];
            $_SESSION['status'] = $data['STATUS'];

            if(isset($_SESSION['product_id'])) {
                header('location: product.php?product_id='. $_SESSION['product_id']);

            }
            else {
                header('location: index.php');
            }
        }
        else {
            array_push($errors, "User not found!");
        }
    }
    else {
        //print errors?
    }


}//lgoin submission ends.







?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>IGNITE</title>
</head>
<body>
    <div class="container logo-search-bar">
                    <div class="pd-6">
                        <a href="index.php"><img src="img/ignite-logo.png"></a>
                    </div>
            </div>

            <div class="login-signup-container">

                <div class="login-signup-box">
                    <div class="form-title"> LOGIN</div>

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
                        <input type='email' name="email" placeholder="EMAIL"/>
                        <input type='password' name="password" placeholder="PASSWORD"/>
                        <input type="checkbox"><span>REMEMBER ME</span>
                        <button type="submit" name="login_submit">LOGIN</button><br>
                        <div class="member">NOT A MEMBER? <a href="register.php">SIGNUP NOW</a></div><br>
                        <div class="member">LOGIN AS A <a href="trader/trader_login.php">TRADER</a></div>
                    </form>
                </div>

    </div>
</body>
</html>



<?php include 'footer.php'?>