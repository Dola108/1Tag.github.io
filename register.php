<?php  
	session_start();
	include('connection.php');
	$uname=$_GET['uname'];
	$myQuery = "SELECT * FROM registration WHERE username='".$uname."'";
	$r=  mysqli_query($dbc, $myQuery) or die($myQuery."<br/><br/>".mysql_error());
	$row = mysqli_fetch_array($dbc, "SELECT * FROM registration");
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="theme.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>1Tag</title>
</head>
<body>
	<nav id="myHeader" style="margin-left: -9px; margin-right: -9px; margin-top: -8px; position: fixed; top: 8px; width: 100%;">
	    <ul class="ls">
	        <li class="ls"><a href="http://localhost/proj/dashboard.php?val=1">Dashboard</a></li>
	        <li class="ls"><a href="http://localhost/proj/tagboard.php?val=Tags">Tags</a></li>
	        <li class="ls"><a href="#">Search</a></li>
	        <li class="ls"><a href="#">Others</a></li>
	    </ul>
	<button type="button" id="logout" class="button3"  onclick="window.location.href = 'http://localhost/fuckinFromSkratch/homepage.html'" value="check" style="margin-right: 5%;
		        										   padding: 6px 16px;
		        										   font-size: 14px;
		        										   margin-top: -3%;">Log out</button>
	</nav>

		<div class="profile_container" style="margin-top: 0;">
			<?php
				$row=  mysqli_fetch_array($r);
				echo "<img src='images/".$row['avatar']."' class='avatar'>";
			?>
			<?php
				echo "<h3>". $uname."</h3>";
			?>
			<nav>
				<ul class="ls" style="background-color: rgba(0,0,0,0.4);">
			        <li class="ls" style="width: 100%;"><a href="http://localhost/proj/dashboard.php?val=1">Write Post</a></li>
				</ul>
				<ul class="ls" style="background-color: rgba(0,0,0,0.4);">
					<li class="ls" style="width: 100%;"><a href="#">Posts</a></li>
				</ul>
				<ul class="ls" style="background-color: rgba(0,0,0,0.4);">
			        <li class="ls" style="width: 100%; padding-bottom: 146%;"><a href="#">Likes</a></li>
				</ul>
			</nav>
		</div>
			
		<div class="post_container">
			<article>
				<h2 style="color: #eaeaea; text-shadow: 4px 5px 10px black;">No posts to show.</h2>
			</article> 
		</div>

	<footer style="margin-top: -8px; margin-left: -9px; margin-right: -6.5px;">Copyright &copy; 1tag.com</footer>

</body>
</html>