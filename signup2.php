<?php
 ob_start();
 session_start();
 include_once 'dbconnect.php';
 print_r($_SESSION);

// it will never let you open index(login) page if session is set
 if ( isset($_SESSION['user'])!="" ) {
  header("Location: signup3.php");
  exit;
 }
 
 $error = false;
 if ( isset($_POST['cust-submit2']) ) {
 	$pass1 = trim($_POST['cust-acc-pwd']);	
 	$pass1 = strip_tags($_POST['cust-acc-pwd']);
  	$pass1 = htmlspecialchars($_POST['cust-acc-pwd']);
  	$pass2 = trim($_POST['cust-confirm-pwd']);
  	$pass2 = strip_tags($_POST['cust-confirm-pwd']);
  	$pass2 = htmlspecialchars($_POST['cust-confirm-pwd']);
	//$_POST = $_SESSION;
  	$acc_no = $_SESSION['acc_no'];
	$q=mysql_query("SELECT userId FROM users WHERE Account_no='$acc_no'");
    $f = mysql_fetch_array($q);
	$ud=$f[0];
	
  	echo "<h1>$acc_no</h1>";

  	if(empty($pass1) || empty($pass2)){
	   $error = true;
	   $passError = "Please enter your password.";
	   echo $passError;
	}else if( strlen($pass1) < 6) {
   		$error = true;
   		$passError = "Password must have atleast 6 characters.";
   		echo $passError;
  	}

 	if (!$error){
	 	if($pass1 == $pass2){

	 		// password encrypt using SHA256();
	 		$newpass = hash('sha256', $pass1);

	 		
	 		$query = "UPDATE users SET userPass = '$newpass' WHERE Account_no='$acc_no'";
	 		$res = mysql_query($query);

			// updating attempts table for new signup
			$query2 = "INSERT INTO attempts(userId,Account_no) VALUES('$ud','$acc_no')";
	 		$res9 = mysql_query($query2);



	 		if($res){
				header("Location: signup3.php");
			    unset($pass1);
			    unset($pass2);
	 		 } 
	 		 else{
			    $errMSG = "<h1>Failure!Try again later..</h1>";
				echo $errMSG;
	 		}
	 	}
	 	else{
	 		echo "Passwords do not match";
	 	}
 	}
 }

 $_POST = $_SESSION;

?>
<html>
	<head>
		<title>IITR Bank</title>
		<meta charset="utf-8">
  		<meta name="viewport" content="width=device-width, initial-scale=1">
  		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  		<link rel="stylesheet" href="banking.css">
		<script src="banking.js"></script>
	</head>
	<body>
		<div class="container">
			<h1 class="float-left">IITR Bank</h1>
			<h1 class="float-right">IITR</h1>
			<br>
			<br>
			<br>
			<hr>
			<nav class="navbar navbar-default">
			  <div class="container-fluid">
			  	<div class="navbar-header">
			      <a class="navbar-brand" href="#">Home</a>
			    </div>
			    <ul class="nav navbar-nav">
			      <li class="active"><a href="#">Register</a></li>
			      <li><a href="#">Products</a></li>
			      <li><a href="#">Services</a></li>
			      <li><a href="#">Contact</a></li>
			    </ul>
			  </div>
			</nav>
			<br>
			<div class="main">
			<div class="col-md-12">
				<div class="col-md-4">
			 		<form method="post" action="">
					Welcome <?php if(!empty($_SESSION['userName'])) echo $_SESSION['userName'] ; ?>
					<br>
					<h3 class="text-center">Customer Panel</h3>
					<br>
					  <div class="form-group">
					    <label for="cust-acc-pwd">Enter your New Password</label>
					    <input type="password" class="form-control" name="cust-acc-pwd" id="cust-acc-pwd">
					  </div>
					  <div class="form-group">
					    <label for="cust-confirm-pwd">Confirm your New Password:</label>
					    <input type="password" class="form-control" name="cust-confirm-pwd" id="cust-confirm-pwd">
					  </div>
					  
					  <br><br>
					   <button type="submit" class="btn btn-default btn-primary" name="cust-submit2"><a class="a-btn">Submit</a></button>
					</form>
				</div>
				<div class="col-md-8 d3 mt0">
					<img src="banking.jpg" width = "100%"; >
				 </div>
			</div>
			</div>
		</div>

	</body>
<html>

	



