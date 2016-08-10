<!DOCTYPE html>
<!-- *******************************************************************
* filename : example.php
* author : Kelsi Benson
* username : kcbenson
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : This program formats a display of theme park
* riders by reading in data from a SQL database and 
* formatting it with CodeIgniter grocery_crud based code.
* The purpose of this program is to format
* a CRUD application with real world value.
*
* input : controller php files
* processing : The program steps are as follows.
* 1. read in the controllers
* 2. format the data based upon the code below
* 3. output data
* output : formatted database table with create, read
* update and delete functionality.
*
* precondition : the controller file must exist
* postcondition: information printed to the screen,
* *******************************************************************
-->

<html>
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<style type='text/css'>
body
{
	font-family: Arial;
	font-size: 14px;
}
a {
    color: blue;
    text-decoration: none;
    font-size: 14px;
}
a:hover
{
	text-decoration: underline;
}
</style>
</head>
<body>
	<div>
		<a href='<?php echo site_url('rides/display')?>'>Rides</a> |
		<a href='<?php echo site_url('ratings/display')?>'>Ratings</a> |
		<a href='<?php echo site_url('riders/display')?>'>Riders</a> 
		
	</div>
	<div style='height:20px;'></div>  
    <div>
		<?php echo $output; ?>
    </div>
</body>
</html>
