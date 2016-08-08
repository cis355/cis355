<?php
	session_start();
	$_SESSION['cust_id'] = 3;
	//if (empty($_SESSION['cust_id'])) 
	//header('Location: se_login.php'); //redirect
	//session_destroy();
	require ("database.php");
	
	class Reservation {
		private static $id;
		private static $cust_id;
		private static $date;
		private static $start_time;
		private static $end_time;
		private static $comments;

	//connect to database and build table of reservations
	public function displayReservations () {
		 $pdo = Database::connect();
		 $sql = 'SELECT * FROM se_reservations ORDER BY date, start_time';
	 	 echo '<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Faculty</th>
		                  <th>Date</th>
		                  <th>Start Time</th>
		                  <th>End Time</th>
		                  <th>Comments</th>
		                  <th>Action</th>
		                </tr>
		              </thead>
		              <tbody>';

		 foreach ($pdo->query($sql) as $row) {
		  	echo '<tr>';
		   	echo '<td>'. $row['cust_id'] . '</td>';
		   	echo '<td>'. $row['date'] . '</td>';
		   	echo '<td>'. $row['start_time'] . '</td>';
		   	echo '<td>'. $row['end_time'] . '</td>';
		   	echo '<td>'. $row['comments'] . '</td>';
		   	echo '<td width="250">';
		   	echo '<a class="btn" href="read.php?id='.
			   $row['id'].'">Read</a>';
		   	echo '&nbsp;';
		   	if ($_SESSION['cust_id'] == $row['cust_id']) { 
				echo '<a class="btn btn-success" 
				href="update.php?id='.$row['id'].'">Update</a>';
				echo '&nbsp;';
				echo '<a class="btn btn-danger" 
				href="delete.php?id='.$row['id'].'">Delete</a>';
		   	}
			echo '</td>';
		   	echo '</tr>';
		 }
		 echo '</tbody></table>';
		 Database::disconnect();
	}
	
	//display the create button and link to create.php when clicked
		function create() {
			echo "<a href='create.php?create=yes' class='btn btn-success'>Create New Reservations</a>";
		}
	}
?>

<html lang="en">
<head>
	<!-- The head section does the following: 
		1. Sets the character set
		2. includes Bootstrap
		-->
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
	<h2>Reservations</h2>
</body>
</html>

<?php
	$res1 = new Reservation;
	$res1->create();
	$res1->displayReservations();
	echo '<br /><br />';
	show_source(__FILE__);
?>