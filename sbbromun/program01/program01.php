<?php 
require ("database.php"); 
session_start(); 

class Customer { 
	//Private Data members
    private static $id; 
    private static $name; 
    private static $email; 
    private static $mobile; 
    
	//Function prints out table and buttons read, update, and delete.
    public function displayRecords () { 
		//connect to database and set up sql
        $pdo = Database::connect(); 
        $sql = 'SELECT * FROM customers ORDER BY id DESC'; 
		//echo table out.
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
         //print each row of records
        foreach ($pdo->query($sql) as $row) { 
            echo '<tr>'; 
            echo '<td>'. $row['name'] . '</td>'; 
            echo '<td>'. $row['email'] . '</td>'; 
            echo '<td>'. $row['mobile'] . '</td>'; 
            echo '<td width=250>'; 
			//these are the buttons
			echo '<a class="btn" href="read.php?id='. $row['id'].'">Read</a>  ';
			echo '<a class="btn" href="update.php?id=' . $row['id'].'">Update  </a>  ';
			echo '<a class="btn" href="delete.php?id=' . $row['id'].'">Delete  </a>  ';
			
            echo '&nbsp;'; 
            echo '</td>'; 
            echo '</tr>'; 
        } 
        echo '</tbody></table>'; 
        Database::disconnect(); 
    } 
 
	function displayCreateButton () {
		echo "<a href='create.php?create=yes' class='btn btn-success'>Create New Record</a><br />";
	} 
}

$cust1 = new Customer; 
echo "Object-oriented CRUD application <br />";
$cust1->displayCreateButton();
$cust1->displayRecords(); 

 


?>