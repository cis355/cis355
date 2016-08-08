<?php
    session_start();
    if(empty($_SESSION['name'])) header("Location: login.php");
?>


<?php 
require ("../crud/database.php"); 

class Customer { 

    private static $id; 
    private static $name; 
    private static $email; 
    private static $mobile; 

    // Add project title to the page
    public function displayTitle() {
        echo '<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">';
        echo '<div class="col-xs-12">';
        echo '<div class="page-header">
                <h1>Program 01<small> CRUD TUTORIAL</small></h1>
              </div>';
    }

    // Add the name of the user currently logged in and display the logout button
    public function displayUser() {
        // Display username
        echo '<div class="row">
                <div class="col-xs-6">
                <p>User: '.($_SESSION['name']).'</p> 
              </div>';

        // Logout button
        echo '<div class="col-xs-6 text-right">
                <a class="btn btn-info" href="logout.php">Logout</a>
              </div>';
        echo '</div>';
    }

    // Add the insert cusomer button to the page
    public function displayInsert() {
        echo '<a class="btn btn-info"  
                   href="create.php">Insert Customer</a>';
        echo '<br><br>'; 
    }

    // Add all records from the customers table to the page
    public function displayRecords() { 
     
        $pdo = Database::connect();  // Connect to the database
        $sql = 'SELECT * FROM customers ORDER BY id DESC';  // Select all customers

        // Display table
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
        
        // Display each customer index in the table
        foreach ($pdo->query($sql) as $row) { 
            echo '<tr>'; 
            echo '<td>'. $row['name'] . '</td>'; 
            echo '<td>'. $row['email'] . '</td>'; 
            echo '<td>'. $row['mobile'] . '</td>'; 
            echo '<td width=250>'; 
            echo '<a class="btn btn-primary" href="read.php?id='. $row['id'].'">Read</a>'; 
            echo '&nbsp;'; 
            echo '<a class="btn btn-success"  
               href="update.php?id='.$row['id'].'">Update</a>'; 
            echo '&nbsp;'; 
            echo '<a class="btn btn-danger"  
               href="delete.php?id='.$row['id'].'">Delete</a>'; 
            echo '</td>'; 
            echo '</tr>'; 
        } 
        echo '</tbody></table>'; 
        echo '</div>';
        Database::disconnect();  // Disconnect from database
    } 
} 

// Create a customer object
$cust1 = new Customer; 
$cust1->displayTitle();     // Call page title
$cust1->displayUser();      // Call current user
$cust1->displayInsert();    // Call insert button 
$cust1->displayRecords();   // Call customer records  
show_source(__FILE__); 
?>