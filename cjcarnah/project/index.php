<?php 

/* *******************************************************************
* filename : userLifts.php
* author : Charles Carnahan
* username : cjcarnah
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* This file uses the class containing the HTML for the site.
*
* input : user input
*
* precondition : database with tables 'users', 'lifts', and 'userLifts' is used.
* *******************************************************************
*/
    //require_once('users.php');
    //require_once('lifts.php');
    require_once('userLifts.php');
        
    //$user = new user();
    //$lift = new lift();
    $userLift = new userLift();
    
    $con = database::connect();

    //Request user Table
    //$user->makeTable($con); 
    //$lift->makeTable($con);
    $userLift->makeTable($con);
    
    //Builds Page 
    //$user->buildPage($con);
    //$lift->buildPage($con);
    $userLift->buildPage($con);
        
    //Checks to see if a command was selected
    if(isset($_GET['m'])){
        //Create user
        if($_GET['m'] == 'createUser'){
            $userLift->createUser($con,$_POST['name'],$_POST['eMail'],$_POST['age']);
            $userLift->readUsers($con);
        }
        //Update user
        if($_GET['m'] == 'updateUser'){
            $userLift->updateUser($con,$_POST['id'],$_POST['name'],$_POST['eMail'],$_POST['age']);
            $userLift->readUsers($con);
        }
        if($_GET['m'] == 'userRoutine'){
                $userLift->userRoutine($con,$_GET['id']);
        }
        //Delete user
        if($_GET['m'] == 'deleteUser'){
            //Delete request from Form
            if(isset($_POST['id'])){
                $userLift->deleteUser($con,$_POST['id']);    
            }
            //Delete request from Read Table
            if(isset($_GET['id'])){
                $userLift->deleteUser($con,$_GET['id']);   
            }
            $userLift->readUsers($con);
        }
        if($_GET['m'] == 'deleteUserLift'){
            //Delete User Lift request from Form
            if(isset($_POST['id'])){
                $userLift->deleteUserLift($con,$_POST['id']);    
                $userLift->userRoutine($con,$_POST['userId']);
            }
            //Delete userLift request from Read Table
            if(isset($_GET['id'])){
                $userLift->deleteUserLift($con,$_GET['id']);
                $userLift->userRoutine($con,$_GET['userId']);
            }
        }
        //Create Lift
        if($_GET['m'] == 'createLift'){
            $userLift->createLift($con,$_POST['name'],$_POST['sets'],$_POST['reps']);
            $userLift->readLifts($con);
        }
        //Update Lift
        if($_GET['m'] == 'updateLift'){
            $userLift->updateLift($con,$_POST['id'],$_POST['name'],$_POST['sets'],$_POST['reps'],$_POST['restTime']);
            $userLift->readLifts($con);
        }
        //Delete Lift
        if($_GET['m'] == 'deleteLift'){
            //Delete request from Form
            if(isset($_POST['id'])){
                $userLift->deleteLift($con,$_POST['id']);    
            }
            //Delete request from Read Table
            if(isset($_GET['id'])){
                $userLift->deleteLift($con,$_GET['id']);   
            }
            $userLift->readLifts($con);
        }
    }
    $userLift->showFooter();
    
    echo '<br><br>';
    $userLift->showSource(); 
   
    echo "index.php";
    show_source(__FILE__);
    
?> 