<?php
	session_start();
	include('connection.php');

	$uname = $_SESSION['uname'];
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
	} else {
		print_r($_GET['id']);
	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		if (isset($_POST['posted'])) {
			$text  = mysqli_real_escape_string($dbc, $_POST['texts']);

			$image      = $_FILES['image'];
			$name       = $_FILES['image']['name'];
			$temp_name  = $_FILES['image']['tmp_name'];
			$newname = $name; 
			//print_r($_FILES); 
			$location = realpath(dirname(__FILE__)).'/images/'.basename($name); 
			$image_path = realpath(dirname(__FILE__)).'/images/';   
			$extention = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

			if (!empty($name)) {
				if(file_exists($location)){
				    $increment = 0;
				    list($name, $extention) = explode('.', $name);
				    while(file_exists($location)) {
				        $increment++;
				        $location = realpath(dirname(__FILE__)).'/images/'.$name. $increment . '.' . $extention;
				        $newname = $name. $increment . '.' . $extention;
				    }
				 } 
			}

			mysqli_query($dbc, "INSERT INTO replies(username, texts, image, c_id) VALUES('$uname', '$text', '$newname', '$id')");

			if(isset($newname)){
			    if(!empty($newname)){    
				    if(move_uploaded_file($_FILES['image']['tmp_name'], $location) && is_writable($location)){
				        //echo 'File uploaded successfully';
				    }
				    else{
				        //echo "Failed to move...";
				    }
				}
			}
		    
			echo "<script>
					alert('Replied!');
			</script>";
			echo "please refresh the page or click the icon in the top cornerof this page.";
		}
	}else {
		echo "No form has been submitted";
	}
?>
