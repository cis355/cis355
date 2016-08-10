<?php
/* *******************************************************************
 filename     : pendingmentorships.php  
 author       : Adam Henderson  
 username     : arhender 
 course       : cs355  
 section      : 11-MW  
 semester     : Summer 2016  
 description  : This file contains the logic to read and display all related connections that are not active
Input         : username from session variable

Process:
1. set noresults to false
2. Read your information
3. if you are a mentor the connection type is students and vice-versa
4. read all related connections to your account
5. loop through and display them in a table format with approve/deny if mentor and just deny if student
Output: table with all connections related to account
Precondition: table will only display if user has any connections in the Connections table that are not active
Postcondition: ability to update or delete a pending connection for a mentor, and delete a pending connection for a student
*********************************************************************  */
require "database.php";
require "sessioncheck.php";
include "header.php";



$noresults = false;
# database.php contains connection code, including connect and disconnect functions
#include 'database.php';
# connect to database and assign object to variable
					 


 #read your own account info and set connectiontype based on your logintype 				 
					 $myinfo = Database::readuser($_SESSION['name']);			  
                     if($_SESSION['LoginType']=="Mentors"){
						 $connectiontype = "Students";
						  
					 }
					 else
					 {
						 $connectiontype = "Mentors";
					 }
					  
	   
					 
     #read all connections related to your account which are not 
    $Relations = Database::readconnections($_SESSION['LoginType'],$connectiontype, $_SESSION['name'], 0);
	 	              
		echo "</br></br>
		<table class='table table-striped table-bordered'>
		              <thead>
		                <tr>
		                  <th>Name</th>
		                  <th>Action</th>
		                </tr>
		              </thead>
		              <tbody>";
                     		
							
							#echo out the html for the table, with the values for each connection placed in
							#each row
					   foreach ($Relations as $row) {
						
						   
         					    echo '<tr>';
							   	echo '<td>'. $row['FirstName'] . " " . $row['LastName'] . '</td>';
							   	echo '<td width=250>';
							   if($_SESSION['LoginType']=="Mentors"){echo '<a class="btn btn-success" 
							   href="approve.php?id='.$row['ConnectionTuid'].'">Approve</a>';}
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-danger" 
								   href="deny.php?id='.$row['ConnectionTuid'].'">Cancel</a>';
							   	echo '</td>';
							   	echo '</tr>';
								
						
					  }
					 
					
					
			
					#disconnect from the datbase
					 Database::disconnect();
					 				  
					 
	





?>


<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Pending Mentorship</title>
	<link rel="stylesheet" type="text/css" href="global.css" />
</head>

	
					 
					  