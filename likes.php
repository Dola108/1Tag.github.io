<?php
	session_start();
	include('connection.php');

	if(isset($_POST['liked'])) {
		$id=$_POST['liked'];
		$uname=$_SESSION['uname'];
		$i=1;
		$row = mysqli_query($dbc, "SELECT count FROM likes WHERE id='".$id."'");
		$n = mysqli_num_rows($row);
		if($n==0) {
			mysqli_query($dbc, "INSERT INTO likes (username, count, p_id) VALUES ('$uname', '$i', '$id')");
		} else {
			mysqli_query($dbc, "UPDATE likes SET count=count+1 WHERE p_id='".$id."'");
		}
		echo "success";
	}

	if(isset($_POST['disliked'])) {
		$id=$_POST['liked'];
		$uname=$_SESSION['uname'];
		$i=-1;
		$row = mysqli_query($dbc, "SELECT count FROM likes WHERE id='".$id."'");
		$n = mysqli_num_rows($row);
		if($n==0) {
			mysqli_query($dbc, "INSERT INTO likes (username, count, p_id) VALUES ('$uname', '$i', '$id')");
		} else {
			mysqli_query($dbc, "UPDATE likes SET count=count-1 WHERE p_id='".$id."'");
		}
		echo "success";
	}
?>