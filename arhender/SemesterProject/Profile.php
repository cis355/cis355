<?php
/* *******************************************************************
 filename     : Profile.php  
 author       : Adam Henderson  
 username     : arhender 
 course       : cs355  
 section      : 11-MW  
 semester     : Summer 2016  
 description  : This file contains the logic to display a user profile
Input         : username from get variable

Process:
1. create a user info variable
2. if the get variable is empty redirect the loginscreen
3. otherwise get the name of the user whose profile will be shown
4. lookup the user profiletype by username
5. if the user doesn't exist in the database redirect to your own profile
6. otherwise read the user from the get variable
7. set the list type of what to display on the page
8. read all active connections involving this account
9. fill out all information on profile where applicable
10. if the session variable logintype= students and the current profile is a mentor, and there is no existing connection in Connections, display request mentorship button
11. loop through relations list and echo out html to display list in "friends list" format
Output: html that is css'd to look like a user profile depending on the get variable in the url
Precondition: User must be logged in, get variable must be complete and a valid user in either mentors or students table
Postcondition: a profile with a picture, info, mentors/students list, bio and a request mentorship button if it makes sense
*********************************************************************  */
require 'sessioncheck.php';
require 'database.php';
include 'header.php';
$Userinfo = array();


if(empty($_GET['user']))
{
	header("Location: Login.php");
	
}
else{


	#get the name of the user in question and find out their login type
$name = $_GET['user'];
$Person = database::lookupuser($name);
if(!empty($Person)){
	
	#if the user exists read their user info
	$Userinfo = database::readuser($name, $Login);
	
	
}

else{
	#if not redirect to your own profile
	header("Location: Profile.php?user=" . $_SESSION['name']);
	
}


	
}


#set the listtype
if($Login== "Mentors")
	{
		
		$ListType = "Students";
		
	}
	else
	{
		$ListType = "Mentors";
	}

	#read all related connections that are active in context of the current user profile
$RelationList = database::readconnections($Login,$ListType, $Userinfo['Username'], 1);



?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<?php echo "<title>" . $Userinfo['FirstName'] . " " . $Userinfo['LastName'] . "</title>";?>
	<link rel="stylesheet" type="text/css" href="global.css" />
</head>


	
	<div id="content" class="clearfix">
		<section id="left">
			<div id="userStats" class="clearfix">
				<div class="pic">
					<?php echo "<a href=" .'"' . Profile.php . '"' . "><img src=" . '"' . $Userinfo['ProfilePicture'] . '" ' . "width=150 height=150 /></a>"; ?>
				</div>
				
				<div class="data">
					<?php echo "<h1>" . $Userinfo['FirstName'] . " " . $Userinfo['LastName'] . "</h1>"; ?>
					<?php echo "<h3>" . $Userinfo['City'] . ", " . $Userinfo['ProvinceOrState'] . " " .  $Userinfo['Country'] . "</h3>"; ?>
					<?php echo "<h3>Age: " . $Userinfo['Age'] . "</h3>"; ?>
					<?php echo "<h3>Education Level: " . $Userinfo['EducationLevel'] . "</h3>"; ?>
					<div class="sep"></div>
					<ul class="numbers clearfix">
					    <?php #if($ListType=="Students"){echo "<li>Average Rating:<strong>9/10</strong></li>";} ?>
						<?php echo "<li> " . $ListType. "<strong>" . count($RelationList) . "</strong></li>";?>
					</ul>
			</div>
			
			
			<?php 
			
			
			#if you are a student
			if($_SESSION['LoginType'] == "Students")
			{
				
				#the user in question is a mentor
			 if ($Login == "Mentors")
			 {
				 #grab all connections active or inactive
				  $norelationship = true;
				  $personalrelationlist=  database::readallconnections($_SESSION['LoginType'],"Mentors",$_SESSION['name']);
				 
				 foreach ($personalrelationlist as $record)
				 {
					 
					 #check and see if you are involved in any connection
					 if($record['Username'] == $Userinfo['Username'])
					 {
						 
					     #if you are set norelationship to false
						 $norelationship = false; 
					 }
					 
				 }
				 
				 
				if($norelationship == true)
					 {
						 #only show the button if you are not already having a pending mentorship or active one
						 echo "<form class='form-horizontal' action='RequestMentor.php' method='post'>";
						 echo "<div class='form-actions'><button type='submit' name='name' value='".$Userinfo['Username']."' class='btn btn-success'>Request Mentorship</button> </div>";
						 echo "</form>";
					 }	 
				 
			 }	
				
			}
			
			?>
			
			<h1>About Me:</h1>
			<?php echo "<p>" . $Userinfo['Bio'] . "</p>"; ?>
		</section>
		
		<section id="right">
			<div class="gcontent">
			
			<div class="gcontent">
				<?php echo "<div class=head><h1>" . $ListType . "</h1></div>"; ?>
				<div class="boxy">
					<?php echo "<p>" . $ListType . "</p>"; ?>
					<div class="friendslist clearfix">
					<?php
						
						#loop through active connections read in and echo out the boxes with names truncated to firstname L.
						foreach($RelationList as $Record)
						{
							
							echo "<div class='friend'>";
							echo "<a href='Profile.php?user=" . $Record['Username'] . "'><img src='" . $Record['ProfilePicture'] ."' width='30' height='30' alt='" . $Record['FirstName']. "'></a><span class='friendly'><a href='Profile.php?user=" . $Record['Username']. "'>" . $Record['FirstName'] . "  " . $Record['LastName'][0] . "." . "</a></span>";
							echo "</div>";
						}
						
						
					 ?>
				</div>
			</div>
		</section>
	</div>
</body>


</body>
</html>