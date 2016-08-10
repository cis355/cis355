<?php
//Created By: Waqas Qureshi
//Course: CIS 355
//Professor: Dr. George Corser
//Purpose: Returns a JSON object of the Event table

require ("crud/database.php");
session_start();

class EventsJSON{
   //Purpose: displays JSON object
   //Input: None
   //Precondition: Events table should exist
   //Output: JSON 
   //PostCondition: None
  public function displayJSON(){
    $info=array();
    $mysqli = new mysqli("localhost", "wzquresh", "446287", "wzquresh");
    $sql = "SELECT * FROM Event";
    $result = mysqli_query($mysqli, $sql);
    
    while ($row = $result->fetch_assoc()){
      $info[] = $row;
    }
    echo json_encode($info);
  }
  
  function __construct () {
	
  }
}

echo '<html lang="en">
        <head>
            <meta charset="utf-8">
            <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        </head>';
echo    '<body>';

//Create new EventsJSON object.
$eventJSON = new EventsJSON();
//Function to display the object.
$eventJSON->displayJSON();

echo "<br/><br/>";

echo "<a href='Qureshi_EventsJSONDiagram.png' class='btn btn-success'>EventsJSON UML Diagram</a>";

echo "<br/><br/>";
echo '</body>';
echo '</html>';
show_source(__FILE__);
?>