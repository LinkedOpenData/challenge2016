<?php
	require_once dirname(__FILE__) . '/util/copyright.php';
	require_once dirname(__FILE__) . '/util/star_badge.php';
	require_once dirname(__FILE__) . '/util/lod_db.php';
	$db = LodDb::getInstance();
	$cr = Copyright::getInstance();
	$sb = StarBadge::getInstance();
	$pageTitle = "エントリー一覧";
	
	$pankuzuList = array(
		array("name" => "HOME", "url" => "index.html"),
		array("name" => "エントリー一覧")
	);
?>
<?php require("template/header.php"); ?>
	<h2>エントリー一覧</h2>
	<table id="entry-list" class="application-form">
		<thead>
			<tr class="column-definition">
				<th style="width:110px;">エントリー番号</th>
				<th style="width:120px;">作品の名称</th>
				<th style="width:100px;">応募者</th>
				<th>応募概要</th>
				<th style="width:185px;">エントリー情報</th>
			</tr>
		</thead>
		<tbody>
			<tr class="category-head">
				<th colspan="5">データセット部門</th>
			</tr>
			<?php
				$datasets = $db->executeQuery("select id, name, dataset_name, abstract, star, copyright from dataset");
				$even = false;
				if($datasets){
					foreach($datasets as $ds){
						echo '<tr'.($even ? ' class="even-row"' : '').'>';
						$even = !$even;
						echo '<td><a href="show_status.php?id=d'.sprintf('%03d',$ds['id']).'">d'.sprintf('%03d',$ds['id']).'</a></td>';
						echo '<td>'.$ds['dataset_name'].'</td>';
						echo '<td>'.$ds['name'].'</td>';
						echo '<td>'.str_replace("\n", "<br>", $ds["abstract"]).'</td>';
						echo '<td><img src="'.$cr->image($ds["copyright"]).'" /> '.(is_null($ds["star"]) ? "" : '<img src="'.$sb->image($ds["star"]).'" />').'</td>';
						echo '</tr>';
					}
				} else {
					echo '<tr><td colspan="5">まだ登録はありません</td></tr>';
				}
			?>
			<tr class="category-head">
				<th colspan="5">アイデア部門</th>
			</tr>
			<?php
				$ideas = $db->executeQuery("select id, name, idea_name,abstract from idea");
				$even = false;
				if($ideas){
					foreach($ideas as $is){
						echo '<tr'.($even ? ' class="even-row"' : '').'>';
						$even = !$even;
						echo '<td><a href="show_status.php?id=i'.sprintf('%03d',$is['id']).'">i'.sprintf('%03d',$is['id']).'</a></td>';
						echo '<td>'.$is['idea_name'].'</td>';
						echo '<td>'.$is['name'].'</td>';
						echo '<td>'.str_replace("\n", "<br>", $is["abstract"]).'</td>';
						echo '<td></td>';
						echo '</tr>';
					}
				} else {
					echo '<tr><td colspan="5">まだ登録はありません</td></tr>';
				}
			?>
			<tr class="category-head">
				<th colspan="5">アプリケーション部門</th>
			</tr>
			<?php
				$applications = $db->executeQuery("select id, name, abstract, application_name, copyright from application");
				$even = false;
				if($applications){
					foreach($applications as $ap){
						echo '<tr'.($even ? ' class="even-row"' : '').'>';
						$even = !$even;
						echo '<td><a href="show_status.php?id=a'.sprintf('%03d',$ap['id']).'">a'.sprintf('%03d',$ap['id']).'</a></td>';
						echo '<td>'.$ap['application_name'].'</td>';
						echo '<td>'.$ap['name'].'</td>';
						echo '<td>'.str_replace("\n", "<br>", $ap["abstract"]).'</td>';
						echo '<td><img src="'.$cr->image($ap["copyright"]).'" /> '.'</td>';
						echo '</tr>';
					}
				} else {
					echo '<tr><td colspan="5">まだ登録はありません</td></tr>';
				}
			?>
		</tbody>
	</table>
	
<?php require("template/footer.php"); ?>