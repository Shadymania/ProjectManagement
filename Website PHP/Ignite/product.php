<?php include 'header.php'; 
    unset($_SESSION['cart_id']);
    unset($_SESSION['product_id']);

    $product = [];
    if(isset($_GET['product_id'])) {
        if($product = $crud->check_column_data('product', 'product_id', $_GET['product_id'])) {
            $product = $product[0];

        }
    }
    ?>

        <?php
        if(isset($_GET['qtn'])) {
            

                    ?>
                    <div class="container mt-20">
                        <div class="msg_error">
                            Quantity exceeds the stock amount!
                        </div>
                    </div>

            <?php
        }
        ?>

        <section class="container bg mt-20">

        <div class="product-display">
            <div class="product-display-img">
                <img src="<?php echo dirname("PHP_SELF")."/img"."/".basename($product['PRODUCT_IMAGE']); ?>" />
            </div>
            <div class="product-display-detail bg">
                <div class="title-discount mt-20 mb-20">
                    <span><?php echo $product['PRODUCT_NAME']; ?></span>
                    <?php
                    $discount = 0;
                    if($discount = $crud->check_column_data('discount', 'product_id', $product['PRODUCT_ID'])) {
                        ?>
                        <div class="discount-box"><div class="discount-price">-$<?php echo $discount[0]['PRICE']; ?></div></div>
                        <?php
                    } 
                    ?>


                </div>

                <div>
                    <div class="product-description">
                            <?php echo $product['DESCRIPTION']; ?>
                    </div>
                    <div class="product-display-price">
                    <?php
                        if($discount) {?>
                            <span>PRICE: <del>$<?php echo $product['PRICE']; ?></del> $<?php echo ($product['PRICE'] - $discount[0]['PRICE']); ?></span>
                        <?php
                        }
                        else {
                            ?>
                            <span>PRICE: $<?php echo $product['PRICE']; ?></span>
                            <?php
                        }
                        ?>
                        <div style="margin: 10px 0px;"><span>STOCK: <?php echo $product['QUANTITY']; ?></span></div>
                        <div class="flex">
                            <span>RATING:</span> 
                                <div class="product-rating">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                </div>
                        </div>

                        <form method="POST" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' enctype="multipart/form-data">
                            <label>QUANTITY:</label>
                            <input type="number" name="qtn" value="1" min="<?php echo $product['MIN_ORDER']; ?>" max="<? echo $product['MAX_ORDER']; ?>"/><br>
                            <input type="hidden" name="product_id" value="<?php echo $product['PRODUCT_ID']; ?>"/>

                            <?php 
                                if($product['QUANTITY']) {
                                    if(isset($_SESSION['user_id'])) {
                                        //faulty logic spotted!
                                        if($crud->check_column_data2('cart', 'user_id', $_SESSION['user_id'], 'product_id', $product['PRODUCT_ID'])) {
                                            ?>
                                            <div class="disabled">ADDED <i class="fa fa-cart-plus" aria-hidden="true"></i></div>
                                            <?php
                                        } else {
                                            ?>
                                            
                                            <button type="submit" name="cart_submit">ADD TO CART</button>
                                        <?php } 
                                    }
                                    else {
                                        ?>
                                            <button type="submit" name="cart_submit">ADD TO CART</button>
                                        <?php
                                    }
                                }
                                else {
                                    ?>
                                    <div class="disabled">OUT OF STOCK<i class="fa fa-cart-plus" aria-hidden="true"></i></div>
                                    <?php
                                }


                                ?>

                        </form>
                    </div>

                </div>
            </div>
         
        </div>
    </section>

    <section class="container bg mt-20 mb-20">
            <div class="product-display">
                    <div class="product-review mt-20 ">
                        <span>PRODUCT REVIEWS</span>
                        <?php
                            
                            if($review_info = $crud->check_column_data('review', 'product_id', $product['PRODUCT_ID'])) {
                                
                                foreach($review_info as $review) {

                                    ?>
                                    <div class="review bg mt-20">
                                        <div class="cust-info">
                                            <div>
                                            <?php
                                                if($cust_name = $crud->check_column_data('users', 'user_id', $review['USER_ID'])) {
                                                    ?>
                                                <img src="<?php echo dirname("PHP_SELF")."/img"."/".basename($cust_name[0]['IMG']); ?>">
                                                <span><?php 
                                                    
                                                        echo strtoupper($cust_name[0]['FIRST_NAME'])." ".strtoupper($cust_name[0]['LAST_NAME']);
                                                    
                                                }?></span>
                                            </div>
                                            <div class="product-rating">
                                                    <?php
                                                        $unchecked = 5 - $review['VALUE'];
                                                        for($i = 0; $i<$review['VALUE']; $i++) {
                                                            ?>
                                                                <span class="fa fa-star checked"></span>
                                                            <?php
                                                        }
                                                        for($i=0;$i<$unchecked;$i++) {
                                                            ?>
                                                                <span class="fa fa-star"></span>
                                                            <?php
                                                        }
                                                    ?>


                                            </div>

                                        </div>
                                        <div class="review-content">
                                                <?php echo $review['REVIEW']; ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                                

                                
                            }
                            else {
                                ?>
                                <div class="review">
                                    No reviews to display!!
                                </div>

                                <?php

                            }
                        ?>
        
                    </div>
                    <div class="review-form mt-20 ">
                        <span>ADD REVIEW</span>
                        <form  class="mt-20" method="POST" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="<?php 
                            if(isset($_SESSION['user_id'])) {
                                echo $_SESSION['user_id'];
                            }
                            else {
                                echo "0";
                            }
                        ?>"/>
                        <input type="hidden" name="product_id" value="<?php echo $product['PRODUCT_ID']; ?>"/>
                            <textarea name="review">Your opinion on the product...</textarea>
                            <div class="star-rating">
                                    <span> YOUR PRODUCT RATING: </span>
                                    <input type="radio" name="stars" value="1" id="star-1" checked/>
                                    <input type="radio" name="stars" value="2" id="star-2" />
                                    <input type="radio" name="stars" value="3" id="star-3" />
                                    <input type="radio" name="stars" value="4" id="star-4"  />
                                    <input type="radio" name="stars" value="5" id="star-5" />
                                    <section>
                                    <label for="star-1"> <svg width="255" height="240" viewBox="0 0 51 48">
                                        <path d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z"/>
                                        </svg> </label>
                                    <label for="star-2"> <svg width="255" height="240" viewBox="0 0 51 48">
                                        <path d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z"/>
                                        </svg> </label>
                                    <label for="star-3"> <svg width="255" height="240" viewBox="0 0 51 48">
                                        <path d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z"/>
                                        </svg> </label>
                                    <label for="star-4"> <svg width="255" height="240" viewBox="0 0 51 48">
                                        <path d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z"/>
                                        </svg> </label>
                                    <label for="star-5"> <svg width="255" height="240" viewBox="0 0 51 48">
                                        <path d="m25,1 6,17h18l-14,11 5,17-15-10-15,10 5-17-14-11h18z"/>
                                        </svg> </label>

                                    </section>
                                    
                            </div>
                            <?php
                                if(isset($_SESSION['user_id'])) {
                                    ?>
                                    <button type="submit" name="review_submit" >SUBMIT</button>
                                    <?php
                                }
                                else {
                                    ?>
                                        YOU MUST LOGIN TO ADD REVIEW.
                                    <?php
                                }
                            ?>

                            
                        </form>
                        
                    </div>
        
                </div>
    </section>




<script>
    reviewform(x) {

        console.log(x.["user_id"].value);
    }
</script>

<?php include 'footer.php'; ?>