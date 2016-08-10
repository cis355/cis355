<?php 
require ("crud/database.php"); 

/**
* Class object for musicans 
* includes method for spitting out JSON DATA
*/
class Musician { 


	//https://www.lucidchart.com/documents/edit/6e4d058e-c5cf-425e-8df1-899ab5b62051#?=undefined
	/**
	* returns the data from the musicians table as JSON 
	*/
    public function getJSONMusician () { 
		$data = '';
		
		//start our object block
        $data = $data . '{';  
        $data = $data . '"musicians":'; 
        $data = $data . '['; 
		
		//connect to the database
		
        $pdo = Database::connect(); 
		
        $sql = 'SELECT * FROM musicians ORDER BY id DESC'; 
         
		//building our JSON string
        foreach ($pdo->query($sql) as $row) {
            $data = $data . '{'; 
            $data = $data .  '"id":"'. $row['id'] . '", '; 
            $data = $data .  '"name":"'. $row['name'] . '",'; 
            $data = $data .  '"indataument":"'. $row['indataument'] . '",'; 
            $data = $data .  '"email":"'. $row['email']. '"';
            $data = $data .  '},'; 
        } 
		
        $data = substr($data, 0, -1); // remove last comma 
		//gives back the data
        echo $data; 
         
		 
        Database::disconnect(); 
        //closes our array and object block
		echo ']'; 
        echo '}'; 
    }   
} 
 
//instance of our Musician object
$musician = new Musician; 
//calls the method to return JSON musician data
$musician->getJSONMusician(); 
show_source(__FILE__);
?>