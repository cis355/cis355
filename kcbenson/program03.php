<?php
/* *******************************************************************
* filename : program03.php
* author : Kelsi Benson
* username : kcbenson
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : The purpose of this program is to 
* demonstrate the knowledge of JSON objects.
* 
*
* input : records from database
* processing : The program steps are as follows.
* 1. connect to the database
* 2. put records into a JSON object
* 3. display the JSON object
*
* *******************************************************************
*/

class Gig {
		
		private static $bandID;
		private static $venueID;
		private static $date;
		private static $time;
		
		public function outputJSON () { 
			
			echo'{'; //begin the object
			echo '"gigs":';
			echo '['; //begin the array
			
			
			$con = mysqli_connect('localhost','kcbenson','Kelsi42B','kcbenson');
			$sql = 'SELECT * FROM gigs ORDER BY id DESC'; 
			$str = '';
			foreach ($con->query($sql) as $row) { 
				$str.= '{'; 
				$str.= '"bandID":"'. $row['bandID'] . '",'; 
				$str.= '"venueID":"'. $row['venueID'] . '",'; 
				$str.= '"date":"'. $row['date'] . '",'; 
				$str.= '"time":"'. $row['time'] . '"'; 
				$str.= '},'; 
			}
			$str = substr($str, 0, -1); //remove last comma
			echo $str;
			mysqli_close($con); 
			echo ']'; //close the array
			echo '}'; //close the object
		} 
	}
$gig1 = new Gig;
$gig1->outputJSON();
echo '<br /><br /><br />';
echo '<a href = "https://www.draw.io/?chrome=0&lightbox=1&edit=https%3A%2F%2Fwww.draw.io%2F%23DProgram02.html&nav=1#DProgram02.html">UML diagram</a>';
echo '<br /><br />';
show_source(__FILE__);

?>