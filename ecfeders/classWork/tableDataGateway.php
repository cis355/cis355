<?php
	require ("../crud/database.php");
	session_start();

	class customer {
		private static $id;
		private static $name;
		private static $email;
		private static $mobile;
		private static $deleteFreds;
		
		public function insertFred () { 
     
        $name = "Fred"; 
        $email = "fred@fred.com"; 
        $mobile = "123.456.7890"; 
     
        $pdo = Database::connect(); 
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        $sql = "INSERT INTO customers (name,email,mobile) values(?, ?, ?)"; 
        $q = $pdo->prepare($sql); 
        $q->execute(array($name,$email,$mobile)); 
        Database::disconnect(); 
        // header("Location: tdg.php"); 
     
    } 
     
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
         
        foreach ($pdo->query($sql) as $row) { 
            echo '<tr>'; 
            echo '<td>'. $row['name'] . '</td>'; 
            echo '<td>'. $row['email'] . '</td>'; 
            echo '<td>'. $row['mobile'] . '</td>'; 
            echo '<td width=250>'; 
            echo '<a class="btn" href="../crud/read.php?id='. $row['id'].'">Read</a>'; 
            echo '&nbsp;'; 
			if($_SESSION['empl_id'] == $row['empl_id']){
				echo '<a class="btn btn-success"  
					href="../crud/update.php?id='.$row['id'].'">Update</a>'; 
				echo '&nbsp;'; 
				echo '<a class="btn btn-danger"  
					href="../crud/delete.php?id='.$row['id'].'">Delete</a>'; 
			}
				echo '</td>'; 
				echo '</tr>';
        } 
        echo '</tbody></table>'; 
        Database::disconnect(); 
    } 
     
    function deleteAllFreds() { 
     
        $name = "Fred"; 
        $pdo = Database::connect(); 
        $sql = "DELETE FROM customers WHERE name = ?"; 
        $q = $pdo->prepare($sql); 
        $q->execute(array($name)); 
        Database::disconnect(); 
         
    } 
     
    function displayDeleteFredButton () { 
     
        echo "<a href='tableDataGateway.php?deleteFreds=yes' class='btn btn-success'>Delete All Freds!!</a><br />"; 
     
    } 
	
	function displayCreateButton () { 
     
        echo "<a href='../crud/create.php?create=yes' class='btn btn-success'>Create New Record</a><br />"; 
     
    }
    
	
	function login0($empl_id){
		$_SESSION['empl_id'] = $empl_id;
	}
	
	function displayLoginButton () { 
     
        echo "<a href='tableDataGateway.php?empl_id=1' class='btn btn-success'>Set Eompl ID to One</a><br />"; 
     
    } 
	
	function displayLoginButton2 () { 
     
        echo "<a href='tableDataGateway.php?empl_id=0' class='btn btn-success'>Set Eompl ID to Zero</a><br />"; 
     
    } 

} 


	$cust1 = new Customer;
	$cust1->displayDeleteFredButton();
	$cust1->displayCreateButton();
	$cust1->displayLoginButton();
	$cust1->displayLoginButton2();
	if($_GET['deleteFreds'] == 'yes'){
		$cust1->deleteAllFreds();
	}
	if($_GET['create'] == 'yes'){
		$cust1->insertFred();
	}
	if($_GET['empl_id'] == 1){
		$cust1->login0(1);
	}
	if($_GET['empl_id'] == 0){
		$cust1->login0(0);
	}
	$cust1->displayRecords();
    echo "</br>";
	
	show_source (__FILE__);

?>