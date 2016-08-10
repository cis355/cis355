<?php
/* *******************************************************************
 filename     : header.php  
 author       : Adam Henderson  
 username     : arhender 
 course       : cs355  
 section      : 11-MW  
 semester     : Summer 2016  
 description  : This file contains the logic to handle displaying the header
Input         : session variable of logged in username

Process:
1. echo out the html for the header the the session information placed into the appropriate spots
Output: a header navigable based on login type and username
Precondition: user is logged in and session['name'] is set appropriately
Postcondition: output the header as displayed below formatted by global.css
*********************************************************************  */

require 'sessioncheck.php';

echo "
	<header>
	<div align='left'>
		<a href='-'><img src='resources/MentorMingle.png' alt='Mentor Mingle logo'/></a>
			<H1>Mentor Mingle</H1>		
         </div>
		 
		 <div class='wrapper'>		
			<span id='usernav'><a href='Logout.php'>Logout</a> - <a href='Profile.php?user=" . $_SESSION['name'] . "'>My Profile<span></span></a></span>
	    </div>
		 
	</header>
	
	<nav>
		<ul id='n' class='clearfix'>
			<li><a href='Profile.php?user=" . $_SESSION['name'] . "'>Profile</a></li>";
			if($_SESSION['LoginType'] == "Students") {echo "<li><a href='search.php'>Search</a></li>";}
				echo "<li><a href='pendingmentorships.php'>Pending Mentorships</a></li>";
				echo "<li><a href='editprofile.php'>Edit Profile</a></li>";
		echo"</ul></nav>";



?>