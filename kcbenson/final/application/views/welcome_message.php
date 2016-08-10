<?php
/* *******************************************************************
* filename : welcome_message.php
* author : Kelsi Benson
* username : kcbenson
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : This program creates a welcome display
* as a landing page for a theme park ride CRUD
* application based upon CodeIgniter grocery_crud
* code used in class.
* The purpose of this program is to demonstrate
* provide a landing for a CRUD application
*
* input : none
* processing : The program steps are as follows.
* 1. read in HTML code
* 2. display coded HTML to screen
* output : welcome screen with links to other pages
*
* precondition : the links must be valid
* postcondition: information printed to the screen
* *******************************************************************
*/

defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to Ride Rater</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>

<div id="container">
	<h1>Welcome to Ride Rater!</h1>

	<div id="body">
		<p>Ride Rater is your home for all your theme park ride planning needs</p>

		<p>Here you will find real users like you who have rated the rides they've ridden.</p>
		<p>You can check out ratings <a href="/~kcbenson/final/index.php/ratings/display">HERE</a>.</p>

		<p>You can sign up and rate the rides you've been on <a href="/~kcbenson/final/index.php/riders/display/add">HERE</a>.</p>

		<p>What are you waiting for? Help your fellow park riders out and get rating or planning your rides!</p>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>