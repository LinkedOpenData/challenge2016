<?php
function get_footer($pageName) {
	if($pageName) {
		$pageName = "<li>$pageName</li>";
	} else {
		$pageName = "";
	}
	return <<<EOT
			</div><!--// #mainBK //-->
		</div><!--// #wrapperAll //-->

		<div id="footerPankuzu">
			<ul>
				<li><a href="index.html" title="ホーム">HOME</a></li>
				$pageName
			</ul>
		</div>
		<div id="footer">
			<a id="sponsor" name="sponsor"></a>
			<div id="footerBody">
			<div id="btmSponsorBK">
					<h3><img src="common/img/headplatinum_wb.jpg" alt="platinum sponsors" /></h3>
					<ul class="platinum">
						<li><a href="http://www.goo.ne.jp/" target="_blank"><img src="common/img/sponsores/goo_p.png" alt="goo" width="180" height="180"></a></li>
						<li><a href="http://www.microsoft.com/japan" target="_blank"><img src="common/img/sponsores2012/microsoft180.png" alt="日本マイクロソフト株式会社" width="180" height="180"></a></li>
						<li><a href="http://jp.fujitsu.com/" target="_blank"><img src="common/img/sponsores/fujitsu_p.png" alt="fujitsu" width="180" height="180"></a></li>
						<li><a href="http://linkdata.org/" target="_blank"><img src="common/img/sponsores2012/linkdata180.png" alt="LinkData
独立行政法人　理化学研究所" width="180" height="180"></a></li>
					</ul>
					
					<h3><img src="common/img/headgold_wb.jpg" alt="gold sponsors"></h3>
					<ul class="gold">
						<li><a href="http://www.indigo.co.jp/" target="_blank"><img src="common/img/sponsores2012/indigo.png" alt="インディゴ株式会社"></a></li>
						<li><a href="http://www.jst.go.jp/" target="_blank"><img src="common/img/sponsores2012/jst.png" alt="独立行政法人　科学技術振興機構"></a></li>
						<li><a href="http://live.cybozu.co.jp/" target="_blank"><img src="common/img/sponsores2012/cybozulive280140.png" alt="サイボウズ株式会社"></a></li>
						<li><a href="http://www.saltlux.com/jp/" target="_blank"><img src="common/img/sponsores2012/saltlux.png" alt="株式会社ソルトルックス"></a></li>
						<li><a href="http://virtualtech.jp/" target="_blank"><img src="common/img/sponsores2012/virtualteck280140.png" alt="日本仮想化技術株式会社"></a></li>
						<li><a href="http://biosciencedbc.jp/" target="_blank"><img src="common/img/sponsores2012/nbdc.png" alt="バイオサイエンスデータベースセンター"></a></li>
						<li><a href="http://www.machi-j.net/" target="_blank"><img src="common/img/sponsores2012/rits.png" alt="ＮＰＯまちづくりジャパン事務局 リッツ総合研究所"></a></li>
					</ul>
					
					<h3 class="footerDataPartner">データ提供パートナー</h3>
					<ul class="gold">
						<li><a href="http://lod.ac/" target="_blank"><img src="common/img/sponsores2012/lodac.png" alt="LODAC: Linked Open Data for Academia" /></a></li>
						<li><a href="http://www.osmf.jp/" target="_blank"><img src="common/img/sponsores2012/osmf.png" alt="オープンストリートマップ・ファウンデーション・ジャパン" /></a></li>
						<li><a href="http://ci.nii.ac.jp/" target="_blank"><img src="common/img/sponsores2012/Cinii.png" alt="国立情報学研究所 CiNii（NII論文情報ナビゲータ[サイニィ]）" /></a></li>
						<li><a href="http://kaken.nii.ac.jp/" target="_blank"><img src="common/img/sponsores2012/kaken.png" alt="国立情報学研究所 KAKEN: 科学研究費助成事業データベース" /></a></li>
						<li><a href="http://www.city.sabae.fukui.jp/" target="_blank"><img src="common/img/sponsores2012/sabae.png" alt="鯖江市役所" /></a></li>
						<li><a href="http://aigid.jp" target="_blank"><img src="common/img/sponsores2012/agid.png" alt="社会基盤情報流通推進協議会" /></a></li>
						<li><a href="http://www.editoria.u-tokyo.ac.jp/dias/" target="_blank"><img src="common/img/sponsores2012/dias.png" alt="東京大学　地球観測データ統融合連携研究機構" /></a></li>
						<li><a href="http://www.csis.u-tokyo.ac.jp" target="_blank"><img src="common/img/sponsores2012/Csis.png" alt="東京大学 空間情報科学研究センター" /></a></li>
						<li><a href="http://www.yaf.or.jp/" target="_blank"><img src="common/img/sponsores2012/yaf.png" alt="公益財団法人　横浜市芸術文化振興財団" /></a></li>
					</ul>
					
					<h3 class="footerDataPartner">基盤提供パートナー</h3>
					<ul class="gold">
						<li><a href="http://www.microsoft.com/japan" target="_blank"><img src="common/img/sponsores2012/microsoft140.png" alt="日本マイクロソフト株式会社"></a></li>
						<li><a href="http://linkdata.org/" target="_blank"><img src="common/img/sponsores2012/linkdata140.png" alt="LinkData
独立行政法人　理化学研究所"></a></li>
					</ul>			
					
					<h3 class="footerDataPartner">メディアパートナー</h3>
					<ul class="gold">
						<li><a href="http://itpro.nikkeibp.co.jp/" target="_blank"><img src="common/img/sponsores2012/ITpro.png" alt="ITPro" width="140" height="140"></a></li>
						<li><a href="http://www.atmarkit.co.jp/" target="_blank"><img src="common/img/sponsores2012/atIT.png" alt="at mark IT" width="140" height="140"></a></li>
					</ul>	
					
					<h3 class="footerDataPartner">サポーター（後援団体）</h3>
					<ul class="supporter">
						<li><a href="http://okfn.jp/" target="_blank">Open Knowledge Foundation 日本グループ</a></li>
						<li><a href="http://creative-city.jp/" target="_blank">クリエイティブ・シティ・コンソーシアム</a></li>
						<li><a href="http://www.meti.go.jp/" target="_blank">経済産業省（予定）</a></li>
						<li><a href="http://www.g-contents.jp/" target="_blank">gコンテンツ流通推進協議会</a></li>
						<li><a href="http://www.ipa.go.jp/" target="_blank">独立行政法人　情報処理推進機構</a></li>
						<li><a href="http://s-web.sfc.keio.ac.jp/" target="_blank">セマンティックWeb委員会</a></li>
						<li><a href="http://www.soumu.go.jp/" target="_blank">総務省（予定）</a></li>
						<li><a href="http://sigdd.sakura.ne.jp/" target="_blank">一般社団法人　情報処理学会　デジタルドキュメント研究会</a></li>
						<li><a href="http://www.jeita.or.jp/" target="_blank">一般社団法人　電子情報技術産業協会</a></li>
						<li><a href="http://linkedopendata.jp/" target="_blank">特定非営利活動法人　リンクト・オープン・データ・イニシアティブ</a></li>
						<li><a href="http://linkeddata.jp/" target="_blank">LinkedData勉強会</a></li>
					</ul>
				</div>
				<div id="footerMenu">
					<ul>
						<li><a href="contact.html" title="お問い合わせ">お問い合わせ</a></li>
						<!-- <li><a href="committee.html" title="実行委員会">実行委員会</a></li> -->
						<li><a href="http://www.facebook.com/LOD.challenge.Japan" title="facebookページ" target="_blank">facebookページ</a></li>
					</ul>
					<p id="facebook"><a href="http://www.facebook.com/LOD.challenge.Japan#" title="LOD Challenge 2012 facebookページ"><img src="common/img/facebook.png" alt="Facebook" width="32" height="32" /></a></p>
				</div>
				<div id="credit">
					<p>Copyright&copy;2012 Linked Open Data Challenge Japan 2012.</p>
				</div><!--// credit //-->
			</div>
		</div><!--// footer //-->
	</body>
</html>
EOT;
}
?>