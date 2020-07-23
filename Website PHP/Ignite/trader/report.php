<?php include 'trader_header.php';

// TRADER LOGIN SESSION VAIRABLES
// $_SESSION['username'];
// $_SESSION['is_admin'];
// $_SESSION['status'];
// $_SESSION['user_id'];
// $_SESSION['trader_name'];
// $_SESSION['trader_status'];
// $_SESSION['trader_id'];

    if(isset($_SESSION['user_id'])) {
        if($trader_data = $crud->check_column_data('trader', 'user_id', $_SESSION['user_id'])) {
            $_SESSION['trader_id'] = $trader_data[0]['TRADER_ID'];
            $_SESSION['trader_name'] = $trader_data[0]['TRADER_NAME'];
        }
    }
    else {
        header('location: index.php');
    }
    //fetching products
    $products=$crud->fetch_view_data('trader_orders', $_SESSION['trader_id']);
?> 
    <section class="container  mt-20 mb-20 bg pd-content">
    <div class="title-box mb-20"><span class="title-text">MONTHLY STATS</span></div>
    <div class="stats-container bg pd-content">
    <?php
    //variables for storing data
        $item_count = 0;//TOTAL ITEM SOLD
        $price = 0;
        $stock = 0;

        if($trader_info=$crud->fetch_view_data('monthly_report', $_SESSION['trader_id'])) {
            foreach($trader_info as $item) {
            $item_count += $item['QUANTITY']; 
            if($discount_info = $crud->check_column_data('discount', 'product_id', $item['PRODUCT_ID'])) {
                $price += $item['PRICE'] - $discount_info[0]['PRICE'];
            }
            else {
                $price += $item['PRICE'];
            }
            }

            //calculating out of stock items
            if($trader_product = $crud->fetch_view_data('trader_products', 'trader_id', $_SESSION['trader_id'])) {
                foreach($trader_product as $info) {
                    if($info['QUANTITY'] <= 0) $stock++;
                }
                
            }

            ?>
            <div class="stats-box">
            <div>
                <h3>TOTAL SALES:</h3>
            </div>
            <div class="stat-data">
                 <span class="price">$<?php echo $price; ?></span>
            </div> 

            </div>

            <div class="stats-box">
            <div>
                <h3>PRODUCTS SOLD:</h3>
            </div>
            <div class="stat-data">
            <?php echo $item_count; ?>
            </div> 

            </div>

            <div class="stats-box">
            <div>
                <h3>OUT OF STOCK:</h3>
            </div>
            <div class="stat-data">
            <?php echo $stock; ?>
            </div> 

            </div>
            <?php
        }
    ?>
    </div>


    </section>

    <section class="container mt-20 mb-20 bg pd-content">
    <div class="title-box mb-20"><span class="title-text">SALES BY PRODUCT</span></div>
    <div class="mb-20">
            <label>SORT BY:</label>
            <div class="dropdown">
                <div class="dropdown-box">
                    <span>--SELECT--<span>&#x25BC;</span></span>
                </div>
                <div class="dropdown-content">
                    <ul class="category-dropdown">

                        <li><a href="report.php?product_sort=1">Alphabets</a></li>
                        <li><a href="report.php?product_sort=5">Orders Count</a></li>
                        <li><a href="report.php?product_sort=2">Product Sales</a></li>
                    </ul>
                </div>
            </div>
        </div>


    <table class="product-table" cellspacing="0">
                <thead>
                    <tr class="w3-light-grey">
                    <th>PRODUCT NAME</th>
                    <th>ORDER COUNT</th>
                    <th>TOTAL SALES</th>
                    </tr>
                </thead>
                <?php
                //setting up if else for different product_sort value from get.
                if(isset($_GET['product_sort'])) {
                    if($products=$crud->trader_product_sales( $_SESSION['trader_id'], $_GET['product_sort'])) {
                        foreach($products as $item) {?>
                            <tr>
                                <td><?php echo $item['PRODUCT_NAME']; ?></td>
                                <td><?PHP echo $item['ORDER_CNT']; ?></td>
                                <td><span class="price">$<?php echo $item['ORDER_TOTAL']; ?></span>   </td>
            
                            </tr>
                        <?php
                        }
                    }

                }
                else {
                    if($products=$crud->trader_product_sales( $_SESSION['trader_id'], 2)) {
                        foreach($products as $item) {?>
                            <tr>
                                <td><?php echo $item['PRODUCT_NAME']; ?></td>
                                <td><?PHP echo $item['ORDER_CNT']; ?></td>
                                <td><span class="price">$<?php echo $item['ORDER_TOTAL']; ?> </span>   </td>
            
                            </tr>
                        <?php
                        }
                    }
                }

                ?>

                </table>
    </section>


<?php include 'trader_footer.php'; ?>
