<?php
 ob_start();
 session_start();
 include_once 'dbconnect.php';

 // $_POST = $_SESSION;
 $p =array();
$p[0] = $_SESSION['pic1'];
$p[1] = $_SESSION['pic2'];
$p[2] = $_SESSION['pic3'];
$p[3] = $_SESSION['pic4'];

// it will never let you open index(login) page if session is set
 if ( isset($_SESSION['user'])!="" ) {
  header("Location: signup3.php");
  exit;
 }
 echo $_SESSION['user'];

// $acc_no1 = $_POST['cust_acc_no'];
// echo $acc_no1;

$error = false;
if ( isset($_POST['cust-confirm']) ) {

	echo "logs";
	$_POST = $_SESSION;
	// $acc_no1 = $_POST['cust_acc_no'];
	// echo $acc_no1;
  echo "<br>";
  //echo $_SESSION['user'];
  //echo $_SESSION['acc_no'];

  $res2=mysql_query("SELECT * FROM users WHERE Account_no=".$_SESSION['acc_no']);
  $userRow=mysql_fetch_array($res2);

  echo $userRow['Account_no'];  //this is print on the page correctly.
  $acc = $userRow['Account_no'];
	
	if(!$error){
		$query = "UPDATE users SET img1 = '$p[0]',img2 = '$p[1]',img3 = '$p[2]',img4 = '$p[3]' WHERE Account_no=".$_SESSION['acc_no'];
		$res = mysql_query($query);		
		if($res>0){
      header("Location: signup_success.php");
			echo "<h2>Registration Success</h2>";
			unset($p);
			unset($acc_no1);
		}else{
			echo "<h2>Error<h2>";
		}
	}else{
		echo "Success";
	}

}else{
	echo "";
}


$_POST = $_SESSION; 

?>

<html>
  <head>
    <title>IITR Bank</title>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>-->
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
          <ul class="nav navbar-nav navbar-right">
              
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <span class="glyphicon glyphicon-user"></span>&nbsp;<strong> Hey! <?php echo $userRow['userName']; ?>&nbsp;<span class="caret"></span></strong></a>
                    <ul class="dropdown-menu">
                      <li><a href="logout2.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
                    </ul>
                  </li>

          </ul>
        </div>
      </nav>
      <br>
      <div class="col-md-12">
        
        <div class="col-md-4">
        <form method="post" action="">
        	Welcome <?php if(!empty($_SESSION['userName'])) echo $_SESSION['userName'] ; ?>
          <br>
          <h3 class="text-center">Customer Panel</h3>
          <br>
           <br>
            <label for="usr">Confirm your Security Image: </label>
            <br><br><br>
            <button type="submit" class="btn btn-default btn-primary float-left" name="cust-back" id="cust-back"><a class="a-btn" href="signup3.php">Back</a></button>
            <button type="submit" class="btn btn-default btn-primary float-right" name="cust-confirm" id="cust-confirm"><a class="a-btn">Confirm</a></button>
            </form>
        </div>

        <div class="col-md-8 d3 mt0">
          <h3 class="text-center pb20 mt0">Your Selected Random Images</h3>
          <div class="d3-2">
                <div class="d4">
                  <div class="d5">
                    <?php
                      for($i=0;$i<4;$i++){
                        echo '<span class="image-box">'; 
                        echo '<img src="textplacement/reg_images/'.$p[$i].'" id='.$p[$i].' name='.$p[$i].' height="25%" width="20%" class="image-box" />';
                        echo '</span>';
                      }
                    ?>

                  </div>
                </div>
            </div>
        </div>
        
      </div>

    </div>
  </body>
</html>
<?php ob_end_flush(); ?>


