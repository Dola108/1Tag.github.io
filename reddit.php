<head>
	<title>1Tag</title>
	<script type="application/javascript">
	  function resizediv(obj) {
	    obj.style.height = obj.contentWindow.document.body.scrollHeight*1.2 + 'px';
	  }
	</script>
	<?php
		include('connection.php');
		if (!empty($_SESSION['uname'])) {
			$uname = $_SESSION['uname'];
			$_SESSION['uname'] = $uname;
		}
	?>
</head>
<link rel="stylesheet" type="text/css" href="view.css">
<link rel="stylesheet" type="text/css" href="dashboard.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<body style="background-color: #333;">
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
	echo "
	<div style='margin-left:30px;margin-top:2%;'>
	<p><a href=\"profile.php?un=".$user."\" style='text-decoration:none; font-size: 22px; color: #4CAF50; font-family: sans-serif;'>".$user."</a></p>
	<p style='margin-top:-10px; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>".$rw['time']."</p>
	<p style='word-wrap: break-word; font-size: 14px; color: #ACE3C4; font-family: sans-serif;'>post no.#".$rw['id']."</p>
	<p style='font-size: 18px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word; padding-bottom:20px;'>".$posts."</p>
	<p>".$taglink."</p>
	<div class=\"commentbox\" style='margin-left:-6.5%;px;'>
		<form class='cform' id=".$id." action=\"#\" enctype=\"multipart/form-data\" method=\"post\">
		    <div class=\"form-group\">
			<textarea class=\"post\" id=\"texts\" maxlength=\"180\" name=\"texts\" cols=\"90\" rows=\"3\" style=\"height:70px;\" placeholder=\"post a comment..\"></textarea>
			</div>
			<div class=\"form-group\">
				<input type=\"hidden\" name=\"comment_id\" id=\"comment_id\" value=".$id." />
				<input type=\"file\" name=\"file\" id=\"file\" style='margin-left:5%;background-color:white;'/>
				<input type=\"submit\" name=\"submit\" id=\"submit\" class=\"button4\" style=\"margin-left:5px;\" value=\"post\" />
			</div>
			<p id=\"pp\" style=\"float: right; margin-right: 85px; margin-top: -50px; font-size: 17px; color: #eaeaea;\"></p>
		</form>
	</div>
	<p><a href=\"comments.php?id=".$id."\" style='text-decoration:none; font-size: 16px; color: #eaeaea; font-family: sans-serif;'>Comments</a></p>
	<hr class=\"gh\" style=\"margin-left:0px; margin-top:3px;\">
	<br>
	<div id=\"display_comment\" style='background-color:#transparent;'></div>
	</div>";
?>
</body>

<script>
$(document).ready(function(){
	var id=<?php echo $id; ?>;
	var pid=id;
	var formData;
	$(document).on('change', '#file', function(){
		formData = new FormData();
		formData.append("file", document.getElementById('file').files[0]);
		$('.cform').on('submit', function(event){
			event.preventDefault();
			$.ajax({
				url:"add_comment.php",
				method:"POST",
				data: formData,
				dataType:"JSON",
				contentType: false,
				cache: false,
				processData: false,
				success:function(response)
				{
					if(response)
					{
						$('.cform')[0].reset();
						$('#comment_id').val(pid);
						load_comment();
					}
				}
			});
		});
	});

	load_comment();

	function load_comment()
	{	
		$.ajax({
			url:"fetch_comment2.php",
			method:"POST",
			data:{
					id: pid
				},
			success:function(data)
			{
			 $('#display_comment').html(data);
			}
		})
	}

	$(document).on('click', '.reply', function(){
		var comment_id = $(this).attr("id");
		$('#comment_id').val(comment_id);
	 	$('#texts').focus();
	});
 
});
</script>
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