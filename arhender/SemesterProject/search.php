<?php
/* *******************************************************************
 filename     : search.php  
 author       : Adam Henderson  
 username     : arhender 
 course       : cs355  
 section      : 11-MW  
 semester     : Summer 2016  
 description  : This file contains the logic to return all mentors in the mentor table
Input         : n/a

Process:
1. if you are a mentor redirect, otherwise:
2. select all users from mentor
3. output table showing user mentor firstname last name as a hyperlink
Output: a table showing all mentors
Precondition: User must be a student
Postcondition: only mentors will be shown in the table
*********************************************************************  */
require "sessioncheck.php";
require "database.php";
include "header.php";

if($_SESSION['LoginType']=="Mentors")
{
	
	header("Location: Profile.php?user=" . $_SESSION['name']);
	
}


					
					  
					   $pdo = Database::connect();
					   # assign select statement to variable
					   $sql = "SELECT * FROM Mentors";
					   # iterates through every record return by the select statement
					   
	 	              	
						
		echo "</br></br>
		<table class='table table-striped table-bordered'>
		              <thead>
		                <tr>
		                  <th>Name</th>
		                </tr>
		              </thead>
		              <tbody>";
                     		
							
						
					   foreach ($pdo->query($sql) as $row) 
					   {
						#for each mentor record returned echo out the row as an href that will lead to the user profile
						   
         					    echo '<tr>';
								
							   	echo "<td><a href='Profile.php?user=" . $row['Username'] . "'>" . $row['FirstName']. " " . $row['LastName'] ."</a></td>";
							   	
								echo '</tr>';
								
	
					  }
					 
					
					
			
				
					 Database::disconnect();
					 
			
					 

				

					


?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<?php echo "<title>" . $Userinfo['FirstName'] . " " . $Userinfo['LastName'] . "</title>";?>
	<link rel="stylesheet" type="text/css" href="global.css" />
</head>


	
	
	
