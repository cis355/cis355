<?php
//the details of 
require 'database.php';

class Musician { 

	 /**
	 * contructor for this class 
	 */
	 function __construct () {  
     
    } 
	/**
	*method used to list all musicians in the db and print them out in html tables 
	*/
	function listMusicians()
	{
	//the html to start a table and list musicians 
	echo "<!DOCTYPE html>
	<html lang='en'>
	<head>
			<meta charset='utf-8'>
			<link   href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' rel='stylesheet'>
			<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
	</head>

	<body>
		<div class='container'>
				<div class='row'>
					<h3>Musicians</h3>
				</div>
			<div class='row'>
				<p>
					<a href='create.php' class='btn btn-success'>Create</a>
				</p>
				
				<table class='table table-striped table-bordered'>
				<thead>
					<tr>
						<th>id</th>
						<th>Musician Name</th>
						<th>Instrument played</th>
						<th>Email address</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>";
						
						//defining vars used to link to database
						define('DBHOST', 'localhost'); 
						define('DBNAME', 'jmwalter'); 
						define('DBUSER', 'jmwalter'); 
						define('DBPASS', '580055');
							
						$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME); 
						//checking if you can connect
						$error = mysqli_connect_error(); 
						if ($error != null) { 
								$output = "<p>Unable to connect to database<p>" . $error; 
								exit($output); 
						} else { 

						} 
						//sql statment to read all musicians in desc order 
						$sql = 'SELECT * FROM musicians ORDER BY id DESC';
						$result = mysqli_query($connection, $sql);
						//building the body of the table bassed on the data in $results
						foreach ($result as $row) 
						{
							echo '<tr>';
							echo '<td>'. $row['id'] . '</td>';
							echo '<td>'. $row['name'] . '</td>';
							echo '<td>'. $row['instrument'] . '</td>';
							echo '<td>'. $row['email'] . '</td>';
							echo '<td width=250>';
							//button for reading data
							echo '<a class="btn btn-primary" href="read.php?id='.$row['id'].'">Read</a>';
							echo '&nbsp;';
							//button for upsating data 
							echo '<a class="btn btn-success" href="update.php?id='.$row['id'].'">Update</a>';
							echo '&nbsp;';
							//button for deleteing musicians
							echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Delete</a>';
							echo '</td>';
							echo '</tr>';
						}
						//close out table and html text
						echo "</tbody>
						</table>
					</div>
				</div>
			</body>
		</html>";
		}
		/*
		*reads the data in the musician recor that has id $id
		*parameter: $id is the id of the musician to be read
		*/
		function readMusician($id)
		{
			//defining the vars used to link to the db 
			define('DBHOST', 'localhost'); 
			define('DBNAME', 'jmwalter'); 
			define('DBUSER', 'jmwalter'); 
			define('DBPASS', '580055');
			
			//creates an instance of mysqli object
			$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME); 
			
			//defines the db object
			$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
			
			//chekcing if we were able to connect
			$error = mysqli_connect_error(); 
			if ($error != null) { 
					$output = "<p>Unable to connect to database<p>" . $error; 
					exit($output); 
			} else { 

			} 
			//sql string to get the musician data were id = $id
			$sql = "SELECT * FROM musicians WHERE id = '" . $id . "'";
			
			//output if there was a query error
			if(!$result = $db->query($sql)){
					die('There was an error running the query [' . $db->error . ']');
			}
			$row = $result->fetch_assoc();
				
			//kicking out html for our form 
			echo "<!DOCTYPE html>
			<html lang='en'>
			<head>
					<meta charset='utf-8'>
					<link   href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' rel='stylesheet'>
					<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
					<style>
					.control-label { color: blue; }
					</style>
			</head>

			<body>
				<div class='container'>
				
							<div class='span10 offset1'>
								<div class='row'>
									<h3>Read a Customer</h3>
								</div>
								
								<div class='form-horizontal' >
								<div class='control-group'>
									<label class='control-label'>Name</label>
									<div class='controls'>
										<label class='checkbox'>" . $row['name'] . "
										</label>
									</div>
								</div>
								<div class='control-group'>
									<label class='control-label'>Instrument played</label>
									<div class='controls'>
											<label class='checkbox'>"
											. $row['instrument'] . "
										</label>
									</div>
								</div>
								<div class='control-group'>
									<label class='control-label'>Email Address</label>
									<div class='controls'>
											<label class='checkbox'>"
											. $row['email'] . "
										</label>
									</div>
								</div>
									<div class='form-actions'>
									<a class='btn btn-danger' href='index.php'>Back</a>
								 </div>
							</div>
						</div>
						
					</div> <!-- /container -->
				</body>
			</html>";
		}
	
		/**
		*does error checking on parameters passed in and 
		*inserts the correct record or prints the form to try again
		*parameters: 
		*$name is name to insert
		*$instrument is the instrument played by inserted user
		*$email is the email address to insert.
		*/
		function createMusician($name,$instrument,$email)
		{
			//init the error vars
			$nameError = null;
			$instrumentError = null;
			$emailError = null;
			
			// validate input
			$valid = true;
			if (empty($name)) {
				$nameError = 'Please enter Name';
				$valid = false;
			}
			
			if (empty($email)) {
				$emailError = 'Please enter Email Address';
				$valid = false;
			} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
				$emailError = 'Please enter a valid Email Address';
				$valid = false;
			}
			
			if (empty($instrument)) {
				$instrumentError = 'Please enter instrument';
				$valid = false;
			}
			
			// insert data
			if ($valid) {
				define('DBHOST', 'localhost'); 
				define('DBNAME', 'jmwalter'); 
				define('DBUSER', 'jmwalter'); 
				define('DBPASS', '580055');
				
				//sqli object creation
				$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME); 
				
				//database object creation
				$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
				
				//checking if we got connected
				$error = mysqli_connect_error(); 
				if ($error != null) { 
						$output = "<p>Unable to connect to database<p>" . $error; 
						exit($output); 
				} else { 

				} 
				//sql statment to insert our record
				$sql = "INSERT INTO musicians (name,instrument,email) values(?, ?, ?)";
				$statement = $db->prepare($sql);
				$statement->bind_param("sss",$name,$instrument,$email);
				$statement->execute();
				header("Location: index.php");
			}
			
			//kick out the html for our create form and error messages 
			echo "<!DOCTYPE html>
			<html lang='en'>
			<head>
					<meta charset='utf-8'>
					<link   href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' rel='stylesheet'>
					<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
			</head>

			<body>
				<div class='container'>
					
								<div class='span10 offset1'>
									<div class='row'>
										<h3>Update a Customer</h3>
									</div>";
							
									echo "<form class='form-horizontal' action='create.php' method='post'>
									<div class='control-group"; echo !empty($nameError)?'error':''; echo "'>
										<label class='control-label'>Name</label>
										<div class='controls'>";
										
												echo "<input name='name' type='text'  placeholder='Name' value='"; echo !empty($name)?$name:''; echo "'>";
												if (!empty($nameError))
													echo "<span class='help-inline'>" .  $nameError . "</span>";
										echo "</div>
									</div>";
										
									echo "<div class='control-group"; echo !empty($instrumentError)?'error':''; echo "'>
										<label class='control-label'>Instrument Played</label>
										<div class='controls'>";
												echo "<input name='instrument' type='text' placeholder='Instrument played' value='"; echo !empty($instrument)?$instrument:''; echo "'>";
												if (!empty($instrumentError)) 
													echo "<span class='help-inline'>" . $instrumentError . "</span>";
												
										echo "</div>
									</div>";
									echo "<div class='control-group"; echo !empty($emailError)?'error':''; echo "'>";
										echo "<label class='control-label'>Email Address</label>
										<div class='controls'>";
												echo "<input name='email' type='text'  placeholder='Email Address' value='";echo !empty($email)?$email:''; echo "'>";
												if (!empty($emailError))
													echo "<span class='help-inline'>" . $emailError . "</span>";
												
									echo "	</div>
									</div>
									<div class='form-actions'>
										<button type='submit' class='btn btn-success'>Update</button>
										<a class='btn' href='index.php'>Back</a>
									</div>
								</form>
							</div>
							
					</div> <!-- /container -->
				</body>
			</html>";
		}
		
		/**
		*this is if the first time you go to create.php and the create form needs to be printed
		*/
		function createPrompt()
		{
			//first time error messages are null
			$nameError = null;
			$instrumentError = null;
			$emailError = null;
			//print html and form 
			echo "<!DOCTYPE html>
			<html lang='en'>
			<head>
				<meta charset='utf-8'>
				<link   href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' rel='stylesheet'>
				<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
			</head>

			<body>
				<div class='container'>
						<div class='span10 offset1'>
							<div class='row'>
								<h3>Update a Customer</h3>
							</div>";
				
							echo "<form class='form-horizontal' action='create.php' method='post'>
							<div class='control-group"; echo !empty($nameError)?'error':''; echo "'>
								<label class='control-label'>Name</label>
								<div class='controls'>";
								
										echo "<input name='name' type='text'  placeholder='Name' value='"; echo !empty($name)?$name:''; echo "'>";
										if (!empty($nameError))
											echo "<span class='help-inline'>" .  $nameError . "</span>";
								echo "</div>
							</div>";
								
							echo "<div class='control-group"; echo !empty($instrumentError)?'error':''; echo "'>
								<label class='control-label'>Instrument Played</label>
								<div class='controls'>";
										echo "<input name='instrument' type='text' placeholder='Instrument played' value='"; echo !empty($instrument)?$instrument:''; echo "'>";
										if (!empty($instrumentError)) 
											echo "<span class='help-inline'>" . $instrumentError . "</span>";
										
								echo "</div>
							</div>";
							echo "<div class='control-group"; echo !empty($emailError)?'error':''; echo "'>";
								echo "<label class='control-label'>Email Address</label>
								<div class='controls'>";
										echo "<input name='email' type='text'  placeholder='Email Address' value='";echo !empty($email)?$email:''; echo "'>";
										if (!empty($emailError))
											echo "<span class='help-inline'>" . $emailError . "</span>";
										
							echo "	</div>
							</div>
							<div class='form-actions'>
								<button type='submit' class='btn btn-success'>Create</button>
								<a class='btn' href='index.php'>Back</a>
							</div>
						</form>
					</div>
						
				</div> <!-- /container -->
			</body>
		</html>";
		}
		
		/**
		*updates the musician record with the passed in parameters
		*$name name to update with
		*$instrument instrument to update wiht 
		*$email email to update with
		*$id id of user to update 
		*/
		function updateMusician($name,$instrument,$email,$id)
		{
			//init error vars 
			$nameError = null;
			$instrumentError = null;
			$emailError = null;
			
			// validate input
			$valid = true;
			if (empty($name)) {
				$nameError = 'Please enter Name';
				$valid = false;
			}
			
			if (empty($email)) {
				$emailError = 'Please enter Email Address';
				$valid = false;
			} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
				$emailError = 'Please enter a valid Email Address';
				$valid = false;
			}
			
			if (empty($instrument)) {
				$instrumentError = 'Please enter instrument';
				$valid = false;
			}
			
			// update data
			if ($valid) {
				
				define('DBHOST', 'localhost'); 
				define('DBNAME', 'jmwalter'); 
				define('DBUSER', 'jmwalter'); 
				define('DBPASS', '580055');

				$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME); 
				$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
				$error = mysqli_connect_error(); 
				if ($error != null) { 
						$output = "<p>Unable to connect to database<p>" . $error; 
						exit($output); 
				} else { 

				} 
				$sql = "UPDATE musicians set name = ?, instrument = ?, email =? WHERE id = ?";
				$statement = $db->prepare($sql);
				$statement->bind_param("sssi",$name,$instrument,$email,$id);
				$statement->execute();
				header("Location: index.php");
			}
			
			
			//kicks out the html for the form and error checking 
			echo "<!DOCTYPE html>
			<html lang='en'>
			<head>
					<meta charset='utf-8'>
					<link   href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' rel='stylesheet'>
					<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
			</head>

			<body>
					<div class='container'>
					
								<div class='span10 offset1'>
									<div class='row'>
										<h3>Update a Customer</h3>
									</div>";
						
									echo "<form class='form-horizontal' action='update.php?id=" . $id . "' method='post'>
									<div class='control-group"; echo !empty($nameError)?'error':''; echo "'>
										<label class='control-label'>Name</label>
										<div class='controls'>";
										
												echo "<input name='name' type='text'  placeholder='Name' value='"; echo !empty($name)?$name:''; echo "'>";
												if (!empty($nameError))
													echo "<span class='help-inline'>" .  $nameError . "</span>";
										echo "</div>
									</div>";
										
									echo "<div class='control-group"; echo !empty($instrumentError)?'error':''; echo "'>
										<label class='control-label'>Instrument Played</label>
										<div class='controls'>";
												echo "<input name='instrument' type='text' placeholder='Instrument played' value='"; echo !empty($instrument)?$instrument:''; echo "'>";
												if (!empty($instrumentError)) 
													echo "<span class='help-inline'>" . $instrumentError . "</span>";
												
										echo "</div>
									</div>";
									echo "<div class='control-group"; echo !empty($emailError)?'error':''; echo "'>";
										echo "<label class='control-label'>Email Address</label>
										<div class='controls'>";
												echo "<input name='email' type='text'  placeholder='Email Address' value='";echo !empty($email)?$email:''; echo "'>";
												if (!empty($emailError))
													echo "<span class='help-inline'>" . $emailError . "</span>";
												
									echo "	</div>
									</div>
									<div class='form-actions'>
										<button type='submit' class='btn btn-success'>Update</button>
										<a class='btn' href='index.php'>Back</a>
									</div>
								</form>
							</div>
							
					</div> <!-- /container -->
				</body>
			</html>";
		}
		
		/**
		* will pre fill the fields in the update with the data already in the db 
		*/
		function fillMusicianFields($id)
		{
			define('DBHOST', 'localhost'); 
			define('DBNAME', 'jmwalter'); 
			define('DBUSER', 'jmwalter'); 
			define('DBPASS', '580055');

			$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME); 
			$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
			$error = mysqli_connect_error(); 
			if ($error != null) { 
					$output = "<p>Unable to connect to database<p>" . $error; 
					exit($output); 
			} else { 

			} 
			// using this we can get the data already in the db and pre fill the fields for the user. 
			$sql = "SELECT * FROM musicians where id = '" . $id . "'";
				if(!$result = $db->query($sql)){
					die('There was an error running the query [' . $db->error . ']');
			}
			$row = $result->fetch_assoc();
			$name = $row['name'];
			$instrument = $row['instrument'];
			$email = $row['email'];
			
			//kicks out the html for the forms with pre filled data
			echo "<!DOCTYPE html>
			<html lang='en'>
			<head>
				<meta charset='utf-8'>
				<link   href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' rel='stylesheet'>
				<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
			</head>

			<body>
					<div class='container'>
							<div class='span10 offset1'>
								<div class='row'>
									<h3>Update a Customer</h3>
								</div>";
					
								echo "<form class='form-horizontal' action='update.php?id=" . $id . "' method='post'>
								<div class='control-group"; echo !empty($nameError)?'error':''; echo "'>
									<label class='control-label'>Name</label>
									<div class='controls'>";
									
											echo "<input name='name' type='text'  placeholder='Name' value='"; echo !empty($name)?$name:''; echo "'>";
											if (!empty($nameError))
												echo "<span class='help-inline'>" .  $nameError . "</span>";
									echo "</div>
								</div>";
									
								echo "<div class='control-group"; echo !empty($instrumentError)?'error':''; echo "'>
									<label class='control-label'>Instrument Played</label>
									<div class='controls'>";
											echo "<input name='instrument' type='text' placeholder='Instrument played' value='"; echo !empty($instrument)?$instrument:''; echo "'>";
											if (!empty($instrumentError)) 
												echo "<span class='help-inline'>" . $instrumentError . "</span>";
											
									echo "</div>
								</div>";
								echo "<div class='control-group"; echo !empty($emailError)?'error':''; echo "'>";
									echo "<label class='control-label'>Email Address</label>
									<div class='controls'>";
											echo "<input name='email' type='text'  placeholder='Email Address' value='";echo !empty($email)?$email:''; echo "'>";
											if (!empty($emailError))
												echo "<span class='help-inline'>" . $emailError . "</span>";
											
								echo "	</div>
								</div>
								<div class='form-actions'>
									<button type='submit' class='btn btn-success'>Update</button>
									<a class='btn' href='index.php'>Back</a>
								</div>
							</form>
						</div>
					</div> <!-- /container -->
				</body>
			</html>";	
		}
		
		/**
		*this will delete the user with id $id and yes was selected from the delete prompt
		*/
		function deleteMusician($id)
		{
				define('DBHOST', 'localhost'); 
				define('DBNAME', 'jmwalter'); 
				define('DBUSER', 'jmwalter'); 
				define('DBPASS', '580055');

				$connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME); 
				$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
				$error = mysqli_connect_error(); 
				if ($error != null) { 
						$output = "<p>Unable to connect to database<p>" . $error; 
						exit($output); 
				} else { 

				} 
				$sql = "DELETE FROM musicians WHERE id = ?";
				$statement = $db->prepare($sql);
				$statement->bind_param("i",$id);
				$statement->execute();
			header("Location: index.php");
		}
		
		/**
		*show the delete prompt "ar you sure yes/no"
		*parameter $id is the id of the musician to delete
		*/
		function showDeleteChoice($id)
		{
			//kicks out html for the form and prompt
			echo "<!DOCTYPE html>
			<html lang='en'>
			<head>
				<meta charset='utf-8'>
				<link   href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' rel='stylesheet'>
				<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
			</head>

			<body>
				<div class='container'>
				
					<div class='span10 offset1'>
						<div class='row'>
							<h3>Delete a musician</h3>
						</div>
						
						<form class='form-horizontal' action='delete.php?id=" . $id . "' method='post'>
						  <input type='hidden' name='id' value='" . $id . "'/>
						  <p class='alert alert-error'>Are you sure to delete ?</p>
						  <div class='form-actions'>
							  <button type='submit' class='btn btn-danger'>Yes</button>
							  <a class='btn' href='index.php'>No</a>
							</div>
						</form>
					</div>
							
				</div> <!-- /container -->
			  </body>
			</html>";
		}
		
}
show_source(__FILE__); 
?>