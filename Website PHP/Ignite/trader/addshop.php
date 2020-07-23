<?php include 'trader_header.php'; 

if(!isset($_SESSION['trader_id'])) {
    echo "your not logged in!!";
}


?>
<div class="form-container bg mt-20 mb-20 pd-content">
        <?php
                if(count($errors)>0) {
                    foreach($errors as $error) {
                        ?>
                                <div class="msg_error mb-20">
                                    <?php echo $error; ?>
                                </div>
                        <?php
                    }
                }
                if($msg) {
                        ?>
                                <div class="msg_success mb-20">
                                    <?php echo $msg; ?>
                                </div>
                        <?php
                    
                }

        ?><br>
        <div class="title-box"> ADD SHOP</div>

        <form class="bg mt-20" method="POST" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' enctype="multipart/form-data">
            <label>Name of your shop that represents your products (eg: Delicatessen)</label>
            <input type='text' name="shop_name"  value="<?php echo (isset($_POST['shop_name'])) ? $_POST['shop_name']: '';?>" placeholder="SHOP NAME" required/>
            <label>Location of your shop</label>
            <input type='text' name="location"  value="<?php echo (isset($_POST['location'])) ? $_POST['location']: '';?>" placeholder="SHOP LOCATION" required/>
            <label>One sub-category of your product (eg: For Delicatessen it can be cakes)</label>
            <input type='text' name="category"  value="<?php echo (isset($_POST['category'])) ? $_POST['category']: '';?>" placeholder="PRODUCT CATEGORY" required/>
            <label>Describe your product:</label>
            <TEXTAREA name='desc' minlength="255" required>Add short description of products in this category...</TEXTAREA>

            <button type="submit" name="register_shop">CREATE SHOP</button><br>
        </form>

</div>
<?php include 'trader_footer.php'; ?>