<?php
	require_once( dirname(__FILE__) . '/template/header.php');
	require_once( dirname(__FILE__) . '/template/footer.php');
	
	require_once dirname(__FILE__) . '/util/copyright.php';
	require_once dirname(__FILE__) . '/util/form_checker.php';
	$cr = Copyright::getInstance();
	$fc = FormChecker::getInstance();
	$pageTitle = "アイデア部門に応募する";
	
	$errorMessages = array();
	
	if($_POST){
		// val check
		$ret = $fc->notEmpty($_POST["name"]);
		if($ret !== true) $errorMessages["name"] = $ret;
		
		$ret = $fc->notEmpty($_POST["affiliation"]);
		if($ret !== true) $errorMessages["affiliation"] = $ret;
		
		$ret = $fc->email($_POST["email"]);
		if($ret !== true) $errorMessages["email"] = $ret;
		
		$ret = $fc->confirm($_POST["email"], $_POST["email-confirmation"]);
		if($ret !== true) $errorMessages["email-confirmation"] = $ret;
		
		$ret = $fc->notEmpty($_POST["idea-name"]);
		if($ret !== true) $errorMessages["idea-name"] = $ret;
		
		$ret = $fc->checkLength($_POST["idea-abstract"], 100);
		if($ret !== true) $errorMessages["idea-abstract"] = $ret;
		
		$ret = $fc->regex($_POST["related-dataset"].' ', "^\s*(([0-9]{4}-)?d[0-9]{3}\s+)*\s*$");
		if($ret !== true) $errorMessages["related-dataset"] = $ret;
		
		$ret = $fc->regex($_POST["related-application"].' ', "^\s*(([0-9]{4}-)?a[0-9]{3}\s+)*\s*$");
		if($ret !== true) $errorMessages["related-application"] = $ret;

		$ret = $fc->regex($_POST["related-idea"].' ', "^\s*(([0-9]{4}-)?i[0-9]{3}\s+)*\s*$");
		if($ret !== true) $errorMessages["related-idea"] = $ret;
		
		$ret = $fc->regex($_POST["related-visualization"].' ', "^\s*(([0-9]{4}-)?v[0-9]{3}\s+)*\s*$");
		if($ret !== true) $errorMessages["related-visualization"] = $ret;
		
		$ret = $fc->regex($_POST["related-basetechnology"].' ', "^\s*(([0-9]{4}-)?b[0-9]{3}\s+)*\s*$");
		if($ret !== true) $errorMessages["related-basetechnology"] = $ret;
		// FileかURLか
		if($_POST["idea-select"] == 'url'){ // url
			$ret = $fc->notEmpty($_POST["idea-url"]);
			if($ret !== true) $errorMessages["object"] = $ret;
			
			$ret = $fc->regex($_POST["idea-url"], "^https?:\/\/");
			if($ret !== true) $errorMessages["object"] = $ret;
		} else { // file
			if(empty($_FILES['idea-file']['name'])){
				$errorMessages["object"] = "ファイルを指定してください．";
			} 
		}
/* benbug for file attache
echo "errorMessages:".$errorMessages["object"]."<br />\n" ;
echo "Num of :".count($errorMessages, 1)."<br />\n";
foreach ($errorMessages as $key => $value) {
    echo "$key: $value<br />\n";
}
*/
		if(empty($errorMessages)){
			require("check_idea_input.php");
			return;
		}
	}
	
	function outErrMes($key){
		global $errorMessages;
		return (isset($errorMessages[$key]) ? '<div class="error-message">'.$errorMessages[$key].'</div>' : '');
	}
	
	$pankuzuList = array(
		array("name" => "HOME", "url" => "index.html"),
		array("name" => "応募する"),
		array("name" => "アイデア部門に応募する")
	);
?>
<?php echo get_header($pageTitle); ?>
<div id="contents-form">
<h2 class="iconIdeaS">アイデア部門に応募する</h2>
<form action="apply_idea_category.php" method="post" enctype="multipart/form-data">
	<div>* がついている項目は入力必須です</div>
	<table class="application-form" id="input-form">
		<tr class="info-row">
			<th colspan="2">応募者の情報</th>
		</tr>
		<tr>
			<th>ご氏名 *</th>
			<td>
				<input type="text" name="name" value="<?php echo $_POST["name"]; ?>" />
				<?php echo outErrMes("name");?>
			</td>
		</tr>
		<tr>
			<th>ご所属 *</th>
			<td><input type="text" name="affiliation" value="<?php echo $_POST["affiliation"]; ?>" />
				<select name="affiliation_anonymous">
					<option value="false"<?php echo (isset($_POST["affiliation_anonymous"]) && $_POST["affiliation_anonymous"] == 'false' ? " selected" : "") ?>>ホームページ上に公開する</option>
					<option value="true"<?php echo (isset($_POST["affiliation_anonymous"]) && $_POST["affiliation_anonymous"] == 'true' ? " selected" : "") ?>>ホームページ上に公開しない</option>
				</select>
				<div class="limit-description">
					学生の方は選択してください（任意）。作品が各賞の他、学生奨励賞の候補にもなります。
					<select name="is_student">
						<option value="false" <?php echo (isset($_POST["is_student"]) && !$_POST["is_student"] ? " selected" : "") ?>>一般</option>
						<option value="true "<?php echo (isset($_POST["is_student"]) && $_POST["is_student"] ? " selected" : "") ?>>学生</option>
					</select>
				</div>
				<?php echo outErrMes("affiliation");?>
			</td>
		</tr>
		<tr>
			<th>e-mailアドレス *</th>
			<td><input type="text" name="email" value="<?php echo $_POST["email"]; ?>" />
				<select name="email_anonymous">
					<option value="false"<?php echo (isset($_POST["email_anonymous"]) && !$_POST["email_anonymous"] ? " selected" : "") ?>>ホームページ上に公開する</option>
					<option value="true"<?php echo (isset($_POST["email_anonymous"]) && $_POST["email_anonymous"] ? " selected" : "") ?>>ホームページ上に公開しない</option>
				</select>
				<?php echo outErrMes("email");?>
			</td>
		</tr>
		<tr>
			<th>e-mailアドレス(確認) *</th>
			<td><input type="text" name="email-confirmation" value="<?php echo $_POST["email-confirmation"]; ?>" />
				<?php echo outErrMes("email-confirmation");?>
			</td>
		</tr>
		<tr>
			<th></th>
			<td>
				<div class="limit-description">
					LODチャレンジのイベント開催等のご案内をお送りしても宜しいでしょうか。
				<select name="set_mailinglist">
					<option value="false" <?php echo (isset($_POST["set_mailinglist"]) && !$_POST["set_mailinglist"] ? " selected" : "") ?> >情報配信を希望しない</option>
					<option value="true" <?php echo (isset($_POST["set_mailinglist"]) && $_POST["set_mailinglist"] ? " selected" : "") ?> >情報配信を希望する</option>
				</select>
				</div>
			</td>
		</tr>
		<tr class="info-row">
			<th colspan="2">応募するアイデアの情報</th>
		</tr>
		<tr>
			<th>アイデアの名称 *</th>
			<td><input type="text" name="idea-name" value="<?php echo $_POST["idea-name"]; ?>" />
				<?php echo outErrMes("idea-name");?>
			</td>
		</tr>
		<tr>
			<?php require("print_str_length.php"); ?>
			<th>アイデアの概略(100字以内で記述して下さい) * [<span id="inputlegth"><?php echo mb_strlen(trim($_POST["application-abstract"]), "UTF-8"); ?>文字</span>]</th>
			<td>
				<textarea name="idea-abstract" onkeyup="ShowLength(value, 'inputlegth');"><?php echo $_POST["idea-abstract"]; ?></textarea>
				<?php echo outErrMes("idea-abstract");?>
			</td>
		</tr>
		<tr>
			<th>アイデアの詳細説明(作品詳細について記述して下さい)</th>
			<td>
				<textarea name="idea-description"><?php echo $_POST["idea-description"]; ?></textarea>
				<?php echo outErrMes("idea-description");?>
			</td>
		</tr>
		<tr>
			<th>アイデアの投稿 *</th>
			<td>
				<input type="radio" name="idea-select" value="url" <?php echo (isset($_POST["idea-select"]) && $_POST["idea-select"] == 'file' ? '' : 'checked'); ?> onclick="document.getElementById('idea-file-input').disabled = true;document.getElementById('idea-url-input').disabled = false;"> URL: <input type="text" id="idea-url-input" name="idea-url" value="<?php echo $_POST["idea-url"]; ?>" <?php echo (isset($_POST["idea-select"]) && $_POST["idea-select"] == 'file' ? 'disabled' : ''); ?> /> 
				<div class="limit-description">http, httpsで始まるURLを入力してください．</div>
				<br>
				<input type="radio" name="idea-select" value="file" <?php echo (isset($_POST["idea-select"]) && $_POST["idea-select"] == 'file' ? 'checked' : ''); ?> onclick="document.getElementById('idea-file-input').disabled = false;document.getElementById('idea-url-input').disabled = true;"> ファイルの送信: <input type="file" id="idea-file-input" name="idea-file" <?php echo (isset($_POST["idea-select"]) && $_POST["idea-select"] == 'file' ? '' : 'disabled'); ?> />
				<?php echo outErrMes("object");?>
			</td>
		</tr>
		<tr class="info-row">
			<th colspan="2">関連する作品の情報　LODチャレンジJapan2013では作品が「つながる」ことを推奨しています</th>
		</tr>
		<tr>
			<th>関連する既に応募されたデータセット</th>
			<td>
				<input type="text" name="related-dataset" value="<?php echo $_POST["related-dataset"]; ?>" />
				<?php echo outErrMes("related-dataset");?>
				<div class="limit-description">dから始まるエントリー番号を入力．2011年度の作品の場合は頭に2011-,2012年度の作品の場合は頭に2012-を入れる。複数ある場合は半角スペースで区切って下さい．(例: d003 2011-d015 2012-d015)</div>
			</td>
		</tr>
		<tr>
			<th>関連する既に応募されたアイデア</th>
			<td>
				<input type="text" name="related-idea" value="<?php echo $_POST["related-idea"]; ?>" />
				<?php echo outErrMes("related-idea");?>
				<div class="limit-description">iから始まるエントリー番号を入力．2011年度の作品の場合は頭に2011-,2012年度の作品の場合は頭に2012-を入れる．複数ある場合は半角スペースで区切って下さい．(例: i003 2011-i015 2012-i015)</div>
			</td>
		</tr>
		<tr>
			<th>関連する既に応募されたアプリケーション</th>
			<td>
				<input type="text" name="related-application" value="<?php echo $_POST["related-application"]; ?>" />
				<?php echo outErrMes("related-application");?>
				<div class="limit-description">aから始まるエントリー番号を入力．2011年度の作品の場合は頭に2011-,2012年度の作品の場合は頭に2012-を入れる。複数ある場合は半角スペースで区切って下さい．(例: a003 2011-a015 2012-a015)</div>
			</td>
		</tr>
		<tr>
			<th>関連する既に応募されたビジュアライゼーション作品</th>
			<td>
				<input type="text" name="related-visualization" value="<?php echo $_POST["related-visualization"]; ?>" />
				<?php echo outErrMes("related-visualization");?>
				<div class="limit-description">vから始まるエントリー番号を入力．2012年度の作品の場合は頭に2012-を入れる．複数ある場合は半角スペースで区切って下さい．(例: v003 v015  2012-v015)</div>
			</td>
		</tr>
		<tr>
			<th>関連する既に応募された基盤技術作品</th>
			<td>
				<input type="text" name="related-basetechnology" value="<?php echo $_POST["related-basetechnology"]; ?>" />
				<?php echo outErrMes("related-basetechnology");?>
				<div class="limit-description">bから始まるエントリー番号を入力．複数ある場合は半角スペースで区切って下さい．(例: b003 b015)</div>
			</td>
		</tr>
	</table>
	<input type="submit" value="確認" />
</form>
</div>
<?php echo get_footer($pageTitle); ?>