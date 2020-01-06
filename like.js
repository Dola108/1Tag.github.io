var a=1;
$( ".like" ).filter(function(){return this.id==1}).click(function() {
if(a==2) {alert();return;}
  $( this ).toggleClass( "highlight");
  if($( this ).hasClass( "highlight" )) {
  a=1;
    $(".dislike").filter(function(){return this.id==x}).prop('disabled', true);
  } else {
  a=0;
    $(".dislike").filter(function(){
    return this.id==x}).prop('disabled', false);
  }
});
$( ".dislike" ).filter(function(){return this.id==1}).click(function() {
if(a==1) {alert();return;}
  $( this ).toggleClass( "highlight");
  if($( this ).hasClass( "highlight" )) {
  a=2;
    $(".like").filter(function(){return this.id==x}).prop('disabled', true);
  } else {
  a=0;
    $(".like").filter(function(){return this.id==x}).removeProp( "disabled" );
  }
});
function postClicked(x, e) {
    e.preventDefault();
    cid=x;
    var post = $("#post-"+x);
    var divHtml = $("#post-"+x).html();
    var editableText = $("<textarea class='post'/>");
    $("#hidden-"+x).show();
    editableText.val(divHtml);
    $("#post-"+x).replaceWith(editableText);
    editableText.focus(); 

  $("#save-"+x).click(function() {
        var texts = $(editableText).val();
    $.ajax ({
      type:'post',
      url:'editpost.php',
      data:{
        edited: texts,
        id: x
      },
      success:function(response) {
        if(response=="success") {
            var viewableText = $(post);
            viewableText.html(texts);
            editableText.replaceWith(viewableText);
          $("#hidden-"+x).hide();
        }
      }
    });
    });

    $("#cancel-"+x).click(function(event) {
      event.preventDefault();
      var viewableText = $(post);
      viewableText.html(divHtml);
        editableText.replaceWith(viewableText);
        $("#hidden-"+x).hide();
    });
}
<div id='hidden-".$rw['id']."' style="display:none;"><p></p> 
<button class=\"buttonq\" id='save-".$rw['id']."'>save</button>
<button class=\"cancel\" id='cancel-".$rw['id']."' >cancel</button>
</div>
          <li class="ls"><a href="javascript:history.go(-1)" style="font-size: 17px!important;">X Back</a></li>