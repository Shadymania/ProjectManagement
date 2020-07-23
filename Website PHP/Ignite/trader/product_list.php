<?php include 'trader_header.php'; 
$product_type= [];
$products = [];
?>
<div class="container bg mt-20 mb-20 pd-content">
    <div>
        <a href="addproduct.php?add_product">ADD PRODUCT</a>
    </div>
    <table class="product-table" cellspacing="0">
            <thead>
                <tr class="w3-light-grey">
                <th class="img-column">IMAGE</th>
                <th> NAME</th>
                <th>PRICE</th>
                <th>QUANTITY</th>
                <th>ACTION</th>
                </tr>
            </thead>
            <?php
if(isset($_GET['shop_id'])) {
    //sets session to keep shop_id
    $_SESSION['shop_id'] = $_GET['shop_id'];
    $shop_id = $_GET['shop_id'];
    //fetch product types of current shop
    if($shop_details = $crud->check_column_data('product_type', 'shop_id', $shop_id)) {
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
            <?php
        foreach($products as $item) {?>
            <tr>
                <td><img class="product-img" src="<?php echo $item['PRODUCT_IMAGE']; ?>" alt="product image"></td>
                <td><?php echo $item['PRODUCT_NAME']; ?></td>
                <td><?PHP echo $item['PRICE']; ?></td>
                <td>
                <form  method="POST" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' enctype="multipart/form-data">
                    <input type="hidden" name="product_id" value="<?php echo $item['PRODUCT_ID']; ?>" />
                    <input type="hidden" name="shop_id" value="<?php echo $_GET['shop_id']; ?>" />
                    <input type='number' min="1" max="10000" name='qtn'value="<?php echo $item['QUANTITY']; ?>" >
                    <input type="submit" name='quantity_submit'style="height: 0px; width: 0px; border: none; padding: 0px;" hidefocus="true" />
                </form>
                </td>
                <td>  <a class="btn-edit" href="addproduct.php?edit_product=<?php echo $item['PRODUCT_ID']; ?>"><i class="fas fa-pencil-alt"></i></a>  <a class="btn-delete" href="product_list.php?shop_id=<?php echo $_SESSION['shop_id']; ?>&delete_product=<?php echo $item['PRODUCT_ID']; ?>"><i class="fas fa-trash-alt"></i></a></td>

            </tr>
        <?php
        }
        ?>

    <?php
    
    
    




?>
            </table>
    </div>





<?php include 'trader_footer.php'; ?>