<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';
 //print_r($_SESSION);
 
 // it will never let you open index(login) page if session is set
 // if ( isset($_SESSION['user'])!="" ) {
 //  header("Location: home.php");
 //  exit;
 // }
  /*$_POST = $_SESSION;*/

 $error = false;
 $res2=mysql_query("SELECT * FROM users WHERE userId =".$_SESSION['user']);
 $userRow=mysql_fetch_array($res2);
 $counter = mysql_num_rows($res2); 

 $p = array();
 $p[0] = $userRow['img1'];
 $p[1] = $userRow['img2'];
 $p[2] = $userRow['img3'];
 $p[3] = $userRow['img4'];
 //$x[0] = $p[$random_keys];
 //print_r($p);
 $random_keys=array_rand($p,1);
 
 $pictures = array("19.jpg", "20.jpg", "21.jpg","22.jpg", "23.jpg", "24.jpg","25.jpg", "26.jpg", "27.jpg","28.jpg", "29.jpg", "30.jpg");
 $pic_string = array_rand($pictures,5);
 shuffle($pic_string);
 echo "<br>";

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
 
 //older code.
 //$a = $p[$random_keys];
 //print_r ($pic_string);
 
 // $l = $pictures[$pic_string[0]];
 // $m = $pictures[$pic_string[1]];
 // $n = $pictures[$pic_string[2]];
 // $o = $pictures[$pic_string[3]];
 // $p = $pictures[$pic_string[4]];
 
 //print_r($x);
 $text = $_SESSION['rcode'];

 // $l = $pictures[$pic_string[0]];
 // $m = $pictures[$pic_string[1]];
 // $n = $pictures[$pic_string[2]];
 // $o = $pictures[$pic_string[3]];
 // $p = $pictures[$pic_string[4]];
 
 $pyscript="C:\\wamp\\www\\iitrpr-net-banking\\textplacement\\new.py";
 $python="C:\\Python27\\python.exe";
 $cmd="$python $pyscript $text $x[0] $x[1] $x[2] $x[3] $x[4] $x[5]";
 $output=shell_exec("python C:\\wamp\\www\\iitrpr-net-banking\\textplacement\\new.py $text $x[0] $x[1] $x[2] $x[3] $x[4] $x[5] 2>&1");
 echo $output; // new images will be placed in output folder

 // $img_output = array(0,1,2,3,4,5);
 // shuffle($img_output);

 $count = 3;
 if(isset($_POST['cust-login'] )) {
 	$flag = 0;
 	      if(!empty($_POST['images_selected'])) {
        $pic_array = array();
        foreach($_POST['images_selected'] as $checked) {
                echo $checked; //echoes the value set in the HTML form for each checked checkbox.
                             //so, if I were to check 1, 3, and 5 it would echo value 1, value 3, value 5.
                             //in your case, it would echo whatever $row['Report ID'] is equivalent to.
                if($checked == "out10"){
                	header("Location: home.php");
        			exit;
                }
                else{
                	$count--;
		        	echo '<script language="javascript">';
					echo 'alert("You are left with '.$count.'more attempts")';
					echo '</script>';
		        }
        }
 	}else{
 		echo " ";
 	}
 }
 else {
 	echo " ";
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
				<form name = "test" method="post" action="">
		        <div class="col-md-4">
		          Welcome <?php if(!empty($_POST['email'])) echo $_POST['email'] ; ?>
		          <br>
		          <h3 class="text-center">Customer Panel</h3>
		          <br>
		          	<div class="form-group">
						  <label for="rcode">Random Code:</label>
						  <input type="text" class="form-control" name="rcode_display" id="rcode_display" maxlength="6" value="<?php if(!empty($_POST['rcode'])) echo $_POST['rcode'];?>" required disabled>
					</div>
		            <label for="usr">Select your Security Image with random code: </label>
		            <br><br>
		            <button type="submit" class="btn btn-default btn-primary" name="cust-login" id="cust-login" disabled><a class="a-btn">Login</a></button>

		        </div>
		        <div class="col-md-8 d3 mt0">
		          <h3 class="text-center pb20 mt0">Select your Image</h3>
		          <div class="d3-2">
		                <div class="d4">
		                  <div class="d5">
		                    <?php

		                      for($i=0;$i<6;$i++){
		                      	if($i == $identity){
		                      		echo '<span class="image-checkbox-container">';
		                        	echo '<input type="checkbox" class="image-checkbox" name="images_selected[]" value="out10"/>'; 
		                        	echo '<img src="textplacement/soutputs/'.$i.'.jpg" name="out10" id="out10" height="230px" width="230px" />';
		                        	echo '</span>';
		                      	}else{
		                        echo '<span class="image-checkbox-container">';
		                        echo '<input type="checkbox" class="image-checkbox" name="images_selected[]" value="out'.$i.'"/>'; 
		                        echo '<img src="textplacement/soutputs/'.$i.'.jpg" name="out'.$i.'" id="out'.$i.'" height="230px" width="230px" />';
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

	    $('.image-checkbox-container img').live('click', function(){
	        if(!$(this).prev('input[type="checkbox"]').prop('checked')){
	            $(this).prev('input[type="checkbox"]').prop('checked', true).attr('checked','checked');
	            this.style.border = '4px solid #38A';
	            this.style.margin = '0px';
	        }else{
	            $(this).prev('input[type="checkbox"]').prop('checked', false).removeAttr('checked');
	            this.style.border = '0';
	            this.style.margin = '4px';
	        }
	    });
	    
	    $('.image-checkbox-container img').live('click', function(){
	    var a = $('.image-checkbox:checked').size();
	    console.log(a);
	        if (a==1) {
	            $('#cust-login').removeAttr('disabled');
	        } else {
	            $('#cust-login').attr('disabled', 'disabled');
	        }
	    });
	    
	    
	 //    $('img').click(function(){
	    	
		// 		console.log($(this).attr('name'));
		// 		if ($(this).attr('name') == 'out10'){
		// 			console.log("success");
		// 		}else{
		// 			count--;
		// 			alert("You are left with "+count+" more attempts"); 
		// 		}
			
		// });
	    
	    </script>
	</body>
</html>