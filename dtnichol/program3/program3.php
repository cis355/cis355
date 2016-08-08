<!--/* *******************************************************************
* filename : program3.php
* author : Derek Nichols
* username : dtnichol
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : This program just outputs the Bands table contents as a JSON object.
*
* input : no input for this file
* processing : The program steps are as follows.
* 		1. instantiate class
* 		2. function to print out Bands table as JSON object
* 		
* 		
* output : prints the table onto the website as JSON object 
*
* precondition : must instantiate a new class to begin and have information in the table
* postcondition: information printed to the screen as JSON object
* 				 
* *******************************************************************
*/-->

<?php
require ("database.php");
//create class band
class Band {
	private static $id;
	private static $name;
	private static $homeTown;
	private static $genre;
	
	public function outputJSON () {
	echo '{'; //begin the object
	echo '"Bands":';
	echo '[';
	
		$pdo = Database::connect();
		$sql = 'SELECT * FROM Bands ORDER BY id DESC';
		
		
		
		$str = '';
		   foreach ($pdo->query($sql) as $row) {
						$str .= '{';
						$str .= '"id":"'. $row['id'] . '", ';
						$str .= '"name":"'. $row['name'] . '", ';
						$str .= '"Home Town":"'. $row['homeTown'] . '", ';
						$str .= '"Genre":"'. $row['Genre'] . '"';
						$str .= '},';
						
		   }
		$str =	substr($str, 0, -1); // remove last comma		
			echo $str;			
						
						
					   
					   Database::disconnect();
	echo ']';	//close the array			   
	echo '}'; //end the object
		
	}
}

$band = new Band; //instantiates class
echo "<a class='btn' href='program3UML.png'>UML Class Diagram</a>";
echo "<br /><br />";
$band->outputJSON(); //outputs table as JSON object
echo "<br /><br />";
show_source(__FILE__);
?>