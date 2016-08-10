<?php 
/* *******************************************************************
* filename : update.php
* author : Jenny Bober
* username : jmbober
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
description : A form that allows the user to update a song in "songs"
              
*
* Structure: PHP:
              starts session
              if post is not empty...
                set variables
                validate input
                update data
             
             HTML: 
              Head -- link to bootstrap
              Body -- create form
*
precondition : database connection is valid, user is logged in, 
               songs table exists with proper fields,
               and a record in the table has an id of $_GET['id']
               
postcondition: record is updated
*
* Code adapted from George Corser
* *******************************************************************/
	session_start();
	if (empty($_SESSION['username'])) header("Location: login.php");
	require 'database.php';
  
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: index.php");
	}
	
  //if post is not empty...
	if ( !empty($_POST)) {
		// keep track validation errors
		$titleError = null;
		$artistError = null;
		$genreError = null;
		$linkError = null;
		
		// keep track post values
		$title = $_POST['title'];
		$artist = $_POST['artist'];
		$genre = $_POST['genre'];
		$link = $_POST['link'];
		
		// validate input
    $valid = true;
		if (empty($title)) {
			$titleError = 'Please enter song title';
			$valid = false;
		}
    
		if (empty($artist)) {
			$artistError = "Please enter artist name";
			$valid = false;
		}
    
		if (empty($genre)) {
			$genreError = 'Please enter a genre';
			$valid = false;
		}
    
    if (empty($link)) {
			$linkError = 'Please enter a url that links to the song';
			$valid = false;
		}
    
    
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE songs set title = ?, artist = ?, genre =?, link = ? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($title, $artist, $genre, $link, $id));
			Database::disconnect();
			header("Location: index.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM songs where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$title = $data['title'];
		$artist = $data['artist'];
		$genre = $data['genre'];
		$link = $data['link'];
    
		Database::disconnect();
	}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  </head>

  <body>
    <div class="container">
      <div class="span10 offset1">
        <div class="row">
          <h3>Update a song</h3>
        </div>
        <!-- FORM -->
        <form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
          <div class="control-group <?php echo !empty($titleError)?'error':'';?>">
            <label class="control-label">Title</label> 
            <div class="controls">
              <input name="title" type="text"  placeholder="Title" value="<?php echo !empty($title)?$title:'';?>">
              <?php if (!empty($titleError)): ?>
                <span class="help-inline"><?php echo $titleError;?></span>
              <?php endif; ?>
            </div>  
          </div>

          <div class="control-group <?php echo !empty($artistError)?'error':'';?>">
            <label class="control-label">Artist</label>
            <div class="controls">
              <input name="artist" type="text" placeholder="artist" value="<?php echo !empty($artist)?$artist:'';?>">
              <?php if (!empty($artistError)): ?>
                <span class="help-inline"><?php echo $artistError;?></span>
              <?php endif;?>
            </div>
          </div>

          <div class="control-group <?php echo !empty($genreError)?'error':'';?>">
            <label class="control-label">Genre</label>
            <div class="controls">
              <input name="genre" type="text"  placeholder="genre" value="<?php echo !empty($genre)?$genre:'';?>">
              <?php if (!empty($genreError)): ?>
                <span class="help-inline"><?php echo $genreError;?></span>
              <?php endif;?>
            </div>
          </div>

          <div class="control-group <?php echo !empty($linkError)?'error':'';?>">
            <label class="control-label">Link</label>
            <div class="controls">
              <input name="link" type="text"  placeholder="link" value="<?php echo !empty($link)?$link:'';?>">
              <?php if (!empty($linkError)): ?>
                <span class="help-inline"><?php echo $linkError;?></span>
              <?php endif;?>
            </div>
          </div>

          <div class="form-actions">
            <button type="submit" class="btn btn-success">Update</button>
            <a class="btn" href="index.php">Back</a>
          </div>
        </form>
      </div>
    </div> <!-- /container -->
  </body>
</html>