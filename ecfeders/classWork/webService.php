<?php 
require ("../crud/database.php"); 

class Registrations { 
    // Member data
    private static $id; 
    private static $class; 
    private static $startTime; 
	private static $endTime; 
    private static $day; 
     
	 //Output JSON and make it
    public function outputJSON () { 
     
        echo '{'; // begin the object 
        echo '"customers":'; 
        echo '['; // begin the array 
        
		//Connect
        $pdo = Database::connect(); 
        $sql = 'SELECT * FROM registrations ORDER BY id DESC'; 
         
        $str = ''; 
		//For each listed
        foreach ($pdo->query($sql) as $row) { 
            $str .= '{'; 
            $str .=  '"id":"'. $row['id'] . '", '; 
            $str .=  '"name":"'. $row['class'] . '",'; 
			$str .=  '"name":"'. $row['startTime'] . '",'; 
            $str .=  '"email":"'. $row['endTime'] . '",'; 
            $str .=  '"mobile":"'. $row['day']. '"';; 
            $str .=  '},'; 
        } 
		
        $str = substr($str, 0, -1); // remove last comma 
        echo $str; 
         //Disconnect
        Database::disconnect(); 
        echo ']'; // close the array 
        echo '}'; // close the object 
    } 
     
} 

//Create Instantiation
$regist = new Registrations; 
//Call Function
$regist->outputJSON(); 
echo '<br /><br /><br />'; 
show_source(__FILE__); 
?>