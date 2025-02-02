<?php
	require_once( dirname(__FILE__) . '/template/header.php');
	require_once( dirname(__FILE__) . '/template/footer.php');
	
	require_once dirname(__FILE__) . '/util/copyright.php';
	require_once dirname(__FILE__) . '/util/star_badge.php';
	require_once dirname(__FILE__) . '/util/lod_db.php';
	require_once dirname(__FILE__) . '/util/base.php';
	$db = LodDb::getInstance();
	$cr = Copyright::getInstance();
	$sb = StarBadge::getInstance();
	
	$id = intval(substr($_GET['id'],1));
	
	if($id > 0){
		$item = $db->executeQuery("select * from application_2013 where id = ".$id);

/* 
		$_POST["id"] = $item[0]["id"];
		$_POST["name"] = $item[0]["name"];
		$_POST["affiliation"] = $item[0]["affiliation"];
		$_POST["affiliation_anonymous"] = $item[0]["affiliation_anonymous"];
		$_POST["is_student"] = $item[0]["is_student"];
		$_POST["email"] = $item[0]["email"]; 
		$_POST["email_anonymous"] = $item[0]["email_anonymous"];
		$_POST["set_mailinglist"] = $item[0]["set_mailinglist"];
		$_POST["application-name"] = $item[0]["application_name"];

		$_POST["application-url"] = $item[0]["url"];
		$_POST["application-abstract"] = $item[0]["abstract"];
		$_POST["application-description"] = $item[0]["description"];
		$_POST["application-used-dataset"] = $item[0]["used_dataset_ids"];

		$_POST["related-dataset"] = $item[0]["related_dataset_ids"];
		$_POST["related-idea"] = $item[0]["related_idea_ids"];
		$_POST["related-application"] = $item[0]["related_application_ids"];
		$_POST["related-visualization"] = $item[0]["related_visualization_ids"];
		$_POST["related-basetechnology"] = $item[0]["related_basetechnology_ids"];
		$_POST["right"] = $item[0]["copyright"];
		$_POST["license"] = $item[0]["license"];

		$_POST["password"] = $item[0]["hashed_password"];
*/
	} else {
		require("show_status.php");
		return;
	}
	
	$pankuzuList = array(
		array("name" => "HOME", "url" => "index.html"),
		array("name" => "エントリー一覧", "url" => "show_list.php"),
		array("name" => "エントリーシート(アプリケーション)")
	);
?>
	<?php 
		if(empty($item)){
			echo get_header($pageTitle);
	?>
			指定されたID <?php echo $_GET['id']; ?> は存在しません。
	<?php 
		} else {
			$pageTitle = $item[0]["application_name"]." - アプリケーションのエントリーシート";
	?>
<?php echo get_header($pageTitle); ?>
<div id="contents-form">
			
	<h2><?php echo $item[0]["application_name"]; ?></h2>
	
	<?php 
		echo (isset($_GET['modified']) ? '<div class="modified-message">修正されました</div>' : "");
	?>
	<table id="entrysheet" class="application-form">
		<tr class="info-row">
			<th colspan="2">応募者の情報</th>
		</tr>
		<tr>
			<th>ご氏名</th>
			<td><?php echo $item[0]["name"]; echo ($item[0]["is_student"] ? "<i>[学生]</i>" : ""); ?></td>
		</tr>
		<tr>
			<th>ご所属</th>
			<td> <?php echo ($item[0]["affiliation_anonymous"] ? "<i>[非公開]</i>" : $item[0]["affiliation"]); ?></td>
		</tr>
		<tr>
			<th>e-mailアドレス</th>
			<td><?php echo ($item[0]["email_anonymous"] ? "<i>[非公開]</i>" : str_replace("@", ' <i>[at]</i> ',  $item[0]["email"])); ?></td>
		</tr>
		<tr class="info-row">
			<th colspan="2">応募するアプリケーションの情報</th>
		</tr>
		<tr>
			<th>アプリケーションの名称</th>
			<td><?php echo $item[0]["application_name"]; ?></td>
		</tr>
		<tr>
			<th>アプリケーションのURL</th>
			<td><a href="<?php echo $item[0]["url"]; ?>" target="_blank"><?php echo $item[0]["url"]; ?></a></td>
		</tr>
		<tr>
			<th>アプリケーションの概略説明</th>
			<td>
				<?php echo str_replace("\n", "<br>", $item[0]["abstract"]); ?>
			</td>
		</tr>
		<tr>
			<th>アプリケーションの詳細説明</th>
			<td>
				<?php echo str_replace("\n", "<br>", $item[0]["description"]); ?>
			</td>
		</tr>
		<tr>
			<th>利用したデータセット</th>
			<td>
				<?php echo $item[0]["used_dataset_ids"]; ?>
			</td>
		</tr>
				<?php if($item[0]["copyright"]){ ?>
		<tr>
			<th>アプリケーションの権利指定</th>
			<td>
				<div class="designate-right">
					<img src="<?php echo $cr->image($item[0]["copyright"]) ?>" />
					<div class="title"><?php echo $cr->title($item[0]["copyright"]) ?></div>
					<div class="description"><?php echo $cr->description($item[0]["copyright"]) ?></div>
				</div>
			</td>
		</tr>
				<?php } ?>
				<?php if($item[0]["license"]){ ?>
		<tr>
			<th>ライセンス</th>
			<td>
				<?php echo $item[0]["license"]; ?>
			</td>
		</tr>
				<?php } ?>
		<tr class="info-row">
			<th colspan="2">関連する作品の情報</th>
		</tr>
		<tr>
			<th>関連するアイデア</th>
			<td>
				<?php 
					foreach (explode(" ", $item[0]["related_idea_ids"]) as $did) {
						if(preg_match("/[0-9]{4}-[adiv][0-9]{3}/", $did)) {
							$year_id = explode("-", $did);
							echo '<a href="'.get_base_url_by_year($year_id[0]).'show_status.php?id='.$year_id[1].'" target="_blank">'.$did.'</a> ';
						} else {
							echo '<a href="'.BASE_URL.'show_status.php?id='.$did.'" target="_blank">'.$did.'</a> ';
						}
					}
				?>
			</td>
		</tr>
		<tr>
			<th>関連するデータセット</th>
			<td>
				<?php 
					foreach (explode(" ", $item[0]["related_dataset_ids"]) as $did) {
						if(preg_match("/[0-9]{4}-[adiv][0-9]{3}/", $did)) {
							$year_id = explode("-", $did);
							echo '<a href="'.get_base_url_by_year($year_id[0]).'show_status.php?id='.$year_id[1].'" target="_blank">'.$did.'</a> ';
						} else {
							echo '<a href="'.BASE_URL.'show_status.php?id='.$did.'" target="_blank">'.$did.'</a> ';
						}
					}
				?>
			</td>
		</tr>
		<tr>
			<th>関連するアプリケーション</th>
			<td>
				<?php 
					foreach (explode(" ", $item[0]["related_application_ids"]) as $did) {
						if(preg_match("/[0-9]{4}-[adiv][0-9]{3}/", $did)) {
							$year_id = explode("-", $did);
							echo '<a href="'.get_base_url_by_year($year_id[0]).'show_status.php?id='.$year_id[1].'" target="_blank">'.$did.'</a> ';
						} else {
							echo '<a href="'.BASE_URL.'show_status.php?id='.$did.'" target="_blank">'.$did.'</a> ';
						}
					}
				?>
			</td>
		</tr>
		<tr>
			<th>関連するビジュアライゼーション作品</th>
			<td>
				<?php 
					foreach (explode(" ", $item[0]["related_visualization_ids"]) as $did) {
						if(preg_match("/[0-9]{4}-[adiv][0-9]{3}/", $did)) {
							$year_id = explode("-", $did);
							echo '<a href="'.get_base_url_by_year($year_id[0]).'show_status.php?id='.$year_id[1].'" target="_blank">'.$did.'</a> ';
						} else {
							echo '<a href="'.BASE_URL.'show_status.php?id='.$did.'" target="_blank">'.$did.'</a> ';
						}
					}
				?>
			</td>
		</tr>
		<tr>
			<th>関連する基盤技術作品</th>
			<td>
				<?php 
					foreach (explode(" ", $item[0]["related_basetechnology_ids"]) as $did) {
						if(preg_match("/[0-9]{4}-[adiv][0-9]{3}/", $did)) {
							$year_id = explode("-", $did);
							echo '<a href="'.get_base_url_by_year($year_id[0]).'show_status.php?id='.$year_id[1].'" target="_blank">'.$did.'</a> ';
						} else {
							echo '<a href="'.BASE_URL.'show_status.php?id='.$did.'" target="_blank">'.$did.'</a> ';
						}
					}
				?>
			</td>
		</tr>
	</table>
<form action="modify_application_status2.php" method="post">
	<h3>登録情報を修正する</h3>
	<input type="hidden" name="id" value="<?php echo $id ?>" />
	<input type="password" name="password" />
	<input type="submit" value="修正" />
	<br> 修正用のパスワードを入力してください。
</form>
	<?php 
		}
	?>
</div>
<?php echo get_footer($pageTitle); ?>