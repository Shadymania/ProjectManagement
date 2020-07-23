<?php include 'header.php'; 
$products=[];
?>
    <section class="container mt-20 mb-20 pd-content bg">
    <div class="title-box mb-20"><span class="title-text">Search Result</span></div>
    <div class="grid-container bg"> 
<?php
    if(isset($_GET['search'])) {
        if($products=$crud->fetch_search_item(strtoupper($_GET['search']))) {
            foreach($products as $product) {
                //CHECKING IF PRODUCT AS DISCOUNT PRICE
                $discount_info = [];
                if($discount_info = $crud->check_column_data('discount', 'product_id', $product['PRODUCT_ID'])) {
                    $discount_info = $discount_info[0];
                }
                
                ?>
                
                    <div class="product-container">
                    <a href="product.php?product_id=<?php  echo $product['PRODUCT_ID']; ?>">
                        <?php
                        if($discount_info) {
                            ?>
                            <div class="discount-box"><div class="discount-price">- $<?php echo $discount_info['PRICE']; ?></div></div>
                            <?php
                        }
                        ?>



                        <img class="product-img" src="<?php echo dirname("PHP_SELF")."/img"."/".basename($product['PRODUCT_IMAGE']); ?>" alt="product image"/>
                        <h3><?PHP echo $product['PRODUCT_NAME']; ?></h3>
                        <?php
                        if($discount_info) {
                            ?>
                        <div class="product-price">Price: <del>$<?php echo $product['PRICE']; ?></del>  $<?php echo ($product['PRICE']-$discount_info['PRICE']); ?></div>
                        <?php
                        } 
                        else {?>
                        <div class="product-price">Price: $<?php echo $product['PRICE']; ?></div>
                        <?php
                        }?>

                        
                        <?php
                                if($review_info = $crud->check_column_data('review', 'product_id', $product['PRODUCT_ID'])) {
                                    $count = 0;
                                    $value = 0;
                                    foreach($review_info as $review) {
                                        $value += $review['VALUE'];
                                        $count++;
                                    }
                                    $rating = round($value/$count);
                                    
                                    ?>
                                    <div class="product-rating"><?php 
                        
                                        $unchecked = 5 - $rating;
                                        for($i = 0; $i<$rating; $i++) {
                                            ?>
                                                <span class="fa fa-star checked"></span>
                                            <?php
                                        }
                                        for($i=0;$i<$unchecked;$i++) {
                                            ?>
                                                <span class="fa fa-star"></span>
                                            <?php
                                        }
                                    ?></div>
                                    <?php

                                }
                                else {
                                    ?>
                                    <div class="product-rating">
                                        No rating!
                                    </div>
                                    <?php
                                }
                            ?>


                    </a>



                    </div>
                <?php
            }
        }

        else {
            echo "no products found!";
        }
    }?>


    </div>
</section>

<?php include 'footer.php'; ?>