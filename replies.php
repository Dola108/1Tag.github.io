<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<?php
		include('connection.php');
		$id = $_GET["id"];
		if (!empty($_SESSION['uname'])) {
			$uname = $_SESSION['uname'];
			$_SESSION['uname'] = $uname;
		}
	?>
	<link rel="stylesheet" type="text/css" href="dashboard.css">
<link rel="stylesheet" type="text/css" href="view.css">
	<style type="text/css">
		p a:hover {
			color: #4CFF5F !important;
		}
		p.del a:hover {
			color: red !important;
		}
		.buttonq,.cancel{
		    background-color: #444;
		    border: none;
		    border-radius: 3px;
		    color: white;
		    padding: 6px 10px;
		    text-align: center;
		    text-decoration: none;
		    font-size: 12px;
		    cursor: pointer;
		    margin-right: 5px;
		    -webkit-transition-duration: 0.4s;
		    transition-duration: 0.4s;
		}


		.buttonq:hover,.cancel:hover{
		    box-shadow: 0 12px 16px 0 rgba(89, 149, 149, 0.6),0 17px 50px 0 rgba(89, 149, 149, 0);
		    background-color: #4CAF50;
		}
	</style>
	<title>1Tag</title>
</head>
<body>
		<?php
			if (empty($id)) {
				echo "<h2 style='text-align: center;'>No replies to show.</h2>";
			}
			else {
				$myQuery = "SELECT * FROM replies WHERE c_id='".$id."' ORDER BY time DESC";
				$ro=  mysqli_query($dbc, $myQuery) or die($myQuery."<br/><br/>".mysql_error());
				$num_row = mysqli_num_rows($ro);

				while($num_row!=0) {
				$rw = mysqli_fetch_array($ro, MYSQLI_BOTH);
				$cid = $rw['id'];
				$posts = nl2br($rw['texts']);
				$user = $rw['username'];
					echo "
					<article class='art' id=".$cid.">
						<div>
							<p><a href=\"profile.php?un=".$user."\" target=\"_blank\" style='text-decoration:none; font-size: 20px; color: #4CAF50; font-family: sans-serif;'>".$user."</a></p>
							<p style='margin-top:-10px; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>".$rw['time']." reply no.#".$rw['id']."</p>
							<p class=\"reply\" id=".$cid." style='font-size: 14px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word;padding-bottom:8px;'>".$posts."</p>
							<div class='hiddens' id=".$cid." style='display:none;'><p></p><button class='buttonq' id=".$cid.">save</button><button class='cancel' id=".$cid." >cancel</button></div>
							<p><a href=\"#\" onclick=\"divClicked(".$cid.")\" style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif; margin-right:5px;'>edit</a> <a href=\"#\" onclick=\"delcmnt(".$cid.")\" style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>delete</a><span class='hidden2' id=".$cid." style='display:none; color:#eaeaea; font-size:13px; margin-left:10px;'> Are you sure?<a href='#' class='del' id=".$cid." style='color:#eaeaea; font-size:13px;'> Y</a> /<a href='#' class='canceld' id=".$cid." style='color:#eaeaea; font-size:13px;'> N</a></span></p>
						</div>
					</article>";
					$num_row--;
				}
			}
		?>

<script type="text/javascript">
	var cid;
	function divClicked(x) {
		cid=x;
	    var divHtml = $(".reply").filter(function(){return this.id==x}).html();
	    var editableText = $("<textarea/>");

	    $(".hiddens").filter(function(){return this.id==x}).show();
	    editableText.val(divHtml);
	    
	    $(".reply").filter(function(){return this.id==x}).replaceWith(editableText);
	    editableText.focus();
	    
		$(".buttonq").filter(function(){return this.id==x}).click(function() {
	        var text = $(editableText).val();
			$.ajax ({
				type:'post',
				url:'editcomment.php',
				data:{
					reid: x,
					editreply: text
				},
				success:function(response) {
					if(response=="success") {
	        			alert(text);
					    var viewableText = $("<p class='reply' id="+x+" style='font-size: 14px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word;padding-bottom:8px;'>");

					    viewableText.html(text);
					    editableText.replaceWith(viewableText);

						$(".hiddens").filter(function(){return this.id==x}).hide();
					}
				}
			});
		});

		$(".cancel").click(function() {
			var viewableText = $("<p class='reply' id="+x+" style='font-size: 14px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word;padding-bottom:8px;'>");
			viewableText.html(divHtml);
		    editableText.replaceWith(viewableText);
			$(".hiddens").filter(function(){return this.id==x}).hide();
		});
	}
	function delcmnt(x) {
	    $(".hidden2").filter(function(){return this.id==x}).show();
		$(".del").filter(function(){return this.id==x}).click(function() {
			$.ajax ({
				type:'post',
				url:'editcomment.php',
				data:{
					deletereply: x
				},
				success:function(response) {
					if(response=="success") {
					    alert("Comment Deleted!");
					    $("article").filter(function(){return this.id==x}).hide();
					}
				}
			});
		});
		$(".canceld").click(function() {
			$(".hidden2").filter(function(){return this.id==x}).hide();
		});
	}
</script>
</body>