<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); 

if($urlToLike=="thispage"){
    $c = Page::getCurrentPage();
    $nh = Core::make('helper/navigation');
    $likeURL = $nh->getCollectionURL($c);
}
else{
    $likeURL = $url;
}
?>

<div class="fb-like" data-href="<?php echo $likeURL?>" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&appId=349374311870323&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>