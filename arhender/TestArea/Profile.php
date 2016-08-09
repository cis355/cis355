<?php

require 'sessioncheck.php';
require 'database.php';
$Userinfo = array();


if(empty($_GET['user']))
{
	header("Location: Profile.php?user=" . $_SESSION['name']);
	
}
else{


	
$name = $_GET['user'];
$Person = database::lookupuser($name);
if(!empty($Person)){
	
	
	$Userinfo = database::GrabProfileInfo($name, $Login);
	
	
}

else{
	
	header("Location: Profile.php?user=" . $_SESSION['name']);
	
}


	
}



if($Login== "Mentors")
	{
		
		$ListType = "Students";
		
	}
	else
	{
		$ListType = "Mentors";
	}

$RelationList = database::GenerateList($Login,$ListType, $Userinfo['Username']);



?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<?php echo "<title>" . $Userinfo['FirstName'] . " " . $Userinfo['LastName'] . "</title>"?>
	<link rel="stylesheet" type="text/css" href="global.css" />
</head>

<body>

<body>	
	<header>
	<div align="left">
		<a href="#"><img src="img/MentorMingle.png" alt="Mentor Mingle logo"/></a>
			<H1>Mentor Mingle</H1>		
         </div>	
		<div class="wrapper">		
			<span id='usernav'><a href='Logout.php'>Logout</a> - <a href= <?php echo "'Profile.php?user=" . $_SESSION['name'] . "'"; ?> >My Profile<span></span></a></span>
		</div>
	</header>
	
	<nav>
		<ul id="n" class="clearfix">
			<li><a href='#'>Profile</a></li>
			<li><a href="#">Pending Mentorships</a></li>
			<?php if($_SESSION['LoginType'] == "Students") echo "<li><a href=#>Search</a></li>" ;?>
		</ul>
	</nav>
	
	<div id="content" class="clearfix">
		<section id="left">
			<div id="userStats" class="clearfix">
				<div class="pic">
					<?php echo "<a href=" .'"' . Profile.php . '"' . "><img src=" . '"' . $Userinfo['ProfilePicture'] . '" ' . "width=150 height=150 /></a>"; ?>
				</div>
				
				<div class="data">
					<?php echo "<h1>" . $Userinfo['FirstName'] . " " . $Userinfo['LastName'] . "</h1>"; ?>
					<?php echo "<h3>" . $Userinfo['City'] . ", " . $Userinfo['ProvinceOrState'] . " " .  $Userinfo['Country'] . "</h3>"; ?>
					
					<div class="sep"></div>
					<ul class="numbers clearfix">
					    <?php #if($ListType=="Students"){echo "<li>Average Rating:<strong>9/10</strong></li>";} ?>
						<?php echo "<li> " . $ListType. "<strong>" . count($RelationList) . "</strong></li>";?>
					</ul>
			</div>
			
			
			<?php 
			
			
			
			if($_SESSION['LoginType'] == "Students")
			{
				
			
			 if ($Login == "Mentors")
			 {
				 
				  $norelationship = false;
				  $personalrelationlist=  database::GenerateList($_SESSION['LoginType'],"Mentors",$_SESSION['name']);
				 
				 foreach ($personalrelationlist as $record)
				 {
					 
					 
					 if($record['Username'] == $Userinfo['Username'])
					 {
						 
						
						 $norelationship = true; 
					 }
					 
				 }
				 
				 
				if($norelationship = true)
					 {
						 
						 echo "<div class='form-actions'><button type='submit' class='btn btn-success'>Request Mentorship</button> </div>";
						  
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