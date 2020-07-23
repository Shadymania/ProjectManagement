<?php include 'trader_header.php'; 
$product_type= [];
$products = [];
if(isset($_GET['shop_id'])) {
    //sets session to keep shop_id
    $_SESSION['shop_id'] = $_GET['shop_id'];
    $shop_id = $_GET['shop_id'];
    //fetch product types of current shop
    if($shop_details = $crud->check_column_data('product_type', 'shop_id', $shop_id)) {
        //goes through each product type and stores it as key value pair
        foreach($shop_details as $shop) {
            $product_type += array($shop['PRODUCT_TYPE_ID'] => $shop['PRODUCT_TYPE_NAME']);
        }
        //uses product type values to fetch all the products
        foreach($product_type as $key=>$value) {

            if($data = $crud->check_column_data('product', 'product_type_id', $key)) {
                foreach($data as $info) {
                    array_push($products, $info);
                }
            }
        }
    }

}
else if(isset($_SESSION['shop_id']) && !isset($_GET['shop_id'])){
    $shop_id = $_SESSION['shop_id'];
    //fetch product types of current shop
    $shop_details = $crud->check_column_data('product_type', 'shop_id', $shop_id);
    //goes through each product type and stores it as key value pair
    foreach($shop_details as $shop) {
        $product_type += array($shop['PRODUCT_TYPE_ID'] => $shop['PRODUCT_TYPE_NAME']);
    }
    //uses product type values to fetch all the products
    foreach($product_type as $key=>$value) {

        if($data = $crud->check_column_data('product', 'product_type_id', $key)) {
            foreach($data as $info) {
                array_push($products, $info);
            }
        }
    }
}
?>
<div class="container bg pd-content mt-20 mb-20">
        <?php
        if($msg) {
                    ?>
                    <div class="mb-20">
                        <div class="msg_success">
                            <?php echo $msg ?>
                        </div>
                    </div>

            <?php
        }
        if(count($errors)) {
            foreach($errors as $error) {
                ?>
                <div class="mb-20">
                    <div class="msg_error">
                        <?php echo $msg ?>
                    </div>
                </div>
                <?php
            }
            ?>
    <?php
}
        ?>
    <div class='title-box mb-20'>Discount Product</div>
    <table class="product-table" cellspacing="0">
            <thead>
                <tr class="w3-light-grey">
                <th class="img-column">IMAGE</th>
                <th> NAME</th>
                <th>PRICE</th>
                <th>DISCOUNT</th>
                <th>SET DISCOUNT</th>
                </tr>
            </thead>
            <?php
            foreach($products as $item) {
                if($discount_info = $crud->check_column_data('discount', 'product_id', $item['PRODUCT_ID'])) {
                    $discount_info = $discount_info[0];
                }
                ?>
                <tr>
                    <td><img class="product-img" src="<?php echo $item['PRODUCT_IMAGE']; ?>" alt="product image"></td>
                    <td><?php echo $item['PRODUCT_NAME']; ?></td>
                    <td><?PHP echo "$ ".$item['PRICE']; ?></td>
                    <td><?PHP 
                        if($discount_info) {
                            echo "$ ".$discount_info['PRICE'] ;
                        }
                        else {
                            echo "0";
                        }
                    ?></td>
                    <td>
                    <form  method="POST" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' enctype="multipart/form-data">
                        <input type="hidden" name="product_id" value="<?php echo $item['PRODUCT_ID']; ?>" />
                        <input type="hidden" name="product_type_id" value="<?php echo $item['PRODUCT_TYPE_ID']; ?>" />
                        <input type='number' name='discount' min="1" max="10">
                        <input type="submit" name='discount_submit'style="height: 0px; width: 0px; border: none; padding: 0px;" hidefocus="true" />
                    </form>
                    </td>

                </tr>
            <?php
            }
            ?>

            </table>
    </div>

<?php include 'trader_footer.php'; ?>