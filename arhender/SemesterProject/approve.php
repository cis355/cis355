<?php
/* *******************************************************************
 filename     : approve.php  
 author       : Adam Henderson  
 username     : arhender 
 course       : cs355  
 section      : 11-MW  
 semester     : Summer 2016  
 description  : This file contains the logic to handle approving a pending
				mentorship
Input         : get variable that is the connection id

Process:
1. Check if the get variable is empty and that the person logged in is a mentor
2. Grab the id from the url
3. grab the record with the connection tuid with a query
4. read your own info from the mentors table
5. check and see if your id matches the mentorsid in the connection record
6. if it does and the record isn't empty there is a valid connection that you are involved in
7. update the connection to make it active
8. redirect to the pending mentorships page, if it isn't involved redirect to profile
9. if the get is empty or you arent a mentor redirect to your profile as well

Output: updated connection in the database to active
Precondition: Connection exists in the database, user is a mentor, user is involved in connection
Postcondition: Database record is changed
*********************************************************************  */

require "sessioncheck.php";
require "database.php";

if(!empty($_GET) and $_SESSION['LoginType']=="Mentors") #only mentors can approve 
{
	
			$id = $_GET['id']; #get the id

#read the connection in question
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "Select * from Connections WHERE ConnectionTuid = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($id));
			$data = $q->fetch(PDO::FETCH_ASSOC);
			Database::disconnect();
		
		
					   
				
						   #read your own info
						   $myinfo = Database::readuser($_SESSION['name']);
						  #if you are related in the connection and the connection exists
						  if($data['MentorTuid'] == $myinfo['Tuid'] && !empty($data))
						   {
							  
							  #activate the connection and redirect
							  Database::updateconnection($id); 
							  header("Location: pendingmentorships.php");
							  
						   }
						   else
						   {
							    #otherwise redirect to profile
							   header("Location: Profile.php?user=" . $_SESSION['name']);
							   
						   }

						  

}
else{
	#otherwise redirect to profile
	header("Location: Profile.php?user=" . $_SESSION['name']);
	
	
	
}






?>