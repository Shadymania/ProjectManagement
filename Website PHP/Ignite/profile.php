<?php include 'header.php'; 
    if(isset($_SESSION['user_id'])) {


        $user_info = $crud->check_column_data('users', 'user_id', $_SESSION['user_id']);
        $user_info = $user_info[0];



    ?>
    <section class="container">
        <?php 
        //action notifications for form edit and email sent
        
        if(isset($_GET['email'])) {
            ?>
            <div class="mt-20">
                <div style="width: 100%; display:block;" class="msg_success">
                <?php echo "Verificaiton email sent!"; ?>
                </div>
            </div>
        <?php
        }
        if(isset($_GET['verification'])) {
            if($crud->edit_table_info('users','status',1,'user_id',$_SESSION['user_id'])) {
                ?>
                <div class="mt-20">
                    <div style="width: 100%; display:block;" class="msg_success">
                    <?php echo "Profile has been verified!"; ?>
                    </div>
                </div>
                <?php
            }
        }
        if($msg) {
            ?>
                <div class="mt-20">
                    <div style="width: 100%; display:block;" class="msg_success">
                    <?php echo $msg; ?>
                    </div>
                </div>
            <?php
        }
         ?>
    <div class="profile-container">
        <div class="profile-display mt-20 mb-20">
                <div class="wrapper">
            <div class="left">
                <img src="<?php echo $user_info['IMG']; ?>" alt="user" width="100">
                <h5><?php echo strtoupper($user_info['FIRST_NAME'])." ".strtoupper($user_info['LAST_NAME']); ?></h5>
                <p>Customer</p>
            </div>
            <div class="right">
                <div class="info">
                    <h3>Information</h3>
                    <div class="info_data">
                        <div class="data">
                            <h4>Email</h4>
                            <p><?php echo strtolower($user_info['EMAIL']); ?></p>
                        </div>
                        <div class="data">
                        <h4>DOB</h4>
                            <p><?php echo $user_info['DOB']; ?></p>
                    </div>
                    </div>
                </div>
                
                <div class="projects">
                        <h3>STATUS</h3>
                        <div class="projects_data">
                            <div class="data">
                                <h4>Account Type</h4>
                                <p>CUSTOMER</p>
                            </div>
                            <div class="data">
                            <h4>Products Bought</h4>
                                <p><?php echo rand(0, 50);?></p>
                        </div>
                        </div>
                    </div>
                
                    <div class="social_media">
                        <?php 
                            if($user_info['STATUS']) {
                                ?>
                                    <i class="fas fa-user-check"></i> <span>Verified</span>
                                <?php
                            }
                            else {
                                ?>
                                <button><a href="profile.php?get_verification=1">VERIFY</a></button>
                                <?php
                            }
                        ?>


                    </div>
                    </div>
                    </div>
                    </div>

            <div class="profile-edit mt-20 mb-20">

                <div class="wrapper">
            <div class="right">
                <div class="info">
                    <h3>EDIT INFO</h3>
                    <form method="POST" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' enctype="multipart/form-data">
                    <input type='text' name="f_name"  value="<?php echo $user_info['FIRST_NAME'];?>" placeholder="First Name"/>
                    <input type='text' name="l_name"  value="<?php echo $user_info['LAST_NAME'];?>" placeholder="LAST Name"/>
                    <input type='password' name="pass1"  value="<?php echo (isset($_POST['pass1'])) ? $_POST['pass1']: '';?>" placeholder="PASSWORD"/>
                    <input type='password' name="pass2"  value="<?php echo (isset($_POST['pass2'])) ? $_POST['pass2']: '';?>" placeholder="COMFIRM PASSWORD"/>
                    <input type='date' name="dob"  value="<?php echo $user_info['DOB'];?>" placeholder="DATE OF BIRTH"/>
                    <div>
                        <label><h4>PROFILE IMAGE:</h4></label><br>
                        <input type="file" name="thumbnail" /><br>
                    </div>

                    <button type="submit" name="user_edit">EDIT INFO</button><br>
                </form>
                

                </div>
            </div>
            </div>

            
            </div>
    </div>
    </section>
    <?php
    }
    ?>


<?php include 'footer.php'; ?>