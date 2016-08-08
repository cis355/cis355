<?php
/* *******************************************************************  
* filename     : deletelisting.php 
* author       : Terry Lewis  
* username     : tjlewis2  
* course       : cs355  
* section      : 1  
* semester : Summer 2016  
*  
* description  : This file is responsible for deleting a listing from the 
*				database
*  
* input        : id  
* processing   : The program steps are as follows.    
*          1. connect to database
*		   2. delete listing from posts and listings table
*		 
* output       : none  
*  
* precondition : listing exists
* postcondition: listing is deleted
* *******************************************************************
*/
	session_start();
	
	require 'database.php';
	
	if (empty($_SESSION['name'])) header("Location: login.php");
	
	$listing_id = null;

	if ( !empty($_GET['id'])) {
		$listing_id = $_REQUEST['id'];
	}
	
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$sql = "DELETE from posts WHERE listing_id = '{$listing_id}'";
	$q = $pdo->prepare($sql);
	$q->execute();
	
	$sql = "DELETE from listings  WHERE listingID = '{$listing_id}'";
	$q = $pdo->prepare($sql);
	$q->execute();
	

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	header("Location: mylistings.php");
?>