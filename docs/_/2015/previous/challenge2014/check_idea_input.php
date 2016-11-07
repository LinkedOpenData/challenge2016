<?php
	require_once( dirname(__FILE__) . '/template/header.php');
	require_once( dirname(__FILE__) . '/template/footer.php');
	
	require_once dirname(__FILE__) . '/util/copyright.php';
	require_once dirname(__FILE__) . '/util/base.php';
	date_default_timezone_set('Asia/Tokyo'); /*  set TimeZone */
	$cr = Copyright::getInstance();
	$pageTitle = "登録情報の確認";
	if($_POST){
		if(isset($_POST['id'])){
			$item = $db->executeQuery("select * from idea_2014 where id = ".$_POST['id']);
			if(empty($item) || !$pm->verify($_POST['password'], $item[0]['hashed_password'])){
				// 認証失敗
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: ".BASE_URL."show_status.php?id=i".sprintf("%03d", $_POST['id']));
				exit();
			}
		}
		
		if($_POST["idea-select"] === 'file'){
			if ( ! empty($_FILES["idea-file"]["name"] ) ) {
				$dateStr = date("YmdHis");
				$tmpFileName = $dateStr."_".$_FILES["idea-file"]["name"];
				copy($_FILES["idea-file"]["tmp_name"], dirname(__FILE__) . '/dat/tmp/'.$tmpFileName);
			}
		}
		// アイコンファイルの処理
		$dateStr = date("YmdHis");
		$changed_icon= 'false';
// echo "アイコンファイルの指定： ".$_FILES['idea-icon']['name'] ." Temp: ". $_FILES['idea-icon']['tmp_name'] ."<br />";
// echo "配列の存在：". is_array($_FILES['idea-icon']) ."要素の存在：".  array_key_exists('name', $_FILES['idea-icon']) ."<br />";
		if ( is_array($_FILES['idea-icon']) && array_key_exists('name', $_FILES['idea-icon']) ){
			if ( ! empty($_FILES['idea-icon']['name']) ) {
// echo "ファイル指定あり：<br />";
			// ファイルが指定された場合
				$tmpIconName = $dateStr."_icon.".get_file_extension($_FILES["idea-icon"]["name"]);
				copy($_FILES["idea-icon"]["tmp_name"], dirname(__FILE__) . '/dat/tmp/'.$tmpIconName);
				$changed_icon= 'true';
			} else {
// echo "ファイル指定なし：<br />";
			// ファイルが指定されない場合。デフォルトのファイルを使用
			$tmpIconName = $dateStr."_". get_file_basename(DEFAULT_ICON) ;
			copy(dirname(__FILE__) . DEFAULT_ICON , dirname(__FILE__) . '/dat/tmp/'.$tmpIconName);
		}}
	} else {
		require("apply_idea_category.php");
		return;
	}
?>
<?php echo get_header($pageTitle); ?>
<div id="contents-form">
<form action="registered_idea.php" method="post">
	<table class="application-form" id="input-form">
		<tr class="info-row">
			<th colspan="2">応募者の情報</th>
		</tr>
		<tr>
			<th>ご氏名</th>
			<td>
				<input type="hidden" name="name" value="<?php echo $_POST["name"]; ?>" /><?php echo $_POST["name"]; ?>
			<input type="hidden" name="is_student" value="<?php echo $_POST["is_student"]; ?>" /><i><?php echo ($_POST["is_student"] == 'true' ? "[学生]" : ""); ?></i>
			</td>
		</tr>
		<tr>
			<th>ご所属</th>
			<td>
				<input type="hidden" name="affiliation" value="<?php echo $_POST["affiliation"]; ?>" /><?php echo $_POST["affiliation"]; ?>
				<input type="hidden" name="affiliation_anonymous" value="<?php echo $_POST["affiliation_anonymous"]; ?>" /><i>[<?php echo ($_POST["affiliation_anonymous"] == "true" ? "非公開" : "公開"); ?>]</i>
			</td>
		</tr>
		<tr>
			<th>e-mailアドレス</th>
			<td>
				<input type="hidden" name="email" value="<?php echo $_POST["email"]; ?>" /><?php echo $_POST["email"]; ?>
				<input type="hidden" name="email_anonymous" value="<?php echo $_POST["email_anonymous"]; ?>" /><i>[<?php echo ($_POST["email_anonymous"] == "true" ? "非公開" : "公開"); ?>]</i>
				<input type="hidden" name="set_mailinglist"  value="<?php echo $_POST["set_mailinglist"]; ?>" /><i>[<?php echo ($_POST["set_mailinglist"] == 'true' ? "メールで情報を受け取る" : "メールで情報を受け取らない"); ?>]</i>
			</td>
		</tr>
		<tr class="info-row">
			<th colspan="2">応募するアイデアの情報</th>
		</tr>
		<tr>
			<th>アイデアの名称</th>
			<td><input type="hidden" name="idea-name" value="<?php echo $_POST["idea-name"]; ?>" /><?php echo $_POST["idea-name"]; ?></td>
		</tr>
		<tr>
			<th>アイデアの概略説明(100字以内) [<?php mb_strlen(trim($_POST["idea-abstract"]), "UTF-8"); ?>文字]</th>
			<td>
				<input type="hidden" name="idea-abstract" value="<?php echo $_POST["idea-abstract"]; ?>"/><?php echo $_POST["idea-abstract"]; ?>
			</td>
		</tr>
		<tr>
			<th>アプリケーションの詳細説明</th>
			<td>
				<input type="hidden" name="idea-description" value="<?php echo $_POST["idea-description"]; ?>" /><?php echo $_POST["idea-description"]; ?>
			</td>
		</tr>
		<tr>
			<th>投稿したアイデア</th>
			<td>
				<div class="designate-right">
					<input type="hidden" name="idea-select" value="<?php echo $_POST["idea-select"]; ?>" />
					<?php if($_POST["idea-select"] === 'url'){ ?>
						<a href="<?php echo $_POST["idea-url"]; ?>" target="_blank"><?php echo $_POST["idea-url"]; ?></a>
						<input type="hidden" name="idea-url" value="<?php echo $_POST["idea-url"]; ?>" />
					<?php } else { ?>
						<a href="<?php echo BASE_URL. '/dat/tmp/'.$tmpFileName; ?>" target="_blank"><?php $splitted = explode("_", $tmpFileName, 2); echo $splitted[1]; ?></a>
					<?php } ?>
				</div>
			<?php
				if(isset($_POST['modify'])){
					echo '<div class="limit-description">修正できません．</div>';
				}
			?>
			</td>
		</tr>
		<tr>
			<th>アイデアのアイコン</th>
			<td>
				<img src="<?php echo './dat/tmp/'.$tmpIconName; ?>" width="<?php echo ICON_WIDTH ; ?>" heigth="<?php echo ICON_HEIGHT ; ?>" alt="icon">
				<input type="hidden" name="tmpiconname"   value="<?php echo $tmpIconName; ?>" /> 
				<input type="hidden" name="changed_icon"   value="<?php echo $changed_icon; ?>" /> 
			</td>
		</tr>
		<tr class="info-row">
			<th colspan="2">関連する作品の情報　LODチャレンジJapan2014では作品が「つながる」ことを推奨しています</th>
		</tr>
		<tr>
			<th>関連する既に応募されたデータセット</th>
			<td>
				<input type="hidden" name="related-dataset" value="<?php echo preg_replace("/\s+/", " ", trim($_POST["related-dataset"])); ?>" />
				<?php 
					foreach (preg_split("/\s+/", trim($_POST["related-dataset"])) as $did) {
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
			<th>関連する既に応募されたアイデア</th>
			<td>
				<input type="hidden" name="related-idea" value="<?php echo preg_replace("/\s+/", " ", trim($_POST["related-idea"])); ?>" />
				<?php 
					foreach (preg_split("/\s+/", trim($_POST["related-idea"])) as $did) {
						if(preg_match("/[0-9]{4}-[adivb][0-9]{3}/", $did)) {
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
			<th>関連する既に応募されたアプリケーション</th>
			<td>
				<input type="hidden" name="related-application" value="<?php echo preg_replace("/\s+/", " ", trim($_POST["related-application"])); ?>" />
				<?php 
					foreach (preg_split("/\s+/", trim($_POST["related-application"])) as $did) {
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
			<th>関連する既に応募されたビジュアライゼーション作品</th>
			<td>
				<input type="hidden" name="related-visualization" value="<?php echo preg_replace("/\s+/", " ", trim($_POST["related-visualization"])); ?>" />
				<?php 
					foreach (preg_split("/\s+/", trim($_POST["related-visualization"])) as $did) {
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
			<th>関連する既に応募された基盤技術作品</th>
			<td>
				<input type="hidden" name="related-basetechnology" value="<?php echo preg_replace("/\s+/", " ", trim($_POST["related-basetechnology"])); ?>" />
				<?php 
					foreach (preg_split("/\s+/", trim($_POST["related-basetechnology"])) as $did) {
						if(preg_match("/[0-9]{4}-[adivb][0-9]{3}/", $did)) {
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
	<?php
		if(isset($_POST['modify'])){
			echo '<input type="hidden" name="id" value="'.$_POST['id'].'" />';
		} else {
	?>
	<div style="margin-top: 20px;"><a href="entry_terms.html" target="_blank">応募規定</a>に同意して</div>
	<?php
		}
	?>
	<input type="submit" value="<?php echo (isset($_POST['modify']) ? "修正を確定する" : "作品を応募する") ?>" />
	<input type="hidden" name="tmpfilename" value="<?php echo $tmpFileName; ?>" />
	<input type="button" value="戻る" onclick="window.history.go(-1);" />
	<?php
		if(!isset($_POST['modify'])){
	?>
	<div style="margin-top: 20px;">
		作品の応募後は、「応募者の情報」「応募するアイデアの情報のうちアイデアの名称/アイデアの概略説明/関連する作品」の修正しかできません。
		また応募作品の取り消しはできません。（応募規程7,応募規程9)
	</div>
	<?php
		} 
	?>
</form>
</div>
<?php echo get_footer($pageTitle); ?>