<?php 

if (!empty($_SESSION['name'])) header("Location: CRUD/logout.php");

session_start(); 
    require 'CRUD/database.php';
 
    if ( !empty($_POST)) {
        // keep track validation errors
        $nameError = null;
        $passwordError = null;
        $emailError = null;
         
        // keep track post values
        $name = $_POST['name'];
        $password = $_POST['password'];
        $email = $_POST['email'];
         
        // validate input
        $valid = true;
        if (empty($name)) {
            $nameError = '<span style="color: white">Please enter Name</span>';
            $valid = false;
        }
         
        if (empty($email)) {
            $emailError = '<span style="color: white">Please enter Email Address</span>';
            $valid = false;
        } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
            $emailError = '<span style="color: white">Please enter a valid Email Address</span>';
            $valid = false;
        }
         
        if (empty($password)) {
            $password = '<span style="color: white">Please enter Password</span>';
            $valid = false;
        }
         
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO customers (name,password,email) values(?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($name,$password,$email));
            Database::disconnect();
            header("Location: createCust.php");
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/business-casual.css" rel="stylesheet">

    <!-- Fonts -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">
</head>
 
<body>
    <div class="container">
     
                <div class="span10 offset1" style="color: #fff;">
                    <div class="row">
                        <h3>Create an Account</h3>
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
                      <div class="control-group <?php echo !empty($passwordError)?'error':'';?>">
                        <label class="control-label">Password</label>
                        <div class="controls">
                            <input name="email" type="text" placeholder="Password" value="<?php echo !empty($password)?$password:'';?>">
                            <?php if (!empty($passwordError)): ?>
                                <span class="help-inline"><?php echo $passwordError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
                        <label class="control-label">Email Address</label>
                        <div class="controls">
                            <input name="email" type="text"  placeholder="Email Address" value="<?php echo !empty($email)?$email:'';?>">
                            <?php if (!empty($emailError)): ?>
                                <span class="help-inline"><?php echo $emailError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
					  </br>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Create</button>
                          <a style="color: #fff;" class="btn" href="index.html">Back</a>
                        </div>
                    </form>
					<p style="color: #fff;">We will not share your information with anyone outside of our organization.
						Your information is used soley for the purpose of maintaing your account and your saved kreations.
					</p>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>