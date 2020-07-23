<?php 
class Dbh {
    public $conn; 
    
    public function __construct() {
        $this->conn = oci_connect('ignite_portal', 'Bishant123', '//localhost/xe');
        
        if(!$this->conn) {
            echo "Error Connecting to the database";
        }
    }

}

?>
