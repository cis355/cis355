<?php
     
    require 'database.php';
 
    if ( !empty($_POST)) {
        // keep track validation errors
        $nameError = null;
        $creatorError = null;
        $locationError = null;
        $descriptionError = null;
         
        // keep track post values
        $name = $_POST['name'];
        $creator = $_POST['creator'];
        $location = $_POST['location'];
        $description = $_POST['description'];
         
        // validate input
        $valid = true;
        if (empty($name)) {
            $nameError = 'Please enter Name';
            $valid = false;
        }
         
        if (empty($creator)) {
            $creatorError = 'Please enter GM Name';
            $valid = false;
        }
         
        if (empty($location)) {
            $locationError = 'Please enter Location';
            $valid = false;
        }

        if (empty($description)) {
            $descriptionError = 'Please enter Description';
            $valid = false;
        }
         
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO campaigns (name,creator,location,description) values(?, ?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($name,$creator,$location,$description));
            Database::disconnect();
            header("Location: semesterProj.php");
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

  <style>
  .resizedTextbox {width: 400px; height: 30px; padding: 1px}
  </style>
</head>
 
<body>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Create a Campaign</h3>
                    </div>
             
                    <form class="form-horizontal" action="create.php" method="post">
                      <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                        <label class="control-label">Name</label>
                        <div class="controls">
                            <input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
                            <?php if (!empty($nameError)): ?>
                                <span class="help-inline"><?php echo $nameError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($creatorError)?'error':'';?>">
                        <label class="control-label">Game Master</label>
                        <div class="controls">
                            <input name="creator" type="text" placeholder="Enter GM Name" value="<?php echo !empty($creator)?$creator:'';?>">
                            <?php if (!empty($creatorError)): ?>
                                <span class="help-inline"><?php echo $creatorError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($locationError)?'error':'';?>">
                        <label class="control-label">Location</label>
                        <div class="controls">
                            <input name="location" type="text"  placeholder="City, State, Zip" value="<?php echo !empty($location)?$location:'';?>">
                            <?php if (!empty($locationError)): ?>
                                <span class="help-inline"><?php echo $locationError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($descriptionError)?'error':'';?>">
                        <label class="control-label">Description</label>
                        <div class="controls">
                            <input name="description" type="text" class=resizedTextbox  placeholder="Enter Description" value="<?php echo !empty($description)?$description:'';?>">
                            <?php if (!empty($descriptionError)): ?>
                                <span class="help-inline"><?php echo $descriptionError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="form-actions">
                          <br/><br/>
                          <button type="submit" class="btn btn-success">Create</button>
                          <a class="btn" href="semesterProj.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>