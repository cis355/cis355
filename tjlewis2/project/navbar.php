<?php
/* *******************************************************************  
* filename     : navbar.php 
* author       : Terry Lewis  
* username     : tjlewis2  
* course       : cs355  
* section      : 1  
* semester : Summer 2016  
*  
* description  : This file is responsible for displaying the navigation bar
*				 at the top of the screen
*  
* input        : none  
* processing   : none
* output       : none  
*  
* precondition : none
* postcondition: none
* *******************************************************************
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //something posted

    if (isset($_POST['btnlogout'])) {
		session_start();
		unset($_SESSION["name"]);  
		header("Location: login.php");
	}
}
?>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Roommate Finder</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="listings.php">Listings</a></li>
		
      </ul>
      
		<form action = "navbar.php" method = "post">
			<ul class="nav navbar-nav navbar-right">
			<li><p style="margin-top:15px; margin-right:15px;"><font color="white" size="3">WELCOME, <?php echo $_SESSION['name']; ?></font></p></li>
			<li><form action="navbar.php"><button style="margin-top: 10px; type="button" name="btnlogout" class="btn btn-danger">Logout</form></button></li> -->
			
		</form>
		
		</ul>
      </ul>
    </div>
  </div>
</nav>