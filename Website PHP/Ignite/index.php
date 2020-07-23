

<?php include 'header.php'; ?>
<div class="main-header">
    <div class="overlay">
        <div class="info-box pd-6">
                <h2>BEST SHOPPING EXPERIENCE FROM HOME!</h2>
                <a class="button">SHOP NOW!</a>
        </div>
    </div>

</div>
</header><!--header ends-->
<section class="container mt-20 mb-20 bg pd-content">
    <div class="title-box mb-20"><span class="title-text">DISCOUNT PRODUCTS</span></div>
    <div class="grid-container bg"> 

        <?php
                if($discount_info = $crud->fetch_table_data('discount')) {
                    foreach($discount_info as $discount) { 
                        if($product = $crud->check_column_data('product', 'product_id', $discount['PRODUCT_ID'])) {
                            $product = $product[0];
                            ?>

                                <div class="product-container">
                                    <a href="product.php?product_id=<?php echo $product['PRODUCT_ID']; ?>">
                                        <div class="discount-box"><div class="discount-price">- $<?php echo $discount['PRICE']; ?></div></div>
                                        <img class="product-img" src="<?php echo dirname("PHP_SELF")."/img"."/".basename($product['PRODUCT_IMAGE']); ?> " alt="product image"/>
                                        <h3><?PHP echo $product['PRODUCT_NAME']; ?></h3>
                                        <div class="product-price">Price: <del>$<?php echo $product['PRICE']; ?></del>  $<?php echo ($product['PRICE']-$discount['PRICE']); ?></div>

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

        ?>
    </div>
</section>

<section class="parallax-section">
        <div class="ptext"><span class="pbg">Support for all your daily needs!!</span></div>
    </section>

    <!--DEAL DISPLAY CONTAINER-->
    <section class="container mt-20 mb-20 bg">
        <div class="deal-display pd-content">
            <div >
                <img class="deal-gif" src="img/giphy.gif" />
            </div>
            <?php
            if($product_info= $crud->fetch_table_data('product')) {
                    foreach($product_info as $product) {
                        ?>
                        <div class="deal-product-box pd-content bg">
                            <span class="deal-title">DEAL OF THE DAY:</span>
                            <div class="deal-product-info-box mt-20">
                                <img class="deal-product-img" src="<?php echo dirname("PHP_SELF")."/img"."/".basename($product['PRODUCT_IMAGE']); ?>"/>
                                <div class="deal-product-info ">
                                    <div class="title-text mb-20"><?php echo $product['PRODUCT_NAME']; ?></div>
                                    <div class="mb-20"><p>
                                        <?php echo $product['DESCRIPTION']; ?>
                                        </p>
                                    </div>
                                    <div class="product-price mb-20">PRICE: <del>$400</del>  $300</div>
                                    <button class="button"><a style="text-decoration:none;color: white;"href="product.php?product_id=<?php echo $product['PRODUCT_ID']; ?>">BUY NOW!</a></button>
                                </div>
                            </div>

                            <div class="discount-timer">
                                    <h3>DEAL ENDS AFTER:</h3>
                                    <ul>
                                    <li><span id="days"></span>days</li>
                                    <li><span id="hours"></span>Hours</li>
                                    <li><span id="minutes"></span>Minutes</li>
                                    <li><span id="seconds"></span>Seconds</li>
                                    </ul>
                            </div>
                        </div>
                        <?php
                        break;
                    }
            }
            ?>

        </div>
    </section>



    <script>
            function myFunction(x) {
              x.classList.toggle("change");
              var y = document.getElementById("navbar");
                if (y.className === "navbar") {
                    y.className += " responsive";
                } else {
                    y.className = "navbar";
                }
            }

            function subnavtoggle(x) {
                x.classList.toggle("nav-open");
            }


        const second = 1000,
        minute = second * 60,
        hour = minute * 60,
        day = hour * 24;

        // COUNTDOWN TIMER 
        let countDown = new Date('Sep 30, 2020 00:00:00').getTime(),
            x = setInterval(function() {    

            let now = new Date().getTime(),
                distance = countDown - now;

            document.getElementById('days').innerText = Math.floor(distance / (day)),
                document.getElementById('hours').innerText = Math.floor((distance % (day)) / (hour)),
                document.getElementById('minutes').innerText = Math.floor((distance % (hour)) / (minute)),
                document.getElementById('seconds').innerText = Math.floor((distance % (minute)) / second);

            //do something later when date is reached
            //if (distance < 0) {
            //  clearInterval(x);
            //  
            //}

            }, second)
        </script>

<?php include 'footer.php';?>
