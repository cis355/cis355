
<?php
	/*
	  This php file assumes that a session variables for wish Id's is created.
	*/
	/*
    require 'database.php';
	session_start();

    if ( !empty($_POST)) {
        // keep track validation errors
        $quantityError = null;
         
		$_SESSION['wish_id'] = 1;
		$_SESSION['cust_id'] = 1;
        //Set Wish ID to Session Variable
        $wish_id = $_SESSION['wish_id'];
		$cust_id = $_SESSION['cust_id'];
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
         
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO se_donations (wish_id,qty,comments, cust_id) values(?, ?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($wish_id,$qty,$comments,$cust_id));
            Database::disconnect();
            header("Location: se_donations.php");
        }else{
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT se_wishes.item As Item FROM se_wishes where se_wishes.id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($wish_id));
			$data = $q->fetch(PDO::FETCH_ASSOC);
			$wishItem = $data['Item'];
			Database::disconnect();
		}
    }
	show_source(__FILE__);
	*/

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
                        <h3>Donation</h3>
                    </div>
             
                    <form class="form-horizontal" action="create.php" method="post">
                      <div class="control-group">
                        <label class="control-label">Item: </label>
                        <div class="controls">
                            <input name="wishItem" type="text"  placeholder="Item" value="<?php echo !empty($wishItem)?$wishItem:'';?>" readonly>
                                <span class="help-inline"></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($quantityError)?'error':'';?>">
                        <label class="control-label">Quantity: </label>
                        <div class="controls">
                            <input name="qty" type="text" placeholder="Quantity" >
                            <?php if (!empty($quantityError)): ?>
                                <span class="help-inline"><?php echo $quantityError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group ">
                        <label class="control-label">Comment: </label>
                        <div class="controls">
                            <textArea name="comments" ></textArea>
                                <span class="help-inline"></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Donate</button>
                          <a class="btn btn-info" href="se_donations.php">Back</a>
                        </div>
                    </form>
                </div>       
    </div> <!-- /container -->
  </body>
</html>