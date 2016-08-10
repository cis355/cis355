<?php
 /* *******************************************************************
 filename     : signup.php  
 author       : Adam Henderson  
 username     : arhender 
 course       : cs355  
 section      : 11-MW  
 semester     : Summer 2016  
 description  : This file contains the logic to create a user in the selected table either mentors or students
Input         : user input from fields on page

Process:
1. check if post is empty if it is display the html
2. if it isn't lookup the user to see if the username is already taken
3. if it isn't taken check if a profile picture was set, if it wasn't use default.gif
4. create the record in the appropriate table based on what is in the post array
5. clear the post array, fill it with the lookup information
6. create a record in the lookup table with the username and profiletype
Output: a record in the appropriate login table, as well as the lookup table
Precondition: username must be unique, all values must be valid and not empty
Postcondition: username cannot be used for 2 different accounts mentor or student
*********************************************************************  */
 
    session_start(); 
	
 require 'database.php';
 
 
 
 if(!empty($_POST)){
  $Username =$_POST['Username'];
   
  $Check = database::lookupuser($Username);
   #check if username is taken 
   if(empty($Check)){
	 $ProfileType = $_POST['Account_Type'];
	 unset($_POST['Account_Type']);
	 #if it isn't unset the account type so it isn't added to the mentors or students databse
	 if(empty($_POST['ProfilePicture'])){
#set the profile picture to default if it wasn't set
		 $_POST['ProfilePicture'] = "resources/default.gif";
		 
	 }
	 #create the record in the mentors/students table
	  database::createrecord($ProfileType);
	  
	  
	  #clear the array and add the lookup table info
	  $_POST = array();
	  $_POST['Username'] = $Username;
	  $_POST['ProfileType'] = $ProfileType;
	  
	#create the record in the lookup table
	  database::createrecord("Lookup");
	  
	  #read the new user info
	  $user = database::readuser($Username);
    	
		#set the session variables and redirect to their profile
	  $_SESSION['name'] = $user['Username'];
	  $_SESSION['LoginType'] = $ProfileType;
	  $_SESSION['YourProfile']= True;
	  header("Location: Profile.php?user=" . $_SESSION['name']);
	 
   }
	  
	  
  
 
 }
    
	echo "
<head>
	<meta charset='utf-8' />
	<title>Mentor Mingle</title>
	<link rel='stylesheet' type='text/css' href='global.css' />
</head>


	<header>
	<div align='left'>
		<a href='-'><img src='resources/MentorMingle.png' alt='Mentor Mingle logo'/></a>
			<H3>Mentor Mingle</H3>		
         </div>
	</header>";
?>
<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="utf-8"> 
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
</head> 


      
      <div class="tab-content">
        <div id="signup">   
          <h1>Sign Up for Free</h1>
          
          <form action="signup.php" method="post" >
		  
		   <div class="field-wrap">
            <label>
              Username<span class="req">*</span>
            </label>
            <input name="Username" type="text"required autocomplete="off"/>
          </div>
          
          <div class="field-wrap">
            <label>
              Password<span class="req">*</span>
            </label>
            <input name="Password" type="password"required autocomplete="off"/>
          </div>
          
          <div class="top-row">
            <div class="field-wrap">
              <label>
                First Name<span class="req">*</span>
              </label>
              <input name= "FirstName"type="text" required autocomplete="off" />
			  
			  <label>
                Last Name<span class="req">*</span>
              </label>
              <input name="LastName" type="text"required autocomplete="off"/>
            </div>
            </div>
       
	   <?php
            echo "<label>Age*</label>";	  
			
		
			echo "<select name='Age'>";
		
			for($i=16; $i<100; $i++){
				
			
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
		  <div>
		  <textarea name= "bio" rows="4" cols="50">
		  </textarea>
		  </div>
		    <div>
		   <br/>
		  <input type='file' name='ProfilePicture'/>

           </div>
		  <div class="field-wrap">
            <label>
              City<span class="req">*</span>
            </label>
            <input name= "City" type="text"required autocomplete="off"/>
			
			 <label>
              state<span class="req">*</span>
            </label>
            <input name="ProvinceOrState" type="text"required autocomplete="off"/>
			
			<label>
              country<span class="req">*</span>
            </label>
            <input name="Country" type="text"required autocomplete="off"/>
          </div>
		  <div>
		  
		   
		  </div>
		  
		
		  
		  <label>Account Type</label>
		  <select name = 'Account Type'>
		  <option value = "Mentors">Mentor</option>
		  <option value = "Students">Student</option>
		  </select>
		  </div>
		   <br/>
		   <div>
		  
		  
		 
		
		  
		  
		
          
          <button type="submit" class="btn btn-success">Create Account</button>  
          </form>
		  

        </div>
        
      </div><!-- tab-content -->
      
</div> <!-- /form -->



