<?php
/* *******************************************************************  
* filename     : listings.php 
* author       : Terry Lewis  
* username     : tjlewis2  
* course       : cs355  
* section      : 1  
* semester : Summer 2016  
*  
* description  : This file is responsible for displaying all posed listings from users
*  
* input        : none  
* processing   : The program steps are as follows.    
*          1. connect to database
*		   2. select all listings that are posted from the listings table
*		   3. insert data into database
* output       : none  
*  
* precondition : records are already in the listings table
* postcondition: listings are read and displayed
* *******************************************************************
*/

	session_start();
	
	include 'database.php';
	
	if (empty($_SESSION['name'])) header("Location: login.php");
	
	//connects to database.
	$pdo = Database::connect();
	
	//sql statement to select all listings that are posted
	$sql = 'SELECT l.* , u.user_name 
			from users u
			inner join posts p on u.user_id = p.user_id
			left join listings l on l.listingID = p.listing_id LIMIT 20';
	
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
		  <h2>All listings</h2>
		  <p>Here's All listings posted by all users:</p>
		  <table class="table table-hover">
			<thead>
			  <tr>
				<th>Username</th>
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
				
					<td><?php echo $row['user_name']; ?></td>
					<td><?php echo $row['title']; ?></td>
					<td><?php echo $row['address']; ?></td>
					<td><?php echo $row['city']; ?></td>
					<td><?php echo $row['state']; ?></td>
					<td><?php echo $row['zip']; ?></td>
					<td><?php echo $row['roommates_needed']; ?></td>
					<td><?php echo $row['rent']; ?>$</td>
					<td><?php echo $row['gender']; ?></td>
					<td><?php echo $row['description']; ?></td>
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