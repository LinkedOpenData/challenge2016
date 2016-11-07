<?php   defined('C5_EXECUTE') or die("Access Denied.");

$urlHelper = Core::make('helper/concrete/urls');
$blockType = BlockType::getByHandle('customizable_twitter_feed');
$localPath = $urlHelper->getBlockTypeAssetsURL($blockType);

?>

<style>
<?php 
if ($feedTheme == 'dark') {
    $feedTitleColor = '#000000';
    $nameTextColor = '#000000';
    $feedTextColor = '#000000';
    $feedLinkColor = '#868686';
    $feedLinkHoverColor = '#46a3d9';
    $timePostedColor = '#46a3d9';
    $tweetDividerColor = '#000000';
} elseif ($feedTheme == 'light') {
    $feedTitleColor = '#FFF';
    $nameTextColor = '#FFF';
    $feedTextColor = '#D5D5D5';
    $feedLinkColor = '#B1B1B1';
    $feedLinkHoverColor = '#73CBFF';
    $timePostedColor = '#73CBFF';
    $tweetDividerColor = '#FFF';
}
?>
    #twitter-feed-container {
        max-width: <?php  if ($maxWidth) { echo $maxWidth . 'px'; } else { echo '520px'; } ?>;
        word-wrap: break-word;
        <?php  if ($feedBackgroundColor) { ?>
        background: <?php  echo $feedBackgroundColor; ?>;
        <?php  } ?>
        <?php  if ($feedPadding) { ?>
        padding: <?php  echo $feedPadding . 'px' ?>;
        <?php  } ?>
    }
    #twitter-feed-container h2 {
        margin: 0 0 15px 0;
        <?php  if ($feedTitle) { ?>
        font-size: <?php  if ($feedTitleTextSize) { echo $feedTitleTextSize . 'px'; } else { echo '18px'; } ?>;
        color: <?php  if ($feedTitleColor) { echo $feedTitleColor; } ?>;
        <?php  } ?>
    }
    #twitter-feed .user a img {
        margin-right: 20px;
        vertical-align: middle;
        float: left;
    }
    #twitter-feed .media img {
        width: 100% \9;
        max-width: 100%;
        height: auto;
    }
    #twitter-feed .media {
        <?php 
        if ($showUser == 'true' && $tweetDivider == 'on') {
            echo 'margin-bottom: 20px;';
        } else {
            echo 'margin-bottom: 30px;';
        }
        ?>
    }
    #twitter-feed .user span span {
        font-size: <?php  if ($nameTextSize) { echo $nameTextSize . 'px'; } else { echo '16px'; } ?>;
        color: <?php  if ($nameTextColor) { echo $nameTextColor; } ?>;
        font-weight: bold;
    }
    #twitter-feed .user span + span {
        font-size: <?php  if ($atNameTextSize) { echo $atNameTextSize . 'px'; } else { echo '14px'; } ?>;
        color: <?php  if ($feedLinkColor) { echo $feedLinkColor; } ?>;
        font-weight: bold;
    }
    #twitter-feed .user span + span:hover {
        color: <?php  if ($feedLinkHoverColor) { echo $feedLinkHoverColor; } ?>;
        -webkit-transition: color 250ms;
        -o-transition: color 250ms;
        transition: color 250ms;
        font-weight: bold;
    }
    #twitter-feed ul {
        margin: 0;
        padding: 0;
    }
    #twitter-feed li {
        list-style: none;
        margin-bottom: 20px;
        <?php  if ($tweetDivider == 'on') { ?>
        border-top: 1px solid <?php  if ($tweetDividerColor) { echo $tweetDividerColor; } ?>;
        <?php  } ?>
        <?php  if (($showUser == 'true' && $tweetDivider == 'on') || $tweetDivider == 'on') { ?>
        padding-top: 20px;
        <?php  } ?>
    }
    #twitter-feed li:first-child {
        border-top: none;
        <?php  if (($showUser == 'true' && $tweetDivider == 'on') || $tweetDivider == 'on') { ?>
        padding-top: 10px;
        <?php  } ?>
    }
    #twitter-feed p {
        color: <?php  if ($feedTextColor) { echo $feedTextColor; } ?>;
    }
    #twitter-feed .tweet {
        margin-bottom: -3px;
        font-size: <?php  if ($feedTextSize) { echo $feedTextSize . 'px'; } else { echo '14px'; } ?>;
        line-height: 1.35;
        <?php  if ($showUser == 'true' && $enableLinks == 'true') { ?>
        margin-left: 68px;
        <?php  } elseif ($showUser == 'true' && $enableLinks == 'false') { ?>
        margin-left: 0;
        <?php  } ?>
    }
    #twitter-feed-container #twitter-feed a {
        color: <?php  if ($feedLinkColor) { echo $feedLinkColor; } ?>;
    }
    #twitter-feed-container #twitter-feed a:hover {
        color: <?php  if ($feedLinkHoverColor) { echo $feedLinkHoverColor; } ?>;
        -webkit-transition: color 250ms;
        -o-transition: color 250ms;
        transition: color 250ms;
    }
    #twitter-feed .tweet img {
        display: none;
    }
    #twitter-feed .timePosted {
        font-size: <?php  if ($timePostedTextSize) { echo $timePostedTextSize . 'px'; } else { echo '12px'; } ?>;
        <?php  if ($showUser == 'true' && $enableLinks == 'true') { ?>
        margin-left: 68px;
        <?php  } elseif ($showUser == 'true' && $enableLinks == 'false') { ?>
        margin-left: 0;
        <?php  } ?>
        color: <?php  if ($timePostedColor) { echo $timePostedColor; } ?>;
        margin-top: 10px;
        margin-bottom: 7px;
    }
    #twitter-feed .interact {
        <?php  if ($showUser == 'true' && $enableLinks == 'true') { ?>
        margin-left: 68px;
        <?php  } elseif ($showUser == 'true' && $enableLinks == 'false') { ?>
        margin-left: 0;
        <?php  } ?>
        font-size: <?php  if ($interactTextSize) { echo $interactTextSize . 'px'; } else { echo '12px'; } ?>;
        <?php  if ($showTime == 'false') { ?>
        margin-top: 10px;
        <?php  } ?>
    }
    #twitter-feed .interact a {
        margin-left: 10px;
        text-decoration: none;
    }
    #twitter-feed .interact a:first-child {
        margin-left: 0px;
    }
</style>

<div id="twitter-feed-container">
    <?php  if ($feedTitle) { ?>
    <h2><?php  echo $feedTitle; ?></h2>
    <?php  } ?>
    <div id="twitter-feed"></div>
</div>

<script src="<?php  echo $localPath; ?>/files/twitterFetcher_min.js"></script>
<script>
    var config1 = {
        "id":'<?php  if ($widgetID) { echo $widgetID; } ?>',
        "domId":'twitter-feed',
        "maxTweets":<?php  if ($maxTweets) { echo $maxTweets; } ?>,
        "enableLinks":<?php  if ($enableLinks) { echo $enableLinks; } ?>,
        "showUser":<?php  if ($showUser) { echo $showUser; } ?>,
        "showTime":<?php  if ($showTime) { echo $showTime; } ?>,
        "showRetweet":<?php  if ($showRetweet) { echo $showRetweet; } ?>,
        "showInteraction":<?php  if ($showInteraction) { echo $showInteraction; } ?>,
        "showImages":<?php  if ($showImages) { echo $showImages; } ?>,
        "linksInNewWindow":<?php  if ($linksInNewWindow) { echo $linksInNewWindow; } ?>,
    };
    twitterFetcher.fetch(config1);
</script>