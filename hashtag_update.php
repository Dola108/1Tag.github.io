<?php  
$post = $_POST['post'];
$post = convertHashtoLink($post);  
function convertHashtoLink($post)  
 {  
 $check_hashtag = "/#+([a-zA-Z0-9_]+)/";  
 $post = preg_replace($check_hashtag, '<a href="#">$0</a>', $post);   
 // Change it to <a href="hashtag.php?tag=$1">$0</a> to redirect the hashtags to a page 
 return $post;
 }
if($post!=""){
 echo"<b>Anonymous: </b>";
 echo $post;
 echo"<p style='color:#8b8b8b; font-size:12px;'>Just Now</p>";
}
else{
  echo"<b>Your Post is Empty!</b>";
}
?>