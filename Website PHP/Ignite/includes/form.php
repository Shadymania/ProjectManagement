<?php 
session_start();
include 'crud.php';
$msg=null;
$errors = [];

/**
 * ADD PRODUCT FORM
 */
if(isset($_POST['add_product']) || isset($_POST['edit_product'])) {
    if(isset($_POST['edit_product'])) $_SESSION['edit'] = true;

    $errors = [];
    $name = "";
    $desc = "";
    $price = 0;
    $qtn = 0;
    $stock= 1;
    $min_order = 0;
    $max_order = 0;
    $allergy_info = "";
    $product_type = 0;



    if(!empty($_POST['name']) && !empty($_POST['desc']) && !empty($_POST['price']) 
        && !empty($_POST['qtn']) && !empty($_FILES["thumbnail"]["name"])) {

        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $desc = filter_var($_POST['desc'], FILTER_SANITIZE_STRING);
        $qtn = filter_var($_POST['qtn'], FILTER_VALIDATE_INT);
        $min_order = filter_var($_POST['min_order'], FILTER_VALIDATE_INT);
        $max_order = filter_var($_POST['max_order'], FILTER_VALIDATE_INT);
        $allergy_info = filter_var($_POST['allergy_info'], FILTER_SANITIZE_STRING);
        $product_type = $_POST['category'];

        //image upload process begins
        $target_dir = "../img/";
        $target_file = $target_dir . basename($_FILES["thumbnail"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
            array_push($errors,"File is not an image.");
            $uploadOk = 0;
            }
        }
    
        // Check if file already exists
        if (file_exists($target_file)) {
            //echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["thumbnail"]["size"] > 1500000) {
            array_push($errors, "Sorry, your file is too large.");
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            array_push($errors, "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            //do nothing and show errors
        
        }// if everything is ok, try to upload file
        else {
            if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_file)) {


            } else {
                array_push($errors, "Sorry, there was an error uploading your file.");
            }
        }
        //image upload process ends
         
        //price validation and storing!
         if(filter_var($_POST['price'], FILTER_VALIDATE_FLOAT)) { 
            $price = $_POST['price'];
         }
         else {
             array_push($errors, "Invalid price!!");
         }

         //checking for any errors before proceeding to storing and inserting data
         if(count($errors) == 0) {

                if(isset($_POST['add_product'])) {
                    $data = [
                        'product_name' => $name,
                        'description' => $desc,
                        'price' => $price,
                        'stock' => $stock,
                        'min_order' => $min_order,
                        'max_order' => $max_order,
                        'product_image' => $target_file,
                        'quantity' => $qtn,
                        'allergy_info' => $allergy_info,
                        'product_type_id' => $product_type
                    ];

                    if($crud->insert_record('product', 'product_id', $data)) $msg="Record inserted!";
                    else echo "Record inserting failed!";
                 }
                 else if(isset($_POST['edit_product'])){
                    $id = $_POST['id'];
                    $data = [
                        'product_id' => $id,
                        'product_name' => $name,
                        'description' => $desc,
                        'price' => $price,
                        'stock' => $stock,
                        'min_order' => $min_order,
                        'max_order' => $max_order,
                        'product_image' => $target_file,
                        'quantity' => $qtn,
                        'allergy_info' => $allergy_info,
                        'product_type_id' => $product_type
                    ];

                     if($crud->edit_product_info($data)) {
                        header('location: addproduct.php?edit_product='. $id.'&success=1');
                        unset($_SESSION['edit']);

                     }
                     else echo "failed!";
                 }
        }

        }
        else {
            array_push($errors, "Fill all the empty fields!!");
            
        }//if isset('addproduct') closes


    }




/**
 * REGISTER FORM
 */

if(isset($_POST['register_submit'])) {
    $data = [];
    $errors = [];
    $f_name = "";
    $l_name = "";
    $email = "";
    $pass1 = "";
    $pass2 = "";
    $dob = "";
    $gender = "";
    $img = "";

    //checks for empty fields
    if(!empty($_POST['f_name']) && !empty($_POST['l_name']) && !empty($_POST['email'])
    && !empty($_POST['pass1']) && !empty($_POST['pass2']) && !empty($_POST['agree'])) {
        //checks for invalid email
        if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            //checks for mismatched passwords
            if($_POST['pass1'] == $_POST['pass2']) {
                $f_name = filter_var($_POST['f_name'], FILTER_SANITIZE_STRING);
                $l_name = filter_var($_POST['l_name'], FILTER_SANITIZE_STRING);
                $email = strtoupper($_POST['email']);
                $pass1 = md5($_POST['pass1']);
                $pass2 = md5($_POST['pass2']);
                $dob = $_POST['dob'];
                $gender = $_POST['gender'];
                
                //if img is choosen
                if(!empty($_FILES["thumbnail"]["name"])) {
                    //image upload process begins
                    $target_dir = "img/";
                    $target_file = $target_dir . basename($_FILES["thumbnail"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    $check = getimagesize($_FILES["thumbnail"]["tmp_name"]);
                
                
                    if($check !== false) {
                        //echo "File is an image - " . $check["mime"] . ".";
                        $uploadOk = 1;
                    } else {
                        array_push($errors, "File is not an image.");
                        $uploadOk = 0;
                    }
                
                    // Check if file already exists
                    if (file_exists($target_file)) {
                        //echo "Sorry, file already exists.";
                        $uploadOk = 0;
                        $img = $target_file;
                    }
                    // Check file size
                    if ($_FILES["thumbnail"]["size"] > 500000) {
                        array_push($errors, "Sorry, your file is too large.");
                        $uploadOk = 0;
                    }
                    // Allow certain file formats
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif" ) {
                        array_push($errors, "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
                        $uploadOk = 0;
                    }
                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                        
                    // if everything is ok, try to upload file
                    } else {
                        if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_file)) {
                            $img = $target_file;

                        } else {
                            array_push($errors, "Sorry, there was an error uploading your file.");
                        }
                    }
                    //image upload process ends
                    
                }//if img is not selected
                else {
                    $img = "img/profile.png";
                }
                
                // echo $dob;
                $data = [
                    'first_name' => $f_name,
                    'last_name' => $l_name,
                    'email' => strtoupper($email),
                    'active' => 0,
                    'status' => 0,
                    'gender' => $gender,
                    'dob' => $dob,
                    'password' => $pass1,
                    'img' => $img

                ];


            }//if for comfirming passwords
            else array_push($errors,"Passwords do not Match!!");


        }//if for validating email
        else array_push($errors, "Invalid emails!");

        
    }//if for checking all required fiels are filled!
    else array_push($errors, "Fill all the required fields!!");

    //checking if email is already in use.
    if($crud->check_column_data('users', 'email', strtoupper($email))) {
        array_push($errors, "User with the email already exists!!");
    }

    if(count($errors) == 0) {
        if($crud->insert_record('users', 'user_id', $data)) {


            $user = $crud->fetch_login_user($email, $pass1);


            if($user) {
                $_SESSION['user_id'] = $user['USER_ID'];
                $_SESSION['username'] = $user['FIRST_NAME'];
                $_SESSION['is_admin'] = $user['IS_ADMIN'];
                $_SESSION['status'] = $user['STATUS'];
                header('location: index.php');
                }

        
        } 
        else array_push($errors, "Record inserting failed!") ;



    }
}//registration submission ends


if(isset($_GET['get_verification'])) {
    $user_info = $crud->check_column_data('users', 'user_id', $_SESSION['user_id']);
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    //the subject
    $sub = "Verification link for IGNITE ECOMMERCE PORTAL";
    //the message
    $message = '<html><body>';
    $message .= '<h1 style="color:#f40;">Hi '.$user_info[0]['FIRST_NAME'].'!</h1>';
    $message .= '<p style="color:#080;font-size:18px;">Go to the link below to verify your IGNITE ECOMMERCE ACCOUNT!</p><br>';
    $message .= '<a href=http://localhost/ignite/profile.php?verification=1>VERIFY</a>';
    $message .= '</body></html>';

    //recipient email here
    $user_info = $crud->check_column_data('users', 'user_id', $_SESSION['user_id']);
    $rec = $user_info[0]['EMAIL'];
    //send email
    $headers = "From: bishant369@gmail.com"."\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


    if(mail($rec,$sub,$message,$headers)) header('location: profile.php?email=true');

    else array_push($errors,"Failed to send mail!");


}

/**
 * TRADER REGISTRATION FORM
 */
if(isset($_POST['trader_register']) && isset($_SESSION['user_id'])) {
    $name = "";
    $mob_num = "";
    $desc = "";
    $data = [];
    $trader_details=[];

    
    if(!empty($_POST['name']) && !empty($_POST['mobile_num']) && !empty($_POST['description'])
    && !empty($_POST['pass1']) && !empty($_POST['pass2'])) {
        $name = "";
        $mobile_num = "";
        $desc = "";
        $status = 1;//one represents deactivated trader
        $pass1 = "";
        $pass2 = "";

            if($_POST['pass1'] == $_POST['pass2']) {
                $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                $mobile_num = $_POST['mobile_num'];
                $desc = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
                $pass1 = md5($_POST['pass1']);
            }
            else array_push($errors, "Passwords donot match!!");


        
        //checks if trader with the name already exists!
        if($crud->check_column_data('trader','trader_name', strtoupper($name))) {
            array_push($errors, "Trader with name '$name' already exist!!");

        }
        //checks if user is already a trader
        if($crud->check_column_data('trader', 'user_id', $_SESSION['user_id'])) {
            array_push($errors,"You are already a trader!");
        }

        if(count($errors) == 0){
            $data = [
                'trader_name' => strtoupper($name),
                'description' => $desc,
                'user_id' => $_SESSION['user_id'],
                'mobile' => $mobile_num,
                'password' => $pass1,
                'status' => $status
            ];

            if($crud->insert_record('trader', 'trader_id', $data)) {
                $trader_details= $crud->check_column_data('trader','trader_name', strtoupper($name));
                if($trader_details) {

                    $_SESSION['trader_id'] = $trader_details[0]['TRADER_ID'];
                    $_SESSION['trader_status'] = $trader_details[0]['STATUS'];
                    $_SESSION['trader_name'] = $trader_details[0]['TRADER_NAME'];

                    header('location: trader_dashboard.php');
                }
                //set session
                
            }
            else {
                array_push($errors, "Failed to register!!") ;
            }
    
        }

        

    }
}//trader_register submission ends.

/**
 * TRADER LOGIN
 */

 if(isset($_POST['trader_login_submit'])) {
    $errors = []; 
    $name = "";
    $pass = "";
    $data = [];//stores trader details.

    if(!empty($_POST['name']) && !empty($_POST['password'])) {

            $name = strtoupper($_POST['name']);
            $pass = md5($_POST['password']);

            if(!$data = $crud->fetch_login_trader($name, $pass)) {
                array_push($errors, "No trader found!!");
            }
            

    }
    else array_push($errors, "Name or password field is left empty!");
    
    if(count($errors) == 0) {

            $_SESSION['user_id'] = $data['USER_ID'];//this allows to continue session as customer.
            $_SESSION['trader_name'] = $data['TRADER_NAME'];
            $_SESSION['trader_status'] = $data['STATUS'];
            $_SESSION['trader_id'] = $data['TRADER_ID'];

            //also fetching user data associated with trader and setting session variables.
            $user_data = $crud->check_column_data('users', 'user_id', $data['USER_ID']);
            if($user_data) {
                $_SESSION['username'] = $user_data[0]['FIRST_NAME'];
                $_SESSION['is_admin'] = $user_data[0]['IS_ADMIN'];
                $_SESSION['status'] = $user_data[0]['STATUS'];
            }
             header('location: trader_dashboard.php');

    
        }
        else {
            foreach ($errors as $error ) {
                echo "$error </br>";
            }
        }
    }//trader_login ends 

    if(isset($_POST['product_type_submit'])) {
        $name = "";
        $desc = "";
        $shop_id = 0;

        if(!empty($_POST['name']) && !empty($_POST['desc'])) {
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $desc = filter_var($_POST['desc'], FILTER_SANITIZE_STRING);
            $shop_id = $_POST['type'];

            $data = [
                'product_type_name' => $name,
                'shop_id' => $shop_id,
                'description' => $desc
            ];

            if($crud->insert_record('product_type', 'product_type_id', $data)) echo "product type inserted!!";
            else echo "Failed to insert product type";
        }
    }

    //add new shop for trader
    if(isset($_POST['register_shop'])) {
        $count = 0;
        $errors = [];
        $shop_name = "";
        $location = "";
        $category = "";
        $desc = "";
        if($shop_num = $crud->fetch_table_data('shop')) {

            
            foreach($shop_num as $shop) {
                $count++;
            }
        }
                if($count >= 10)
                array_push($errors, "Maximum number of shop reached you can't add anymore!");
                else {
                    if(!empty($_POST['shop_name']) && !empty($_POST['location']) && !empty($_POST['category']) && !empty($_POST['desc'])) {

                        if($crud->check_column_data('shop', 'shop_name', $_POST['shop_name'])) {
                            array_push($errors, "Shop with the given name already exists!");
                        }
                        $data = [
                            'shop_name' => filter_var($_POST['shop_name'], FILTER_SANITIZE_STRING),
                            'shop_location' => filter_var($_POST['location'], FILTER_SANITIZE_STRING),
                            'trader_id' => $_SESSION['trader_id']
                        ];
                    }
                    else array_push($errors, "Fill in all required fields!");
            
                    if(count($errors) == 0) {
                        if($crud->insert_record('shop', 'shop_id', $data)) {
                            if($shop_detail = $crud->check_column_data('shop', 'shop_name', $_POST['shop_name'])) {
                                $product_type = [
                                    'product_type_name' => $_POST['category'],
                                    'description' => $_POST['desc'],
                                    'shop_id' => $shop_detail[0]['SHOP_ID']
                                ];
                                $crud->insert_record('product_type','product_type_id', $product_type);
                            }

                            $msg = "New shop added!";
                        } 
                        else {
                            array_push($errors, "Failed to insert shop!");
                    }
                }
        
        

    }
}

if(isset($_POST['edit_shop'])) {
    if(!empty($_POST['shop_name']) && !empty($_POST['location'])) {
        $data = [
            'shop_id' => $_POST['shop_id'],
            'shop_name' => $_POST['shop_name'],
            'shop_location' => $_POST['location']
        ];

        if($crud->edit_shop_info($data)) $msg =  "record updated";
        else array_push($errors,"Failed to update the record");

    }
}

if(isset($_POST['add_category'])) {
    if(!empty($_POST['category']) && !empty($_POST['desc'])) {
        $data = [
            'product_type_name' => $_POST['category'],
            'shop_id' => $_POST['shop_id'],
            'description' => $_POST['desc']
        ];

        if($crud->insert_record('product_type', 'product_type_id', $data)) {
            $msg = "Category inserted!";
        }
        else {
            array_push($erros, "failed to insert record!") ;
        }
    }
}

if(isset($_GET['delete_product'])) {
    $query = $crud->delete_record('product', 'product_id', $_GET['delete_product']);

    if($query) {
        header('location: product_list.php?shop_id='. $_SESSION['shop_id']);
    }
}

/**
 * DISCOUNT PRODUCT FORM
 */
if(isset($_POST['discount'])) {
    $errors = [];
    if($_POST['discount'] > 0) {
        $data = [
            'product_id' => $_POST['product_id'],
            'product_type_id' => $_POST['product_type_id'],
            'price' => $_POST['discount']
        ];

        if($crud->check_column_data('discount', 'product_id', $data['product_id'])) {
            if($crud->edit_table_info('discount', 'price',$data['price'], 'product_id', $data['product_id'])) {
                $msg = "New discount set!";
            }
        }
        else {
            $crud->insert_record('discount', 'discount_id', $data);
        }

    }
    else {
        array_push($errors, "Invalid discount amount!!");
    }
}

/**
 * ADD PRODUCT TO CART TABLE
 */

 if(isset($_POST['cart_submit'])) {
     if(isset($_SESSION['user_id'])) {
            if($product = $crud->check_column_data('product','product_id', $_POST['product_id'])) {
                if($product[0]['QUANTITY']<$_POST['qtn']) {
                    header('location: product.php?product_id='.$_POST['product_id'].'&qtn=1');
                    
                }
                else {
                    $data = [
                        'user_id' => $_SESSION['user_id'],
                        'product_id' => $_POST['product_id'],
                        'quantity' => $_POST['qtn']
                     ];
                      $crud->insert_record('cart', 'cart_id', $data);
                        header('location: product.php?product_id='.$_POST['product_id']);
                }
            }

             

     }
     else {
         header('location: login.php?product_id='.$_POST['product_id']);
     }


 }

 /**
  * CART EDIT 
  */
  if(isset($_POST['cart_edit'])) {
    $errors = [];
    if($_POST['qtn'] > 0) {
        $data = [
            'cart_id' => $_POST['cart_id'],
            'qtn' => $_POST['qtn']
        ];

        if($crud->edit_cart_info($data)) {
            echo "quantity set";
        }
    }
    else {
        array_push($errors, "Invalid amount!!");
    }
  }

  /**
   * INVOICE SUBMISSION AND EMAIL DELIVERY
   */
  if(isset($_POST['invoice-submit'])) {
    //create or update the slot and sends the slot_id has get value;
    $errors = [];  
    $time_slot = $_POST['time-slot'];
    $date= explode(' ', $time_slot);
    $data = [
        'SLOT_DATE' => $date[0],
        'AVAILABLE' => 19,
        'SLOT_TIME' => $date[1]
    ];

    if($slot_data = $crud->slot_fetch($date[0], $date[1])) {
        //CHECKING IF SLOT IS AVAILABLE
        if($slot_data[0]['AVAILABLE']) {
            $slot_data = $slot_data[0];
            $slot_value = $slot_data['AVAILABLE'] - 1 ;
            $crud->slot_update($slot_data['SLOT_ID'], $slot_value);
            echo "SLOT UPDATED!";
            header('location: invoice.php?slot_id='. $slot_data['SLOT_ID']);
        }
        else {
            array_push($errors, "Slot is full!");
        }


      }
      //IF SLOT IS NOT AVAILABLE IT'S SHOULD BE A NEW SLOT SO INSERTING IT IN THE TABLE
      else {
        if($crud->insert_record('collection_slot','slot_id', $data)) {
            if($slot_data = $crud->slot_fetch($date[0], $date[1])) {
                
                    $slot_data = $slot_data[0];
                    header('location: invoice.php?slot_id='. $slot_data['SLOT_ID']);
        
              }

        }
        else {
            array_push($errors, "Failed to insert Slot");
        }
      }

    print_r($errors);
  } 

  /**
   * CART DELETE
   */
  if(isset($_GET['cart_delete']) && $_SESSION['user_id']) {
      $crud->delete_record('cart', 'user_id', $_SESSION['user_id']);
  }

  if(isset($_POST['review_submit'])) {
      if(!empty($_POST['review'])) {
        $data = [
            "user_id" => $_SESSION['user_id'],
            "value" => $_POST['stars'],
            "review" => $_POST['review'],
            "product_id" => $_POST['product_id']
        ];


        if($crud->insert_record('review', 'review_id', $data)) {
            header('location: product.php?product_id='. $_POST['product_id']);
        }
        else {
            echo "failed!";
        }
      }
  }

  if(isset($_POST['search_submit'])) {
      if(!empty($_POST['data']))
      header('location: search.php?search='.$_POST['data']);
      
  }

  if(isset($_POST['quantity_submit'])) {
    $data = [
        "qtn" => $_POST['qtn'],
        'product_id' => $_POST['product_id']
    ];

    $crud->edit_product_qtn($data);
  }

  if(isset($_POST['user_edit'])) {
      $user_info = $crud->check_column_data('users', 'user_id', $_SESSION['user_id']);

      if(!empty($_POST['f_name'])) {
          $crud->edit_table_info('users', 'FIRST_NAME', $_POST['f_name'], 'user_id', $_SESSION['user_id']);
          $msg="User info edited!";
      }
      if(!empty($_POST['l_name'])) {
        $crud->edit_table_info('users', 'LAST_NAME', $_POST['l_name'], 'user_id', $_SESSION['user_id']);
        $msg="User info edited!";
      }
      if(!empty($_POST['pass1']) and !empty($_POST['pass2'])) {
          if($pass1 == $pass2) {
            $crud->edit_table_info('users', 'PASSWORD', md5($_POST['pass1']), 'user_id', $_SESSION['user_id']);
          }
          $msg="User info edited!";
      }
      if(!empty($_POST['dob'])) {
        
          $crud->edit_table_info('users', 'DOB', $_POST['dob'], 'user_id', $_SESSION['user_id']);
          $msg="User info edited!";
    }
    if(!empty($_FILES["thumbnail"]["name"])) {
                //image upload process begins
                $target_dir = "img/";
                $target_file = $target_dir . basename($_FILES["thumbnail"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                $check = getimagesize($_FILES["thumbnail"]["tmp_name"]);
            
            
                if($check !== false) {
                    //echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    array_push($errors, "File is not an image.");
                    $uploadOk = 0;
                }
            
                // Check if file already exists
                if (file_exists($target_file)) {
                    //echo "Sorry, file already exists.";
                    $uploadOk = 0;
                }
                // Check file size
                if ($_FILES["thumbnail"]["size"] > 500000) {
                    array_push($errors, "Sorry, your file is too large.");
                    $uploadOk = 0;
                }
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                    array_push($errors, "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                // if everything is ok, try to upload file
                } else {
                    if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_file)) {
        
        
                    } else {
                        array_push($errors, "Sorry, there was an error uploading your file.");
                    }
                }
                //image upload process ends
                $crud->edit_table_info('users', 'img',$target_file, 'user_id', $_SESSION['user_id'] );

                $msg="User info edited!";
    }



      
  }



  ?>

