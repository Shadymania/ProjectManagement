
<?php
include 'includes/form.php';
if(!isset($_GET['slot_id'])){
    $_SESSION['i'] =0;
}





?>
<!DOCTYPE html>
<html>

<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	
	<title>Editable Invoice</title>
	
    <style>

        * { margin: 0; padding: 0; }
        body { font: 14px/1.4 Georgia, serif; }
        #page-wrap { width: 800px; margin: 0 auto; }
        #success_msg {
            background: #00e673;
            color: white;
            width: 100%;
            padding: 10px 16px;
            margin: 10px 0px;
            width: 400px;
            border-radius: 5px;
            font-weight: 700;
        }
        #invoice_submit {
            margin-bottom: 10px;
            width: 100%;
            color: white;
            background: linear-gradient(to right,#01a9ac,#01dbdf);
            padding: 10px 16px;
            cursor: pointer;
            border: none;
        }
        textarea { border: 0; font: 14px Georgia, Serif; overflow: hidden; resize: none; }
        table { border-collapse: collapse; }
        table td, table th { border: 1px solid black; padding: 5px; }

        #header { height: 15px; width: 100%; margin: 20px 0; background: #222; text-align: center; color: white; font: bold 15px Helvetica, Sans-Serif; text-decoration: uppercase; letter-spacing: 20px; padding: 8px 0px; }

        #address { width: 250px; height: 150px; float: left; }
        #customer { overflow: hidden; }

        #logo { text-align: right; float: right; position: relative; margin-top: 25px; border: 1px solid #fff; max-width: 540px; max-height: 100px; overflow: hidden; }
        #logo:hover, #logo.edit { border: 1px solid #000; margin-top: 0px; max-height: 125px; }
        #logoctr { display: none; }
        #logo:hover #logoctr, #logo.edit #logoctr { display: block; text-align: right; line-height: 25px; background: #eee; padding: 0 5px; }
        #logohelp { text-align: left; display: none; font-style: italic; padding: 10px 5px;}
        #logohelp input { margin-bottom: 5px; }
        .edit #logohelp { display: block; }
        .edit #save-logo, .edit #cancel-logo { display: inline; }
        .edit #image, #save-logo, #cancel-logo, .edit #change-logo, .edit #delete-logo { display: none; }
        #customer-title { font-size: 20px; font-weight: bold; float: left; }

        #meta { margin-top: 1px; width: 300px; float: right; }
        #meta td { text-align: right;  }
        #meta td.meta-head { text-align: left; background: #eee;}
        #meta td textarea { width: 100%; height: 20px; text-align: right; }

        #items { clear: both; width: 100%; margin: 30px 0 0 0; border: 1px solid black; }
        #items th { background: #eee; }
        #items textarea { width: 80px; height: 50px; }
        #items tr.item-row td { border: 0; vertical-align: top; }
        #items td.description { width: 300px; }
        #items td.item-name { width: 175px; }
        #items td.description textarea, #items td.item-name textarea { width: 100%; }
        #items td.total-line { border-right: 0; text-align: right; }
        #items td.total-value { border-left: 0; padding: 10px; }
        #items td.total-value textarea { height: 20px; background: none; }
        #items td.balance { background: #eee; }
        #items td.blank { border: 0; }

        #terms { text-align: center; margin: 20px 0 0 0; }
        #terms h5 { text-transform: uppercase; font: 13px Helvetica, Sans-Serif; letter-spacing: 10px; border-bottom: 1px solid black; padding: 0 0 8px 0; margin: 0 0 8px 0; }
        #terms textarea { width: 100%; text-align: center;}

        textarea:hover, textarea:focus, #items td.total-value textarea:hover, #items td.total-value textarea readonly:focus, .delete:hover { background-color:#EEFF88; }

        .delete-wpr { position: relative; }
        .delete { display: block; color: #000; text-decoration: none; position: absolute; background: #EEEEEE; font-weight: bold; padding: 0px 3px; border: 1px solid; top: -6px; left: -22px; font-family: Verdana; font-size: 12px; }
    </style>


</head>

<body>
<?php
    if(isset($_GET['payment'])) {
        if($_GET['payment'] == $_SESSION['payment']) {
            echo "payment success!";
        }
        else {
            echo "payment not recieved!";
        }
    }

if(isset($_SESSION['payment'])) {


            date_default_timezone_set('Asia/Kathmandu');
                $date = date('Y-m-d');
                $time = date('H');
                $day = strtoupper(date('l'));
                $slots = [];


        /**
         * SATURDAY SUNDAY MONDAY TIMESLOTS
         */
        if($day == "SATURDAY" || $day == "SUNDAY" || $day == "MONDAY" || $day == "TUESDAY" || $day == "FRIDAY") {
            if(!$day="TUESDAY" && !$time >= 10){

            array_push($slots, date('Y-m-d', strtotime($date. 'next Wednesday')) . " 10am-1pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Wednesday')) . " 1pm-4pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Wednesday')) . " 4pm-7pm ");

            array_push($slots, date('Y-m-d', strtotime($date. 'next Thursday')) . " 10am-1pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Thursday')) . " 1pm-4pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Thursday')) . " 4pm-7pm ");

            array_push($slots, date('Y-m-d', strtotime($date. 'next Friday')) . " 10am-1pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Friday')) . " 1pm-4pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Friday')) . " 4pm-7pm ");
            }

            
        }//TUESDAY TIMESLOT
        elseif ($day = "TUESDAY" && $time >= 10) {
            if($time >= 10 && $time < 13) {
            array_push($slots, date('Y-m-d', strtotime($date. 'next Wednesday')) . " 1pm-4pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Wednesday')) . " 4pm-7pm ");

            array_push($slots, date('Y-m-d', strtotime($date. 'next Thursday')) . " 10am-1pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Thursday')) . " 1pm-4pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Thursday')) . " 4pm-7pm ");

            array_push($slots, date('Y-m-d', strtotime($date. 'next Friday')) . " 10am-1pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Friday')) . " 1pm-4pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Friday')) . " 4pm-7pm ");
            }
            elseif ($time >= 13 && $time < 16) {
            array_push($slots, date('Y-m-d', strtotime($date. 'next Wednesday')) . " 4pm-7pm ");

            array_push($slots, date('Y-m-d', strtotime($date. 'next Thursday')) . " 10am-1pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Thursday')) . " 1pm-4pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Thursday')) . " 4pm-7pm ");

            array_push($slots, date('Y-m-d', strtotime($date. 'next Friday')) . " 10am-1pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Friday')) . " 1pm-4pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Friday')) . " 4pm-7pm ");
            }
            else {
            array_push($slots, date('Y-m-d', strtotime($date. 'next Thursday')) . " 10am-1pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Thursday')) . " 1pm-4pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Thursday')) . " 4pm-7pm ");

            array_push($slots, date('Y-m-d', strtotime($date. 'next Friday')) . " 10am-1pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Friday')) . " 1pm-4pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Friday')) . " 4pm-7pm ");
            }
        }//WEDNESDAY TIMESLOT
        elseif ($day="WEDNESDAY") {
        if($time < 10) {

            array_push($slots, date('Y-m-d', strtotime($date. 'next Thursday')) . " 10am-1pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Thursday')) . " 1pm-4pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Thursday')) . " 4pm-7pm ");

            array_push($slots, date('Y-m-d', strtotime($date. 'next Friday')) . " 10am-1pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Friday')) . " 1pm-4pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Friday')) . " 4pm-7pm ");

            array_push($slots, date('Y-m-d', strtotime($date. 'next Wednesday')) . " 10am-1pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Wednesday')) . " 1pm-4pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Wednesday')) . " 4pm-7pm ");
        }
        else if($time >= 10 && $time < 13) {

            array_push($slots, date('Y-m-d', strtotime($date. 'next Thursday')) . " 1pm-4pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Thursday')) . " 4pm-7pm ");

            array_push($slots, date('Y-m-d', strtotime($date. 'next Friday')) . " 10am-1pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Friday')) . " 1pm-4pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Friday')) . " 4pm-7pm ");

            array_push($slots, date('Y-m-d', strtotime($date. 'next Wednesday')) . " 10am-1pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Wednesday')) . " 1pm-4pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Wednesday')) . " 4pm-7pm ");
        }
        else if ($time >= 13 && $time < 16) {

            array_push($slots, date('Y-m-d', strtotime($date. 'next Thursday')) . " 4pm-7pm ");

            array_push($slots, date('Y-m-d', strtotime($date. 'next Friday')) . " 10am-1pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Friday')) . " 1pm-4pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Friday')) . " 4pm-7pm ");

            array_push($slots, date('Y-m-d', strtotime($date. 'next Wednesday')) . " 10am-1pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Wednesday')) . " 1pm-4pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Wednesday')) . " 4pm-7pm ");
        }
        else {

            array_push($slots, date('Y-m-d', strtotime($date. 'next Friday')) . " 10am-1pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Friday')) . " 1pm-4pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Friday')) . " 4pm-7pm ");

            array_push($slots, date('Y-m-d', strtotime($date. 'next Wednesday')) . " 10am-1pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Wednesday')) . " 1pm-4pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Wednesday')) . " 4pm-7pm ");
        }
    }
    else if($day="Thursday") {
        if($time < 10) {

            array_push($slots, date('Y-m-d', strtotime($date. 'next Friday')) . " 10am-1pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Friday')) . " 1pm-4pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Friday')) . " 4pm-7pm ");

            array_push($slots, date('Y-m-d', strtotime($date. 'next Wednesday')) . " 10am-1pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Wednesday')) . " 1pm-4pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Wednesday')) . " 4pm-7pm ");

            array_push($slots, date('Y-m-d', strtotime($date. 'next Thursday')) . " 10am-1pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Thursday')) . " 1pm-4pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Thursday')) . " 4pm-7pm ");

        }
        if($time >= 10 && $time < 13) {

            array_push($slots, date('Y-m-d', strtotime($date. 'next Friday')) . " 1pm-4pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Friday')) . " 4pm-7pm ");

            array_push($slots, date('Y-m-d', strtotime($date. 'next Wednesday')) . " 10am-1pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Wednesday')) . " 1pm-4pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Wednesday')) . " 4pm-7pm ");

            array_push($slots, date('Y-m-d', strtotime($date. 'next Thursday')) . " 1pm-4pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Thursday')) . " 4pm-7pm ");
        }
        elseif ($time >= 13 && $time < 16) {

            array_push($slots, date('Y-m-d', strtotime($date. 'next Friday')) . " 4pm-7pm ");

            array_push($slots, date('Y-m-d', strtotime($date. 'next Wednesday')) . " 10am-1pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Wednesday')) . " 1pm-4pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Wednesday')) . " 4pm-7pm ");

            array_push($slots, date('Y-m-d', strtotime($date. 'next Thursday')) . " 10am-1pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Thursday')) . " 1pm-4pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Thursday')) . " 4pm-7pm ");
        }
        else {

            array_push($slots, date('Y-m-d', strtotime($date. 'next Wednesday')) . " 10am-1pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Wednesday')) . " 1pm-4pm ");
            array_push($slots, date('Y-m-d', strtotime($date. 'next Wednesday')) . " 4pm-7pm ");

            array_push($slots, date('Y-m-d', strtotime($date. '+1 week')) . " 10am-1pm ");
            array_push($slots, date('Y-m-d', strtotime($date. '+1 week')) . " 1pm-4pm ");
            array_push($slots, date('Y-m-d', strtotime($date. '+1 week')) . " 4pm-7pm ");
        }
        }
            else {
            array_push($slots, "ERROR");
            }



        ?>
        <div id="page-wrap">
        <form method="POST" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' enctype="multipart/form-data">
        <?php   
        if(isset($_GET['slot_id'])) {
        ?>  
        <div id='success_msg'>Invoice sent, check your email for invoice!!</div>
            <a href="index.php?cart_delete=1">RETURN TO WEBSITE</a>
        <?php
            }
            ?>
        <textarea readonly id="header">INVOICE</textarea>
        <?php
        if($user_details = $crud->check_column_data('users', 'user_id', $_SESSION['user_id'])) {
            $user_details = $user_details[0];
            ?>
            <div id="identity">

                USER ID: <?php echo $user_details['USER_ID'];?><br>
                NAME: <?php echo $user_details['FIRST_NAME']." ".$user_details['LAST_NAME'] ;?><br>
                EMAIL: <?php echo $user_details['EMAIL']; ?><br><br><br>

            </div>
            <?php
        }
        ?>


    <div style="clear:both"></div>

    <div id="customer">

        <textarea readonly id="customer-title">IGNITE ECCOMMERCE PORTAL</textarea>

        <table id="meta">
            <tr>
                <td class="meta-head" colspan="5">Invoice #</td>
                <td><textarea readonly><?php echo $_SESSION['payment']; ?></textarea></td>
            </tr>
            <tr>

                <td class="meta-head" colspan="5">Date</td>
                <td><textarea readonly id="date">December 15, 2009</textarea></td>
            </tr>
            <tr>
                <td class="meta-head" colspan="5">Time Slot</td>
                <td><div class="due">
                        <?php
                        //if slot is already set then fetch from table
                        if(isset($_GET['slot_id'])) {
                            if($slot_value = $crud->check_column_data('collection_slot', 'slot_id', $_GET['slot_id'])) {
                                echo $slot_value[0]['SLOT_DATE']." ".$slot_value[0]['SLOT_TIME'];
                            }
                        }
                        //Else let the user chooose.
                        else {
                            ?>
                        <select name="time-slot">
                            <?php
                            foreach($slots as $slot) {
                            $data=[];
                            $data = explode(" ", $slot);
                            $slot_data = [];
                            if($slot_data = $crud->slot_fetch($data[0], $data[1])) {
                                $slot_data = $slot_data[0];
                                
                                ?>
                                 <option value="<?php echo $slot; ?>". ><?php echo $data[0] ." ".date('l',strtotime($data[0]))."(".$data[1].") AVAILABLE: ".$slot_data['AVAILABLE']; ?></option>
                                <?php
                              }
                              else {
                                  ?>
                                    <option value="<?php echo $slot; ?>". ><?php echo $data[0] ." ".date('l',strtotime($data[0]))."(".$data[1].") AVAILABLE: 20"; ?></option>
                                  <?php
                              }
                            ?>
                                
                                
                            <?php
                            print_r($slot_data);
                            }
                        ?>
                        </select>
                            <?php
                        }
                        ?>
                    


                </div></td>
            </tr>

        </table>

    </div>
  
    <table id="items">

    <tr>
        <th>Item</th>
        <th>Description</th>
        <th>Unit Cost</th>
        <th>Quantity</th>
        <th>Price</th>
    </tr>
    <?php
    $cart_details = [];
    $total_price=0;

    if($cart_details = $crud->check_column_data('cart', 'user_id', $_SESSION['user_id'])) {

    foreach($cart_details as $cart) {
        //makes this code run only only incase of reload
        if(isset($_GET['slot_id']) and $_SESSION['i'] == 0) {
            if($product_info=$crud->check_column_data('product','product_id',$cart['PRODUCT_ID'])) {
                $product_info = $product_info[0];
            }
            
            $data = [
                'product_id' => $cart['PRODUCT_ID'],
                'user_id' => $_SESSION['user_id'],
                'slot_id' => $_GET['slot_id'],
                'quantity' => $cart['QUANTITY']
            ];
            $crud->insert_record('orders', 'order_id', $data);

            
        }

   
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
                <tr class="item-row">
                    <td class="item-name"><textarea readonly><?php echo $product_details['PRODUCT_NAME']; ?></textarea></td>
                    <td class="description"><textarea readonly> <?php echo $product_details['DESCRIPTION']; ?></textarea></td>
                    <?php
                        if($discount_details) {
                            ?>
                            <td><textarea readonly class="cost"><?php echo ($product_details['PRICE'] - $discount_details['PRICE']); ?></textarea></td>
                            <?php
                        }
                        else {
                            ?>
                              <td><textarea readonly class="cost"><?php echo $product_details['PRICE']; ?></textarea></td>
                            <?php
                        }
                    ?>
                    
                    <td><textarea readonly class="qty"><?php echo $cart['QUANTITY']; ?></textarea></td>
                    <?php 
                      if($discount_details) {
                          ?>
                            <td><span class="price">$<?php echo ($product_details['PRICE'] - $discount_details['PRICE'])*$cart['QUANTITY']; ?> </span></td>
                          <?php
                          
                          $total_price += ($product_details['PRICE'] - $discount_details['PRICE'])*$cart['QUANTITY'];
                      }  
                      else {
                          ?>
                          <td><span class="price">$<?php echo $product_details['PRICE']*$cart['QUANTITY']; ?> </span></td>
                          <?php
                          $total_price += $product_details['PRICE']*$cart['QUANTITY'];

                      } 
                    ?>

                </tr>
                <?php
     }
    }
?>

    
    <tr id="hiderow">
        <td colspan="5"></td>
    </tr>
    

    <tr>

        <td colspan="2" class="blank"> </td>
        <td colspan="2" class="total-line">Total</td>
        <td class="total-value"><div id="total">$<?php echo $total_price; ?></div></td>
        <?php
        if(isset($_GET['slot_id']) &&  $_SESSION['i'] == 0) {
        $data = [
            'user_id' => $_SESSION['user_id'],
            'price' => $total_price
        ];
        $crud->insert_record('payment', 'invoice_id', $data);

        if(isset($_GET['slot_id']) and $_SESSION['i'] == 0) {

            /**
             * send mail to the user.
             */
            $user_info = $crud->check_column_data('users', 'user_id', $_SESSION['user_id']);
            //the subject
            $sub = "INVOICE FOR THE LATEST PURCASE";
            //the message
            $message = '<html>



            <body style="margin: 50px;">
            
            <div style="width: 90%;margin:auto;">
                <div style="width:100%; text-align:center;letter-spacing: 2px;background: black;color: white;"><h3>INVOICE</h3></div>';

            
            $message .= '<table>
                        <tr>';

            $message .= '<td >Invoice #</td>';                                        
            $message .= '<td><span>'.$_SESSION['payment'].'</span></td></tr>';
            if($user_details = $crud->check_column_data('users', 'user_id', $_SESSION['user_id'])) {
                $user_details = $user_details[0];
                
                $message .= '<tr><td >NAME:</td>';                                        
                $message .= '<td><span>'.$user_details['FIRST_NAME'].' '.$user_details['LAST_NAME'].'</span></td></tr>';
                
            }   
            $message .= '                       
                        
                        <tr>
        
                            <td >Date</td>
                            <td><span>'.date("Y-m-d").'</span></td>
                        </tr>

                    
                                </table>
                            
                            
                            <table style="margin:10px 0px;width: 100%;">
                            
                              <tr style="background: black; color: white">
                                  <th>Item</th>
                                  <th>Description</th>
                                  <th>Unit Cost</th>
                                  <th>Quantity</th>
                                  <th>Price</th>
                              </tr>';

            foreach($cart_details as $cart) {
                
                $qtn=0;
                $product_details = [];
                $discount_details = [];
                if($product_details = $crud->check_column_data('product', 'product_id', $cart['PRODUCT_ID'])) {
                    $product_details = $product_details[0];
                }
                if($discount_details = $crud->check_column_data('discount', 'product_id', $cart['PRODUCT_ID'])) {
                    $discount_details = $discount_details[0];

                }

                    //seperate data generation for discount products
                    if($discount_details) {
                        $message .= '<tr style="background: rgb(216, 216, 216);">
                        <td ><span>'.$product_details['PRODUCT_NAME'].'</span></td>
                        <td ><span>'.$product_details['DESCRIPTION'].'</span></td>
    
                        <td><span >$'. ($product_details['PRICE'] - $discount_details['PRICE']).'</span></td>
                        <td><span >'.$cart['QUANTITY'].'</span></td>
                        <td><span >$'.($product_details['PRICE'] - $discount_details['PRICE'])*$cart['QUANTITY'].'</span></td>
                        </tr>';
                        
                    }
                    //for non-discounted products
                    else {
                        $message .= '<tr style="background: rgb(216, 216, 216);">
                        <td ><span>'.$product_info['PRODUCT_NAME'].'</span></td>
                        <td ><span>'.$product_info['DESCRIPTION'].'</span></td>
    
                        <td><span >$'.$product_details['PRICE'].'</span></td>
                        <td><span >'.$cart['QUANTITY'].'</span></td>
                        <td><span >$'.$product_details['PRICE'] * $cart['QUANTITY'].'</span></td>
                        </tr>';

                    }
                    //reducing product qtn for the products bought
                    $qtn = $product_details['QUANTITY']-$cart['QUANTITY'];
                        $crud->edit_table_info('product','quantity',$qtn,'product_id',$product_info['PRODUCT_ID']);
         
            }

                              
            $message .= '
                            
                              <tr>
                    
                                  <td colspan="2"> </td>
                                  <td colspan="2" style="background: rgb(201, 201, 201);">Total</td>
                                  <td colspan="2" style="background: rgb(201, 201, 201);">$'.$total_price.'</td>
                              </tr>
                              <tr>
                                  <td colspan="2"> </td>
                                  <td colspan="2" style="background: rgb(201, 201, 201);">Amount Paid</td>
                                  <td colspan="2" style="background: rgb(201, 201, 201);">$'.$total_price.'</td>
                              </tr>
                    
                            
                            </table>
                    <span >Terms:</span>
                    <span>If failed to collect product within the allocate timeslot, contact the trader for refund.</span>
            
            </div>
            
                    
            
            
                
                
            </body>
            
            </html>';

        
            //recipient email here
            $user_info = $crud->check_column_data('users', 'user_id', $_SESSION['user_id']);
            $rec = $user_info[0]['EMAIL'];
            //send email
            $headers = "From: bishant369@gmail.com"."\r\n"."Cc: bishant369@gmail.com"."\r\n"."Bcc: bishant369@gamil.com"."\r\n";
            $headers .='Content-type: text/html; charset=iso-8859-1';
        
        
            if(mail($rec,$sub,$message,$headers)) {
                //GIVE A HINT ABOUT MAIL SENT AND SHOW BUTTON TO RETURN TO WEBSITE
            }
            else {
                //GIVE ANOTHER MSG
            }


            
        }
        
    }?>
    </tr>

    <tr>
        <td colspan="2" class="blank"> </td>
        <td colspan="2" class="total-line balance">Amount Paid</td>
        <td class="total-value balance"><div class="due">$<?php echo $total_price; ?></div></td>
    </tr>

    </table>

    <div id="terms">
    <h5>Terms</h5>
    <textarea readonly>If failed to collect product within the allocate timeslot, contact the trader for refund.</textarea>
    </div>
    <?php
    if(!isset($_GET['slot_id'])) {
        ?>
            <button id="invoice_submit" type="submit" name="invoice-submit">CONFIRM</button>
        <?php

    }
    ?>

    </form>
    </div>
<?php
    

}
else {
    header('location: index.php');
}
if(isset($_GET['slot_id'])) {
    $_SESSION['i'] = 1;//represents session on repeat
}
?>
</body>

</html>