<?php include 'header.php'; 
$_SESSION['payment'] = rand(100000, 100000000);

?>





<div class="shopping-cart bg"><!--shopping cart div starts-->
  <div class="title">
    Shopping Cart
  </div>
<?php
$cart_details = [];
$total_price = 0;
if(isset($_SESSION['user_id'])) {
  ?>
  <!-- Title -->

    <div class="item">
      <div class="image">IMAGE</div>
      <div class="description">PRODUCT NAME</div>
      <div class="quantity">QUANTITY</div>
      <div class="total-price">PRICE</div>
      <div class="total-price">TOTAL</div>
      <div class="buttons">ssd</div>

    </div>
  <?php
    if(isset($_GET['delete_cart'])) {
        $crud->delete_record('cart', 'cart_id', $_GET['delete_cart']);
    }
    if($cart_details = $crud->check_column_data('cart', 'user_id', $_SESSION['user_id'])) {

      
        foreach($cart_details as $cart) {?>

                <?php
                    $product_details = [];
                    $discount_details = [];
                    if($product_details = $crud->check_column_data('product', 'product_id', $cart['PRODUCT_ID'])) {
                        $product_details = $product_details[0];
                    }
                    if($discount_details = $crud->check_column_data('discount', 'product_id', $cart['PRODUCT_ID'])) {
                        $discount_details = $discount_details[0];
                        
                    }
                ?>
                  <div class="item">
 
                    <div class="image">
                      <img src="<?php echo dirname("PHP_SELF")."/img"."/".basename($product_details['PRODUCT_IMAGE']); ?>" alt="" />
                    </div>

                    <div class="description">
                      <span><?php echo $product_details['PRODUCT_NAME']. $product_details['PRODUCT_ID']; ?></span>

                    </div>

                    <div class="quantity">
                    <form  method="POST" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' enctype="multipart/form-data">
                      <input type="hidden" name="product_id" value="<?php echo $product_details['PRODUCT_ID']; ?>" />
                      <input type="hidden" name="cart_id" value="<?php echo $cart['CART_ID']; ?>" />
                      <input type='number' name='qtn' value="<?PHP echo $cart['QUANTITY']; ?>"/>
                      <input type="submit" name='cart_edit'style="height: 0px; width: 0px; border: none; padding: 0px;" hidefocus="true" />
                    </form>
                    </div>
                    <!--CALCULATING TOTAL PRICE EXCLUDING DISCOUNT IF IT HAS ANY.-->
                    <?php 
                    if($discount_details) {
                      ?>
                      <div class="total-price">$ <?php echo ($product_details['PRICE'] - $discount_details['PRICE']); ?>
                        <small> <s>$ <?php echo $product_details['PRICE']; ?></s></small>
                      </div>
                      <?php
                    }
                        
                    else {
                      ?>
                        <div class="total-price">
                          $ <?php echo $product_details['PRICE']; ?>
                      </div>
                      <?php

                    } 
                    ?>

                    <div class="total-price">
                      $ 
                    <?php 
                      if($discount_details) {
                          echo ($product_details['PRICE'] - $discount_details['PRICE'])*$cart['QUANTITY']; 
                          $total_price += ($product_details['PRICE'] - $discount_details['PRICE'])*$cart['QUANTITY'];
                      }
                          
                      else {
                          $total_price += $product_details['PRICE']*$cart['QUANTITY'];
                          echo $product_details['PRICE']*$cart['QUANTITY'];
                      } 
                    ?>
                    </div>
                    <a href="cart.php?delete_cart=<?php echo $cart['CART_ID']; ?>" class="delete-btn">
                    <div class="buttons">
                        <i class="fas fa-trash-alt"></i>
                    </div>
                    </a>
                    
                    </div>

                

        <?php
        
        }?>
          <div class="checkout-details">
          <!--
          <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_cart">
            <input type="hidden" name="upload" value="1">
            <input type="hidden" name="business" value="seller@dezignerfotos.com">
            <input type="hidden" name="item_name_1" value="Item Name 1">
            <input type="hidden" name="amount_1" value="1.00">
            <input type="hidden" name="shipping_1" value="1.75">
            <input type="hidden" name="item_name_2" value="Item Name 2">
            <input type="hidden" name="amount_2" value="2.00">
            <input type="hidden" name="shipping_2" value="2.50">
            <input type="submit" value="PayPal">
            </form>
            -->
          <form  action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
              <div class="time-slot">
                  <input type="hidden" name="cmd" value="_cart">
                  <input type="hidden" name="upload" value="1">
                  <input type="hidden" name="business" value="Ignite-trader@gmail.com">
                  <input type="hidden" name="return" value="http://localhost/ignite/invoice.php?payment=<?php echo $_SESSION['payment']; ?>">
									<input type="hidden" name="cancel_return" value="http://localhost/ignite/cart.php">

                  <?php
                  //items values to paypal
                  $i = 1;
                  foreach($cart_details as $cart) {
                    ?>
                      <?php
                          $product_details = [];
                          $discount_details = [];
                          if($product_details = $crud->check_column_data('product', 'product_id', $cart['PRODUCT_ID'])) {
                              $product_details = $product_details[0];
                          }
                          if($discount_details = $crud->check_column_data('discount', 'product_id', $cart['PRODUCT_ID'])) {
                              $discount_details = $discount_details[0];
                              
                          }
                      ?>
                      <input type="hidden" name="item_name_<?php echo $i; ?>" value="<?php echo $product_details['PRODUCT_NAME']; ?>">
                        <?php 
                        if($discount_details) {
                          ?>
                          <input type="hidden" name="amount_<?php echo $i; ?>" value=" <?php echo ($product_details['PRICE'] - $discount_details['PRICE']); ?>">
                          <?php
                        }    
                        else {
                          ?>
                            <input type="hidden" name="amount_<?php echo $i; ?>" value=" <?php echo $product_details['PRICE']; ?>">
                          <?php

                        } 
                      ?>                      
                      <input type="hidden" name="quantity_<?php echo $i; ?>" value="<?php echo $cart['QUANTITY']; ?>">
                      
                    <?php
                    $i++;
                  }
                  ?>


          
              </div>
              <?php
                  if($_SESSION['status']==1) {
                    ?>
                    <div class="checkout">
                      <div>TOTAL PRICE: $<?php echo $total_price; ?></div>
                        <button name="checkout" type="paypal" value="PayPal">PROCEED TO CHECKOUT</button>
              
                    </div>
                    <?php
                  }
                  else {
                    ?>
                    <div class="checkout">
                      <div>TOTAL PRICE: $<?php echo $total_price; ?></div>

                        <a class="button" href="profile.php">

                          VERIFY EMAIL

                        </a>
              
                    </div>
                    <?php
                  }
              ?>


          </form>


        </div>
        </div><!--shopping cart div ends-->
        
        <?php


    }
    else {
      ?>
      <div class="item">
        CART EMPTY!!
      </div>
      <?php
    }
}

?>
</div>
<?php include 'footer.php'; ?>