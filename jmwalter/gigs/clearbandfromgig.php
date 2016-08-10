<?php
/* *******************************************************************
* filename : clearbandfromgig.php
* author : Joshua Walters
* username : jmwalter
* course : cis355
* section : 11-MW
* semester : Summer 2016
*
* description : this program uses the gigId gotten from the get request to clear
* any booked band from the gig and sets the gig as open. 
*
* purpose: if the business had chosen a band and wants to unhire that band 
* and set the gig as open again they will use this page
*
* input : database.php
*
* processing : 
* 1. checks the get request for gigId
* 2. updates the gig from gigs table with the gigId and changes bookedbands to 0 and 
* open to true
*
* output : no output (but changes the data in gigs)
*
* precondition : needs to have gigId in the get request
* *******************************************************************
*/ 
	session_start();
	require 'database.php';
	$gigId = null;

	
	$dest = "Location: home.php?&errorMsg=removingBand";
	if ( !empty($_GET['gigId'])) {
		$gigId = $_REQUEST['gigId'];
	}
			
	if($gigId == null )
	{
		header($dest);
	}
	else
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "UPDATE gigs  set open = ?, bookedBand = ? WHERE gigId = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array(1,"",$gigId));
		header("Location: chooseband.php?gigId=" . $gigId);
		Database::disconnect();
	}
	?>	
