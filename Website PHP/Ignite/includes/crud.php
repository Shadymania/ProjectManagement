<?php
include 'connection.php';


class CrudOperation extends Dbh {

    //method for inserting data inside table
    public function insert_record($table, $primary_key, $data) {
        $conn = $this->conn;
        $sql = "";
        $sql .= "INSERT INTO ".$table;
        $sql .= " ($primary_key, ".implode(", ", array_keys($data)).") VALUES ";
        $sql .= "(seq_id.nextval, '".implode("', '", array_values($data))."')";
        $query = oci_parse($conn, $sql);

        if(oci_execute($query)) return true;
        else return false;
    }
    

    //FETCH LOGIN USER DETAILS
    public function fetch_login_user($email, $pass) {
        $data=null;
        $conn = $this->conn;
        $sql = "SELECT * FROM USERS WHERE email='$email' AND password='$pass'";
        $query = oci_parse($conn, $sql);
        oci_execute($query);

        while($row = oci_fetch_assoc($query)) {
            $data = $row;
        }

        if($data) return $data;
        else return false;

    }

    //FETCH LOGIN TRADER DETAILS
    public function fetch_login_trader($name, $pass) {
        $data=null;
        $conn = $this->conn;
        $sql = "SELECT * FROM TRADER WHERE TRADER_NAME='$name' AND password='$pass'";
        $query = oci_parse($conn, $sql);
        oci_execute($query);

        while($row = oci_fetch_assoc($query)) {
            $data = $row;
        }

        if($data) return $data;
        else return false;

    }

    //CHECK COLUMNS VALUES
    public function check_column_data($table,$column,$column_data) {
        $data=[];
        $conn = $this->conn;
        $sql = "SELECT * FROM $table WHERE $column='$column_data'";
        $query = oci_parse($conn, $sql);
        oci_execute($query);

        while($row = oci_fetch_assoc($query)) {
            array_push($data, $row);
        }

        if(count($data) == 0)
        return false;
        else
        return $data;

    }

        //CHECK COLUMNS VALUES
        public function check_column_data2($table,$column1,$column_data1,$column2, $column_data2) {
            $data=[];
            $conn = $this->conn;
            $sql = "SELECT * FROM $table WHERE $column1='$column_data1' AND $column2='$column_data2'";
            $query = oci_parse($conn, $sql);
            oci_execute($query);
    
            while($row = oci_fetch_assoc($query)) {
                array_push($data, $row);
            }
    
            if(count($data) == 0)
            return false;
            else
            return $data;
    
        }

    public function edit_shop_info($data) {
        $conn = $this->conn;
        $sql = "";
        $sql .= "UPDATE SHOP SET ";
        $sql .= "SHOP_NAME = '" . $data['shop_name'] . "', SHOP_LOCATION = '" . $data['shop_location'];
        $sql .= "' WHERE SHOP_ID = ". $data['shop_id'];

        $query = oci_parse($conn, $sql);

        if(oci_execute($query)) return true;
        else return false;
    }

    public function edit_product_info($data) {
        $conn = $this->conn;
        $sql = "";
        $sql .= "UPDATE PRODUCT SET ";
        $sql .= "PRODUCT_NAME = '" . $data['product_name'] . "', DESCRIPTION = '" . $data['description'];
        $sql .= "', PRICE = '" . $data['price'] . "', STOCK = '" . $data['stock'];
        $sql .= "', MIN_ORDER = '" . $data['min_order'] . "' , PRODUCT_IMAGE = '" . $data['product_image'];
        $sql .= "', QUANTITY = '" . $data['quantity'] . "', ALLERGY_INFO = '" . $data['allergy_info'];
        $sql .= "', PRODUCT_TYPE_ID = '" . $data['product_type_id'] . "', MAX_ORDER = '" . $data['max_order'];
        $sql .= "' WHERE PRODUCT_ID = ". $data['product_id'];

        $query = oci_parse($conn, $sql);

        if(oci_execute($query)) return true;
        else return false;
    }
    public function edit_table_info($table, $column, $data, $key, $value) {
        $conn = $this->conn;
        $sql = "";
        $sql .= "UPDATE $table SET ";
        $sql .= "$column= '" . $data;
        $sql .= "' WHERE $key = ". $value;

        $query = oci_parse($conn, $sql);

        if(oci_execute($query)) return true;
        else return false;
    }
    public function edit_cart_info($data) {
        $conn = $this->conn;
        $sql = "";
        $sql .= "UPDATE cart SET ";
        $sql .= "QUANTITY= '" . $data['qtn'];
        $sql .= "' WHERE CART_ID = ". $data['cart_id'];

        $query = oci_parse($conn, $sql);

        if(oci_execute($query)) return true;
        else return false;
    }
    public function edit_product_qtn($data) {
        $conn = $this->conn;
        $sql = "";
        $sql .= "UPDATE product SET ";
        $sql .= "QUANTITY= '" . $data['qtn'];
        $sql .= "' WHERE product_id = ". $data['product_id'];

        $query = oci_parse($conn, $sql);

        if(oci_execute($query)) return true;
        else return false;
    }

    public function delete_record($table, $key, $value) {
        $conn = $this->conn;

        $sql = "DELETE $table WHERE $key = $value";

        $query = oci_parse($conn, $sql);

        if(oci_execute($query)) return true;
        else return false;
    }

    public function fetch_table_data($table) {
        $data = [];
        $conn = $this->conn;

        $sql = "SELECT * FROM $table";

        $query = oci_parse($conn, $sql);

        oci_execute($query);

        while($row = oci_fetch_assoc($query)) {
            array_push($data, $row);
        }

        if(count($data) == 0) return false;
        else return $data;
    }

    public function fetch_time_slots($day, $time) {
        $data = [];
        $conn = $this->conn;

        if($time < 10) {
            $sql = "SELECT * FROM COLLECTION_SLOT WHERE NOT DAY = '$day' AND SLOT_START=10 and SLOT_END=13";
        }
        else if($time > 19) {
            $sql = "SELECT * FROM COLLECTION_SLOT WHERE NOT DAY = '$day' AND SLOT_START=16 and SLOT_END=19";
        }
        else {
            $sql = "SELECT * FROM COLLECTION_SLOT WHERE NOT DAY = '$day' AND SLOT_START<=$time and SLOT_END>$time";
        }


        $query = oci_parse($conn, $sql);

        oci_execute($query);

        while($row = oci_fetch_assoc($query)) {
            array_push($data, $row);
        }

        if(count($data) == 0) return false;
        else return $data;
    }
    public function sort_product($value, $sort) {
        $data = [];
        $conn = $this->conn;

        if($sort == 1) {
            $sql = "SELECT * FROM product WHERE product_type_id = $value order by price desc";
        }
        else if($sort ==2) {
            $sql = "SELECT * FROM product WHERE product_type_id = $value order by price asc";
        }
        $query = oci_parse($conn, $sql);

        oci_execute($query);

        while($row = oci_fetch_assoc($query)) {
            array_push($data, $row);
        }

        if(count($data) == 0) return false;
        else return $data;
    
    }

    public function sort_product_all($sort, $type) {
        $data = [];
        $conn = $this->conn;

        if($sort == 1) {
            $sql = "SELECT * FROM PRODUCT where product_type_id IN(";
            $sql .=implode(",",  $type);
            $sql .= ") order by price desc";
        }
        else if($sort ==2) {
            $sql = "SELECT * FROM PRODUCT where product_type_id IN(";
            $sql .=implode(",",  $type);
            $sql .= ") order by price asc";
        }
        $query = oci_parse($conn, $sql);

        oci_execute($query);

        while($row = oci_fetch_assoc($query)) {
            array_push($data, $row);
        }

        if(count($data) == 0) return false;
        else return $data;
    
    }

    public function slot_update($slot_id, $value) {
        $conn = $this->conn;
        $sql= "";
        $sql .= "UPDATE collection_slot SET ";
        $sql .= "AVAILABLE= " . $value;
        $sql .= " WHERE slot_id = ". $slot_id;

        $query = oci_parse($conn, $sql);

        if(oci_execute($query)) return true;
        else return false;
    }

    public function slot_fetch($date, $time) {
        $conn = $this->conn;
        $sql = "SELECT * FROM COLLECTION_SLOT WHERE SLOT_DATE ='$date' AND SLOT_TIME = '$time'";
        $query = oci_parse($conn, $sql);
        $data = [];

        oci_execute($query);

        while($row = oci_fetch_assoc($query)) {
            array_push($data, $row);
        }

        if(count($data) == 0) return false;
        else return $data;
    }

    public function fetch_search_item($searchitem){
        $data = [];
        $conn = $this->conn;
        $sql = "SELECT * FROM product where UPPER(product_name) LIKE '$searchitem%' OR UPPER(product_name)='$searchitem'";
        $query = oci_parse($conn, $sql);
        oci_execute($query);

        while($row = oci_fetch_assoc($query)) {
            array_push($data, $row);
        }

        if(count($data) == 0) return false;
        else return $data;

    }

    public function fetch_view_data($view_name, $id) {
        $data = [];
        $conn = $this->conn;
        $sql = "SELECT * FROM $view_name where trader_id = $id";
        
        $query = oci_parse($conn, $sql);
        oci_execute($query);

        while($row = oci_fetch_assoc($query)) {
            array_push($data, $row);
        }

        if(count($data) == 0) return false;
        else return $data;
    }
    public function trader_product_sales($trader_id,$sort_by) {
        $data = [];
        $conn = $this->conn;
        if($sort_by == 1) {
            $sql = "SELECT
            p.product_name  as product_name,
            nvl(SUM(a.price * a.quantity),0) order_total,
            count(a.order_id) as order_cnt
            FROM
                trader_orders a,
                product p
            WHERE
                p.product_id = a.product_id and a.trader_id = $trader_id
            GROUP BY
                p.product_id,
                p.product_name
            ORDER BY
                p.product_name asc";
        }
        else if($sort_by ==2) {
            $sql = "SELECT
            p.product_name  as product_name,
            nvl(SUM(a.price * a.quantity),0) as order_total,
            count(a.order_id) as order_cnt
            FROM
                trader_orders a,
                product p
            WHERE
                p.product_id = a.product_id and a.trader_id = $trader_id
            GROUP BY
                p.product_id,
                p.product_name
            ORDER BY
                order_total desc";
        }
        else {
            $sql = "SELECT
            p.product_name  as product_name,
            nvl(SUM(a.price * a.quantity),0) as order_total,
            count(a.order_id) as order_cnt
            FROM
                trader_orders a,
                product p
            WHERE
                p.product_id = a.product_id and a.trader_id = $trader_id
            GROUP BY
                p.product_id,
                p.product_name
            ORDER BY
                3 desc";
        }


        $query = oci_parse($conn, $sql);
        oci_execute($query);

        while($row = oci_fetch_assoc($query)) {
            array_push($data, $row);
        }

        if(count($data) == 0) return false;
        else return $data;

    }
}


$crud = new CrudOperation;
