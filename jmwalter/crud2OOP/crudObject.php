<?php
require 'database.php';

class Customer { 
		//private data
   
     
	 
	 
	 function __construct () {  
     
    } 
	
    public function insertCustomer ($inputName,$inputEmail,$inputMobile) { 
        //this function takes in a user name, email and mobile and inserts the 
		// record into the database 
        $pdo = Database::connect(); 
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        $sql = "INSERT INTO customers (name,email,mobile) values(?, ?, ?)"; 
		// the sql statement to insert our record given an array of inputs
        $q = $pdo->prepare($sql); 
        $q->execute(array($inputName,$inputEmail,$inputMobile)); 
		// the array to input into our (?,?,?)
        Database::disconnect(); 
     
    } 
     
    public function displayCustomers () { 
		// this function will print our table with all records in our customers 
		// table and buttons to call differnet php files for read,update and delete
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
     
    function deleteCustomer($deleteId) { 
    //this function will delete the record from the customers table 
	// with the passed in id value gotten from the delete.php command line
    $pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM customers  WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($deleteId));
		Database::disconnect();      
    }  
		
		function updateCustomer ($inputName,$inputEmail,$inputMobile,$inputId)
		{
			// this function will update the information of the user with the id of the passed 
			// in $inputId value with the information passed over of name , email  and mobile
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE customers  set name = ?, email = ?, mobile =? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($inputName,$inputEmail,$inputMobile,$inputId));
			Database::disconnect();
		}
		
		function fillUpdateFields ($insertId)
		{	// i could not get this method to work... 
			// this was ment to flll in the fields of the update form if you click on the update 
			// button on a particular user 
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM customers where id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($id));
			$data = $q->fetch(PDO::FETCH_ASSOC);
			Database::disconnect();
			return array ($data['name'],$data['email'],$data['mobile']);

		
		}
		
		function readCustomerData ($insertId)
		{
			// this function, after the user clicks on the read button for a user 
			// will take that users id and pass that value to this function and read his select information
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM customers where id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($insertId));
			$result = $q->fetch(PDO::FETCH_ASSOC);
			$data = $result;
			Database::disconnect();
			
			// i was not able to pass $data back so i put the html in this 
			//function so that it will display the information we need
			
			echo "
			<!DOCTYPE html>
			<html lang='en'>
			<head>
				<meta charset='utf-8'>
				<link   href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' rel='stylesheet'>
				<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
			</head>

			<body>
				<div class='container'>
				
    			<div class='span10 offset1'>
    				<div class='row'>
		    			<h3>Read a Customer</h3>
		    		</div>
		    		
	    			<div class='form-horizontal' >
					  <div class='control-group'>
					    <label class='control-label'>Name</label>
					    <div class='controls'>
						    <label class='checkbox'>". $data['name'] .
								
									
						    "</label>
					    </div>
					  </div>
					  <div class='control-group'>
					    <label class='control-label'>Email Address</label>
					    <div class='controls'>
					      	<label class='checkbox'>
									
						     	" . $data['email'] . "
									
						    </label>
					    </div>
					  </div>
					  <div class='control-group'>
					    <label class='control-label'>Mobile Number</label>
					    <div class='controls'>
					      	<label class='checkbox'>" .
						     	 $data['mobile'] . "
			
						    </label>
					    </div>
					  </div>
					    <div class='form-actions'>
						  <a class='btn' href='index.php'>Back</a>
					   </div>
					
					 
					</div>
				</div>
				
				</div> <!-- /container -->
			  </body>
			</html>";	
		}
		
     
   
     

} 
?>