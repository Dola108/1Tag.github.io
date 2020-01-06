<link rel="stylesheet" type="text/css" href="theme.css">
<?php 
 	include('connection.php');
	$myQuery = "SELECT tag, count(*) as sames FROM post GROUP BY tag ORDER BY sames DESC";
	$maxLines = 33;

	$r=  mysqli_query($dbc, $myQuery) or die($myQuery."<br/><br/>".mysqli_error($dbc));
	$num_row = mysqli_num_rows($r);

	while($num_row!=0) {
		$row = mysqli_fetch_array($r, MYSQLI_BOTH);
		$tag = $row['tag'];
		$taglink = preg_replace( "/#([^\s]+)/", "<a href=\"Tagboard.php?val=%23$1\">".$tag."</a>", $tag );
		echo "<li class=\"tg\">".$taglink."</li>";
		$maxLines--;
		if( 0 == $maxLines )
			break;
	}
	$num_row--;
?>