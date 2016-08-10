<!DOCTYPE html>
<html lang="en">
<head>
  <title>DnDatabase</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
 
<body>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="semesterProj.php">Dungeons n' Database</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="semesterProj.php">Campaigns <span class="sr-only">(current)</span></a></li>
        <li><a href="#">Profile</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Logout</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class="container">

<?php
class UserProfile {

	public function connect(){
		$c = mysqli_connect("localhost","cjmealey","564667","cjmealey");
		// Check connection
		if (mysqli_connect_errno()){
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else{
			return($c);
		}
	}

	public function displayProfile(){

		$id = 2;

		$con=$this->connect();
		$sql = "SELECT * FROM players where id = $id ";
		$result=mysqli_query($con,$sql);
		$row=mysqli_fetch_row($result);

		echo'	<div class="container-fluid well span6">
					<div class="row-fluid">
				        <div class="col-xs-3">
				            <h3>' . $row[1] . '</h3>
				            <h6>Email: ' . $row[5] . '</h6>
				            <h6>Location: ' . $row[3] . '</h6>
				        </div>
				        <div class="col-xs-7" style="margin-left:20px;">
				        	<p>' . $row[4] . '</p>
				        </div>
					</div>
					<div class="col-xs-1">
		            <div class="dropdown">
		                <a class="btn dropdown-toggle btn-info" data-toggle="dropdown" href="#">
		                    Action 
		                    <span class="icon-cog icon-white"></span><span class="caret"></span>
		                </a>
		                <ul class="dropdown-menu">
		                    <li><a href="#"><span class="icon-wrench"></span> Modify</a></li>
		                    <li><a href="#"><span class="icon-trash"></span> Delete</a></li>
		                </ul>
		            </div>
		        </div>';
	}

	public function selectJoined(){

		echo'	<table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Joined Campaigns</th>
                      <th>Game Master</th>
                      <th>Location</th>
                      <th>Description</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>';

		$id = 1; 

		$con=$this->connect();
		$sql = "SELECT * FROM campaigns ORDER BY id DESC";
		foreach ($con->query($sql) as $row) {
            echo "<tr>";
            echo "<td class='col-xs-2'><q>" . $row['name'] . "</q><br/>ID: " . $row['id'];
            echo "<td class='col-xs-1'>" . $row['creator'] . "</td>";
            echo "<td class='col-xs-1'>" . $row['location'] . "</td>";
            echo "<td class='col-xs-2'><button type='button' class='btn btn-info'
              data-toggle='modal' data-target='#myModal".$row['id']."'>View Full Description</button>";
            echo '   <div id="myModal'.$row['id'].'" class="modal fade" role="dialog">';
            echo "      <div class='modal-dialog'>

                      <!-- Modal content-->
                      <div class='modal-content'>
                        <div class='modal-header'>
                          <button type='button' class='close' data-dismiss='modal'>&times;</button>
                          <h4 class='modal-title'>The Story of <q>" . $row['name'] . "</q></h4>
                        </div>
                        <div class='modal-body'>
                          <p>" . $row['description'] . "</p>
                        </div>
                        <div class='modal-footer'>
                          <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                        </div>
                      </div>

                    </div>
                  </div>
                </td>";
            echo "<td class='col-xs-3'><a class='btn btn-danger' href='#'>Leave Game</a>&nbsp;&nbsp;";
            echo "</tr>";
		}
	}
}

$profile = new UserProfile;
$profile->displayProfile();
$profile->selectJoined();

?>

</div>
</body>
</html>

