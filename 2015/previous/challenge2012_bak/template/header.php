<?php
function get_header($pageName) {
	if($pageName) {
		$pageName .= " |";
	}
	return <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Content-Style-Type" content="text/css" />
		<meta name="description" content="Linked Open Data (LOD) の仕組み作りやデータづくりにチャレンジされている方々による活動の発表の場を提供します。" />
		<meta name="keywords" content="lod,linked data,linked open data,lod challenge,linked open data challenge japan,LODチャレンジ" />
		<link rel="shortcut icon" href="favicon.ico" />
		<meta property="og:image" content="http://lod.sfc.keio.ac.jp/challenge2012/common/img/mainvisual2.png"/>
		<meta property="og:url" content="http://lod.sfc.keio.ac.jp/challenge2012/"/>
		<meta property="og:title" content="LOD Challenge Japan 2012"/>
		<meta property="og:site_name" content="LOD Challenge Japan 2012"/>
		<meta property="og:type" content="website"/>
		
		<link rel="stylesheet" type="text/css" media="all" href="common/css/import.css" />
		<title>$pageName Linked Open Data Challenge Japan 2012</title>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
		<script type="text/javascript" src="common/js/droppy.js"></script>
		<script type="text/javascript" src="common/js/jShowOff/jquery.jshowoff.min.js"></script>
		<!--[if IE 6]>
		<script src="common/js/DD_belatedPNG.js"></script>
		<script>
		DD_belatedPNG.fix('img, .png');
		</script>
		<![endif]-->
		<script type="text/javascript">
			$(function() {
				$("#nav").droppy({speed:50});
			});
		</script>
	<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-26316207-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
	<body>
		<div id="pageTop"><a id="pageTop" name="pageTop"></a></div>
		<div id="wrapperAll">
			<div id="header">
				<h1><a href="index.html" title="Linked Open Data Challenge Japan 2012"><img src="common/img/logo2012.png" alt="LODチャレンジ Japan / Linked Open Data Challenge Japan 2012" width="335" height="26" /></a></h1>
			</div><!--// #header //-->
			<div id="mainBK">
				<div id="mainMenu">
					<ul id="nav">
						<li id="hm001"><a href="index.html" title="トップ">トップ</a></li>
						<li id="hm003"><a href="javascript:void(0);" title="スポンサー">スポンサー</a>
						<ul>
							<li><a href="#sponsor">スポンサー一覧</a></li>
							<li><a href="sponsorrecruit.html">スポンサー募集</a></li>
							<li><a href="partner_platform_data.html">データ提供／基盤提供パートナー募集</a></li>
							<li><a href="partner_media.html">メディアパートナー募集</a></li>
							<li><a href="supporter.html">サポーター募集</a></li>
						</ul></li>
						<li id="hm005"><a href="javascript:void(0);" title="LODとは">LODとは</a>
							<ul>
								<li><a href="aboutlod.html">lodとは？</a></li>
								<li><a href="slideresources2.html">技術解説</a></li>
								<li><a href="slideresources.html">分野別事例紹介</a></li>
								<li><a href="link.html">リンク集</a></li>
							</ul>
						</li>
						<li id="hm006"><a href="../blog/" title="公式ブログ">公式ブログ</a></li>
					</ul>
				</div><!--// mainMenu //-->
EOT;
	
}
?>