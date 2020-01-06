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

	if (empty($image)) {
		echo "
		<article>
		<div>
			<span class=\"closea\" title=\"Close\" style=\"float: right;\">&times;</span>
			<p><a href=\"profile.php?un=".$user."\" style='text-decoration:none; font-size: 22px; color: #4CAF50; font-family:sans-serif;'>".$user."</a></p>
			<p style='margin-top:-10px; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>".$rw['time']."</p>
			
				<p style='margin-bottom:-10px; word-wrap: break-word; font-size: 14px; color: #ACE3C4; font-family: sans-serif;'>postno.#".$rw['id']."</p>
				<p style='font-size: 18px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word; padding-bottom:20px;'>".$posts."</p>
				<p>".$taglink."</p>
			<p class='del'><a href=\"delpost.php?id=".$id."\" style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>delete</a></p>
		</div>
		</article>";
	} else {
		echo "
		<article>
		<div>
				<span onclick=window.location.href = \"Dashboard.php\" class=\"closea\" title=\"Close\" style=\"float: right;\">&times;</span>
				<p><a href=\"profile.php?un=".$user."\" style='text-decoration:none; font-size: 22px; color: #4CAF50; font-family: sans-serif;'>".$user."</a></p>
				<p style='margin-top:-10px; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>".$rw['time']."</p>
				
					<p style='margin-bottom:-10px; word-wrap: break-word; font-size: 14px; color: #ACE3C4; font-family: sans-serif;'>post no.#".$rw['id']."</p>
					<p style='font-size: 18px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word; padding-bottom:20px;'>".$posts."</p>
					<p>".$taglink."</p>
					<img src='images/".$rw['image']."' width='500px' style='margin-left:-10px;'>
				<p class='del'><a href=\"delpost.php?id=".$id."\" style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>delete</a></p>
		</div>
		</article>";
	}

?>