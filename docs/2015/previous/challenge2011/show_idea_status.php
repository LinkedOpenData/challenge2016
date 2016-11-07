<?php
	require_once dirname(__FILE__) . '/util/copyright.php';
	require_once dirname(__FILE__) . '/util/lod_db.php';
	require_once dirname(__FILE__) . '/util/base.php';
	require_once dirname(__FILE__) . '/util/password_manager.php';
	$pm = PasswordManager::getInstance();
	$db = LodDb::getInstance();
	$cr = Copyright::getInstance();
	
	$ideaId = $_GET['id'];
	$id = intval(substr($_GET['id'],1));
	
	if($id > 0){
		$item = $db->executeQuery("select * from idea where id = ".$id);
	} else {
		require("show_status.php");
		return;
	}
	
	$verified = $pm->verify($_GET['password'], $item[0]['hashed_password']);
	
	$pankuzuList = array(
		array("name" => "HOME", "url" => "index.html"),
		array("name" => "エントリー一覧", "url" => "show_list.php"),
		array("name" => "エントリーシート(アイデア)")
	);
?>
	<?php 
		if(empty($item)){
			require("template/header.php");
	?>
			指定されたID <?php echo $_GET['id']; ?> は存在しません。
	<?php 
		} else if($item[0]["disclosed"] || (isset($_GET['password']) && $verified)) {
			$pageTitle = $item[0]["idea_name"]." - アイデアのエントリーシート";
	?>
<?php require("template/header.php"); ?>
			
	<h2><?php echo $item[0]["idea_name"]; ?></h2>
	
	<?php 
		echo (isset($_GET['modified']) ? '<div class="modified-message">修正されました</div>' : "");
	?>
	
	<table id="entrysheet" class="application-form">
		<tr class="info-row">
			<th colspan="2">応募者の情報</th>
		</tr>
		<tr>
			<th>ご氏名</th>
			<td><?php echo $item[0]["name"]; ?></td>
		</tr>
		<tr>
			<th>ご所属</th>
			<td><?php echo ($item[0]["affiliation_anonymous"] ? "<i>[非公開]</i>" : $item[0]["affiliation"]); ?></td>
		</tr>
		<tr>
			<th>e-mailアドレス</th>
			<td><?php echo ($item[0]["email_anonymous"] ? "<i>[非公開]</i>" : str_replace("@", ' <i>[at]</i> ',  $item[0]["email"])); ?></td>
		</tr>
		<tr class="info-row">
			<th colspan="2">応募するアイデアの情報</th>
		</tr>
		<tr>
			<th>アイデアの名称</th>
			<td><?php echo $item[0]["idea_name"]; ?></td>
		</tr>
		<tr>
			<th>アイデアの公開</th>
			<td><?php echo ($item[0]["open"] ? "公開" : "非公開"); ?></td>
		</tr>
		<tr>
			<th>アイデアの概略説明</th>
			<td>
				<?php echo str_replace("\n", "<br>", $item[0]["abstract"]); ?>
			</td>
		</tr>
		<tr>
			<th>関連するデータセット</th>
			<td>
				<?php 
				if($item[0]["open"]){
					foreach (explode(" ", $item[0]["related_dataset_ids"]) as $did) {
						echo '<a href="'.BASE_URL.'show_status.php?id='.$did.'">'.$did.'</a> ';
					}
				} else {
					echo "非公開";
				}
				?>
			</td>
		</tr>
		<tr>
			<th>関連するアプリケーション</th>
			<td>
				<?php 
				if($item[0]["open"]){
					foreach (explode(" ", $item[0]["related_application_ids"]) as $iid) {
						echo '<a href="'.BASE_URL.'show_status.php?id='.$iid.'">'.$iid.'</a> ';
					}
				} else {
					echo "非公開";
				}
				?>
			</td>
		</tr>
		<tr>
			<th>投稿したアイデア</th>
			<td>
				<?php if($item[0]["open"]){ ?>
				<?php if($item[0]["type"] == 'url'){ ?>
					<a href="<?php echo $item[0]["url"]; ?>" target="_blank"><?php echo $item[0]["url"]; ?></a>
				<?php 
					} else {
						 
					$res_dir = opendir( dirname(__FILE__) . '/dat/idea/' );

					//ディレクトリ内のファイル名を１つずつを取得
					$filedate = 0;
					while( $file_name = readdir( $res_dir ) ){
						//取得したファイル名を表示
						if(preg_match("/^".$ideaId.".+/", $file_name)){
							//$splitted = explode("_", $file_name, 2);
							//if($filedate < doubleval($splitted[0])){
								//$filedate = doubleval($splitted[0]);
								$fileName = $file_name;
							//}
						}
					}
					
					//ディレクトリ・ハンドルをクローズ
					closedir( $res_dir );
				?>
					<a href="<?php echo BASE_URL. 'dat/idea/'.$fileName; ?>" target="_blank"><?php $splitted = explode("_", $fileName, 3); echo $splitted[2]; ?></a>
				<?php } ?>
				<?php } else {
					echo '非公開';
				} 
				if($_GET['id'] == 'i029'){
				?>
					<br><a href="<?php echo BASE_URL. 'dat/movie/i029_movie.wmv'; ?>">LODチャレンジ.wmv</a>
				<?php 
				}
				?>
			</td>
		</tr>
	</table>
<form action="modify_idea_status.php" method="post">
	<h3>登録情報を修正する</h3>
	<input type="hidden" name="id" value="<?php echo $id ?>" />
	<input type="password" name="password" /> <input type="submit" value="修正" />
	<br> 修正用のパスワードを入力してください。
</form>
	<?php 
		} else {
			require("template/header.php");
	?>
			指定されたID <?php echo $_GET['id']; ?> はまだ公開されていません。
			
<form action="show_idea_status.php" method="get">
	<h3>登録情報を閲覧・修正する</h3>
	<input type="hidden" name="id" value="<?php echo $ideaId ?>" />
	<input type="password" name="password" /> <input type="submit" value="送信" />
	<br> 閲覧・修正用のパスワードを入力してください。
</form>

	<?php 
		} 
	?>
<?php require("template/footer.php"); ?>