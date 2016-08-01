<?php 
// Includes the database in the php for use
require ("database.php"); 

//Starts a session
session_start(); 

//Creation of the class Customer
class Customer { 
	// id,name,email.mobile private variables
    private static $id; 
    private static $name; 
    private static $email; 
    private static $mobile; 

    //This function displays all of the records by:
	// connecting to the database, selecting the info, and creating a table.
    public function displayRecords () { 
     
        $pdo = Database::connect(); 
        $sql = 'SELECT * FROM customers ORDER BY id DESC'; 
        echo '<table class="table table-striped table-bordered"> 
                <thead> 
                <tr> 
                  <th>Name</th> 
                  <th>Email Address</th> 
                  <th>Mobile Number</th> 
                  <th>Action</th> 
                </tr> 
              </thead> 
              <tbody>'; 
         
		// This is where it loops through each entry in our tables
        foreach ($pdo->query($sql) as $row) { 
            echo '<tr>'; 
            echo '<td>'. $row['name'] . '</td>'; 
            echo '<td>'. $row['email'] . '</td>'; 
            echo '<td>'. $row['mobile'] . '</td>'; 
            echo '<td width=100>'; 
            echo '<a class="btn" href="read.php?id='. $row['id'].'">Read</a>'; 
            echo '&nbsp;'; 
            if ($_SESSION['empl_id'] == $row['employer_id']) { 
                echo '<a class="btn btn-success"  
                   href="update.php?id='.$row['id'].'">Update</a>'; 
                echo '&nbsp;'; 
                echo '<a class="btn btn-danger"  
                   href="delete.php?id='.$row['id'].'">Delete</a>'; 
            } 
            echo '</td>'; 
            echo '</tr>'; 
        } 
        echo '</tbody></table>'; 
        Database::disconnect(); 
    } 
     
     
	 
	// This function display the create new person button, it has a link to the create.php link for creation
	// of a new user.
	function displayCreateButton() {
		
		echo "<a href='create.php' class='btn btn-success'>Create a New Person!!</a><br />";
		
	} 
	
	// This function shows the read button to the right of each person.
	// This has a link to the read.php file where it shows the contents of the person.
	function readButton () { 
     
        echo "<a href='read.php' class='btn btn-success'></a><br />"; 
     
    } 
	
	// This function shows the update button to the right of each person.
	// This has a link to the update.php where it shows the create screen but with the original
	// contents from the user you choose and lets you change anything and update.
	function updateButton() {
		
		echo "<a href='update.php' class='btn btn-success'></a><br />"; 
	}
	
	// This function shows the delete button to the right of each person.
	// This has a link to the delete.php where it asks if you are sure about deleting.
	// Depending on whcih you choose if will delete the record or take you back.
	function deleteButton() {
		
		echo "<a href='delete.php' class='btn btn-success'></a><br />"; 
	}
} 

// Create a new instance of class Customer
$cust1 = new Customer; 
echo "BETZ PROGRAM 1";
echo "<br />";
echo "<br />";
// Display the create new person button
$cust1->displayCreateButton();
echo "<br />";
// display the record in your customer table
$cust1->displayRecords(); 

echo "<br />";
echo "<br />";

show_source(__FILE__); 
?>