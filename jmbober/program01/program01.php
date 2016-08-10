<?php 
require ("database.php"); 
session_start(); 


class Customer { 

    private static $id; 
    private static $name; 
    private static $email; 
    private static $mobile; 

    //displays records with options to read, update, or delete 
    public function displayRecords () { 
     
        $pdo = Database::connect(); 
        $sql = 'SELECT * FROM customers1 ORDER BY id DESC'; 
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
         
        foreach ($pdo->query($sql) as $row) { 
            echo '<tr>'; 
            echo '<td>'. $row['name'] . '</td>'; 
            echo '<td>'. $row['email'] . '</td>'; 
            echo '<td>'. $row['mobile'] . '</td>'; 
            echo '<td width=250>'; 
            echo '<a class="btn" href="read.php?id='. $row['id'].'">Read</a>'; 
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
        Database::disconnect(); 
    } 
   
     
    function displayCreateButton() { 
        echo "<a href='create.php?create=yes' class='btn btn-success'>Create New Record</a><br /><br />";   
    } 

} 

$cust1 = new Customer; 
echo "<h1>Object-oriented CRUD application</h1><br />"; 
$cust1->displayCreateButton(); 
$cust1->displayRecords(); 

if ($_GET['empl_id'] == 1) $cust1->login(1); 
if ($_GET['empl_id'] == 2) $cust1->login(2); 
if ($_GET['deleteFreds'] == 'yes') $cust1->deleteAllFreds(); 

echo "<br /><br /><br />"; 
print_r ($_SESSION); 
echo "<br /><br /><br />"; 


?>