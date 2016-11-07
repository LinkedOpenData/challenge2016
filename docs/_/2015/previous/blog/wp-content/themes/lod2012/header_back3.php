<!DOCTYPE html>
<html <?php language_attributes(); ?> xmlns:og="http://ogp.me/ns#">
<head profile="http://gmpg.org/xfn/11">
<title><?php wp_title(' '); ?><?php if(wp_title(' ', false)) { ?> at <?php } ?><?php bloginfo('name'); ?></title>
<meta property="og:image" content="http://lod.sfc.keio.ac.jp/common/img/mainvisual2.png" />
<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
<meta name="description" content="<?php bloginfo('description'); ?>" />
<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats please -->
<!--link rel="stylesheet" type="text/css" media="all" href="../common/css/import.css" />-->
<link rel="stylesheet" type="text/css" media="all" href="/challenge2014/common/css/import.css" />
<link href="<?php bloginfo('stylesheet_url'); ?>" rel="stylesheet" type="text/css" media="screen" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="shortcut icon" type="image/x-png" href="<?php bloginfo('template_url'); ?>/favicon.ico" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script type="text/javascript" src="../common/js/droppy.js"></script>
<?php wp_head(); ?>
		<script type="text/javascript">
			$(function() {
				$("#nav").droppy({speed:50});
			});
		</script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-26316207-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>

<body <?php body_class(); ?>>
		<div id="pageTop"><a id="pageTop" name="pageTop"></a></div>
		<div id="wrapperAll">
		<div id="wrapperAll">
			<div id="mainBK">
				<div id='header'>
				<h1><a href="/challenge2014" title="Linked Open Data Challenge Japan 2014"><img src="/challenge2014/common/img/logo2014top.png" alt="LODチャレンジ Japan / Linked Open Data Challenge Japan 2013" /></a></h1>
				</div>
				<div id="mainMenu">
					<ul id="nav">
						<li id="hm001"><a href="/challenge2013/objective.html" title="開催情報">開催情報</a>
						<ul>
							<li><a href="/challenge2013/objective.html">開催趣旨</a></li>
							<!-- <li><a href="outline.html">応募について</a></li>-->
							<li><a href="/challenge2013/category.html">エントリー部門</a></li>
							<li><a href="/challenge2013/evaluate.html">審査について</a></li>
							<!-- <li><a href="entry_terms.html">応募規定</a></li>-->
							<li><a href="/challenge2013/faq.html">FAQ</a></li>
							<li><a href="http://lod.sfc.keio.ac.jp/challenge2012/index.html" target="_blank">LODチャレンジJapan2012アーカイブ</a></li>
							<li><a href="http://lod.sfc.keio.ac.jp/challenge2011/index.html" target="_blank">LODチャレンジJapan2011アーカイブ</a></li>
						</ul></li>
						<li id="hm002"><a href="javascript:void(0);" title="応募情報">応募情報</a>
						<!-- <li id="hm002"><a href="outline.html" title="応募について">応募について</a>-->
						<ul>
							<li><a href="/challenge2013/outline.html">応募について</a></li>
							<li><a href="/challenge2013/entry_terms.html">応募規定</a></li>
							<!-- <li><a href="idea.html">アイデア部門</a></li>-->
						</ul></li>
						<!-- <li id="hm002"><a href="javascript:void(0);" title="エントリー">エントリー</a>
						<ul>
							<li><a href="dataset.html">データセット部門</a></li>
							<li><a href="idea.html">アイデア部門</a></li>
							<li><a href="application.html">アプリケーション部門</a></li>
							<li><a href="visualization.html">ビジュアライゼーション部門</a></li>
						</ul></li> -->
						<li id="hm003"><a href="javascript:void(0);" title="スポンサー">スポンサー</a>
						<ul>
							<!-- <li><a href="resource_usage.html">データ／基盤パートナーのリソース利用方法</a></li> -->
							<!-- <li><a href="#sponsor">スポンサー一覧</a></li>-->
							<li><a href="/challenge2013/sponsorrecruit.html">スポンサー募集</a></li>
							<li><a href="/challenge2013/partner_platform_data.html">データ提供／基盤提供パートナー募集</a></li>
							<li><a href="/challenge2013/partner_media.html">メディアパートナー募集</a></li>
							<li><a href="/challenge2013/supporter.html">サポーター募集</a></li>
						</ul></li>
						<li id="hm004"><a href="/challenge2013/event.html" title="イベント">イベント</a>
						<li id="hm005"><a href="javascript:void(0);" title="LODとは">LODとは</a>
							<ul>
								<li><a href="/challenge2013/aboutlod.html">LODとは？</a></li>
								<li><a href="/challenge2013/slideresources2.html">技術解説</a></li>
								<li><a href="/challenge2013/slideresources.html">分野別事例紹介</a></li>
								<li><a href="/challenge2013/link.html">リンク集</a></li>
							</ul>
						</li>
						<li id="hm006"><a href="/blog/" title="公式ブログ">公式ブログ</a></li>
					</ul>
				</div><!--// mainMenu //-->
				<!-- 
<div id="container" class="group">

<h1><a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a></h1>
<div id="bubble"><p><?php bloginfo('description'); ?></p></div> <!-- erase this line if you want to turn the bubble off -->
