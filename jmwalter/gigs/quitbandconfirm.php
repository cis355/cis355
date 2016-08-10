<?php 
/* *******************************************************************
* filename : quitbandconfirm.php
* author : Joshua Walters
* username : jmwalter
* course : cis355
* section : 11-MW
* semester : Summer 2016
*
* description : this page is another confirmation page for quitting a band, 
*
* purpose: this page is actually quite neccissary. 
* on top of preventing any accedental clicks from slipping through it also 
* will tell if a user is the last user in the band in which case the band is deleted
* or if the user is the admin and not the last user you can not quit untill you pass admin to 
* someone else... which is a functionality that is not built into this application yet.
*
* input : database.php
*
* processing : 
* 1. checks if logged in 
* 2. checks for bandId from the url with get request 
* 3. gets information from the gigs table joined with the members table 
* from the bandId passed in from get request 
* 4. checks for a post sent to this page 
* 5. depending on who is trying to leave the band displays warnings and "are you sure" prompts 
* 6. sends the data from the prompt form back to this page signaling that the user can be removed from the band
*
* output : depending on who is in the band and who the current user is, this page could 
* warn that quitting the band will delete the band,
* remove the user with no problem , 
* or block quitting from the band all togeather if there is more than one member and you are the admin 
*
* precondition : bandid must be in url, and logged in 
* *******************************************************************
*/
	session_start();
	require 'database.php';
		if (($_SESSION['gigsUserName'] == '') || ($_SESSION['gigsUserId'] == ''))
		header("Location: login.php");
	else
	{
		$userName = $_SESSION['gigsUserName'];
		$userId = $_SESSION['gigsUserId'];
	} 
	
	$bandId = null;
	
	//function responsible for taking the applied band list and removing the given id
	function removeFromList($arr,$removeId)
	{
		$retArr = array();
		foreach($arr as $i)
		{
			if ($i != $removeId)
				array_push($retArr,$i);
		}
		return $retArr;
	}

	//check the list and returns boolean for if the item id is in the array 
	function checkIfExists($arr,$id)
	{
		foreach($arr as $entry)
		{
			if ($entry == $id)
				return true;
		}
		return false;
	}	
	
		if ( !empty($_GET['bandId'])) {
		$bandId = $_REQUEST['bandId'];
	}
		
	if(($userId == null) || ($bandId == null))
	{
		$dest = "Location: home.php?errorMsg=Unapplying_to_gig";
		header($dest);
	}
	else
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT 
		bands.bandId as bandId, bands.members as bandMembers,
		bands.bandName as bandName, bands.bandLeader as bandLeader
		FROM members 
		INNER JOIN bands on bands.bandId = members.bandId WHERE bands.bandId = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($bandId));
		$results = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();
	
		
		if ( !empty($_POST)) {
			//good to do code
				
			if (!empty($results) )
			{
				
				if($_POST['delete'] == "no")
				{
	
					//update the members with out this user
					$pdo = Database::connect();
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					
					$sql = "SELECT members FROM bands WHERE bandId = ?";
						$q = $pdo->prepare($sql);
						$q->execute(array($bandId));
						$memberInfo = $q->fetch(PDO::FETCH_ASSOC);
					
					$tempMembers = explode(",",$memberInfo['members']);
					$updateMembers = removeFromList($tempMembers, $userId);
					$updateMembers = implode(",", $updateMembers);
					$sql = "UPDATE bands set members = ? WHERE bandId = ?";
					$q = $pdo->prepare($sql);
					$q->execute(array($updateMembers,$bandId));
					Database::disconnect();
				}
				else 
					if($_POST['delete'] == "yes")
					{
						
						
						$pdo = Database::connect();
						$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						
						//band has to be removed from booked bands and or pendingBands in gigs
						$sql = "SELECT * FROM gigs";

						foreach ($pdo->query($sql) as $i)
						{
							$pendingBands = $i['pendingBands'];
							$bookedBand = $i['bookedBand'];
							$changeBookedBand = $bookedBand;
							$openGig = $i['open'];
							
								
							if ($bookedBand == $bandId)
							{
								
								$changeBookedBand = "";
								if ($openGig == 0)
								{
									$openGig = 1;
								}
							}

							$tempBands = explode(",", $pendingBands);
							if (checkIfExists($tempBands, $bandId))
							{
								//band exists in the pending bands and must be removed 
								$updateBands = removeFromList($tempBands, $bandId);
								$updateBands = implode(",",$updateBands);
								// changes appropriate info
								$sql = "UPDATE gigs set pendingBands = ?, bookedBand = ?, open = ? WHERE gigId = ?";
								$q = $pdo->prepare($sql);
								$q->execute(array($updateBands,$changeBookedBand,$openGig,$i['gigId']));
							}
						}
						
						//band has to be removed from bands
						$sql = "DELETE FROM bands WHERE bandId = ?";
						$q = $pdo->prepare($sql);
						$q->execute(array($bandId));
	
					}
					
					header("Location: home.php");
			}
			else 
				$dest = "Location: home.php?errorMsg=quitingBand";
				header($dest);
			
		}	
	}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gigs|Gig Application</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Gigs</a>
            </div>
           
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Shows</a>
                    </li>
                    <li>
                        <a href="searchbands.php"><i class="fa fa-fw fa-bar-chart-o"></i> Bands</a>
                    </li>
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

								<div class="row">
								<h1>Gig Application</h1>
								
							<form class="form-horizontal" action="quitbandconfirm.php?bandId=<?php echo $bandId; ?>" method="post">
							 <input type="hidden" name="answer" value="yes"/>
					  <?php
					  
						if (!empty($results))
						{
							
							$tempMembers = explode(",", $results['bandMembers']);
							if (sizeof($tempMembers) == 1)//there is only one person in the band
							{
								echo "<p class='alert alert-error'>You are the only member of the Band! </p>";
								echo "<p class='alert alert-error'>Quiting the band now will delete the band entirly!</p>";
								echo "<input type='hidden' name='delete' value='yes'/>";
								echo "<p class='alert alert-error'>Are you sure you want to quit " . $results['bandName'] . "?</p>
								  <div class='form-actions'>
									  <button type='submit' class='btn btn-success'>Yes</button>
									  <a class='btn btn-danger' href='home.php'>No</a>
									</div>
									</form>";
							}
							else
							{
								if ((checkIfExists($tempMembers,$userId)) && ($results['bandLeader'] == $userId))
								{
									//they can not leave, they are the band leader
									echo "<p class='alert alert-error'>You are the band leader, and there are other members! </p>";
									echo "<p class='alert alert-error'>Leadership must be changed to another member before you can quit " . $results['bandName'] . "!</p>";
									echo "<input type='hidden' name='delete' value='changeLeader'/>";
									echo "<div class='form-actions'>
										  <button type='submit' class='btn btn-danger'>Back</button>
										</div>
										</form>";
								}
								else
								{
									//they can leave with no problems
									echo "<input type='hidden' name='delete' value='no'/>";
									echo "<p class='alert alert-error'>Are you sure you want to quit " . $results['bandName'] . "?</p>
									  <div class='form-actions'>
										  <button type='submit' class='btn btn-success'>Yes</button>
											<a class='btn btn-danger' href='home.php'>No</a>
										</div>
										</form>";
								}
							}
						}
					  ?>			
										
								</div><!-- end row -->
								

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
