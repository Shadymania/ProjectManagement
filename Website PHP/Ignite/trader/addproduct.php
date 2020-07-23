<?php include 'trader_header.php';
if(isset($_SESSION['shop_id'])) {
    $shop_details = $crud->check_column_data('product_type', 'shop_id', $_SESSION['shop_id']);

}
else {
    echo "no session for shop!";
}

if(isset($_GET['add_product'])) {
    unset($_SESSION['edit_product']);
}
if(isset($_GET['edit_product'])) {
    $_SESSION['edit_product'] = $_GET['edit_product'];
    $product_details = $crud->check_column_data('product', 'product_id', $_GET['edit_product']);
    $product_details = $product_details[0];
}
else if(isset($_SESSION['edit_product'])) {
    $product_details = $crud->check_column_data('product', 'product_id', $_SESSION['edit_product']);
    $product_details = $product_details[0];
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
        if(isset($_GET['success'])) {
            ?>
            <div class="msg_success mb-20">
                <?php echo "Product edited successfully!" ?>
                    </div>
            <?php
        }

        ?><br>
    <div class='title-box mb-20'><?php echo (isset($_SESSION['edit']) || isset($product_details)) ? 'EDIT': 'ADD'; ?> PRODUCT</div>
    <form class="bg" method="POST" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' enctype="multipart/form-data">
        
        <input type='hidden' name='id' 
        value = "<?php  echo (isset($product_details)) ? $product_details['PRODUCT_ID']: ''; ?>"/>
        <label>Product Name: </label>
        <input type="text" pLaceholder="PRODUCT NAME" name="name" 
        value="<?php  echo (isset($product_details)) ? $product_details['PRODUCT_NAME']: ''; ?>" required/><br>
        <label>Description</label>
        <textarea name="desc" minlength="255" required><?php echo (isset($product_details)) ? $product_details['DESCRIPTION']: 'Short description about the product..'; ?></textarea><br>
        <div class="number-input">
            <div class="input-box">
                <label>Price:</label><br>
                <input type="number" step="0.01" name="price" min="1" max="1000000"
                value="<?php echo (isset($product_details)) ? $product_details['PRICE']: ''; ?>"required/>
            </div>

            <div class="input-box">
                <label>Quantity:</label><br>
                <input type="number" name="qtn" min="1" max="10000" 
                value="<?php echo (isset($product_details)) ? $product_details['QUANTITY']: ''; ?>" required/>

            </div>
            <div class="input-box">
                <label>Minimum order</label><br>
                <input type="number" name="min_order" min="1" max="5"
                value="<?php echo (isset($product_details)) ? $product_details['MIN_ORDER']: ''; ?>" required/>               
            </div>

            <div class="input-box">
                <label>Maximum order</label><br>
                <input type="number" name="max_order" min="10" max="1000"
                value="<?php echo (isset($product_details)) ? $product_details['MAX_ORDER']: ''; ?>" required/>       
            </div>


        </div>

        <label>Allergy Info:</label>
        <textarea name="allergy_info"><?php echo (isset($product_details)) ? $product_details['ALLERGY_INFO']: ''; ?></textarea><br>
        <label for="cars">Choose product type:</label>
        <select id="cars" name="category">
        <?php
            foreach($shop_details as $shop) { ?>
                <option value="<?php echo $shop['PRODUCT_TYPE_ID']; ?>"><?php echo strtoupper($shop['PRODUCT_TYPE_NAME']); ?></option>
            <?php
            }
        ?>
        </select><br>
        <label>Choose thumbnail:</label>
        <input type="file" name="thumbnail" required/>
        <button type="submit"
         name="<?php echo (isset($_SESSION['edit']) || isset($product_details)) ? 'edit_product': 'add_product'; ?>">
        <?php echo (isset($_SESSION['edit']) || isset($product_details)) ? 'Edit Product': 'Add product'; ?>
        </button>
    </form>
    </div>


<?php include 'trader_footer.php' ?>