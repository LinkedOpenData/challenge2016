<?php
	define('BASE_URL', "http://lod.sfc.keio.ac.jp/challenge2014/"); // '/'で終わる
	//define('BASE_URL', "http://localhost/lod/"); // @localhost
	function get_base_url_by_year($year) {
		return "http://lod.sfc.keio.ac.jp/challenge{$year}/";
	}
?>
