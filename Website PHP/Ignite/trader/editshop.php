<?php include 'trader_header.php'; 

if(!isset($_SESSION['trader_id'])) {
    echo "your not logged in!!";
}
//fetching shop details 
if(isset($_GET['editshop'])) {
    $_SESSION['edit_shop'] = $_GET['editshop'];
    $shop_details = [];
    if($shop_info = $crud->check_column_data('shop','shop_id',$_GET['editshop'])) {
        
        foreach($shop_info as $shop) {
            $shop_details = $shop;
        }
    
    }
}
if(isset($_SESSION['edit_shop'])) {
    $shop_details = [];
    if($shop_info = $crud->check_column_data('shop','shop_id',$_SESSION['edit_shop'])) {
        
        foreach($shop_info as $shop) {
            $shop_details = $shop;
        }
    
    }
}
?>

<div class="error-container mt-20">
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
</div>
<div class="edit-shop-container bg mt-20 mb-20">
    <!--  EDIT SHOP FORM-->

<div class="form-container bg pd-content mt-20 mb-20">

<div class="title-box"> EDIT SHOP</div>

<form method="POST" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' enctype="multipart/form-data">
    <input type="hidden" name="shop_id" value = '<?php echo (isset($shop_details)) ? $shop_details['SHOP_ID'] : '';?>'/>
    <label>Name of your shop that represents your products (eg: Delicatessen)</label>
    <input type='text' name="shop_name"  value='<?php echo (isset($shop_details)) ? $shop_details['SHOP_NAME'] : ''; ?>' placeholder="SHOP NAME" required/>
    <label>Location of your shop</label>
    <input type='text' name="location"  value='<?php echo (isset($shop_details)) ? $shop_details['SHOP_LOCATION'] : ''; ?>' placeholder="SHOP LOCATION" required/>


    <button type="submit" name="edit_shop">EDIT SHOP</button><br>
</form>

</div>
<!--  ADD PRODUCT FORM-->
<div class="form-container bg pd-content mt-20 mb-20">

        <div class="title-box"> ADD CATEGORY</div>

        <form method="POST" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' enctype="multipart/form-data">

            <input type='hidden' name='shop_id' value = '<?php echo (isset($shop_details)) ? $shop_details['SHOP_ID'] : '';
                            echo (isset($_POST['shop_id'])) ? $_POST['shop_id']: ''; ?>'/>
            <label>Category of your product (eg: For Delicatessen it can be cakes)</label>
            <input type='text' name="category"  value="<?php echo (isset($_POST['category'])) ? $_POST['category']: '';?>" placeholder="PRODUCT CATEGORY" required/>
            <label>Describe products in this category:</label>
            <TEXTAREA name='desc' minlength="255" required><?php echo (isset($_POST['desc'])) ? $_POST['desc']: 'Add short description of products in this category...';?></TEXTAREA>

            <button type="submit" name="add_category">ADD CATEGORY</button><br>
        </form>

</div>
</div>

<?php

 include 'trader_footer.php'; ?>