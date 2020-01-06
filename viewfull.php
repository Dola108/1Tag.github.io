<head>
	<title>1Tag</title>
	<script type="application/javascript">
	  function resizediv(obj) {
	    obj.style.height = obj.contentWindow.document.body.scrollHeight*1.2 + 'px';
	  }
</script>
	</script>
</head>
<body>
<link rel="stylesheet" type="text/css" href="view.css">
<link rel="stylesheet" type="text/css" href="dashboard.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php 
	include('connection.php');
	
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
	} else {
		print_r($_GET['id']);
	}

	$myQuery = "SELECT * FROM post WHERE id='".$id."'";
	$ro=  mysqli_query($dbc, $myQuery);//or die($myQuery."<br/><br/>".mysql_error());
	
	$rw = mysqli_fetch_array($ro, MYSQLI_BOTH);
	$user = $rw['username'];
	$tag = $rw['tag'];
	$image = $rw['image'];
	$posts = nl2br($rw['post']);
	$taglink = preg_replace( "/#([^\s]+)/", "<a href=\"Tagboard.php?val=%23$1\"  style='text-decoration:none; font-size: 14px; color: #eaeaea; font-family: sans-serif;'>".$tag."</a>", $tag );
	//switch(1){
	//    case 'thumbnailload':
	//       thumbnailload($_GET['id']);
	//    break;
	//}
	//function thumbnailload($id)
	//{
	//	$i = $id;
	//}
	//if(!empty($id)) {thumbnailload($id); print_r($id); die();}
		echo "
		<article>
			<div id='box' class='modala'>
			<div class='modala-content'>
			<span onclick=\"window.location.reload()\" class=\"closea\" title=\"Refresh\" style=\"float: right;\"><img id='i' onmouseover=\"this.style.opacity = '0.6';\" onmouseout=\"this.style.opacity = 'initial';\" width='20px' height='20px' class=\"img\" src=\"refresh.png\"></img></span>
				<p><a href=\"profile.php?un=".$user."\" style='text-decoration:none; font-size: 22px; color: #4CAF50; font-family: sans-serif;'>".$user."</a></p>
				<p style='margin-top:-10px; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>".$rw['time']."</p>
				
					<p style='margin-bottom:-10px; word-wrap: break-word; font-size: 14px; color: #ACE3C4; font-family: sans-serif;'>post no.#".$rw['id']."</p>
					<p style='font-size: 18px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word; padding-bottom:20px;'>".$posts."</p>
					<p>".$taglink."</p>
				<p class='del'><a href=\"flagpost.php?id=".$id."\" style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif; margin-right:10px;'>flag</a> <i onclick=\"myFunction(this)\" class=\"fa fa-thumbs-up\" style=\"font-size:18px; margin-right:10px;\"></i> <i onclick=\"myFunction2(this)\" class=\"fa fa-thumbs-down\" style=\"font-size:18px;\"></i></p>
				<div class=\"commentbox\">
					<form action=\"make_comment.php?id=".$id."\" enctype=\"multipart/form-data\" method=\"post\">
						<textarea class=\"post\" maxlength=\"180\" id=\"posst\" name=\"texts\" cols=\"90\" rows=\"3\" style=\"height:70px;\" placeholder=\"post a comment..\"></textarea>
					    <button type=\"submit\" class=\"button4\" style=\"margin-left:5px;\" name=\"posted\">POST</button>
					    <div style=\"margin-top:5px;\"><div class=\"image-upload\">
						    <label for=\"file-input\">
						    	<img src=\"cam0.png\" width=\"130%\" onmouseover=\"this.src='cam1.png';\" onmouseout=\"this.src='cam0.png';\"/>
						    </label>
						    <input id=\"file-input\" name=\"image\" accept=\"image/*\" onchange=\"previewImg();\" type=\"file\"/>
						</div>
						<input type=\"text\" id=\"tagbox\" name=\"tag\" pattern=\"#[A-Za-z0-9_]{2,50}\" placeholder=\"e.g.:#hash_tag\" onfocusin=\"focusFunction()\" onfocusout=\"blurFunction()\" title=\"Character limit: 2-50\">
						<img src=\"http://upload.wikimedia.org/wikipedia/commons/c/ce/Transparent.gif\" id=\"uploadPreview\" style=\"width: 40px; height: 40px;\" /></div>
						<p id=\"pp\" style=\"float: right; margin-right: 85px; margin-top: -50px; font-size: 17px; color: #eaeaea;\"></p>
					</form>
				</div>
				<p><a href=\"comments.php?id=".$id."\" style='text-decoration:none; font-size: 16px; color: #eaeaea; font-family: sans-serif;'>Comments</a></p>
				<hr class=\"gh\" style=\"margin-left:0px; margin-top:3px;\">
				<object id='ok' class=\"comm\" data=\"comments.php?id=".$id."\"  frameborder=\"0\" scrolling=\"no\" onload=\"resizediv(this)\"></object>
				</div>
			</div>
		</article>";
?>
<script type="text/javascript">
		var textarea = document.querySelector("textarea");
		var tg = document.getElementsByName("tag")[0];


	    function previewImg() {
	        var oFReader = new FileReader();
	        oFReader.readAsDataURL(document.getElementById("file-input").files[0]);

	        oFReader.onload = function (oFREvent) {
	            document.getElementById("uploadPreview").src = oFREvent.target.result;
	            document.getElementById("uploadPreview").style.border = "2px solid #333";
	            document.getElementById("uploadPreview").style.borderRadius = "4px";
	        };
	    };

		function focusFunction(){tg.placeholder=' '; tg.style.background = transparent;}
		function blurFunction(){tg.placeholder='e.g.:#hash_tag';}

		textarea.addEventListener("input", function(){
		    var maxlength = this.getAttribute("maxlength");
		    var currentLength = this.value.length;

		    if( currentLength >= maxlength ){
		        document.getElementById('pp').innerText = maxlength - currentLength + "/" + maxlength;
		    }else{
		        document.getElementById('pp').innerText = maxlength - currentLength + "/" + maxlength; 
		    }
		});
		textarea.onpaste = function(e){
		    //do some IE browser checking for e
		    var max = this.getAttribute("maxlength");
		    e.clipboardData.getData('text/plain').slice(0, max);
		};
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