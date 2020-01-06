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
	<style type="text/css">
		p a:hover {
			color: #4CFF5F !important;
		}
		p.del a:hover {
			color: red !important;
		}
		.buttonq{
		    background-color: #444;
		    border: none;
		    border-radius: 3px;
		    color: white;
		    padding: 6px 10px;
		    text-align: center;
		    text-decoration: none;
		    font-size: 12px;
		    cursor: pointer;
		    margin-right: 10px;
		    -webkit-transition-duration: 0.4s;
		    transition-duration: 0.4s;
		}


		.buttonq:hover{
		    box-shadow: 0 12px 16px 0 rgba(89, 149, 149, 0.6),0 17px 50px 0 rgba(89, 149, 149, 0);
		    background-color: #4CAF50;
		}
	</style>
	<title>1Tag</title>
</head>
<body>
		<?php
			if (empty($id)) {
				echo "<h2 style='text-align: center;'>No posts to show.</h2>";
			}
			else {
				$myQuery = "SELECT * FROM comments WHERE post_id='".$id."' ORDER BY time DESC";
				$ro=  mysqli_query($dbc, $myQuery) or die($myQuery."<br/><br/>".mysql_error());
				$num_row = mysqli_num_rows($ro);

				while($num_row!=0) {
				$rw = mysqli_fetch_array($ro, MYSQLI_BOTH);
				$cid = $rw['id'];
				$tag = $rw['tag'];
				$image = $rw['image'];
				$posts = nl2br($rw['texts']);
				$user = $rw['username'];
				$taglink = preg_replace( "/#([^\s]+)/", "<a target=\"_blank\" href=\"Tagboard.php?val=%23$1\"  style='text-decoration:none; font-size: 14px; color: #eaeaea; font-family: sans-serif;'>".$tag."</a>", $tag );
				if (empty($image)) {
					echo "
					<article>
						<div>
							<p><a href=\"profile.php?un=".$user."\" target=\"_blank\" style='text-decoration:none; font-size: 22px; color: #4CAF50; font-family: sans-serif;'>".$user."</a></p>
							<p style='margin-top:-10px; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>".$rw['time']." post no.#".$rw['id']."</p>
							<p class=\"comment\" value=".$cid." style='font-size: 16px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word;padding-bottom:20px;'>".$posts."  ".$taglink."</p>
							<div class='hiddens' value=".$cid." style='display:none;'><p></p><button class='buttonq' onclick=\"save(".$cid.")\">save</button><button class='buttonq' id='cancel' value=".$cid." >cancel</button></div>
							<p><a href=\"#\" onclick=\"divClicked(".$cid.")\" id=\"edit\" style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif; margin-right:10px;'>edit</a> <a href=\"#\" style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif; margin-right:10px;'>reply</a> <a href='#' onclick=\"\" id='v' style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif; margin-right:10px;'>upvote</a> <a href='#' onclick=\"\" id='v' style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif; margin-right:10px;'>downvote</a> <a href='#' onclick=\"\" id='v' style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif; margin-right:10px;'>show replies</a> <a href=\"delete_comment.php?id=".$cid."\" style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>delete</a></p>
							<hr>
						</div>
					</article>";
				} else {
					echo "
					<article>
						<div>
							<p><a href=\"profile.php?un=".$user."\" target=\"_blank\" style='text-decoration:none; font-size: 22px; color: #4CAF50; font-family: sans-serif;'>".$user."</a></p>
							<p style='margin-top:-10px; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>".$rw['time']." post no.#".$rw['id']."</p>
							<p id=\"comment\" style='font-size: 16px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word;padding-bottom:20px;'>".$posts."</p>
							<p id=\"comment\" style='font-size: 16px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word;padding-bottom:20px;'>".$taglink."</p>
							<div id='hiddens' style='display:none;'><p></p><button class='buttonq'>save</button><button id='cancel' class='buttonq'>cancel</button></div>
							<img src='images/".$rw['image']."' width='400px'>
							<p><a href='#' id='edit' style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif; margin-right:10px;'>edit</a> <a href='#' onclick=\"\" id='v' style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif; margin-right:10px;'>reply</a> <a href='#' onclick=\"\" id='v' style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif; margin-right:10px;'>upvote</a> <a href='#' onclick=\"\" id='v' style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif; margin-right:10px;'>downvote</a> <a href='#' onclick=\"\" id='v' style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif; margin-right:10px;'>show replies</a> <a href=\"delete_comment.php?id=".$cid."\" style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>delete</a></p>
							<hr>
						</div>
					</article>";
				}
					
					$num_row--;
					$_SESSION['id'] = $rw['id'];
				}
			}
		?>

<script type="text/javascript">
	var texts;
	function divClicked(id) {
	    var divHtml = $(".comment").filter(function(){return this.value==id}).html();
	    var editableText = $("<textarea class='post' style='height:60px;'/>");
	    $(".hiddens").filter(function(){return this.value==id}).show();
	    editableText.val(divHtml);
	    $(".comment").filter(function(){return this.value==id}).replaceWith(editableText);
	    editableText.focus();
	    // setup the blur event for this new textarea
		texts = editableText.val();
	}
	function save(id) {
		$.ajax ({
			type:'post',
			url:'editcomment.php',
			data:{
				edited: texts,
				id: id
			},
			success:function(response) {
				if(response=="success") {	
					alert(texts);
				    var viewableText = $("<p id='comment'>");
				    viewableText.html(texts);
				    $(this).replaceWith(viewableText);
				}
			}
		});
	}
</script>
</body>