<?php 
/* *******************************************************************
* filename : uploadSong.php
* author : Jenny Bober
* username : jmbober
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
description : Adds a song to the songs table 
              
*
* Structure: PHP:
              start session
              if post is not empty...
                -set variables
                -validate input
                -insert data into database      
             HTML:
              header:
                -links to bootstrap
              body:
                -Create form
*
precondition : database connection is valid, 
               songs table exists with proper fields,
               user is logged in
               
postcondition: if user input is valid, record is added to "songs" table, user redirected to index
               otherwise displays error message
*
* Code adapted from George Corser
* *******************************************************************/
  session_start();
	if (empty($_SESSION['username'])) header("Location: login.php"); 
	
	# include connection data and functions
	require 'database.php';
	
	# if there was data passed, then insert record, 
	# otherwise do nothing (that is, just display html for create)
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
		
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO songs (title, artist, genre, link) values(?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($title, $artist, $genre, $link));
			Database::disconnect();
			header("Location: index.php");
		}
	} # end if(!empty($_POST))
    

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
          <h3>Add a song</h3>
        </div>
    		<!-- FORM -->
        <form class="form-horizontal" action="uploadSong.php" method="post">
          <div class="control-group <?php echo !empty($titleError)?'error':'';?>">
            <label class="control-label">Song Title</label>
            <div class="controls">
              <input name="title" type="text"  placeholder="title" value="<?php echo !empty($title)?$title:'';?>">
              <?php if (!empty($titleError)): ?>
                <span class="help-inline"><?php echo $titleError;?></span>
              <?php endif; ?>
            </div>
          </div>
            
          <div class="control-group <?php echo !empty($artistError)?'error':'';?>">
            <label class="control-label">Artist</label>
            <div class="controls">
              <input name="artist" type="text"  placeholder="artist" value="<?php echo !empty($artist)?$artist:'';?>">
              <?php if (!empty($artistError)): ?>
                <span class="help-inline"><?php echo $artistError;?></span>
              <?php endif; ?>
            </div>
          </div>
            
          <div class="control-group <?php echo !empty($genreError)?'error':'';?>">
            <label class="control-label">Genre</label>
            <div class="controls">
              <input name="genre" type="text"  placeholder="genre" value="<?php echo !empty($genre)?$genre:'';?>">
              <?php if (!empty($genreError)): ?>
                <span class="help-inline"><?php echo $genreError;?></span>
              <?php endif; ?>
            </div>
          </div>
            
          <div class="control-group <?php echo !empty($linkError)?'error':'';?>">
            <label class="control-label">Link</label>
            <div class="controls">
              <input name="link" type="text"  placeholder="link" value="<?php echo !empty($link)?$link:'';?>">
              <?php if (!empty($linkError)): ?>
                <span class="help-inline"><?php echo $linkError;?></span>
              <?php endif; ?>
            </div>
          </div>
          </br>
          <div class="form-actions">
            <button type="submit" class="btn btn-success">Add Song</button>
            <a class="btn" href="index.php">Back</a>
          </div>
        </form>
      </div>			
    </div> <!-- /container -->
  </body>
</html>
