<?php
/* *******************************************************************  
* filename     : mylistings.php 
* author       : Terry Lewis  
* username     : tjlewis2  
* course       : cs355  
* section      : 1  
* semester : Summer 2016  
*  
* description  : This file is responsible for displaying all listings posted 
*				  by the logged in user
*  
* input        : none  
* processing   : The program steps are as follows.    
*          1. connect to database
*		   2. select all listings that are posted by the  current user
*		   3. read in data and allow for editing of the listings
* output       : none  
*  
* precondition : user has posted a listing
* postcondition: listings are read and displayed with editing options
* *******************************************************************
*/
	session_start();
	include 'database.php';
	if (empty($_SESSION['name'])) header("Location: login.php");
	//connects to database.
	$pdo = Database::connect();
	
	$name = $_SESSION['name'];
	
	$sql = "SELECT users.user_id from users WHERE users.user_name = '{$name}'";
	$q = $pdo->prepare($sql);
	$q->execute(array($name));
	$result = $q->fetch(PDO::FETCH_ASSOC);
	$user_id = (string)$result['user_id'];
	
	//sql statement variable to select listings by current user
	$sql = "SELECT l.* , u.user_name, p.listing_id
			from listings l 
			inner join posts p on l.listingID = p.listing_id
			inner join users u on u.user_id = p.user_id 
			where p.user_id = '{$user_id}';
			";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Listings</title>
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
    .row.content {height: 450px}
    
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

    <div class="col-sm-8 text-left">
		  <h2>Your listings</h2>
		  <p>Here's All listings posted by you:</p>
		  <table class="table table-hover">
			<thead>
			  <tr>
				<th>Title</th>
				<th>Address</th>
				<th>City</th>
				<th>State</th>
				<th>Zip</th>
				<th>Roommates Needed</th>
				<th>Rent Price</th>
				<th>Gender</th>
				<th>Description</th>
			  </tr>
			</thead>
			<tbody>
			<?php foreach ($pdo->query($sql) as $row) {	?>
				<tr>
			
					<td><?php echo $row['title']; ?></td>
					<td><?php echo $row['address']; ?></td>
					<td><?php echo $row['city']; ?></td>
					<td><?php echo $row['state']; ?></td>
					<td><?php echo $row['zip']; ?></td>
					<td><?php echo $row['roommates_needed']; ?></td>
					<td><?php echo $row['rent']; ?>$</td>
					<td><?php echo $row['gender']; ?></td>
					<td><?php echo $row['description']; ?></td>
					
					<?php
					echo '<td width=250>';
	
						echo '<a class="btn btn-success" 
							 href="updatelisting.php?id='.$row['listing_id'].'">Update</a>';
							   echo '&nbsp;';
						echo '<a class="btn btn-danger" 
								href="deletelisting.php?id='.$row['listing_id'].'">Delete</a>';
					?>
					</tr>
			<?php } ?>
			</tbody>
		  </table>
	</div>
	
	
	<?php include("sidenav2.php"); ?>
  </div>
</div>

<footer class="container-fluid text-center">
  <p>Roommate Finder</p>
</footer>

</body>
</html>