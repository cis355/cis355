<!-- ========================================================================

   _____      _  __  __  ______            _       ______ __     __
  / ____|    | ||  \/  ||  ____|    /\    | |     |  ____|\ \   / /
 | |         | || \  / || |__      /  \   | |     | |__    \ \_/ / 
 | |     _   | || |\/| ||  __|    / /\ \  | |     |  __|    \   /  
 | |____| |__| || |  | || |____  / ____ \ | |____ | |____    | |   
  \_____|\____/ |_|  |_||______|/_/    \_\|______||______|   |_|   
   _____  _____   _____        ____   _____  _____                 
  / ____||_   _| / ____|      |___ \ | ____|| ____|                
 | |       | |  | (___  ______  __) || |__  | |__                  
 | |       | |   \___ \|______||__ < |___ \ |___ \                 
 | |____  _| |_  ____) |       ___) | ___) | ___) |                
  \_____||_____||_____/       |____/ |____/ |____/                 
                                                         

filename  : semesterProj.php
author    : Colin Mealey
date      : 2016-08-08
email     : cjmealey@svsu.edu
course    : CIS-355
link      : csis.svsu.edu/~gpcorser/cis355/cjmealey/semesterProj/semesterProj.php
backup    : github.com/cis355/cis355
purpose   : This file displays all the created campaigns

copyright : GNU General Public License (http://www.gnu.org/licenses/)
      This program is free software: you can redistribute it and/or modify
      it under the terms of the GNU General Public License as published by
      the Free Software Foundation, either version 3 of the License, or
      (at your option) any later version.
      This program is distributed in the hope that it will be useful,
      but WITHOUT ANY WARRANTY; without even the implied warranty of
      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.   
            
external code used in this file: 
      Some code adapted from STAR Tutorials
      
program structure : 
      HTML Header
      session
      HTML for table
        PHP fills table
        SQL statement
      close tags

                
======================================================================== -->

<!DOCTYPE html>
<html lang="en">
<head>
  <title>DnDatabase</title>
  <link rel="icon" type="image/png" href="favicon.ico">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://bootswatch.com/sandstone/bootstrap.min.css">
  <!--link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link href='https://fonts.googleapis.com/css?family=Shadows+Into+Light' rel='stylesheet' type='text/css'>
  <!--<link href='https://fonts.googleapis.com/css?family=Vollkorn' rel='stylesheet' type='text/css'>
  <style>body{font-family: 'Vollkorn', serif;}</style>-->
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
        <li><a href="user_profile.php">Profile</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


<?php

session_start();
if(empty($_SESSION['username'])) 
  {header('Location: login.php');}//redirect
else {
   echo' <div class="container"><div class="row"><center><h4>Welcome to Dungeons n&#39; Database, ' . $_SESSION['username'] . '!</h4></center></div></div><br/>';
 } 
?>

    <div class="container">
            <div class="row">
                <center><h2>All Campaigns</h2></center>
            </div>
            <div class="row">
                <p><br/>
                    <center><a href="create.php" class="btn-lg btn-warning">Create New Campaign</a><br/><br/></center>
                </p>
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Title</th>
                      <th>Game Master</th>
                      <th>Location</th>
                      <th>Description</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php

                   include "database.php";
                   $pdo = Database::connect();
                   $sql = "SELECT * FROM campaigns ORDER BY id DESC";
                   foreach ($pdo->query($sql) as $row) {
                            echo "<tr>";
                            echo "<td class='col-xs-2'><strong><q>" . $row['name'] . "</q></strong><br/>ID number: " . $row['id'];
                            echo "<td class='col-xs-1'><a href=other_profile.php?username=" . $row['creator'] . ">" . $row['creator'] . "</td>";
                            echo "<td class='col-xs-1'>" . $row['camplocation'] . "</td>";
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
                                </td>
                            <td class='col-xs-3'>";

                            if($row['creator'] != $_SESSION['username']){
                              echo "<a class='btn btn-primary' href='join_game.php?id=".$row['id']."'>Join Game</a>&nbsp;&nbsp;";
                            }
                            else
                            {
                              echo "<a class='btn btn-danger' href='delete.php?id=".$row['id']."'>Delete</a>&nbsp;&nbsp;";
                              echo "<a class='btn btn-success' href='update.php?id=" . $row['id'] . "'>Update Campaign</a>";
                            }
                            echo "</td></tr>";
                   }
                   Database::disconnect();

                  //show_source(__FILE__);
                  ?>
                  </tbody>
            </table>
        </div>
    </div> <!-- /container -->
  </body>
</html> 