<?php
/* *******************************************************************  
* filename     : updatelisting.php 
* author       : Terry Lewis  
* username     : tjlewis2  
* course       : cs355  
* section      : 1  
* semester : Summer 2016  
*  
* description  : This file is responsible for allowing an user to update a 
*				 listing
*  
* input        : none  
* processing   : The program steps are as follows.    
*          1. connect to database
*		   2. read in all information about the current listing
*		   3. verify that all fields are filled out after updating
*		   4. update listing in database
* output       : none  
*  
* precondition : user has posted a listing
* postcondition: listings is updated
* *******************************************************************
*/
	session_start();
		require 'database.php';
	if (empty($_SESSION['name'])) header("Location: login.php");
	
	$listing_id = null;
	
	$listing_id = null;
	if ( !empty($_GET['id'])) {
		$listing_id = $_REQUEST['id'];
	}

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$sql = "SELECT l.* from listings l WHERE l.listingID = '{$listing_id}'";
			
	$q = $pdo->prepare($sql);
	$q->execute();
	$result = $q->fetch(PDO::FETCH_ASSOC);
	
	$description = (string)$result['description'];
	$listing = (string)$result['title'];
	$address = (string)$result['address'];
	$city = (string)$result['city'];
	$zip = (string)$result['zip'];
	$roomiesneeded = (string)$result['roommates_needed'];
	$currroomies = (string)$result['current_roommates'];
	$rent = (string)$result['rent'];
	
	$gender = (string)$result['gender'];
	$state = (string)$result['state'];
	$id = $listing_id;
	
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
		$id = $_POST['did'];

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

			$sql = ("UPDATE listings SET title='{$listing}', address='{$address}', city='{$city}',
					state='{$state}', zip='{$zip}', roommates_needed='{$roomiesneeded}',
					current_roommates='{$currroomies}', rent='{$rent}', gender='{$gender}',
					description='{$description}' WHERE listings.listingID='{$id}' ");
			$q = $pdo->prepare($sql);
			$q->execute();
			
			$correctError = 'Your listing has been updated!!';
			
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
      <h1>WELCOME </h1>
      <p>LOGGED IN NOW</p>
      <hr>
      <h3>Info</h3>
	  
      <p><font size="3" color="red">	<?php if (!empty($correctError)): ?>
						<span class="help-inline"><?php echo $correctError;?></span>
						<?php endif; ?>	</font></p>
	  
		<form class="form-horizontal" method="post" action="updatelisting.php">
			
			<label class="control-label">Listing Title :</label>
			<input style="width:300px; display:inline"; type="text" class="form-control" name="dtitle" id="Listing Title" value="<?php echo !empty($listing)?$listing:'';?>">
		
			<label class="control-label" style="margin-left:25px";>Address :</label>
     		<input style="width:300px; display:inline"; type="text" class="form-control" name="daddress" id="Address" value="<?php echo !empty($address)?$address:'';?>"><br>
			
			<label class="control-label" style="margin-top:30px; margin-left:54px";>City :</label>
     		<input style="width:300px; display:inline"; type="text" class="form-control" name="dcity" id="City" value="<?php echo !empty($city)?$city:'';?>">
				
			<label class="control-label" style="margin-left: 46px; margin-top:35px";>State :</label>
			<select style="width:300px; display:inline"; class="form-control" name="dstate">
				
				<option value="AL" <?php if ($state == 'AL') echo' selected="selected"'; ?>>Alabama</option>
				<option value="AK" <?php if ($state == 'AK') echo ' selected="selected"'; ?>>Alaska</option>
				<option value="AZ"<?php if ($state == 'AZ') echo ' selected="selected"'; ?>>Arizona</option>
				<option value="AR"<?php if ($state == 'AR') echo ' selected="selected"'; ?>>Arkansas</option>
				<option value="CA"<?php if ($state == 'CA') echo ' selected="selected"'; ?>>California</option>
				<option value="CO"<?php if ($state == 'CO') echo ' selected="selected"'; ?>>Colorado</option>
				<option value="CT"<?php if ($state == 'CT') echo ' selected="selected"'; ?>>Connecticut</option>
				<option value="DE"<?php if ($state == 'DE') echo ' selected="selected"'; ?>>Delaware</option>
				<option value="DC"<?php if ($state == 'CT') echo ' selected="selected"'; ?>>District Of Columbia</option>
				<option value="FL"<?php if ($state == 'FL') echo ' selected="selected"'; ?>>Florida</option>
				<option value="GA"<?php if ($state == 'GA') echo ' selected="selected"'; ?>>Georgia</option>
				<option value="HI"<?php if ($state == 'HI') echo ' selected="selected"'; ?>>Hawaii</option>
				<option value="ID"<?php if ($state == 'ID') echo ' selected="selected"'; ?>>Idaho</option>
				<option value="IL"<?php if ($state == 'IL') echo ' selected="selected"'; ?>>Illinois</option>
				<option value="IN"<?php if ($state == 'IN') echo ' selected="selected"'; ?>>Indiana</option>
				<option value="IA"<?php if ($state == 'IA') echo ' selected="selected"'; ?>>Iowa</option>
				<option value="KS"<?php if ($state == 'KS') echo ' selected="selected"'; ?>>Kansas</option>
				<option value="KY"<?php if ($state == 'KS') echo ' selected="selected"'; ?>>Kentucky</option>
				<option value="LA"<?php if ($state == 'LA') echo ' selected="selected"'; ?>>Louisiana</option>
				<option value="ME"<?php if ($state == 'ME') echo ' selected="selected"'; ?>>Maine</option>
				<option value="MD"<?php if ($state == 'MD') echo ' selected="selected"'; ?>>Maryland</option>
				<option value="MA"<?php if ($state == 'MA') echo ' selected="selected"'; ?>>Massachusetts</option>
				<option value="MI"<?php if ($state == 'MI') echo ' selected="selected"'; ?>>Michigan</option>
				<option value="MN"<?php if ($state == 'MN') echo ' selected="selected"'; ?>>Minnesota</option>
				<option value="MS"<?php if ($state == 'MS') echo ' selected="selected"'; ?>>Mississippi</option>
				<option value="MO"<?php if ($state == 'MO') echo ' selected="selected"'; ?>>Missouri</option>
				<option value="MT"<?php if ($state == 'MT') echo ' selected="selected"'; ?>>Montana</option>
				<option value="NE"<?php if ($state == 'NE') echo ' selected="selected"'; ?>>Nebraska</option>
				<option value="NV"<?php if ($state == 'NV') echo ' selected="selected"'; ?>>Nevada</option>
				<option value="NH"<?php if ($state == 'NH') echo ' selected="selected"'; ?>>New Hampshire</option>
				<option value="NJ"<?php if ($state == 'NJ') echo ' selected="selected"'; ?>>New Jersey</option>
				<option value="NM"<?php if ($state == 'NM') echo ' selected="selected"'; ?>>New Mexico</option>
				<option value="NY"<?php if ($state == 'NY') echo ' selected="selected"'; ?>>New York</option>
				<option value="NC"<?php if ($state == 'NC') echo ' selected="selected"'; ?>>North Carolina</option>
				<option value="ND"<?php if ($state == 'ND') echo ' selected="selected"'; ?>>North Dakota</option>
				<option value="OH"<?php if ($state == 'OH') echo ' selected="selected"'; ?>>Ohio</option>
				<option value="OK"<?php if ($state == 'OK') echo ' selected="selected"'; ?>>Oklahoma</option>
				<option value="OR"<?php if ($state == 'OR') echo ' selected="selected"'; ?>>Oregon</option>
				<option value="PA"<?php if ($state == 'PA') echo ' selected="selected"'; ?>>Pennsylvania</option>
				<option value="RI"<?php if ($state == 'RI') echo ' selected="selected"'; ?>>Rhode Island</option>
				<option value="SC"<?php if ($state == 'SC') echo ' selected="selected"'; ?>>South Carolina</option>
				<option value="SD"<?php if ($state == 'SD') echo ' selected="selected"'; ?>>South Dakota</option>
				<option value="TN"<?php if ($state == 'TN') echo ' selected="selected"'; ?>>Tennessee</option>
				<option value="TX"<?php if ($state == 'TX') echo ' selected="selected"'; ?>>Texas</option>
				<option value="UT"<?php if ($state == 'UT') echo ' selected="selected"'; ?>>Utah</option>
				<option value="VT"<?php if ($state == 'VT') echo ' selected="selected"'; ?>>Vermont</option>
				<option value="VA"<?php if ($state == 'VA') echo ' selected="selected"'; ?>>Virginia</option>
				<option value="WA"<?php if ($state == 'WA') echo ' selected="selected"'; ?>>Washington</option>
				<option value="WV"<?php if ($state == 'WW') echo ' selected="selected"'; ?>>West Virginia</option>
				<option value="WI"<?php if ($state == 'WI') echo ' selected="selected"'; ?>>Wisconsin</option>
				<option value="WY"<?php if ($state == 'WY') echo ' selected="selected"'; ?>>Wyoming</option>
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
				<button style="margin-top:25px; type="submit" class="btn btn-success" value="<?php echo !empty($dcorrect)?$dcorrect:'';?>">>Update Listing</button>
			</div>
			
			<input type="hidden" name="did" value="<?php echo !empty($id)?$id:'';?>">
			
    </div>
	</form>
<?php include("sidenav2.php"); ?>
  </div>
</div>

<footer class="container-fluid text-center">
  <p>Footer Text</p>
</footer>

</body>
</html>