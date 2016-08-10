<?php
/* *******************************************************************
 filename     : RequestMentor.php  
 author       : Adam Henderson  
 username     : arhender 
 course       : cs355  
 section      : 11-MW  
 semester     : Summer 2016  
 description  : This file contains the logic to create an inactive connection in the Connections table
Input         : username from post variable

Process:
1. Check if post is empty and that the user requesting the mentorship is a student
2. if it is grab the post name which is the mentor name, and your own name
3. read your info
4. read the mentor info
5. if you attempting to request mentorship of a student, or their mentor profile doesnt exist, redirect to your profile
6. otherwise clear the post array
7. fill it with your tuid, and the mentortuid
8. call the create record function to create a record in the connections database
9. then redirect to the mentor profile you just requested
Output: an inactive record in the connections table
Precondition: User must be logged in,post variable must be valid username who is a mentor
Postcondition: Active attribute must be set to true to make the connections record active this is done from pendingmentorships.php
*********************************************************************  */

require 'database.php';
require 'sessioncheck.php';








if(!empty($_POST) and $_SESSION['LoginType']=="Students"){
$mentor = $_POST['name'];
$me = $_SESSION['name'];

#grab the values from post and session and then read both user records into variables

$mentorinfo = database::readuser($mentor, $Login);

$myinfo = database::readuser($me, $Login);

if($mentorinfo['LoginType']=="Students" or empty($mentorinfo))
{
	
   header("Location: Profile.php?user=" . $_SESSION['name']);
	
}



$_POST = array();

#clear the post array because it has the mentor name in it
#then add the mentortuid, your tuid, and a 0 to indicate inactive
$_POST['MentorTuid']=$mentorinfo['Tuid'];
$_POST['StudTuid']= $myinfo['Tuid'];
$_POST['Active']=0;


#call the createrecord to insert based on values in the get array
database::createrecord("Connections");

#redirect to the mentor profile
header("Location: Profile.php?user=" . $mentor);


}
else
{
	
	header("Location: Profile.php?user=" . $_SESSION['name']);
	
}



?>