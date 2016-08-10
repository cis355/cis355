<!--
/* *******************************************************************
* filename : anime.php
* author : Gage Beckett
* username : sgbecket
* course : CIS355
* section : 11-MW
* semester : Summer 2016
*
* description : The table veiw for the anime database that displays the matching
* titles with the user submissions. It also displays the whole list for viewing should it 
* be requested.
*
* input : from the form.php submission, the parameters to search the database for
* output : displays either the whole database or returns the search parameters.
*
* precondition : form.php search parameters
* postcondition: none
* *******************************************************************-->

<?php
class Anime{
	
function __construct(){
	
	echo'
	<head>
	  <title>Matches</title>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		</head>';
}
	function show(){
		$con = $this->connect();
		echo '<a class="btn btn-success" href="home.php">Home</a>';
		$sql = "SELECT * FROM `anime`";
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
				
				echo'</td>';
				echo'</tr>';
			}
	}
	function match($genre, $period, $style){
		$con = $this->connect();

		$sql = "SELECT * FROM `anime` WHERE genre='$genre' AND period='$period' AND style='$style'; ";
  echo '<table class="table table-striped table-bordered">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Genre</th>
                  <th>Period</th>
                  <th>Style</th>
				  <th>More</th>
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
				
				echo '<a class="btn btn-info" href="http://myanimelist.net/anime/20/Naruto">Watch</a>';
				echo'</td>';
				echo'</tr>';
			}
	}

	private function connect(){
		$c = mysqli_connect("localhost","sgbecket","42BeckettSG","sgbecket");
		if (mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		else{return $c;}
	}
}
		$anime = new Anime;
		$genre = $_GET['genre'];
		$period = $_GET['period'];
		$style = $_GET['style'];
		if(!empty($_GET['genre'])){
			$anime->match($genre, $period, $style);
		}else{$anime->show();};
		
		
?>