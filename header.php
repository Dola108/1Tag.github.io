<!DOCTYPE html>
<html>
<head>
	<?php
		session_start();
		include('connection.php');
		if (!empty($_SESSION['uname'])) {
			$uname = $_SESSION['uname'];
			$myQuery = "SELECT * FROM registration WHERE username='".$uname."'";
			$r=  mysqli_query($dbc, $myQuery) or die($myQuery."<br/><br/>".mysql_error());
			$row = mysqli_fetch_array($dbc, "SELECT * FROM registration");
			$_SESSION['uname'] = $uname;
		}
	?>
	<link rel="stylesheet" type="text/css" href="dashboard.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>1Tag</title>
</head>
<body>
	<nav id="myHeader" style="margin-left: -9px; margin-right: -9px; margin-top: -8px; position: fixed; top: 8px; width: 100%;">
	    <ul class="ls">
	        <li class="ls"><a href="profile.php">Profile</a></li>
	        <li class="ls"><a href="Dashboard.php">Dashboard</a></li>
	        <li class="ls"><a href="#">Search</a></li>
	        <li class="ls"><a href="#">Others</a></li>
	    </ul>
	    <?php 
	    	if (!empty($_SESSION['uname'])) {
	    		echo "<button type='button' id='logout' class='button3'  onclick='window.location.href = 'logout.php'' 
													   value='check' style='margin-right: 5%;
		        										   padding: 6px 16px;
		        										   font-size: 14px;
		        										   margin-top: -3%;'>Log out</button>";
	    	} else {
	    		include('homepage.php');
	    		echo "<button type='button' id='but0n' data-target='#myModal' class='button3'> Log In</button>";
	    	}
	    ?>
	
	</nav>
</body>