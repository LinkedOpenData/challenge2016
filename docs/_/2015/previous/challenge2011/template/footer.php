
			</div><!--// #contents-form //-->
			</div><!--// #mainBK //-->
		</div><!--// #wrapperAll //-->

		<div id="footerPankuzu">
			<ul>
				<?php
					if(isset($pankuzuList)){
						foreach($pankuzuList as $item){
							echo '<li>'.(isset($item['url']) ? '<a href="'.$item['url'].'">' : '').$item['name'].(isset($item['url']) ? '</a>' : "").'</li>';
						}
					} else {
						echo '<li><a href="index.html" title="ホーム">HOME</a></li>';
					}
				?>
			</ul>
		</div>
		<div id="footer">
			<div id="footerBody">
				<div id="btmSponsorBK">
					<h3><img src="common/img/p_sponsors.png" alt="platinum sponsors" width="311" height="34" /></h3>
					<ul class="platinum">
						<li><a href="http://www.goo.ne.jp/" target="_blank"><img src="common/img/sponsores/goo_p.png" alt="goo" width="180" height="180" /></a></li>
						<li><a href="http://ja.biolod.org/" target="_blank"><img src="common/img/sponsores/bio_p.png" alt="bio lod" width="180" height="180" /></a></li>
						<li><a href="http://jp.fujitsu.com/" target="_blank"><img src="common/img/sponsores/fujitsu_p.png" alt="fujitsu" width="180" height="180" /></a></li>
					</ul>
					<h3><img src="common/img/sponsors.png" alt="gold sponsors" width="252" height="34" /></h3>
					<ul class="gold">
						<li><a href="http://www.saltlux.com/jp/" target="_blank"><img src="common/img/sponsores/saltlux_s2.png" alt="saltlus" width="140" height="140" /></a></li>	
						<li><a href="http://www.5tec.co.jp/" target="_blank"><img src="common/img/sponsores/five_technology_inc_s.png" alt="five technology.inc" width="140" height="140" /></a></li>
						<li><a href="http://www.indigo.co.jp/" target="_blank"><img src="common/img/sponsores/indigo_g.jpg" alt="インディゴ株式会社" width="140" height="140" /></a></li>
						<li><a href="http://www.rits-ri.net/" target="_blank"><img src="common/img/sponsores/rits_g.png" alt="RITS総合研究所" width="140" height="140" /></a></li>
						<li><a href="http://www.zenrin.co.jp/" target="_blank"><img src="common/img/sponsores/zenrin_g.png" alt="株式会社ゼンリン" width="140" height="140" /></a></li>
					</ul>
					
					<h3 class="footerDataPartner">データ提供パートナー</h3>
					<ul class="gold">
						<li><a href="http://ci.nii.ac.jp/" target="_blank"><img src="common/img/sponsores/cinii_g.png" alt="cinii" width="140" height="140" /></a></li>
						<li><a href="http://kaken.nii.ac.jp/" target="_blank"><img src="common/img/sponsores/kaken_g.png" alt="kaken" width="140" height="140" /></a></li>
						<li><a href="http://ja.biolod.org/" target="_blank"><img src="common/img/sponsores/riken_g.png" alt="理化学研究所（理研）" width="140" height="140" /></a></li>
					</ul>
					
					<h3 class="footerDataPartner">メディアパートナー</h3>
					<ul class="gold">
						<li><a href="http://www.atmarkit.co.jp/" target="_blank"><img src="common/img/sponsores/at_mark_it_g.png" alt="at mark IT" width="140" height="140" /></a></li>
					</ul>
				</div><!--// btmSponsorBK //-->
				<div id="footerMenu">
					<ul>
						<li><a href="contact.html" title="お問い合わせ">お問い合わせ</a></li>
						<li><a href="committee.html" title="実行委員会">実行委員会</a></li>
						<li><a href="http://www.facebook.com/LOD.challenge.Japan" title="facebookページ" target="_blank">facebookページ</a></li>
					</ul>
					<p id="facebook"><a href="http://www.facebook.com/LOD.challenge.Japan#" title="LOD Challenge 2011 facebookページ"><img src="common/img/facebook.png" alt="Facebook" width="32" height="32" /></a></p>
				</div>
				<div id="credit">
					<p>Copyright&copy;2011 Linked Open Data Challenge Japan 2011.</p>
				</div><!--// credit //-->
			</div>
		</div><!--// footer //-->
	</body>
</html>
