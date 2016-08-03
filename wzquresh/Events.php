<?php
//Purpose: Add new event data to the database table Event
//PreConditions: Date and Title should have POST values
//Input: eventDate, eventTitle, eventDescription.
//Output: None.
//PostConditions: Entered data added to table Event.

//Define how the database connects
require ("crud/database.php");
session_start();

  class Events{
    private static $eventDate;
    private static $eventTitle;
    private static $eventDescription;
    
    
    public function displayEventsTable () {
      $mysqli = new mysqli("localhost", "wzquresh", "446287", "wzquresh");
      $sql = "SELECT * FROM Event ORDER BY id";
      $result = mysqli_query($mysqli, $sql);
      echo '<table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Event Date</th>
              <th>Event Title</th>
              <th>Event Description</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>';
      while ($row = $result->fetch_assoc()) {
        //echo " id = " . $row['id'] . "\n";
        echo '<tr>';
        echo '<td>'. $row['eventDate'] . '</td>';
        echo '<td>'. $row['eventTitle'] . '</td>';
        echo '<td>'. $row['eventDescription'] . '</td>';
        echo '<td width=250>';
        echo '<a class="btn btn-info" href="readEvent.php?id='. $row['id'].'">Read</a>';
        echo '&nbsp;';
        if ($_SESSION['empl_id'] == $row['employer_id']) {
          echo '<a class="btn btn-success" 
             href="updateEvent.php?id='.$row['id'].'">Update</a>';
          echo '&nbsp;';
          echo '<a class="btn btn-danger" 
             href="deleteEvent.php?id='.$row['id'].'">Delete</a>';
        }
        echo '</td>';
        echo '</tr>';
      }
      echo '</tbody></table>';
      Database::disconnect();
    }
    
    function __construct () {
	
	}
  
    function displayCreateScreen(){
      echo "<a href='createEvent.php' class='btn btn-primary'>Create</a><br/>";
    }
    
  }
  
echo '<html lang="en">
        <head>
            <meta charset="utf-8">
            <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        </head>';
echo    '<body>';
//Create a new customer object
$event1 = new Events();
//Display the button to create a new users
$event1->displayCreateScreen();
//Display the records
echo '<div class="container">';
  echo '<div class="panel panel-primary">';
    echo '<div class="panel-heading">Events Table</div>';
    echo '<div class="panel-body">';
      $event1->displayEventsTable();
    echo '</div>';
  echo '</div>';
echo '</div>';


echo "<br/><br/><br/>";
print_r ($_SESSION);
echo "<br/><br/><br/>";
echo "<br/><br/>";
echo '</body>';
echo '</html>';
echo '<br/><br/><br/>';
  
  
  
  
show_source(__FILE__); 
?>