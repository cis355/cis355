
<?php
/* *******************************************************************  
* filename     : createlisting.php 
* author       : Terry Lewis  
* username     : tjlewis2  
* course       : cs355  
* section      : 1  
* semester : Summer 2016  
*  
* description  : This file is responsible for creating a listing an inserting
*				 the new listing into the database 
*  
* input        : create listing form filled out  
* processing   : The program steps are as follows.    
*          1. get database
*		   2. verify that all fields are filled out
*		   3. insert data into database
* output       : none  
*  
* precondition : all fields are filled in  
* postcondition: listing is inserted into the database
* *******************************************************************
*/
	session_start();
		require 'database.php';
	if (empty($_SESSION['name'])) header("Location: login.php");
	
	
	$description='';
	if ( !empty($_POST)) {
		
		// keep track validation errors
		$listingError = null;
		$addressError = null;
		$cityError = null;
		$stateError = null;
		$zipError = null;
		$roomieneededError = null;
		$currroomieError = null;
		$rentError = null;
		$descriptionError = null;
		$correctError = null;
		$createSuccess = null;
		
		// keep track post values
		$listing = $_POST['dtitle'];
		$address = $_POST['daddress'];
		$city = $_POST['dcity'];
		$state = $_POST['dstate'];
		$zip = $_POST['dzip'];
		$roomiesneeded = $_POST['droomiesneeded'];
		$currroomies = $_POST['dcurrroomies'];
		$rent = $_POST['drent'];
		$description = $_POST['ddescription'];
		$gender = $_POST['dgender'];
		$name = $_SESSION['name'];
		
		// validate input
		$valid = true;
		if ((empty($listing)) OR (empty($address)) OR (empty($city)) OR (empty($state)) OR (empty($zip)) OR (empty($roomiesneeded))
			OR (empty($currroomies)) OR (empty($rent)) OR (empty($description)))
		{
			$correctError = 'All fields must be filled in!';
			$valid = false;
		}
		else
		{
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$sql = "SELECT user_id FROM users WHERE user_name = '{$name}'";
			$q = $pdo->prepare($sql);
			$q->execute(array($name));
			$result = $q->fetch(PDO::FETCH_ASSOC);
			$user_id = (string)$result['user_id'];
			
			$sql = "INSERT INTO listings (title,user_id, address,city,state,zip,roommates_needed,current_roommates,
					rent, gender, description) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($listing,$user_id, $address,$city,$state,$zip,$roomiesneeded,$currroomies,$rent,$gender,$description));
			
			
			$last_id= $pdo->lastInsertId('listingID');
			
			$sql = "INSERT INTO posts (user_id,listing_id) values(?,?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($user_id,$last_id));
			
			$createSuccess = 'Your listing has been posted! ';
			
		}
	}
		
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Home</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 400px; min-width:1000px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 250%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }

	
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;}
    }
  </style>
</head>
<body>

<?php include("navbar.php"); ?>
  
<div class="container-fluid text-center">
  <div class="row content">
<?php include("sidenav.php"); ?>
    <div class="col-sm-8 text-left" >
      <h1>Post New Listing</h1>
	  <p>Create a new listing<p>
		<form class="form-horizontal" method="post" action="createListing.php">
			
			<label class="control-label">Listing Title :</label>
			<input style="width:300px; display:inline"; type="text" class="form-control" name="dtitle" id="Listing Title" value="<?php echo !empty($listing)?$listing:'';?>">
		
			<label class="control-label" style="margin-left:25px";>Address :</label>
     		<input style="width:300px; display:inline"; type="text" class="form-control" name="daddress" id="Address" value="<?php echo !empty($address)?$address:'';?>"><br>
			
			<label class="control-label" style="margin-top:30px; margin-left:54px";>City :</label>
     		<input style="width:300px; display:inline"; type="text" class="form-control" name="dcity" id="City" value="<?php echo !empty($city)?$city:'';?>">
				
			<label class="control-label" style="margin-left: 46px; margin-top:35px";>State :</label>
			<select style="width:300px; display:inline"; class="form-control" name="dstate">
				<option value="AL">Alabama</option>
				<option value="AK">Alaska</option>
				<option value="AZ">Arizona</option>
				<option value="AR">Arkansas</option>
				<option value="CA">California</option>
				<option value="CO">Colorado</option>
				<option value="CT">Connecticut</option>
				<option value="DE">Delaware</option>
				<option value="DC">District Of Columbia</option>
				<option value="FL">Florida</option>
				<option value="GA">Georgia</option>
				<option value="HI">Hawaii</option>
				<option value="ID">Idaho</option>
				<option value="IL">Illinois</option>
				<option value="IN">Indiana</option>
				<option value="IA">Iowa</option>
				<option value="KS">Kansas</option>
				<option value="KY">Kentucky</option>
				<option value="LA">Louisiana</option>
				<option value="ME">Maine</option>
				<option value="MD">Maryland</option>
				<option value="MA">Massachusetts</option>
				<option value="MI">Michigan</option>
				<option value="MN">Minnesota</option>
				<option value="MS">Mississippi</option>
				<option value="MO">Missouri</option>
				<option value="MT">Montana</option>
				<option value="NE">Nebraska</option>
				<option value="NV">Nevada</option>
				<option value="NH">New Hampshire</option>
				<option value="NJ">New Jersey</option>
				<option value="NM">New Mexico</option>
				<option value="NY">New York</option>
				<option value="NC">North Carolina</option>
				<option value="ND">North Dakota</option>
				<option value="OH">Ohio</option>
				<option value="OK">Oklahoma</option>
				<option value="OR">Oregon</option>
				<option value="PA">Pennsylvania</option>
				<option value="RI">Rhode Island</option>
				<option value="SC">South Carolina</option>
				<option value="SD">South Dakota</option>
				<option value="TN">Tennessee</option>
				<option value="TX">Texas</option>
				<option value="UT">Utah</option>
				<option value="VT">Vermont</option>
				<option value="VA">Virginia</option>
				<option value="WA">Washington</option>
				<option value="WV">West Virginia</option>
				<option value="WI">Wisconsin</option>
				<option value="WY">Wyoming</option>
			</select><br>
			
			<!-- for inputting only numbers http://stackoverflow.com/questions/469357/html-text-input-allow-only-numeric-input -->
			<label class="control-label" style="margin-left:60px";>Zip :</label>
     		<input onkeypress='return event.charCode >= 48 && event.charCode <= 57' style="width:100px; margin-top:30px; display:inline"; 
			type="text" class="form-control" maxlength="5" name="dzip" id="City" value="<?php echo !empty($zip)?$zip:'';?>">
			
			<label class="control-label" style="margin-left:25px";>Number of Roommates Needed :</label>
     		<input onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="2" style="width:50px; display:inline"; 
			type="text" class="form-control" name="droomiesneeded" id="roomiesneeded" value="<?php echo !empty($roomiesneeded)?$roomiesneeded:'';?>">
			
			<label class="control-label" style="margin-left:25px";>Current Number of Residents:</label>
     		<input onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="2" style="width:50px; display:inline"; 
			type="text" class="form-control" name="dcurrroomies" id="currroomies" value="<?php echo !empty($currroomies)?$currroomies:'';?>"><br>
			
			<label class="control-label" style="margin-left:-5px; margin-top:35px";>Monthly Rent:</label>
     		<input onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="4" style="width:100px; display:inline"; 
			type="text" class="form-control" name="drent" id="rent" value="<?php echo !empty($rent)?$rent:'';?>">
			
			<label class="control-label" style="margin-left: 46px; margin-top:35px";>Housing Gender :</label>
			<select style="width:150px; display:inline"; class="form-control" name="dgender">
				<option value="M">Male</option>
				<option value="F">Female</option>
				<option value="MF">Male/Female</option>
			</select><br>
			
			<label class="control-label" style="margin-left:-5px; margin-top:5x";>Description:</label>
     		<textarea style="width:800px; height:300px; display:inline; margin-top:35px"; type="textarea" class="form-control" name="ddescription" id="description"><?php echo ($description)?$description:'';?></textarea>
			
			<div class="form-actions">
				<button style="margin-top:25px; type="submit" class="btn btn-success">Post Listing</button>
			</div>
			
			<?php if (!empty($correctError)): ?>
					<span class="help-inline"><?php echo '<br>' . $correctError;?></span>
			<?php endif; ?>
			
			<!--Displays success message if listing was created successfully-->
			<?php if (!empty($createSuccess)): ?>
				<font size="5" color="green"><span class="help-inline"><?php echo $createSuccess;?></font></span><br>
				<?php echo "<script>setTimeout(\"location.href = 'mylistings.php';\",3500);</script>";?>
			<?php endif; ?>
			
			
    </div>
	</form>
	
<?php include("sidenav2.php"); ?>
  </div>
</div>

<footer class="container-fluid text-center">
  <p>Roommate Finder</p>
</footer>

</body>
</html>