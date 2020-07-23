<?php include'header.php'; 
$shop_details=[];

if(isset($_GET['shop_id'])) {

    if($shop_details = $crud->check_column_data('shop', 'shop_id', $_GET['shop_id'])) {
        $shop_details = $shop_details[0];
    }
}
else {
    header('location: index.php');
}
?>
<section class="banner-section">
    <div class="shop-banner">
            <span class="shop-name"><?php echo $shop_details['SHOP_NAME']; ?></span>
    </div>

</section>

<section class="category-section mt-20 mb-20">
    <div class="container mt-20">
        <div>
            <label>PRODUCT CATEGORY:</label>
            <div class="dropdown">
                <div class="dropdown-box">
                    <?php
                        if(isset($_GET['category_id'])) {
                            if($category_name = $crud->check_column_data('product_type', 'product_type_id', $_GET['category_id'])) {
                                ?>
                                <span><?php echo $category_name[0]['PRODUCT_TYPE_NAME']; ?><span>&#x25BC;</span></span>
                            <?php    
                            }

                        }
                        else {
                            ?>
                                <span>ALL<span>&#x25BC;</span></span>
                            <?php
                        }?>
                </div>
                <div class="dropdown-content">
                    <ul class="category-dropdown">

                        <li><a href="shop.php?shop_id=<?php echo $_GET['shop_id']; ?>">ALL</a></li>
                        <?php
                            if($category = $crud->check_column_data('product_type', 'shop_id', $shop_details['SHOP_ID'])) {
                                foreach($category as $option) {
                                    ?>
                                    <li><a href="shop.php?shop_id=<?php echo $shop_details['SHOP_ID']; ?>&category_id=<?php echo $option['PRODUCT_TYPE_ID']; ?>"><?php echo $option['PRODUCT_TYPE_NAME']; ?></a></li>
                                    <?php
                                }
                            }
                            else {
                                ?>
                                    <li><a href="#">NO CATEGORY</a></li>
                                <?php
                            }

                        
                        ?>
                    </ul>
                </div>
            </div>
        </div>

                <div>
                    <label>SORT BY:</label>
                    <div class="dropdown">
                    <div class="dropdown-box">
                        <?php
                        if(isset($_GET['sort_by'])) {
                            if($_GET['sort_by'] == 1){
                                ?>
                                <span>EXPENSIVE<span>&#x25BC;</span></span>
                                <?php
                            }
                            else {
                                ?>
                                <span>CHEAPEST<span>&#x25BC;</span></span>
                            
                                <?php
                            }

                        }
                        else {
                            ?>
                            <span>---select---<span>&#x25BC;</span></span>
                        
                    
                            <?php
                            }?>
                    </div>
                        <div class="dropdown-content">
                                <ul class="category-dropdown">
                                <?php
                                if(isset($_GET['category_id'])) {
                                    ?>
                                    <li><a href="shop.php?shop_id=<?php echo $shop_details['SHOP_ID']; ?>&category_id=<?php echo $_GET['category_id']; ?>&sort_by=1">EXPENSIVE</a></li>
                                    <li><a href="shop.php?shop_id=<?php echo $shop_details['SHOP_ID']; ?>&category_id=<?php echo $_GET['category_id']; ?>&sort_by=2">CHEAPEST</a></li>
                                    <?php
                                }
                                else {
                                    ?>
                                    <li><a href="shop.php?shop_id=<?php echo $shop_details['SHOP_ID']; ?>&sort_by=1">EXPENSIVE</a></li>
                                    <li><a href="shop.php?shop_id=<?php echo $shop_details['SHOP_ID']; ?>&sort_by=2">CHEAPEST</a></li>
                                    <?php
                                }
                                ?>
                                </ul>
                        </div>
                </div>
        </div>

    </div>
</section>

<section class="container mt-20 mb-20 bg">
    <div class="title-box margin-content"><span class="title-text">OUR PRODUCTS</span></div>
    <div class="grid-container bg"> 
        <?php
            //FETCHING PRODUCT IF SORTING VALUE IS CHOOSEN
            if(isset($_GET['sort_by']) && isset($_GET['category_id'])) {
                if($products = $crud->sort_product($_GET['category_id'],$_GET['sort_by'])) {
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
            }
            else if(!isset($_GET['sort_by']) && isset($_GET['category_id'])) {
                if($products = $crud->check_column_data('product', 'product_type_id', $_GET['category_id'])) {
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
            }
            else if(isset($_GET['sort_by']) && !isset($_GET['category_id'])) {
                $product_types = [];
                if($product_type = $crud->check_column_data('product_type', 'shop_id', $_GET['shop_id'])) {
                    foreach($product_type as $category) {
                        array_push($product_types, $category['PRODUCT_TYPE_ID']);
                    }
                    if($products=$crud->sort_product_all($_GET['sort_by'], $product_types)) {
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

                }
            }
            else {
                
                 if($product_type = $crud->check_column_data('product_type', 'shop_id', $_GET['shop_id'])) {
                    foreach($product_type as $category) {
                        if($products =  $crud->check_column_data('product', 'product_type_id', $category['PRODUCT_TYPE_ID'])) {
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
        
                                        <div class="product-rating">
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
                                        </div>
        
        
                                    </a>
        
        
        
                                    </div>
                                <?php
                            }
                        }
                    }

                }
            }
        ?>
        
    </div>
</section>

<section class="container mt-20 mb-20 bg">
    <div class="deal-display pd-content">
        <div >
            <img class="deal-gif" src="img/banner.jpeg" />
        </div>
        <div class="deal-product-box pd-content bg">
            <span class="deal-title">ABOUT US:</span>
            <div class="deal-product-info-box mt-20">
                    <div class="mb-20">
                        <p>This carrot cake cake sets the standard for carrot cakes everywhere. It’s deeply moist and filled with toasted pecans. Most of its flavor comes from brown sugar, cinnamon, ginger, nutmeg, and carrots. Ginger adds the most delicious zing, but it isn’t overpowering at all. The cake is dense, but each forkful tastes super soft and extra lush. If made ahead, the flavor intensifies and the cream cheese frosting seeps into the layers, creating an even more tender bite.
                        </p>

                    </div>
            </div>

        </div>
    </div>
</section>


<?php include'footer.php'; ?>