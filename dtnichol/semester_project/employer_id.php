<?php
require ("crud/database.php");
session_start();

class Customer {
	private static $id;
	private static $name;
	private static $email;
	private static $mobile;
	
	
	
	
	
		
		
		
		   foreach ($pdo->query($sql) as $row) {
						echo '<tr>';
						echo '<td>'. $row['name'] . '</td>';
						echo '<td>'. $row['email'] . '</td>';
						echo '<td>'. $row['mobile'] . '</td>';
						echo '<td width=350>';
						echo '<a class="btn" href="read.php?id='.
						$row['id'].'">Read</a>';
						echo '&nbsp;';
						if ($_SESSION['id'] == $row['id']) {
							echo '<a class="btn btn-success" 
							href="update.php?id='.$row['id'].'">Update</a>';
							echo '&nbsp;';
							echo '<a class="btn btn-danger" 
							href="delete.php?id='.$row['id'].'">Delete</a>';
						}
						echo '&nbsp;';
						echo '<a class="btn" href="ratingsList.php?id='.$row['id'].'">Rate</a>';
						echo '</td>';
						echo '</tr>';
					   }
					   echo '</tbody></table>';
					   
					   Database::disconnect();
		
	}
	
	
	
	
	
	
	

	function login ($empl_id){
		$_SESSION['id'] = $empl_id;
		
	}

	
	
}

$cust1 = new Customer;
$cust1->insertFred();
$cust1->displayDeleteFredButton();
$cust1->displayLoginButton();
if ($_GET['id'] == 1) $cust1->login(1);
if ($_GET['deleteFreds'] == 'yes') $cust1->deleteAllFreds();
$cust1->displayRecords();
echo "<br />";
print_r($_SESSION);



?>