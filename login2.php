<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';
 
 // it will never let you open index(login) page if session is set
 // if ( !isset($_SESSION['user'])) {
 // header("Location: login1.php");
  //exit;
 // }
  /*$_POST = $_SESSION;*/
  print_r($_SESSION);
  echo "<br>";
  echo $_SESSION['timeout'];

  //$currentDateTime = date('Y-m-d H:i:s');
  //echo $currentDateTime;
  date_default_timezone_set('Asia/Kolkata');
  echo date('d-m-Y H:i:s');
  
  $error = false;
  $newmail = $_SESSION['email'];
  //echo $newmail;
  

// new code imported from login3.php
 
 //$res3=mysql_query("SELECT * FROM users WHERE userEmail =".$_SESSION['email']);
 //$counter = mysql_num_rows($res3);
 $first_query = "SELECT * FROM users WHERE userEmail='$newmail'";
 $res3 = mysql_query($first_query);
 mysql_query($first_query) or die(mysql_error());
 $fetch1 = mysql_fetch_array($res3);
 $counter = mysql_num_rows($res3);
 echo "<br>";
 echo $counter;
 $ano = $fetch1['Account_no'];
 $uid = $fetch1['userId'];
 echo "<br>";
 echo $ano;
 $s_query = "SELECT cur_status FROM users WHERE Account_no='$ano'";   //status query to know if user is logged in from any device
 $res5 = mysql_query($s_query) or die(mysql_error()) ;
 $fetch3 = mysql_fetch_array($res5);
 $c = $fetch3[0];
 
 //$status_query = "SELECT status FROM logs WHERE Account_no='$ano'";   //status query to know if user is logged in from any device
 //$res4 = mysql_query($status_query) or die(mysql_error()) ;
 //$fetch2 = mysql_fetch_array($res4);
 //echo $fetch2;
 if($c == 0){
 if($counter>=1)
 {
 $specific = 0;
 $second_query = "SELECT * FROM users WHERE userEmail='$newmail'";
 $res2 = mysql_query($second_query);
 $userRow=mysql_fetch_array($res2);
 $counter1 = mysql_num_rows($res2); 
 //echo $counter1;
 //print_r($userRow);

 $p = array();
 $p[0] = $userRow['img1'];
 $p[1] = $userRow['img2'];
 $p[2] = $userRow['img3'];
 $p[3] = $userRow['img4'];

 print_r($p);


 $random_keys=array_rand($p,1);
 
 $pictures = array("51.jpg", "52.jpg", "53.jpg","54.jpg", "55.jpg", "56.jpg","57.jpg", "58.jpg", "59.jpg","60.jpg", "61.jpg", "62.jpg","63.jpg", "64.jpg","65.jpg", "66.jpg", "67.jpg","68.jpg", "69.jpg", "70.jpg","71.jpg", "72.jpg", "73.jpg");
 $pic_string = array_rand($pictures,5);
 shuffle($pic_string);
 
 $x = array();
 $y = array();
 $x[0] = $p[$random_keys];
 $x[1] = $pictures[$pic_string[0]];
 $x[2] = $pictures[$pic_string[1]];
 $x[3] = $pictures[$pic_string[2]];
 $x[4] = $pictures[$pic_string[3]];
 $x[5] = $pictures[$pic_string[4]];

$y = $x; //copy of x array
for ($i=0;$i<6;$i++){
	'<img src="textplacement/reg_images/'.$x[$i].'" name="'.$x[$i].'" id="'.$x[$i].'"/>';
 }
$identity = 0;
 shuffle($x);
 print_r($x);
 for($k=0;$k<6;$k++){
		if($x[$k] == $y[0]){
			$identity = $k;
			break;		                      		
		}
	}

 echo $identity;
 $text = $_SESSION['rcode'];

 $pyscript="C:\\wamp\\www\\iitrpr-net-banking\\textplacement\\new.py";
 $python="C:\\Python27\\python.exe";
 $cmd="$python $pyscript $text $x[0] $x[1] $x[2] $x[3] $x[4] $x[5]";
 $output=shell_exec("python C:\\wamp\\www\\iitrpr-net-banking\\textplacement\\new.py $text $x[0] $x[1] $x[2] $x[3] $x[4] $x[5] 2>&1");
 echo $output; // new images will be placed in output folder


 }
 else
 {
  $specific = 1;
 
  $pictures = array("51.jpg", "52.jpg", "53.jpg","54.jpg", "55.jpg", "56.jpg","57.jpg", "58.jpg", "59.jpg","60.jpg", "61.jpg", "62.jpg","63.jpg", "64.jpg","65.jpg", "66.jpg", "67.jpg","68.jpg", "69.jpg", "70.jpg","71.jpg", "72.jpg", "73.jpg");
  $pic_string = array_rand($pictures,6);
  shuffle($pic_string);
  $x = array();
 $x[0] = $pictures[$pic_string[0]];
 $x[1] = $pictures[$pic_string[1]];
 $x[2] = $pictures[$pic_string[2]];
 $x[3] = $pictures[$pic_string[3]];
 $x[4] = $pictures[$pic_string[4]];
 $x[5] = $pictures[$pic_string[5]];

 print_r($x);
 $text = $_SESSION['rcode'];

 $pyscript="C:\\wamp\\www\\iitrpr-net-banking\\textplacement\\new.py";
 $python="C:\\Python27\\python.exe";
 $cmd="$python $pyscript $text $x[0] $x[1] $x[2] $x[3] $x[4] $x[5]";
 $output=shell_exec("python C:\\wamp\\www\\iitrpr-net-banking\\textplacement\\new.py $text $x[0] $x[1] $x[2] $x[3] $x[4] $x[5] 2>&1");
 echo $output; // new images will be placed in output folder
 
 
 }
 }  //if statement terminates here. If user is logged in somewhere else then else statement will follow.
 else{
	header("Location: duplicate.php");
	exit(); 
 }

 // new code ends here
 if(isset($_POST['login-btn'] )) {
	 //attempt validation


$at = mysql_query("SELECT * FROM attempts WHERE userId='$uid'");
$faa= mysql_fetch_array($at);
$att = $faa['net_attempt'];
$t_time = $faa['t_msec'];
$attflag=0;
$ms1 = round(microtime(true) * 1000);

$diff1 = ($ms1-$t_time)/1000;




if($att < 3){
	$att = $att+1;
	$quer = "UPDATE attempts SET net_attempt = '$att' WHERE userId='$uid'";
	$resq = mysql_query($quer);
	$attflag=1;
  
  if($att-1 == 0){
     $_SESSION['timeout'] = time();
  }
}
//LOCKED OUT CODE
else{
    //echo "sorry you have to wait 5 min to log in again";
	date_default_timezone_set('Asia/Kolkata');
    $aDate = date("Y-m-d H:i:s");
	$ms2 = round(microtime(true) * 1000);
    $quer1 = "UPDATE attempts SET net_attempt = '$att', last_time = '$aDate',t_msec = '$ms2' WHERE userId='$uid'";
	$resq1 = mysql_query($quer1);
    //Check elapsed time
    //10 minute timeout
    if ($_SESSION['timeout'] + 5 * 60 < time()) {
       $att = 0;
	   $attflag=1;
	   //date_default_timezone_set('Asia/Kolkata');
       //$aDate = date("Y-m-d H:i:s");
       $quer11 = "UPDATE attempts SET net_attempt = '$att' WHERE userId='$uid'";
	   $resq1 = mysql_query($quer11);
       header("Location: index.php");
	   session_destroy();
	   exit();

       
    }else{

	   $att = 0;
       $quer12 = "UPDATE attempts SET net_attempt = '$att' WHERE userId='$uid'";
	   $resq12 = mysql_query($quer12);

		// take him to a blocked page
		header("Location: blocked.php");
		session_destroy();
		exit();

	}
}


















     
//attempt validation ends here
  if($attflag==1)
	 {
	  $pass = trim($_POST['pass']);
	  $pass = strip_tags($pass);
	  $pass = htmlspecialchars($pass);
	 if(empty($pass)){
	   $error = true;
	   $passError = "Please enter your password.";
	  }
	  
	  // if there's no error, continue to login
	  if (!$error) {
	   
	   $password = hash('sha256', $pass); // password hashing using SHA256
	  
	   $res=mysql_query("SELECT userId, userName, userPass, userEmail FROM users WHERE userPass='$password'");
	   $row=mysql_fetch_array($res);
	   $count = mysql_num_rows($res); // if pass correct it returns must be 1 row
	   
	   if( $count == 1 && $row['userPass']==$password ) {
		  //header("Location: login3.php");
		  $_SESSION['user'] = $row['userId'];
		  //$_SESSION['userMail'] = $row['userEmail'];
		  if(!empty($_POST['images_selected'])){
			$pic_array = array();
			foreach($_POST['images_selected'] as $checked) {
					echo $checked; //echoes the value set in the HTML form for each checked checkbox.
								 //so, if I were to check 1, 3, and 5 it would echo value 1, value 3, value 5.
								 //in your case, it would echo whatever $row['Report ID'] is equivalent to.
					if($checked == "out10"){
						header("Location: home.php");
						exit();
					}
					else{
						echo "<h3>Incorrect image</h3>";
					}
			}     
	  }
	  else{
		  echo "<br><h3>No Image Selected</h3>";
		}
	  
	 }
	 else {
		$errMSG = "<h1>Incorrect Password, Try again...</h1>";
		echo $errMSG;
	   }
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
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  		<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
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
			      <li class="active"><a href="#">Login</a></li>
			      <li><a href="#">Products</a></li>
			      <li><a href="#">Services</a></li>
			      <li><a href="#">Contact</a></li>
			    </ul>
			  </div>
			</nav>
			<br>
			<div class="col-md-12">
			<form method="post" action="">
				<div class="col-md-4">
					Welcome <?php 
					if($counter==0){if(!empty($_POST['email'])) echo $_POST['email'] ;} 
					else if($counter==1){if(!empty($userRow['userName'])) echo $userRow['userName'];}
					?>
						<br>
						<br>
						<div class="form-group">
						  <label for="password">Password:</label>
						  <input type="password" class="form-control" name="pass" id="password" required disabled>
						</div>
						<div class="form-group">
						  <label for="rcode">Random Code:</label>
						  <input type="text" class="form-control" name="rcode_display" id="rcode_display" maxlength="6" value="<?php if(!empty($_POST['rcode'])) echo $_POST['rcode'];?>" required disabled>
						</div>
						<label for="usr">Select your Security Image: </label>
						<br>
						<br>
						<br>
						<h5 class="text-center"><a href="forgot-password.php">Forgot Password? Click here!</a></h5>
						<br>
						<div class= "center-btn">
						<button type="submit" class="btn btn-primary a-btn" name="login-btn" id="btnlogin" value="login" disabled><a class="a-btn">Login</a></button>
						</div>
						<!-- <button type="submit" class="btn btn-primary ml-70">Refresh</button> -->
				</div>
				<div class="col-md-8 d3 mt0">
		          <h3 class="text-center pb20 mt0">Select your Image</h3>
		          <div class="d3-2">
		                <div class="d4">
		                  <div class="d5">
		                    <?php 
							if($specific == 0)
							{

		                      for($i=0;$i<6;$i++){
		                      	if($i == $identity){
		                      		echo '<span class="image-checkbox-container">';
		                        	echo '<input type="radio" class="image-checkbox" style="display: none;" name="images_selected[]" value="out10" id="img'.$i.'" />'; 
		                        	echo '<img src="textplacement/soutputs/'.$i.'.jpg" name="out10" id="out10" class="image-disp" height="35%" width="32%" />';
		                        	echo '</span>';
		                      	}else{
		                        echo '<span class="image-checkbox-container">';
		                        echo '<input type="radio" class="image-checkbox" style="display: none;" name="images_selected[]" value="out'.$i.'" id="img'.$i.'"/>'; 
		                        echo '<img src="textplacement/soutputs/'.$i.'.jpg" name="out'.$i.'" id="out'.$i.'" class="image-disp" height="35%" width="32%" />';
		                        echo '</span>';
		                    	}
		                      }
							}
							else
							{
							
							for($i=0;$i<6;$i++){
		                        echo '<span class="image-checkbox-container">';
		                        echo '<input type="radio" class="image-checkbox" style="display: none;" name="images_selected[]" value="out'.$i.'" id="img'.$i.'"/>'; 
		                        echo '<img src="textplacement/soutputs/'.$i.'.jpg" name="out'.$i.'" id="out'.$i.'" class="image-disp" height="35%" width="32%" />';
		                        echo '</span>';
		                    	}
		                      }
		                    ?>

		                  </div>
		                </div>
		            </div>
		        </div>
			</form>
			
			</div>


		</div>
		<script>
	    if(location.search)
	        alert(location.search);

	    // $('.image-checkbox-container img').live('click', function(){
	    //     if(!$(this).prev('input[type="checkbox"]').prop('checked')){
	    //         $(this).prev('input[type="checkbox"]').prop('checked', true).attr('checked','checked');
	    //         this.style.border = '4px solid #38A';
	    //         this.style.margin = '0px';
	    //     }else{
	    //         $(this).prev('input[type="checkbox"]').prop('checked', false).removeAttr('checked');
	    //         this.style.border = '0';
	    //         this.style.margin = '4px';
	    //     }
	    // });
		var a = 0;

		$(".image-checkbox-container img").live('click',function(){

			//var a = $("input[type='radio'][name='images_selected[]']:checked").val();
			//console.log(a);
			var clickedBtnId = $(this).attr('id');
			$(this).prev().prop("checked", true);
			console.log(clickedBtnId);
			var x = document.getElementById(clickedBtnId);
			var trueimg = document.getElementById('out10');
			//var p = document.getElementById(a);
			var y = "out";
			for(var i=0;i<6;i++){
				//console.log(y+i);
				var all = document.getElementById(y+i);
				//var inner = document.getElementById(y+i);
				if(all && x){
					console.log("all:"+all);
					if(trueimg){
						if(x.name == trueimg.name){
							for(var j=0;j<6;j++){
								var newimg = document.getElementById(y+j);
								if(newimg){
								newimg.style.border = "0";
								console.log("inside");
								}
							}
							trueimg.style.border = "4px solid #38A";
							break;
						}
					}
					if(x.name == all.name){
						console.log("check1");
						for(var j=0;j<6;j++){
							console.log("check2");
							var newimg = document.getElementById(y+j);
							if(newimg){
							newimg.style.border = "0";
							console.log("inside");
							}
						}
					
						x.style.border = "4px solid #38A";
					}
					else{
						console.log("check3");
						all.style.border = "0";
						if(trueimg){
						trueimg.style.border = "0";
						}
					}
				}
			}
		});

		$('.image-checkbox-container img').live('click', function(){
		 	// $("input:radio[name='html_radio']").is(":checked")
		 	
		 	var a = $('.image-checkbox:checked').size();
	 		// console.log(a);
	 		if(a){
	            $('#btnlogin').removeAttr('disabled');
	            $('#password').removeAttr('disabled');
	        } 
	   		else if (a==0){
	            $('#btnlogin').attr('disabled', 'disabled');
	            $('#password').attr('disabled', 'disabled');
	        }
	 	});
	    
	    
		</script>
	</body>
<html>
	