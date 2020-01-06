<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<?php
		include('connection.php');
		$id = $_GET["id"];
		if (!empty($_SESSION['uname'])) {
			$uname = $_SESSION['uname'];
			$_SESSION['uname'] = $uname;
		}
	?>
	<script type="application/javascript">
	  function resizediv2(obj) {
	    obj.style.height = obj.contentWindow.document.body.scrollHeight*1.1 + 'px';
	  }
</script>
	<link rel="stylesheet" type="text/css" href="dashboard.css">
<link rel="stylesheet" type="text/css" href="view.css">
	<style type="text/css">
		p a:hover {
			color: #4CFF5F !important;
		}
		p.del a:hover {
			color: red !important;
		}
		.buttonq,.cancel,.replyb,.replyc{
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
		.buttonq:hover,.cancel:hover,.replyb:hover,.replyc:hover{
		    box-shadow: 0 12px 16px 0 rgba(89, 149, 149, 0.6),0 17px 50px 0 rgba(89, 149, 149, 0);
		    background-color: #4CAF50;
		}
		.replies{
			display:none;
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
				$myr = "SELECT * FROM replies WHERE c_id='".$cid."'";
				$rq=  mysqli_query($dbc, $myr);
				$num_reps = mysqli_num_rows($rq);
				if (empty($image)) {
					echo "
					<article class='art' id=".$cid.">
						<div>
							<p><a href=\"profile.php?un=".$user."\" target=\"_blank\" style='text-decoration:none; font-size: 22px; color: #4CAF50; font-family: sans-serif;'>".$user."</a></p>
							<p style='margin-top:-10px; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>".$rw['time']." post no.#".$rw['id']."</p>
							<p class=\"comment\" id=".$cid." style='font-size: 16px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word;padding-bottom:20px;width:70%;'>".$posts."  ".$taglink."</p>
							<div class='hiddens' id=".$cid." style='display:none;'><p></p><button class='buttonq' id=".$cid.">save</button><button class='cancel' id=".$cid." >cancel</button></div>
							<div class='hiddenr' id=".$cid." style='display:none;'>
								<form action='#' enctype=\"multipart/form-data\" class='replies' id=".$cid." method='post'>
									<textarea class=\"reply\" id=\"posst\" name=\"texts\"></textarea>
									<button type=\"submit\" name=\"posted\" id=".$cid." class=\"replyb\" style='display:flex;margin-top:-30px;margin-left:14.4%;'>reply</button>
								</form>
								<button id=".$cid." class=\"replyc\" style='display:flex;margin-top:-26px;margin-left:18.8%;'>cancel</button>
							</div>
							<p><a href=\"#\" onclick=\"divClicked(".$cid.")\" id=\"edit\" style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif; margin-right:10px;'>edit</a> <a href=\"#\" onclick=\"reply(".$cid.")\" style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif; margin-right:10px;'>reply</a> <i onclick=\"myFunction(this)\" class=\"fa fa-thumbs-up\" style=\"font-size:17px; margin-right:10px;\"></i> <i onclick=\"myFunction2(this)\" class=\"fa fa-thumbs-down\" style=\"font-size:17px; margin-right:10px;\"></i><a href=\"#\" class='showreps' onclick=\"showReplies(".$cid.")\" id=".$cid." style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif; margin-right:10px;'>show replies (".$num_reps.")</a> <a href=\"#\" class='hidereps' onclick=\"hideReplies(".$cid.")\" id=".$cid." style='display:none;text-decoration:none; font-size: 12px; color: red; font-family: sans-serif; margin-right:10px;'>hide replies</a> <a href=\"#\" onclick=\"delcmnt(".$cid.")\" style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>delete</a><span class='hidden2' id=".$cid." style='display:none; color:#eaeaea; font-size:13px; margin-left:10px;'> Are you sure?<a href='#' class='del' id=".$cid." style='color:#eaeaea; font-size:13px;'> Y</a> /<a href='#' class='canceld' id=".$cid." style='color:#eaeaea; font-size:13px;'> N</a></span></p>
							<div class=\"replies\" id=".$cid."><object style='margin-left:7%;width:600px;border-left: 2px solid #a9a9a9;' data=\"replies.php?id=".$cid."\"  frameborder=\"0\" scrolling=\"no\" onload=\"resizediv2(this)\"></object></div>
							<hr>
						</div>
					</article>";
				} else {
					echo "
					<article class='art' id=".$cid.">
						<div>
							<p><a href=\"profile.php?un=".$user."\" target=\"_blank\" style='text-decoration:none; font-size: 22px; color: #4CAF50; font-family: sans-serif;'>".$user."</a></p>
							<p style='margin-top:-10px; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>".$rw['time']." post no.#".$rw['id']."</p>
							<p class=\"comment\" id=".$cid." style='font-size: 16px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word;padding-bottom:20px;'>".$posts."  ".$taglink."</p>
							<img src='images/".$rw['image']."' class=\"img\" id=".$cid." width='400px'>
							<div class='hiddens' id=".$cid." style='display:none;'>
							    <button class='buttonq' id=".$cid.">save</button>
							    <button class='cancel' id=".$cid." >cancel</button>
								<img src=\"http://upload.wikimedia.org/wikipedia/commons/c/ce/Transparent.gif\" id=\"uploadPreview\" style=\"width: 40px; height: 40px; margin-left:10px; margin-top:1px;\" />
						    </div>
							<p><a href=\"#\" onclick=\"divClicked2(".$cid.")\" id=\"edit\" style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif; margin-right:10px;'>edit text</a> <a href='#' onclick=\"\" id='v' style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif; margin-right:10px;'>reply</a> <a href='#' onclick=\"\" id='v' style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif; margin-right:10px;'>upvote</a> <a href='#' onclick=\"\" id='v' style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif; margin-right:10px;'>downvote</a> <a href='#' onclick=\"\" id='v' style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif; margin-right:10px;'>show replies</a> <a href=\"#\" onclick=\"delcmnt(".$cid.")\" style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>delete</a><span class='hidden2' id=".$cid." style='display:none; color:#eaeaea; font-size:13px; margin-left:10px;'> Are you sure?<a href='#' class='del' id=".$cid." style='color:#eaeaea; font-size:13px;'> Y</a> /<a href='#' class='cancel' id=".$cid." style='color:#eaeaea; font-size:13px;'> N</a></span></p>
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
	var cid;
    var oFReader = new FileReader();
    var file;
    var data;
    var nor;
	function divClicked(x) {
		cid=x;
	    var divHtml = $(".comment").filter(function(){return this.id==x}).html();
	    var editableText = $("<textarea class='post' style='height:60px;'/>");
	    $(".hiddens").filter(function(){return this.id==x}).show();
	    editableText.val(divHtml);
	    $(".comment").filter(function(){return this.id==x}).replaceWith(editableText);
	    editableText.focus();
	    // setup the blur event for this new textarea
		$(".buttonq").filter(function(){return this.id==x}).click(function() {
	        var texts = $(editableText).val();
			$.ajax ({
				type:'post',
				url:'editcomment.php',
				data:{
					edited: texts,
					id: x
				},
				success:function(response) {
					if(response=="success") {
					    var viewableText = $("<p class='comment' id="+x+" style='font-size: 16px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word;padding-bottom:20px;'>");
					    viewableText.html(texts);
					    editableText.replaceWith(viewableText);
						$(".hiddens").filter(function(){return this.id==x}).hide();
					}
				}
			});
		});
		$(".cancel").click(function() {
			var viewableText = $("<p class='comment' id="+x+" style='font-size: 16px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word;padding-bottom:20px;'>");
			viewableText.html(divHtml);
		    editableText.replaceWith(viewableText);
			$(".hiddens").filter(function(){return this.id==x}).hide();
		});
	}
	function divClicked2(x) {
		cid=x;
	    var divHtml = $(".comment").filter(function(){return this.id==x}).html();
	    var editableText = $("<textarea class='post' style='height:60px;'/>");
	    var image = $(".img").filter(function(){return this.id==x});

	    $(".img").filter(function(){return this.id==x}).css({"opacity": "0.4"});
	    $(".hiddens").filter(function(){return this.id==x}).show();
	    editableText.val(divHtml);
	    $(".comment").filter(function(){return this.id==x}).replaceWith(editableText);
	    editableText.focus();
	    
		$(".buttonq").filter(function(){return this.id==x}).click(function() {
			var texts = $(editableText).val();
			$.ajax ({
				type:'post',
				url:'editcomment.php',
				data:{
					edited: texts,
					id: x
				},
				success:function(response) {
					if(response=="success") {
					    var viewableText = $("<p class='comment' id="+x+" style='font-size: 16px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word;padding-bottom:20px;'>");
					    viewableText.html(texts);
					    editableText.replaceWith(viewableText);
						$(".hiddens").filter(function(){return this.id==x}).hide();
					}
				}
			});
		});
		$(".cancel").click(function() {
			$(".img").filter(function(){return this.id==x}).css({"opacity": "initial"});
			var viewableText = $("<p class='comment' id="+x+" style='font-size: 16px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word;padding-bottom:20px;'>");
			viewableText.html(divHtml);
		    editableText.replaceWith(viewableText);
			$(".hiddens").filter(function(){return this.id==x}).hide();
		});
		//reply cmnt er kono id thakbe na.id ta parent cmnt er hobe.deletion,tree maintain will be easy
	}
	function delcmnt(x) {
	    $(".hidden2").filter(function(){return this.id==x}).show();
		$(".del").filter(function(){return this.id==x}).click(function() {
			$.ajax ({
				type:'post',
				url:'editcomment.php',
				data:{
					delete: x
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
	function reply(x) {
		cid=x;
	    $(".hiddenr").filter(function(){return this.id==x}).show();

		$("form").filter(function(){return this.id==x}).submit(function(e) {
		    var texts = $("#posst").val();
		    e.preventDefault();
		    $.ajax({
	            type:'post',
	            url: 'editcomment.php',
	            data:{
					id: x,
					reply: texts
				},
	            success:function(success) {
	            	nor = success;
					alert("Replied!");
	    			$(".hiddenr").filter(function(){return this.id==x}).hide();
	    			$(".showreps").filter(function(){return this.id==x}).html('show replies ('+nor+')');
				}
		    });
		});
		$(".replyc").click(function() {
	    	$(".hiddenr").filter(function(){return this.id==x}).hide();
		});
	}
	function showReplies(x) {
	    $(".replies").filter(function(){return this.id==x}).css("display", "inline-block");
	    $(".hidereps").filter(function(){return this.id==x}).show();
	}
	function hideReplies(x) {
	    $(".replies").filter(function(){return this.id==x}).hide();
	    $(".hidereps").filter(function(){return this.id==x}).hide();
	}
</script>
<script>
var count=1;
var count2=1;
function myFunction(x) {
	if(count2%2==0) {
    	return;
    }
    count++;
    if(count%2==0) {
    //alert(count);
      x.style.color = "#1bb86f";
    } else {
      x.style.color = "#eaeaea";
    }
}
function myFunction2(x) {
	if(count%2==0) {
    	return;
    }
    count2++;
    if(count2%2==0) {
      x.style.color = "#1bb86f";
    } else {
      x.style.color = "#eaeaea";
    }
}
</script>
</body>
</html>