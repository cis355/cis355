<?php
require("crud/database.php");

class Customer { 

    private static $id; 
    private static $name; 
    private static $email; 
    private static $mobile; 
    
     public function outputJSON () { 
     
      echo '{'; //begin object
      echo '"customers1":';
      echo '['; //begin array
      
      
      $pdo = Database::connect(); 
      $sql = 'SELECT * FROM customers1 ORDER BY id DESC'; 
      
    
        $str = '';
        foreach ($pdo->query($sql) as $row) { 
            $str .= '{'; 
            $str .=  '"id":"'. $row['id'] . '", '; 
            $str .=  '"name":"'. $row['name'] . '",'; 
            $str .=  '"email":"'. $row['email'] . '",'; 
            $str .=  '"mobile":"'. $row['mobile']. '"';; 
            $str .=  '},'; 
            }
            $str = substr($str, 0, -1);
            echo $str; 
         
        Database::disconnect(); 
        
        echo ']'; //close array
        echo '}'; //close object
    } 
}

$cust = new Customer;
$cust->outputJSON();
echo '<br /><br /><br />'; 

show_source(__FILE__); 
?>