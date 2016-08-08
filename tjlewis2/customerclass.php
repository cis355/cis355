<?php 
require ("crud/database.php"); 
session_start(); 

class Customer { 

    private static $id; 
    private static $name; 
    private static $email; 
    private static $mobile; 
    private static $deleteFreds; 
     
	 
	public function deleteCustomer($name) {
		#connecting to the database
		$pdo = Database::connect(); 
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
		
		//$sql statement that will delete the record where the passed name matches with the one in the database
        $sql = "DELETE FROM Customer WHERE name = '$name'"; 
        $q = $pdo->prepare($sql); 
		
		#executing the delete statement
        $q->execute(array($name)); 
        Database::disconnect(); 
	

	public function updateCustomer($name, $email, $mobile) {
		#updates the customer with the given values passed in
		
		$pdo = Database::connect(); 
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

		#finds where the name matches and updates the values in currently in the database
        $sql = "UPDATE customers SET name = '$name', email ='$email', mobile='$mobile' WHERE name = '$name'"; 
        $q = $pdo->prepare($sql); 
        $q->execute(array($name,$email,$mobile)); 
        Database::disconnect(); 
		
	public function readCustomer() {
	#reads all customers in the database
	
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
         
		
		foreach ($pdo->query($sql) as $row) { 
            echo '<tr>'; 
            echo '<td>'. $row['name'] . '</td>'; 
            echo '<td>'. $row['email'] . '</td>'; 
            echo '<td>'. $row['mobile'] . '</td>'; 
            echo '<td width=250>'; 
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
	{
	
	#inserts a customer in to the database with their name, email, and mobile
	public function insertCustomer($name, $email, $mobile) {
	
		$pdo = Database::connect(); 
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        $sql = "INSERT INTO customers (name,email,mobile) values(?, ?, ?)"; 
        $q = $pdo->prepare($sql); 
        $q->execute(array($name,$email,$mobile)); 
        Database::disconnect(); 
        // header("Location: tdg.php"); 
	
	}
	
   
     
    function displayDeleteFredButton () { 
     
        echo "<a href='tdg.php?deleteFreds=yes' class='btn btn-success'>Delete All Freds!!</a><br />"; 
     
    } 
     
    function displayLoginButton () { 
     
        echo "<a href='tdg.php?empl_id=1' class='btn btn-success'>Set Empl ID to One</a><br />"; 
     
    } 
     
    function __construct () { 
     
        $deleteFreds = $_GET['deleteFreds']; 
     
    } 
     
    function login ($empl_id) { 
        $_SESSION['empl_id'] = $empl_id;  
    } 

} 

$cust1 = new Customer; 
$cust1->insertFred(); 
$cust1->displayDeleteFredButton(); 
$cust1->displayLoginButton(); 
if ($_GET['empl_id'] == 1) $cust1->login(1); 
if ($_GET['empl_id'] == 2) $cust1->login(2); 
if ($_GET['deleteFreds'] == 'yes') $cust1->deleteAllFreds(); 
$cust1->displayRecords(); 
echo "<br /><br /><br />"; 
print_r ($_SESSION); 
echo "<br /><br /><br />"; 











show_source(__FILE__); 
?>