<!--
/* *******************************************************************
* filename : reviewusersub.php
* author : Gage Beckett
* username : sgbecket
* course : CIS355
* section : 11-MW
* semester : Summer 2016
*
* description : admin page for approving or rejecting the a user submission. 
*
* input : button click to approve or reject the submission
* output : adds to anime and removes from usersub as well as just deleting from usersub
*
* precondition : none
* postcondition: none
* *******************************************************************-->
<?php

class ReviewUser{
	
		function __construct(){
		echo'
		<head>
		<title>User Submissions</title>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		</head>';
	}
	function remove(){
	

	
	
	$id = $_REQUEST['delete'];                  //get id value from url
	$con=$this->connect();                      //call connect function to connect with database
	$sql = "DELETE FROM `user submission` WHERE name = '$id'"; //variable to hold sql statement
	if(!empty($_POST)){                         //if the user posted
		$con->query($sql);                      //query the database
		$this->redirect();
	
	}
	//display modal asking user to confirm delete
		echo '    		
		<script>
			function loadModal(){
				$("#myModal").modal("show");
			}
		</script>
		</head>
		<body onload="loadModal();">
		<div class="container">

		  <!-- Modal -->
		  <div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog">
			  <!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <a type="button" class="close" href="reviewusersub.php">&times;</a>
				  <h4 class="modal-title">Anime: ';echo $id; echo'</h4>
				</div>
				<div class="modal-body">
				  <form class="form-horizontal" action="reviewusersub.php?delete=';echo $id;echo'" method="post">
					<input type="hidden" name="id" value="'; echo $id; echo'"/>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-danger">Yes</button>
						  <a class="btn btn-default" href="reviewusersub.php">No</a>
					  </div>
					</form>
				<div class="modal-footer">
				  <a type="button" class="btn btn-default" href="reviewusersub.php" >Close</a>
				</div>
			  </div>     
			</div>
		  </div>
		</div>
		</body>
		</html>';
	}
	private function connect(){
		$c = mysqli_connect("localhost","sgbecket","42BeckettSG","sgbecket");
		if (mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else{return $c;}
	}
	function readUserSub(){
		$con = $this->connect();
		$sql = "SELECT * FROM `user submission`;";
  echo '<table class="table table-striped table-bordered">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Genre</th>
                  <th>Period</th>
                  <th>Style</th>
                </tr>
              </thead>
              <tbody>';
			foreach ($con->query($sql) as $row) {
				echo '<tr>';
				echo '<td>'. $row['name'] . '</td>';
				echo '<td>'. $row['genre'] . '</td>';
				echo '<td>'. $row['period'] . '</td>';
				echo '<td>'. $row['style'] . '</td>';
				echo '<td width=250>';
				echo '<a class="btn btn-info" href="approved.php?name='. $row['name'].'&genre='. $row['genre'].'&period='. $row['period'].'&style='. $row['style'].'">Approve</a>';
				echo '<a class="btn btn-info" href="reviewusersub.php?delete=' . $row['name'] .'">Reject</a>';
				echo'</td>';
				echo'</tr>';
			}
	}
}
$rev = new ReviewUser;
$rev->readUserSub();
if(!empty($_GET['delete'])){
	$rev->remove();
}
?>