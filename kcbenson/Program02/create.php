	<?php
	# if there was data passed, then insert the record, otherwise just display the HTML 
	if ( !empty($_POST)) {
		// keep track validation errors
		$bandIDError = null;
		$venueIDError = null;
		$timeError = null;
		$dateError = null;
		
		// keep track post values
		$bandID = $_POST['bandID'];
		$venueID = $_POST['venueID'];
		$time = $_POST['time'];
		$date = $_POST['date'];
		
		// validate input
		$valid = true;
		if (empty($bandID)) {
			$bandIDError = 'Please enter a band ID.';
			$valid = false;
		}
		
		if (empty($venueID)) {
			$venueIDError = 'Please enter a venue ID';
			$valid = false;
		}
		if (empty($date)) {
			$dateError = 'Please enter the gig date.';
			$valid = false;
		}
		if (empty($time)) {
			$timeError = 'Please enter the gig time.';
			$valid = false;
		}
		
		// insert data
		if ($valid) {
			$con = mysqli_connect('localhost','kcbenson','Kelsi42B','kcbenson');
			mysqli_query($Con,"INSERT INTO gigs (bandID, venueID, date, time) values(?, ?, ?, ?)");
			mysqli_close($con);
			header("Location: program02.php");
		}
	} 
	?>