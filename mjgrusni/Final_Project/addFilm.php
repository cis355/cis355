<?php 

	
	# include connection data and functions
	include_once 'database.php';
	function addFilm($actorID, $filmID, $pdo){			
		// insert data
	
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO `actor_film_mappings` (`actor_id`, `film_id`) VALUES (?, ?);";
		$q = $pdo->prepare($sql);
		$q->execute(array($actorID, $filmID));
		Database::disconnect();
		header("Location: viewActors.php");
			
	}
?>