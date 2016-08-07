<?php
/* *******************************************************************
 filename     : delete.php  
 author       : Adam Henderson  
 username     : arhender 
 course       : cs355  
 section      : 11-MW  
 semester     : Summer 2016  
 description  : This file contains the logic to handle denying a pending
				mentorship
Input         : get variable that is the connection id

Process:
1. Check if the get variable is empty
2. Grab the id from the url
3. grab the record with the connection tuid with a query
4. read your own info
5. check and see if your id matches the mentorsid, or studentsid in the connection record
6. if it does and the record isn't empty there is a valid connection that you are involved in
7. delete the connection
8. redirect to the pendingmentorships page, if it isn't involved redirect to profile
9. if the get is empty redirect to your profile as well

Output: updated connection in the database to active
Precondition: Connection exists in the database, user is a mentor, user is involved in connection
Postcondition: Database record is changed
*********************************************************************  */

require "sessioncheck.php";
require "database.php";

if(!empty($_GET))
{
	 #grab the get variable
			$id = $_GET['id'];

#grab the record for the connection
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "Select * from Connections WHERE ConnectionTuid = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($id));
			$data = $q->fetch(PDO::FETCH_ASSOC);
			Database::disconnect();
		
		
					   
				#read your own info
						   
						   $myinfo = Database::readuser($_SESSION['name']);
				#check if you are involved as a mentor OR student in the relationship		  
						  if($data['MentorTuid'] == $myinfo['Tuid'] && !empty($data))
						   {
							  
							  #if so delete the connection and redirect to pending mentorships
							  Database::deleteconnection($id); 
							  header("Location: pendingmentorships.php");
							  
						   }
						   elseif($data['StudTuid'] == $myinfo['Tuid']&& !empty($data))
						   {
							    #if so delete the connection and redirect to pending mentorships
							  Database::deleteconnection($id); 
							  header("Location: pendingmentorships.php");
						   }
						   else{
							   #otherwise redirect to your profile
							   header("Location: Profile.php?user=" . $_SESSION['name']);
						   }

						  

}
else{
	 #otherwise redirect to your profile
	header("Location: Profile.php?user=" . $_SESSION['name']);
	
	
}






?>