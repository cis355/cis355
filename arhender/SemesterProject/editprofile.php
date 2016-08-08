<?php
/* *******************************************************************
 filename     : editprofile.php  
 author       : Adam Henderson  
 username     : arhender 
 course       : cs355  
 section      : 11-MW  
 semester     : Summer 2016  
 description  : This file contains the logic to handle updating your user info
				or deleting your user info
Input         : session variable of username, post variable based on button pushed and values within fields provided

Process:
1. Check if post is empty, if it is read the current user info and display the HTML with values filled in
2. if it isn't empty that means either an update or delete
3. check the post value type, if it is delete then the user clicked delete, if it is update the user is updating
---DELETE----
4. read your own info
5. check with table you are located in
6. delete all related connections to manage Referential Integrity
7. delete the user account from the related table
8. delete the user from the lookup table
9. redirect to logout to destroy the session variable and place the user to login page
---UPDATE----
4. read your own info
5. set your session name to your posted username if it had changed
6. update your user information
7. redirect to your profile
Output: either a deleted record in the database, or an updated record in the database
Precondition: user exists in the database
Postcondition: Database record is changed, or deleted
*********************************************************************  */
require 'database.php';
require 'sessioncheck.php';
require 'header.php';


if(!empty($_POST)){
	
#if post type is delete
if ($_POST['type']=="delete"){
	#read your user info
    $user = database::readuser($_SESSION['name']);
	#read the table you are in
	$person = database::lookupuser($user['Username']);
	
	#delete your connections, your user record, and from the lookup table
	database::deleterelatedconnections($_SESSION['LoginType'], $user['Tuid']);
	database::deleteuser($_SESSION['LoginType'], $user['Tuid'], $user['Username']);
	database::deletelookup($person['Tuid']);
	header("Location: Logout.php");
	#redirect to logout
	
	
}

if ($_POST['type']=="update"){
	 
			#if the post type is update
			#grab your user info
	 
		$user = database::readuser($_SESSION['name']);
		
		#set the session name to the posted name
		$_SESSION['name'] = $_POST['Username'];
		
		#update the user with the new information posted
		database::updateuser($_SESSION['LoginType'], $user['Tuid'], $user['Username']);
		
		#redirect to your profile
		header("Location: Profile.php?user=" . $_SESSION['name']);
			
}
	
	
	
	
}


#read user info
$Userinfo = database::readuser($_SESSION['name']);

?>
<head>
	<meta charset='utf-8' />
	<title>Mentor Mingle</title>
	<link rel='stylesheet' type='text/css' href='global.css' />
    <meta charset="utf-8"> 
    
</head> 


</head>

<div class="tab-content">
        <div id="signup">   
          <h1>Edit Profile</h1>
          
          <form action="editprofile.php" method="post" >
		  
		   <div class="field-wrap">
            <label>
              Username<span class="req">*</span>
            </label>
            <input name="Username" value="<?php echo $Userinfo['Username']; ?>" type="text"required autocomplete="off"/>
          </div>
          
          <div class="field-wrap">
            <label>
              Password<span class="req">*</span>
            </label>
            <input name="Password" value="<?php echo $Userinfo['Password']; ?>" type="password"required autocomplete="off"/>
          </div>
          
          <div class="top-row">
            <div class="field-wrap">
              <label>
                First Name<span class="req">*</span>
              </label>
              <input name= "FirstName" value="<?php echo $Userinfo['FirstName']; ?>" type="text" required autocomplete="off" />
			  
			  <label>
                Last Name<span class="req">*</span>
              </label>
              <input name="LastName" value="<?php echo $Userinfo['LastName']; ?>" type="text"required autocomplete="off"/>
            </div>
            </div>
       
			 <?php
			 #Echo out the select age range based on current age of the user existing
            echo "<label>Age*</label>";	  
			
		
			echo "<select name='Age'>";
		
			for($i=$Userinfo['Age']; $i<100; $i++){
				
			
			echo "<option value=". $i . ">". $i . "</option>";
	
				
			} 
			echo "</select>";
		  
		  ?>
	   
	   
		  
		    <label>Education Level</label>
		  <select name = 'EducationLevel'>
		  <option value = "Freshman">Freshman</option>
		  <option value = "Sophomore">Sophomore</option>
		  <option value = "Junior">Junior</option>
		  <option value = "Senior">Senior</option>
		  <option value = "Graduate">Graduate</option>
		  </select>
 
 
		 <label>Bio<Label>
		  </div>
		  
		  <br/>
		  
		  <div> 
		  
		  <textarea name= "bio" rows="4" cols="50">
		  <?php echo $Userinfo['Bio']; ?>
		  </textarea>
		  </div>
		    <div>
		   <br/>
		  
           </div>
		  <div class="field-wrap">
            <label>
              City<span class="req">*</span>
            </label>
            <input name= "City" value="<?php echo $Userinfo['City']; ?>"type="text"required autocomplete="off"/>
			
			 <label>
              state<span class="req">*</span>
            </label>
            <input name="ProvinceOrState" value="<?php echo $Userinfo['ProvinceOrState']; ?>" type="text"required autocomplete="off"/>
			
			<label>
              country<span class="req">*</span>
            </label>
            <input name="Country" value="<?php echo $Userinfo['Country']; ?>" type="text"required autocomplete="off"/>
          </div>
		  <div>
		   <button type="submit" name="type" value='update' class="btn btn-success">Update Profile</button>  
          </form>
		  
		  <form action="editprofile.php" method="post" >
		  <button type="submit" name="type" value='delete' class="btn btn-success">Delete Profile</button>  
		  </div>