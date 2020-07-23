<?php 
include '../includes/form.php';

$user_info = "";

if(isset($_SESSION['user_id'])) {
    if($user_info = $crud->check_column_data('users', 'user_id', $_SESSION['user_id'])) {
        $user_info = $user_info[0];
    }
}

$shops= [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type='text/css' href='../css/dashboard.css'/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <title>DASHBOARD</title>
</head>
<body>
    
    <div class="grid-container">
        <header class="header">
        <div class="header__search">
        <?php
            if(isset($_SESSION['user_id'])) {
                if($trader_details = $crud->check_column_data('trader', 'user_id', $_SESSION['user_id'])) {

                    if(isset($_SESSION['trader_id'])) {
                        $shops = $crud->check_column_data('shop','trader_id', $_SESSION['trader_id'] );
                    }
                    else {
                        $shops = $crud->check_column_data('shop','trader_id', $trader_details[0]['TRADER_ID'] );
                    }
                }

            }

        ?>

                
               
            </div>
            <div class="profile_container" onclick="subnavtoggle(this)">
                <?php
                if(isset($_SESSION['user_id'])) {
                    ?>
                    <div class="header__avatar"><img src="<?php echo '../'.$user_info['IMG']; ?>" alt=""><span>&#x25BC;</span></div>
                    <?php
                }
                else {
                    ?>
                    <div class="header__avatar"><img src="../img/profile.png" alt=""><span>&#x25BC;</span></div>
                    <?php
                }
                ?>
                
                
            </div>
            <div class="header__dropdown">
                    <ul class="user__option">
                        <li><a href="../profile.php">Profile</a></li>
                        <li><a href="../login.php">Logout</a></li>
                    </ul>
            </div>

        </header>

        <div class="menu-icon" id="menu-icon" onclick="toggle_nav()">
                <i class="fas fa-bars"></i>
        </div>
        <aside class="sidenav" id="side-nav" >
                <div class="logo"><img class="ignite-logo" src="../img/ignite-logo.png"></div>
                <div class="sidenav__close-icon" onclick="toggle_nav()">
                    <i class="fas fa-times"></i>
                </div>

                
                <ul class="sidenav__list">
                    <li class="sidenav__list-item" onclick="subnavtoggle(this)">
                        <a href="#">Dashboard <span>&#x25BC;</span></a>
                    </li>
                        <!--sub nav-->
                        <ul class="sub-nav " >
                            <li class="sub-nav-item" >
                                <a href="trader_dashboard.php">Orders Report</a>
                            </li>
                            <li class="sub-nav-item" >
                                <a href="report.php">Monthly Report</a>
                            </li>

                        </ul>


                    <li class="sidenav__list-item" onclick="subnavtoggle(this)">
                        <a href="#">My Shops</a> <span>&#x25BC;</span>
                    </li>
                        <!--sub nav-->
                        <ul class="sub-nav " >
                            <?php
                            if($shops) {
                                foreach($shops as $shop) {
                                    ?>   
                                       <li class="sub-nav-item" onclick="subnavtoggle(this)"><a><?php echo $shop['SHOP_NAME'] ?><span>&#x25BC;</span></a></li>
                                       <ul class="sub-nav">
                                           <li class="sub-nav-item"><a href="product_list.php?shop_id=<?php echo $shop['SHOP_ID']; ?>">Product Listing</a></li>
                                           <li class="sub-nav-item"><a href="editshop.php?editshop=<?php echo $shop['SHOP_ID']; ?>">Edit Shop</a></li>
                                           <li class="sub-nav-item"><a href="discount.php?shop_id=<?php echo $shop['SHOP_ID']; ?>">Discount product</a></li>
                                       </ul>
                                   <?php 
                                }
                            }
                            else {
                                ?>
                                <li class="sub-nav-item " ><a>NO SHOPS!</a></li>
                                <?php
                            }
                            ?>
                        </ul>




                    
                    <li class="sidenav__list-item"><a href="addshop.php">Add Shop</a></li>

                </ul>
                    
        </aside>
         <!--MAIN CONTENTS THE CONTENTS-->
        <main class="main">