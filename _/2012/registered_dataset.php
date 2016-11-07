<?php
	require_once( dirname(__FILE__) . '/template/header.php');
	require_once( dirname(__FILE__) . '/template/footer.php');
	
	require_once dirname(__FILE__) . '/util/lod_db.php';
	require_once dirname(__FILE__) . '/util/password_manager.php';
	require_once dirname(__FILE__) . '/util/base.php';
	require_once dirname(__FILE__) . '/util/send_mail.php';
	require_once dirname(__FILE__) . '/util/mail_template.php';
	$sm = SendMail::getInstance();	
	$db = LodDb::getInstance();
	$pm = PasswordManager::getInstance();
	$pageTitle = "データセット登録完了";
	if($_POST){
		if(isset($_POST['id'])){
			$db->executeUpdate(
				"update dataset_2012 set name = '".$_POST['name']."' , affiliation = '".$_POST['affiliation']."' , affiliation_anonymous = ".$_POST['affiliation_anonymous']." , email = '".$_POST['email']."' , email_anonymous = ".$_POST['email_anonymous']." , dataset_name = '".$_POST['dataset-name']."' ".
				", url = '".$_POST['dataset-url']."' , abstract = '".$_POST['dataset-abstract']."' , request = '".$_POST['dataset-propose']."' ".
				", related_dataset_ids = '".$_POST['related-dataset']."' , related_idea_ids = '".$_POST['related-idea']."' , related_visualization_ids = '".$_POST['related-visualization']."' , copyright = '".$_POST['right']."' , timestamp = '".date('c')."' , creator = '".$_POST['creator']."' ".
				"where id = ".$_POST['id']);
			
			$db->executeUpdate( // input history
				"insert into dataset_input_2012 (master_id, name, affiliation, affiliation_anonymous, email, email_anonymous, dataset_name, url, abstract, request, related_dataset_ids, related_idea_ids, related_visualization_ids, copyright, timestamp, creator) ".
				"values (".$_POST['id'].", '".$_POST['name']."', '".$_POST['affiliation']."', ".$_POST['affiliation_anonymous'].", '".$_POST['email']."', ".$_POST['email_anonymous'].", '".$_POST['dataset-name']."', '".$_POST['dataset-url']."', '".$_POST['dataset-abstract']."', '".
					$_POST['dataset-propose']."', '".$_POST['related-dataset']."', '".$_POST['related-idea']."', '".$_POST['related-visualization']."', '".$_POST['right']."', '".date('c')."', '".$_POST['creator']."')");
			// redirect
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: ".BASE_URL."show_status.php?id=d".sprintf("%03d", $_POST['id']).'&modified=true');
			exit();
		} else {
			$password = $pm->randomString(8);
			$hash = $pm->password($password);
			$result = $db->executeQuery("select * from dataset_2012 where name = '".$_POST['name']."' and affiliation = '".$_POST['affiliation']."' and affiliation_anonymous = ".$_POST['affiliation_anonymous']." and email = '".$_POST['email']."' and email_anonymous = ".$_POST['email_anonymous']." and dataset_name = '".$_POST['dataset-name']."' and url = '".$_POST['dataset-url']."' and abstract = '".$_POST['dataset-abstract']."' ".
				"and request = '".$_POST['dataset-propose']."' and related_dataset_ids = '".$_POST['related-dataset']."' and related_idea_ids = '".$_POST['related-idea']."' and related_visualization_ids = '".$_POST['related-visualization']."' and copyright = '".$_POST['right']."'"); // 二重送信チェック
			$double = false;
			if(empty($result)){
				$db->executeUpdate(
					"insert into dataset_2012 (name, affiliation, affiliation_anonymous, email, email_anonymous, dataset_name, url, abstract, request, related_dataset_ids, related_idea_ids, related_visualization_ids, copyright, hashed_password, timestamp, creator) ".
					"values ('".$_POST['name']."', '".$_POST['affiliation']."', ".$_POST['affiliation_anonymous'].", '".$_POST['email']."', ".$_POST['email_anonymous'].", '".$_POST['dataset-name']."', '".$_POST['dataset-url']."', '".$_POST['dataset-abstract']."', '".
						$_POST['dataset-propose']."', '".$_POST['related-dataset']."', '".$_POST['related-idea']."', '".$_POST['related-visualization']."', '".$_POST['right']."', '".$hash."', '".date('c')."', '".$_POST['creator']."')");
				
				$insertId = $db->getLastInsertId();
				
				$db->executeUpdate( // input history
					"insert into dataset_input_2012 (master_id, name, affiliation, affiliation_anonymous, email, email_anonymous, dataset_name, url, abstract, request, related_dataset_ids, related_idea_ids, related_visualization_ids, copyright, timestamp, creator) ".
					"values (".$insertId.", '".$_POST['name']."', '".$_POST['affiliation']."', ".$_POST['affiliation_anonymous'].", '".$_POST['email']."', ".$_POST['email_anonymous'].", '".$_POST['dataset-name']."', '".$_POST['dataset-url']."', '".$_POST['dataset-abstract']."', '".
						$_POST['dataset-propose']."', '".$_POST['related-dataset']."', '".$_POST['related-idea']."', '".$_POST['related-visualization']."', '".$_POST['right']."', '".date('c')."', '".$_POST['creator']."')");
				
				$content = MailTemplate::datasetMail($insertId, $_POST['name'], $_POST['affiliation'], ($_POST['affiliation_anonymous'] == 'true' ? true : false), 
					$_POST['email'], ($_POST['email_anonymous'] == 'true' ? true : false), $_POST['dataset-name'], $_POST['dataset-url'], $_POST['dataset-abstract'], 
					$_POST['dataset-propose'], $_POST['related-dataset'], $_POST['related-idea'], $_POST['related-visualization'], $_POST['right'], $password, $_POST['creator']);
				$sm->send($_POST['email'], "LODチャレンジ　エントリー内容のご確認 (#d".sprintf("%03d", $insertId).")", $content);
			} else {
				$double = true;
			}
		}
	} else {
		require("apply_dataset_category.php");
		return;
	}
?>

<?php echo get_header($pageTitle); ?>
<div id="contents-form">
<?php if(!$double){ ?>
<h2>登録が完了致しました</h2>

<div id="registered-message">
<div class="message">データセットID： <span>d<?php echo sprintf("%03d", $insertId); ?></span></div>
<div class="message">登録情報修正用パスワード： <span><?php echo $password; ?></span></div>
<div class="message">このページを印刷して情報を保管してください。</div>
</div>
<?php }else{ ?>
<h2>二重送信です</h2>

<div id="registered-message">
<div class="message">その情報は既に登録されています。</div>
</div>
<?php } ?>
</div>
<?php echo get_footer($pageTitle); ?>