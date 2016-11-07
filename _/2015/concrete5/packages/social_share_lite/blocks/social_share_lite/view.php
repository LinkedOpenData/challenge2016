<?php   defined('C5_EXECUTE') or die("Access Denied.");

if($page->isEditMode()) { ?>
<div class="ccm-edit-mode-disabled-item"><?php  echo t('Social share buttons disabled in edit mode.');?></div>
<?php 
} else {

echo '<div class="ccm-social-share">';
echo '<ul>';

/**
 * Like Button from Facebook
 * get another code: https://developers.facebook.com/docs/reference/plugins/like/
 */
if($fblike){ ?>
<li class="fblike">
<div class="fb-like" data-href="<?php  echo h($url); ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
</li><?php 
}

/**
 * Tweet Button from Twitter
 * get another code: https://dev.twitter.com/docs/tweet-button
 */
if($tweet){ ?>
<li class="tweet">
<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php  echo h($url); ?>" data-lang="<?php  echo h($language); ?>"<?php  if(isset($twitter_site) && !empty($twitter_site)){?> data-via="<?php  echo h($twitter_site); ?>"<?php  }?>><?php  echo t('Tweet'); ?></a>
</li><?php 
}

/**
 * Google plus Button from Google
 * get another code: https://developers.google.com/+/web/+1button/
 */
if($gplus){ ?>
<li class="gplus">
<div class="g-plusone" data-size="medium" data-href="<?php  echo h($url); ?>"></div>
</li><?php 
}

/**
 * Hatena bookmark Button from Hatena
 * get another code: http://b.hatena.ne.jp/guide/bbutton
 */
if($bhatena){ ?>
<li class="bhatena">
<a href="http://b.hatena.ne.jp/entry/<?php  echo h($url); ?>" class="hatena-bookmark-button" data-hatena-bookmark-layout="simple-balloon" data-hatena-bookmark-lang="<?php  echo h($language); ?>" title="<?php  echo t('Add this entry to hatena bookmark');?>"><img src="http://b.st-hatena.com/images/entry-button/button-only@2x.png" alt="<?php  echo t('Add this entry to hatena bookmark');?>" width="20" height="20" style="border: none;" /></a>
</li><?php 
}

/**
 * Share Button from Tumblr
 * get another code: http://www.tumblr.com/buttons
 */
if($tumblr){ ?>
<li class="tumblr">
<a href="http://www.tumblr.com/share" title="<?php  echo t('Share on Tumblr'); ?>" class="tumblr-button"><?php  echo t('Share on Tumblr'); ?></a>
</li><?php 
}

/**
 * Pin It button from Pinterest
 * get another code: http://business.pinterest.com/widget-builder/#do_pin_it_button
 */
if($pinterest){ ?>
<li class="pinterest">
<a href="//pinterest.com/pin/create/button/" class="pin-it-button" data-pin-do="buttonBookmark" ><img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" /></a>
</li><?php 
}

/**
 * Share Button from LinkedIn
 * get another code: http://developer.linkedin.com/plugins/share-plugin-generator
 */
if($linkedin){ ?>
<li class="linkedin">
<script type="IN/Share" data-url="<?php  echo h($url); ?>" data-counter="right"></script>
</li><?php 
}

/**
 * Pocket Button from Pocket
 * get another code: http://getpocket.com/publisher/button
 */
if($pocket){ ?>
<li class="pocket">
<a data-pocket-label="pocket" data-pocket-count="horizontal" data-save-url="<?php  echo h($url); ?>" class="pocket-btn" data-lang="<?php  echo h($language); ?>"></a>
</li><?php 
}

/**
 * Send to LINE Button from LINE
 * get another code: http://media.line.me/howto/en/
 */
if($line){ ?>
<li class="line">
<span><script type="text/javascript">new media_line_me.LineButton({"pc":false,"lang":"<?php  echo h($language); ?>","type":"a","text":"<?php  echo h($url); ?>","withUrl":true});</script></span>
</li><?php 
}

echo '</ul>';
echo '</div>';

}
