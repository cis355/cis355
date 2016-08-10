<?php
/* *******************************************************************
* filename : project/index.php
* author : Jon Benson
* username : jmbenso2
* course : cis355
* section : 31-MW
* semester : Summer 2016
*
* PURPOSE : 	Presents a CRUD application for hosting, browsing, and
*							RSVPing to study sessions on campus.
* INPUT : 		N/A
* PRE : 			N/A 
* OUTPUT :		Dynamically generated HTML.
* POST : 			Interactive CRUD application presented.
*
* ER Diagram : http://csis.svsu.edu/~jmbenso2/cis355/jmbenso2/project/ERDiagram.png
* Screen Flow Diagram : http://csis.svsu.edu/~jmbenso2/cis355/jmbenso2/project/screenFlowDiagram.png
* UML Class Diagram : http://csis.svsu.edu/~jmbenso2/cis355/jmbenso2/project/UMLDiagram.png
*
* *******************************************************************
*/
require('database.php');

class StudyGateway {
	/***********V*   Methods that interface with database  *V**************/

	// These next five CRUD/getAll functions are for the meetups table
	
	/* createMeetup ($name, $location, $host, $description, $start, $end)
	***********************************************************
	*PURPOSE: Creates a record in the meetups table.
	*INPUT: $name $location $description (strings), $host (int)
	*				$start $end (datetimes)
	*PRE: $host is a valid user id
	*OUTPUT: N/A
	*POST: New record in meetups table.
	*NOTE:
	**********************************************************/
	public function createMeetup ($name, $location, $host, $description, $start, $end) {
		$mysqli = Database::connect();
		// SQL to execute:
		$sql = "INSERT INTO meetups (name, location, host, description, start, end) values(?, ?, ?, ?, ?, ?)";
		$q = $mysqli->prepare($sql);
		$q->bind_param('ssisss',$name, $location, $host, $description, $start, $end);
		$q->execute();
		Database::disconnect();
	}
	
	/* readMeetup ($id, &$data)
	***********************************************************
	*PURPOSE: Reads a record in the meetups table.
	*INPUT: $id (containing integer)
	*PRE: $id corresponds to an existing record where $id == meetups.id
	*OUTPUT: &$data
	*POST: &$data is associative array of record's values
	*NOTE:
	**********************************************************/
	public function readMeetup ($id, &$data) {
		$mysqli = Database::connect();
		$sql = "SELECT name, location, host, description, DATE_FORMAT(start, '%Y-%m-%dT%H:%i') AS start, DATE_FORMAT(end, '%Y-%m-%dT%H:%i') AS end FROM meetups where id = ?";
		$q = $mysqli->prepare($sql);
		$q->bind_param('i',$id);
		$q->execute();
		$q->store_result();
		$q->bind_result($name, $location, $host, $description, $start, $end);
		while ($q->fetch()) {
			// Read results into data
			$data['name'] = $name;
			$data['location'] = $location;
			$data['host'] = $host;
			$data['description'] = $description;
			$data['start'] = $start;
			$data['end'] = $end;
		}
		Database::disconnect();
	}
	
	/* updateMeetup ($id,$name,$location,$description,$start,$end)
	***********************************************************
	*PURPOSE: Updates a record in the meetups table.
	*INPUT: $id (int), $name $location $description (strings)
	*				$start $end (datetimes)
	*PRE: $id corresponds to an existing record where $id = meetups.id
	*OUTPUT: N/A
	*POST: Record updated in meetups table
	*NOTE:
	**********************************************************/
	public function updateMeetup ($id,$name,$location,$description,$start,$end) {
		$mysqli = Database::connect();
		$sql = "UPDATE meetups set name = ?, location = ?, description = ?, start = ?, end = ? WHERE id = ?";
		$q = $mysqli->prepare($sql);
		$q->bind_param('sssssi',$name,$location,$description,$start,$end,$id);
		$q->execute();
		Database::disconnect();
	}
	
	/* deleteMeetup ($id)
	***********************************************************
	*PURPOSE: Deletes a record from the meetups table.
	*INPUT: $id (containing integer)
	*PRE: $id corresponds to an existing record where $id = meetups.id
	*OUTPUT: N/A
	*POST: Record of id $id no longer exists in meetups table.
	*NOTE:
	**********************************************************/
	public function deleteMeetup ($id) {
		$mysqli = Database::connect();
		$sql = "DELETE FROM meetups WHERE id = ?";
		$q = $mysqli->prepare($sql);
		$q->bind_param('i',$id);
		$q->execute();
		Database::disconnect();
	}
	
	// Quick note about the next two functions:
	// getAllMeetup gets all records in the meetup table
	// getAllMeetup takes a user id, and gets only the records hosted by that user
	//
	/* getAllMeetup ()
	***********************************************************
	 *PURPOSE: Returns an object containing all records in meetups table.
	 *INPUT: N/A
	 *PRE: N/A
	 *OUTPUT: returns mysqli results object
	 *POST: All meetups table contents returned
	 *NOTE:
	 **********************************************************/
	public function getAllMeetup() {
		$mysqli = Database::connect();
		// SQL to execute:
		$sql = 'SELECT * FROM meetups WHERE (end > NOW()) ORDER BY start ASC';
		$result = $mysqli->query($sql);
		Database::disconnect();
		return $result;
	}
	
	/* getAllMyMeetup ($user)
	***********************************************************
	 *PURPOSE: Returns an object containing all records in meetups table
	 *					where host = $user
	 *INPUT: $user
	 *PRE: $user is a valid user id in the users table
	 *OUTPUT: returns mysqli results object
	 *POST: $user's meetups table contents returned
	 *NOTE:
	 **********************************************************/
	public function getAllMyMeetup($user) {
		$mysqli = Database::connect();
		// SQL to execute:
		$sql = "SELECT * FROM meetups WHERE host='$user' AND (end > NOW()) ORDER BY start ASC";
		$result = $mysqli->query($sql);
		Database::disconnect();
		return $result;
	}
	
	/* getAllRsvpdMeetup ($user)
	***********************************************************
	 *PURPOSE: Returns an object containing all records in meetups table
	 *					to which the passed $user is RSVP'd.
	 *INPUT: $user
	 *PRE: $user is a valid user id in the users table
	 *OUTPUT: returns mysqli results object
	 *POST: $user's RSVP'd meetups table contents returned
	 *NOTE:
	 **********************************************************/
	public function getAllRsvpdMeetup($user) {
		$mysqli = Database::connect();
		// SQL to execute:
		$sql = "SELECT * FROM meetups WHERE (end > NOW()) AND id IN (SELECT meetup FROM rsvps WHERE user = $user) ORDER BY start ASC";
		$result = $mysqli->query($sql);
		Database::disconnect();
		return $result;
	}
	
	/* readUser ($id, &$data)
	***********************************************************
	*PURPOSE: Reads a record in the users table.
	*INPUT: $id (containing integer)
	*PRE: $id corresponds to an existing record where $id == users.id
	*OUTPUT: &$userData
	*POST: &$userData is associative array of record's values
	*NOTE:
	**********************************************************/
	public function readUser ($id, &$data) {
		$mysqli = Database::connect();
		$sql = "SELECT id, name, faculty, password FROM users where id = ?";
		$q = $mysqli->prepare($sql);
		$q->bind_param('i',$id);
		$q->execute();
		$q->store_result();
		$q->bind_result($id, $name, $faculty, $password);
		while ($q->fetch()) {
			// Read results into data
			$data['id'] = $id;
			$data['name'] = $name;
			$data['faculty'] = $faculty;
			$data['password'] = $password;
		}
		Database::disconnect();
	}
	
	/* readRsvp ($id, &$data)
	***********************************************************
	*PURPOSE: Reads a record in the rsvps table.
	*INPUT: $id (containing integer)
	*PRE: $id corresponds to an existing record where $id == rsvps.id
	*OUTPUT: &$data
	*POST: &$data is associative array of record's values
	*NOTE:
	**********************************************************/
	public function readRsvp ($id) {
		$mysqli = Database::connect();
		$sql = "SELECT user, meetup FROM rsvps where id = ?";
		$q = $mysqli->prepare($sql);
		$q->bind_param('i',$id);
		$q->execute();
		$q->store_result();
		$q->bind_result($user, $meetup);
		while ($q->fetch()) {
			// Read results into data
			$data['user'] = $user;
			$data['meetup'] = $meetup;
		}
		Database::disconnect();
	}
	
	/* createRsvp ($user, $meetup)
	***********************************************************
	*PURPOSE: Creates a record in the rsvps table.
	*INPUT: $user $meetup (ints)
	*PRE: $user corresponds to an existing record where $user == users.id
	*     $meetup corresponds to an existing record where $meetup == meetups.id
	*OUTPUT: N/A
	*POST: New record in meetups table.
	*NOTE:
	**********************************************************/
	public function createRsvp ($user, $meetup) {
		self::deleteRsvp($user,$meetup); // If already exists, delete
		$mysqli = Database::connect();
		// SQL to execute:
		$sql = "INSERT INTO rsvps (user,meetup) values(?, ?)";
		$q = $mysqli->prepare($sql);
		$q->bind_param('ii',$user, $meetup);
		$q->execute();
		Database::disconnect();
	}
	
	/* deleteRsvp ($user, $meetup)
	***********************************************************
	*PURPOSE: Deletes a record from the rsvps table.
	*INPUT: $user $meetup (ints)
	*PRE: $user and $meetup correspond to the user and meetup fields
	*			 of a record in the rsvps table
	*OUTPUT: N/A
	*POST: Record with user $user and meetup $meetup removed from rsvps.
	*NOTE:
	**********************************************************/
	public function deleteRsvp ($user, $meetup) {
		
		$mysqli = Database::connect();
		$sql = "DELETE FROM rsvps WHERE user = ? AND meetup = ?";
		$q = $mysqli->prepare($sql);
		$q->bind_param('ii',$user,$meetup);
		$q->execute();
		Database::disconnect();
		
	}
	
	//Quick note about these next two functions:
	//  getMyRsvps takes the id of a user, and gets ids of meetups
	//  getMeetupRsvps takes the id of a meetup, and gets the ids of users
	//
	/* getMyRsvps ($id, &$myRsvps)
	***********************************************************
	 *PURPOSE: Gets in $myRsvps an object containing all meetup ids
	 *				  for which the passed user $id is rsvpd.
	 *INPUT: N/A
	 *PRE: N/A
	 *OUTPUT: &$myRsvps
	 *POST: $myRsvps is an array of meetup ids.
	 *NOTE:
	 **********************************************************/
	public function getMyRsvps($id,&$myRsvps) {
		$mysqli = Database::connect();
		// SQL to execute:
		$sql = 'SELECT * FROM rsvps WHERE user = ?';
		$q = $mysqli->prepare($sql);
		$q->bind_param('i',$id);
		$q->execute();
		$q->bind_result($rsvpId, $user, $meetup);
		while ($q->fetch()) {
			if ($user == $id)
				array_push($myRsvps,$meetup);
		}
		Database::disconnect();
	}
	
		/* getMeetupRvps ($id, &$meetupRsvps)
	***********************************************************
	*PURPOSE: Reads into &$data all user ids who are rsvpd for passed $id.
	*INPUT: $user (containing integer)
	*PRE: $id corresponds to an existing record where $id == rsvps.meetup
	*OUTPUT: &$data
	*POST: &$data is an array of user ids.
	*NOTE:
	**********************************************************/
	public function getMeetupRsvps ($id, &$meetupRsvps) {
		$mysqli = Database::connect();
		// SQL to execute:
		$sql = 'SELECT * FROM rsvps WHERE meetup = ?';
		$result = $mysqli->query($sql);
		$q = $mysqli->prepare($sql);
		$q->bind_param('i',$id);
		$q->execute();
		$q->bind_result($rsvpId, $user, $meetup);
		while ($q->fetch()) {
			if ($id == $meetup)
				array_push($meetupRsvps,$user);
		}
		Database::disconnect();
	}
		
	/***********^*   Methods that interface with database  *^**************/
	/***********V* Methods that respond to POSTed commands *V**************/
	
	
	/* runIndex()
	***********************************************************
	*PURPOSE: Checks GET and POST for commands and determines how to respond;
	*					if no valid commands in either, defaults to printing standard
	*					index screen.
	*INPUT: N/A
	*PRE: N/A
	*OUTPUT: N/A 
	*POST: Request responded to; Appropriate screen is printed to display.
	*NOTE:
	**********************************************************/
	public function runIndex () {
		session_start();
		// Respond to commands in $_POST
		if ($_POST['cmd'] == 'login') { // If login cmd sent from login screen
			self::runLogin();
		}
		else if (empty($_SESSION['id'])) { // If not logged in (and not trying) 
			self::displayLogin();
		}
		else if ($_POST['cmd'] == 'create') { // If create cmd sent from create screen
			self::runCreate();
		}
		else if ($_POST['cmd'] == 'update') { // If update cmd sent from update screen
			self::runUpdate();
		}
		else if ($_POST['cmd'] == 'delete') { // If delete cmd sent from delete screen
			self::runDelete();
		}
		else if ($_POST['cmd'] == 'rsvp') { // If rsvp cmd sent from front screen
			self::runRsvp();
		}
		else if ($_POST['cmd'] == 'unrsvp') { // If unrsvp cmd sent from front screen
			self::runUnRsvp();
		}
		// Respond to commands in $_GET
		else if ($_GET['cmd'] == 'logout') { // If logout link clicked on front screen
			self::runLogout();
		}
		else if ($_GET['cmd'] == 'create') { // If create link clicked on front screen
			self::displayCreate();
		}
		else if ($_GET['cmd'] == 'read') { // If read link clicked on front screen
			self::displayRead();
		}
		else if ($_GET['cmd'] == 'update') { // If update link clicked on front screen
			self::displayUpdate();
		}
		else if ($_GET['cmd'] == 'delete') { // If delete link clicked on front screen
			self::displayDelete();
		}
		else if ($_GET['cmd'] == 'src') { // We'll show our source code if anyone asks!
		  // Show diagrams first
			echo '<p>ER Diagram<br /><img src=ERDiagram.png><p>Screen Flow Diagram<br /><img src=screenFlowDiagram.png><p>UML Class Diagram<br /><img src=UMLDiagram.png><p>Source Code</p>';
			show_source(__FILE__);
		}
		
		// If none of the above posted/gotten:
		// Default to showing standard front screen
		else {
			self::displayFront();
		}
	}

	/* runLogin()
	***********************************************************
	*PURPOSE: Reads posted id and password, verifies, and starts session.
	*INPUT: N/A
	*PRE: 'id' and 'password' posted (if not, shows login screen again)
	*OUTPUT: N/A 
	*POST: If valid id and password posted, session started and redirected to front page.
	*			 Otherwise, redirected to login page with error message.
	*NOTE:
	**********************************************************/
	public function runLogin () {
		if ($_POST['id'] == null || $_POST['password'] == null) {
			self::displayLogin();
			echo 'User ID and Password required.';
		}
		else {
			$id = $_POST['id'];
			$password = $_POST['password'];
			self::readUser($id,$data);
			if ($data['password'] == $password) {
				$_SESSION['id'] = $data['id'];
				$_SESSION['name'] = $data['name'];
				header("Location: index.php");
			}
			else {
				self::displayLogin();
				echo 'Incorrect password.';
				echo $data['id'];
				echo $data['password'];
			}
		}
	}

	/* runLogout()
	***********************************************************
	*PURPOSE: Ends session and unsets session['id']
	*INPUT: N/A
	*PRE: N/A
	*OUTPUT: N/A 
	*POST: Session destroyed; session id unset; redirected to login page.
	*NOTE:
	**********************************************************/
	public function runLogout () {
		$_SESSION['id'] = ""; // Unset session variable
		header("Location: index.php");
		session_destroy(); // end session
	}

	/* runCreate()
	***********************************************************
	*PURPOSE: Responds to posted create request.
	*INPUT: N/A
	*PRE: User is logged in (SESSION['id'] is set to valid user id)
	*OUTPUT: N/A 
	*POST: If posted data is valid, new meetup record is added.
	*			 If any is invalid, displayCreate screen is shown again with
	*			 error message.
	*NOTE:
	**********************************************************/
	public function runCreate () {
		// Read posted values
		$name = $_POST['name'];
		$location = $_POST['location'];
		$description = $_POST['description'];
		$start = $_POST['start'];
		$end = $_POST['end'];
		
		// Validate input
		self::validateMeetup($name,$location,$description,$start,$end,$valid,$errorHtml);

		// If valid, add
		if ($valid) {
			$host = $_SESSION['id'];
			self::createMeetup($name,$location,$host,$description,$start,$end);
			header("Location: index.php?tableMode=mySeshes");
		}
		// If invalid, show screen again with error messages
		else {
			self::displayCreate($name,$location,$description,$start,$end);
			echo $errorHtml;
		} 
	}

	/* runUpdate()
	***********************************************************
	*PURPOSE: Responds to posted update request.
	*INPUT: N/A
	*PRE: N/A
	*OUTPUT: N/A 
	*POST: If the current user is not the host of the record in question, redirects to index.
	*			 If user is host and data is valid, meetup record is updated.
	*			 If user is host and data invalid, displayUpdate screen is shown again with error message.
	*NOTE:
	**********************************************************/
	public function runUpdate () {
		// Read posted values
		$id = $_POST['id'];
		$name = $_POST['name'];
		$location = $_POST['location'];
		$description = $_POST['description'];
		$start = $_POST['start'];
		$end = $_POST['end'];
		
		// Validate input
		self::validateMeetup($name,$location,$description,$start,$end,$valid,$errorHtml);

		// If valid and current user's id matches host's id, add
		if ($valid) {
			self::readMeetup($id, $data);
			if ($data['host'] == $_SESSION['id']) // if host matches current user's id
				self::updateMeetup($id,$name,$location,$description,$start,$end); // update it
			header("Location: index.php?tableMode=mySeshes"); // Either way, redirect
		}
		// If invalid, show screen again with error messages
		else {
			self::displayUpdate($id,$name,$location,$description,$start,$end);
			echo $errorHtml;
		} 
	}

	/* runDelete()
	***********************************************************
	*PURPOSE: Responds to posted delete request.
	*INPUT: N/A
	*PRE: N/A
	*OUTPUT: N/A 
	*POST: If the current user is not the host of the record in question, redirects to index.
	*			 If user is host, meetup record with posted id no longer exists in meetups table.
	*NOTE:
	**********************************************************/
	public function runDelete () {
		$id = $_POST['id'];
		// If ID is posted 
		if ($id != null) {
			self::readMeetup($id, $data);
			if ($data['host'] == $_SESSION['id']) // and host matches current user's id
				self::deleteMeetup($id); // delete it
			else 
				header("Location: index.php");
		}
		header("Location: index.php");
	}

	/* runRsvp()
	***********************************************************
	*PURPOSE: Creates an rsvps record with posted meetup id and SESSION user id.
	*INPUT: N/A
	*PRE: N/A
	*OUTPUT: N/A 
	*POST: If valid meetup and user ids provided, new rsvp created.
	*NOTE:
	**********************************************************/
	public function runRsvp () {
		if ($_POST['meetup'] == null || $_SESSION['id'] == null) { // If meetup/user id not posted/set
			header("Location: index.php"); // redirect
		}
		else {
			// Create rsvp
			self::createRsvp($_SESSION['id'],$_POST['meetup']);
			header("Location: index.php"); // redirect
		}
	}
	
	/* runUnRsvp()
	***********************************************************
	*PURPOSE: Deletes any rsvps record with posted meetup id and SESSION user id.
	*INPUT: N/A
	*PRE: N/A
	*OUTPUT: N/A 
	*POST: If valid meetup and user ids provided, any existing rsvp linking them is deleted.
	*NOTE:
	**********************************************************/
	public function runUnRsvp () {
		if ($_POST['meetup'] == null || $_SESSION['id'] == null) { // If meetup/user id not posted/set
			header("Location: index.php"); // redirect
		}
		else {
			// Remove rsvp
			self::deleteRsvp($_SESSION['id'],$_POST['meetup']);
			header("Location: index.php"); // redirect
		}
	}
	
	/* validateMeetup($name,$location,$description,$start,$end,&$valid,&$errorHtml)
	***********************************************************
	*PURPOSE: Checks if data is valid, returns boolean in &$valid, HTML error messages in &$errorHtml
	*INPUT: $name $location $description (strings), $start $end (datetimes)
	*PRE: N/A
	*OUTPUT: &$valid (boolean), &$errorHtml (string)
	*POST: If data valid, &$valid is true and &$errorHtml = ''
	*			 If data invalid, &$valid is false and &$errorHtml contains any error messages
	*NOTE:
	**********************************************************/
	public function validateMeetup ($name,$location,$description,$start,$end,&$valid,&$errorHtml) {
		$valid = true;
		$errorHtml = '<br>';
		
		// Create integer timestamps from the time strings in start and end
		if ($start != NULL)
			$startInt = strtotime($start);
		if ($end != NULL)
			$endInt = strtotime($end);
		
		if ($name == NULL) { // If no name provided
			$valid = false;
			$errorHtml .= 'Sesh name required. <br />';
		}
		if ($location == NULL) { // If no location provided
			$valid = false;
			$errorHtml .= 'Location required. <br />';
		}
		if ($description == NULL) { // If no description provided
			$valid = false;
			$errorHtml .= 'Description required. <br />';
		}
		if ($start == NULL) { // If no start time provided
			$valid = false;
			$errorHtml .= 'Start time required. <br />';
		}
		else if ($startInt < time()) { // If Start time is already past
			$valid = false;
			$errorHtml .= 'Start time has already passed. <br />';
		}
		if ($end == NULL) { // If no end time provided
			$valid = false;
			$errorHtml .= 'End time required. <br />';
		}
		else if ($endInt < $startInt) { // If End is before Start
			$valid = false;
			$errorHtml .= 'End time is earlier than Start time. <br />';
		}
		else if ($endInt < ($startInt +3600)) {  // If total duration is less than one hour
			$valid = false;
			$errorHtml .= 'Sesh must last at least 1 hour. <br />';
		}
	}

	/***********^* Methods that respond to POSTed commands *^**************/
	/***********V*      Methods that display screens       *V**************/

	/* displayFront()
	***********************************************************
	*PURPOSE: Echoes HTML of default front screen -- table of meetups, filter links, create/logout buttons.
	*INPUT: N/A
	*PRE: user is logged in (SESSION['id'] set to valid user ID -- as it is, shouldn't be possible to get here without)
	*OUTPUT: N/A 
	*POST: HTML for application front screen spat out.
	*NOTE:
	**********************************************************/
	public function displayFront() {
		$tableMode = 'start';
		if (!($_GET['tableMode'] == null)) { // tablemode refers to how we'll filter/sort the table
			if ($_GET['tableMode'] == 'default') {
				$_SESSION['tableMode'] = ""; // Reset tablemode to default
			}
			else {
				// Otherwise store new tablemode in session
				$_SESSION['tableMode'] = $_GET['tableMode'];
			}
		}
		
		$myRsvps = array();
		self::getMyRsvps($_SESSION['id'],$myRsvps); // Get list of meetups current user's rsvp'd to

		echo '<h1>Study Club: The Study Sesh Solution</h1>';
		echo '<h4>Welcome, ' . $_SESSION['name'] . '!</h4>'; // Print user name
		// Print links to filter table
		echo '<a href="index.php?cmd=create">Create New Sesh</a>&emsp;';
		echo '<a href="index.php?tableMode=default">All Seshes</a>&emsp;';
		echo '<a href="index.php?tableMode=mySeshes">My Hosted Seshes</a>&emsp;';
		echo '<a href="index.php?tableMode=myRsvps">My RSVP\'d Seshes</a>';
		
		// Determine what query to send based on tablemode
		if ($_SESSION['tableMode'] == 'mySeshes') {
			// Results will be limited to ones you're hosting
			$result = self::getAllMyMeetup($_SESSION['id']);
			echo '<h3>My Hosted Seshes:</h3>';
		}
		else if ($_SESSION['tableMode'] == 'myRsvps') {
			// Results will be limited to ones you're RSVP'd to
			$result = self::getAllRsvpdMeetup($_SESSION['id']);
			echo '<h3>My RSVP\'d Seshes:</h3>';
		}
		else {
			// Results won't be limited
			$result = self::getAllMeetup();
			echo '<h3>All Seshes:</h3>';
		}
		
		// Table headings
		echo '<table border="1"><tr>';
		echo '<th>RSVP</th>';
		echo '<th>Sesh Name</th>';
		echo '<th>Description</th>';
		echo '<th>Location</th>';
		echo '<th>Starts</th>';
		echo '<th>Ends</th>';
		echo '<th>People Going</th>';
		echo '<th>Actions</th></tr>';
		// Echo rows
		foreach ($result as $row) { // Get table contents
			//   as $row -- as you iterate through, the current meetup will be named $row
			echo '<tr>';
			
			// First: RSVP button
			echo '<td><form method="post" action="index.php"><input type="hidden" name="meetup" value="';
			echo $row['id']; // Be ready to post id of this meetup
			echo '" />';
			if (in_array($row['id'],$myRsvps)) { // If user's RSVP'd to this meetup
				// Display a lit-up button that if clicked, un-rsvps
				echo '<input type="hidden" name="cmd" value="unrsvp" /><input type="image" src="rsvpd.png" /></form></td>';
			}
			else { // If user's not RSVP'd to this meetup
				// Display a dim button that if clicked, rsvps
				echo '<input type="hidden" name="cmd" value="rsvp" /><input type="image" src="notrsvpd.png" /></form></td>';
			}
			
			// Continue with the standard fields
			echo '<td>' . $row['name'] . '</td>'; // Name
			echo '<td>' . $row['description'] . '</td>'; // Description
			echo '<td>' . $row['location'] . '</td>'; // Location
			echo '<td>' . $row['start'] . '</td>'; // Start time
			echo '<td>' . $row['end'] . '</td>'; // End time
			
			// Read in the user ids who are rsvp'd to this meetup
			$rsvpList = array();
			self::getMeetupRsvps($row['id'],$rsvpList);
			echo '<td>' . count($rsvpList) . '</td>'; // Number of people going
			
			// Actions
			echo '<td><a href="index.php?cmd=read&id=' . $row['id'] . '">Read</a> ';
			if ($_SESSION['id'] == $row['host']) { // If current user's id matches user id on the record
				echo '<a href="index.php?cmd=update&id=' . $row['id'] . '">Update</a> '; // show these options
				echo '<a href="index.php?cmd=delete&id=' . $row['id'] . '">Delete</a> </td>';
			}
			echo '</tr>';
		} // End of table drawing loop
		echo '</table><br />';
		
		// Draw logout button
		echo '<a href="index.php?cmd=logout">Logout</a>';
	}

	/* displayLogin()
	***********************************************************
	*PURPOSE: Echoes HTML of login screen - heading, login form
	*INPUT: N/A
	*PRE: N/A
	*OUTPUT: N/A 
	*POST: HTML for application login screen spat out.
	*NOTE:
	**********************************************************/
	public function displayLogin () {
		// DISPLAY LOGIN SCREEN
		echo '<h1>Study Club: The Study Sesh Solution</h1>';
		echo '<form action="index.php" method="post">';
		echo '<h2>Login with your Student/Faculty ID and Password to get started!</h2>';
		echo '<input type="text" name="id" placeholder="User ID" /> <br />';
		echo '<input type="password" name="password" placeholder="Password" /> <br />';
		echo '<input type="hidden" name="cmd" value="login" />';
		echo '<input type="submit" /> <br />';
		echo '</form>';	
	}
	
	/* displayCreate($name,$location,$description,$start,$end)
	***********************************************************
	*PURPOSE: Echoes HTML of create meetup screen -- heading, create form, back button.
	*					If values are passed, form fields are populated with them.
	*INPUT: $name $location $description (strings), $start $end (datetime)
	*PRE: user is logged in (SESSION['id'] set to valid user ID  -- as it is, shouldn't be possible to get here without)
	*OUTPUT: N/A 
	*POST: HTML for application create meetup screen spat out.
	*NOTE:
	**********************************************************/
	public function displayCreate ($name,$location,$description,$start,$end) {
		// DISPLAY CREATE SCREEN
		echo '<form action="index.php" method="post">';
		echo '<h2>Host New Sesh</h2>';
		// Event name
		echo '<input type="text" name="name" placeholder="Sesh Name" value="';
		if (!($name == null)) echo $name;
		echo '" /> Name the sesh. <br />';
		// Location
		echo '<input type="text" name="location" placeholder="Location" value="';
		if (!($location == null)) echo $location;
		echo '"/> Where will it take place? <br />';
		// Event description
		echo '<input type="text" name="description" placeholder="Description" value="';
		if (!($description == null)) echo $description;
		echo '"/> Briefly describe the sesh, including what you\'ll be working on. <br />';
		// Start time
		echo '<input type="datetime-local" name="start" value="';
		if (!($start == null)) echo $start;
		echo '"/>  Select start date and time. <br /> ';
		// End time
		echo '<input type="datetime-local" name="end" value="';
		if (!($end == null)) echo $end;
		echo '"/>  Select end date and time.<br /> ';
		// Submit button
		echo '<input type="hidden" name="cmd" value="create" />';
		echo '<input type="submit" />&emsp;&emsp;<a href="index.php">Cancel</a> <br />';
		echo '</form>';
	}

	/* displayRead()
	***********************************************************
	*PURPOSE: Echoes HTML of read meetup screen for posted id -- heading, each record field.
						Values are read from record where id = posted id.
	*INPUT: N/A
	*PRE: user is logged in (SESSION['id'] set to valid user ID -- as it is, shouldn't be possible to get here without)
	*OUTPUT: N/A 
	*POST: HTML for application read screen spat out.
	*			 If no id posted, redirected.
	*NOTE:
	**********************************************************/
	public function displayRead () {
		if ($_GET['id'] == null) { // redirect if null
			header("Location: index.php");
		}
		else {
			
			// Read id and get record from database
			$id = $_GET['id'];
			self::readMeetup($id, $data);
			
			$host = $data['host'];
			self::readUser($host,$userData);
			
			// DISPLAY READ SCREEN
			echo '<h2>Sesh Details</h2>';
			echo '<table>';
			echo '<tr><td>Sesh Name:</td><td>' . $data['name'] . '</td></tr>';
			echo '<tr><td>Host:</td><td>' . $userData['name'] . '</td></tr>';
			echo '<tr><td>Location:</td><td>' . $data['location'] . '</td></tr>';
			echo '<tr><td>Description:</td><td>' . $data['description'] . '</td></tr>';
			echo '<tr><td>Start Time:</td><td>' . date("Y-m-d H:i", strtotime($data['start'])) . '</td></tr>';
			echo '<tr><td>End Time:</td><td>' . date("Y-m-d H:i", strtotime($data['end'])) . '</td></tr>';
			echo '</table>';
			echo '<br /><br /><a type="btn" href="index.php">Back</a>'; // Back link
		}
	}

	/* displayUpdate($id,$name,$location,$description,$start,$end)
	***********************************************************
	*PURPOSE: Echoes HTML of update meetup screen -- heading, update form, back button.
	*					If data values are passed, form fields are populated with them.
	*					Otherwise, values are read from the record in the meetups table where id = $id.
	*INPUT: $id (int), $name $location $description (strings), $start $end (datetime)
	*PRE: user is logged in (SESSION['id'] set to valid user ID  -- as it is, shouldn't be possible to get here without)
	*OUTPUT: N/A 
	*POST: HTML for application update meetup screen spat out.
	*NOTE:
	**********************************************************/
	public function displayUpdate ($id,$name,$location,$description,$start,$end) {
		if ($_GET['id'] == null && $id == null) { // redirect if no id provided
			header("Location: index.php");
		}
		else {
			if ($_GET['id'] != null) { // If id in get, don't use passed values
				$id = $_GET['id']; // get id and record from database
				self::readMeetup($id, $data);
			}
			if ($data['host'] != $_SESSION['id']) { // Redirect if host id and current user id don't match
				header("Location: index.php");
			}
			
			// DISPLAY UPDATE SCREEN
			echo '<form action="index.php" method="post">';
			echo '<h2>Update Sesh Details</h2>';
			// Event name
			echo '<input type="text" name="name" placeholder="Sesh Name" value="';
			if (!($name == null)) echo $name;
			else echo $data['name'];
			echo '" /> Name the sesh. <br />';
			// Location
			echo '<input type="text" name="location" placeholder="Location" value="';
			if (!($location == null)) echo $location;
			else echo $data['location'];
			echo '"/> Where will it take place? <br />';
			// Event description
			echo '<input type="text" name="description" placeholder="Description" value="';
			if (!($description == null)) echo $description;
			else echo $data['description'];
			echo '"/> Briefly describe the sesh, including what you\'ll be working on. <br />';
			// Start time
			echo '<input type="datetime-local" name="start" value="';
			if (!($start == null)) echo $start;
			else echo $data['start'];
			echo '"/>  Select start date and time. <br /> ';
			// End time
			echo '<input type="datetime-local" name="end" value="';
			if (!($end == null)) echo $end;
			else echo $data['end'];
			echo '"/>  Select end date and time.<br /><br /> ';
			// Submit button
			echo '<input type="hidden" name="id" value="'; // Because hidden fields can be edited by user,
			echo $id;														// we'll need to double-check that $id = session user id later. 
			echo '" />';
			echo '<input type="hidden" name="cmd" value="update" />';
			echo '<input type="submit" value="Update" />&emsp;&emsp;<a href="index.php">Cancel</a> <br />';
			echo '</form>';
		}
	}

	/* displayDelete()
	***********************************************************
	*PURPOSE: Echoes HTML of delete meetup confirmation screen -- heading, record contents, back button.
	*					Values are read from record where id = posted id.
	*INPUT: N/A
	*PRE: user is logged in (SESSION['id'] set to valid user ID -- as it is, shouldn't be possible to get here without)
	*OUTPUT: N/A 
	*POST: HTML for delete meetup confirmation screen spat out for record whose id is posted.
	*NOTE:
	**********************************************************/
	public function displayDelete () {
		if ($_GET['id'] == null) { // redirect if null
			header("Location: index.php");
		}
		else {
			// Read id and get record from database
			$id = $_GET['id'];
			self::readMeetup($id, $data);
			if ($data['host'] != $_SESSION['id']) { // Redirect if host id and current user id don't match
				header("Location: index.php");
			}
			
			// DISPLAY DELETE SCREEN
			echo '<form action="index.php" method="post">';
			echo '<h2>Delete Sesh?</h2><br />';
			echo '<table>';
			echo '<tr><td>Sesh Name:</td><td>' . $data['name'] . '</td></tr>';
			echo '<tr><td>Location:</td><td>' . $data['location'] . '</td></tr>';
			echo '<tr><td>Description:</td><td>' . $data['description'] . '</td></tr>';
			echo '<tr><td>Start Time:</td><td>' . date("Y-m-d H:i", strtotime($data['start'])) . '</td></tr>';
			echo '<tr><td>End Time:</td><td>' . date("Y-m-d H:i", strtotime($data['end'])) . '</td></tr>';
			echo '</table><br /><br />';
			// Echo hidden values and submit button
			echo '<input type="hidden" name="id" value="'; // Because hidden fields can be edited by user,
			echo $id;														// we'll need to double-check that $id = session user id later. 
			echo '" />'; 
			echo '<input type="hidden" name="cmd" value="delete" />'; 
			echo '<input type="submit" value="Confirm Delete" />&emsp;&emsp;';    
			echo '<a type="btn" href="index.php">Back</a>'; // Back link
			echo '</form>';
		}
	}
}

/**********************************************/
/* Create new gateway and tell it to runIndex */
/**********************************************/
$gtwy = new StudyGateway();
$gtwy->runIndex();

?>