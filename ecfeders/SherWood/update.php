<?php
    require 'database.php';
 
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: se_donations.php");
    }
     
    if ( !empty($_POST)) {
        // keep track validation error
        $quantityError = null;
         
        //Set Wish ID to Session Variable
        $wish_id = $_SESSION['wish_id'];
		// keep track post values
        $qty = $_POST['qty'];
        $comments = $_POST['comments'];
         
        // validate input
        $valid = true;
         
        if (empty($qty)) {
            $quantityError = 'Please enter a Quantity';
            $valid = false;
        }
		
		if ($qty < 0) {
            $quantityError = 'Please enter a Correct Quantity';
            $valid = false;
        }
         
        // update data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE se_donations set qty = ?, comments = ? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($qty,$comments,$id));
            Database::disconnect();
            header("Location: se_donations.php");
        }
    } else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT se_wishes.item As Item FROM se_wishes where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($wish_id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$wishItem = $data['Item'];
		Database::disconnect();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Update</h3>
                    </div>
             
                    <form class="form-horizontal" action="update.php?id=<?php echo $id?>" method="post">
                      <div class="control-group">
                        <label class="control-label">Item: </label>
                        <div class="controls">
                            <input name="wishItem" type="text"  placeholder="Item" value="<?php echo !empty($wishItem)?$wishItem:'';?> readonly">
                                <span class="help-inline"></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($quantityError)?'error':'';?>">
                        <label class="control-label">Quantity: </label>
                        <div class="controls">
                            <input name="qty" type="text" placeholder="Quantity" value="<?php echo !empty($qty)?$qty:'';?>">
                            <?php if (!empty($quantityError)): ?>
                                <span class="help-inline"><?php echo $quantityError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group ">
                        <label class="control-label">Comment: </label>
                        <div class="controls">
                            <textArea name="comments" type="text" value="<?php echo !empty($comments)?$comments:'';?>"></textArea>
                                <span class="help-inline"></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Update</button>
                          <a class="btn btn-info" href="se_donations.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>