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
	$pageTitle = "アイデア登録完了";
	if($_POST){
		if(isset($_POST['id'])){
			$db->executeUpdate(
				"update idea_2012 set name = '".$_POST['name']."' , affiliation = '".$_POST['affiliation']."' , affiliation_anonymous = ".$_POST['affiliation_anonymous']." , email = '".$_POST['email']."' , email_anonymous = ".$_POST['email_anonymous']." , idea_name = '".$_POST['idea-name']."' ".
				", abstract = '".$_POST['idea-abstract']."' ".
				", related_dataset_ids = '".$_POST['related-dataset']."' , related_application_ids = '".$_POST['related-application']."' , related_visualization_ids = '".$_POST['related-visualization']."' , timestamp = '".date('c')."' ".
				"where id = ".$_POST['id']);
				
			$db->executeUpdate( // insert history
				"insert into idea_input_2012 (master_id, name, affiliation, affiliation_anonymous, email, email_anonymous, idea_name, abstract, related_dataset_ids, related_application_ids, related_visualization_ids, type, url, timestamp) ".
				"values (".$_POST['id'].", '".$_POST['name']."', '".$_POST['affiliation']."', ".$_POST['affiliation_anonymous'].", '".$_POST['email']."', ".$_POST['email_anonymous'].", '".$_POST['idea-name']."', '".$_POST['idea-abstract']."', '".
					$_POST['related-dataset']."', '".$_POST['related-application']."', '".$_POST['related-visualization']."', '', '', '".date('c')."')");
				
			$ideaId = 'i'.sprintf("%03d", $_POST['id']);
			// redirect
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: ".BASE_URL."show_status.php?id=i".sprintf("%03d", $_POST['id']).'&modified=true');
			exit();
		} else {
			$password = $pm->randomString(8);
			$hash = $pm->password($password);
			$result = $db->executeQuery("select * from idea_2012 where name = '".$_POST['name']."' and affiliation = '".$_POST['affiliation']."' and affiliation_anonymous = ".$_POST['affiliation_anonymous']." and email = '".$_POST['email']."' and email_anonymous = ".$_POST['email_anonymous']." and idea_name = '".$_POST['idea-name']."' and abstract = '".$_POST['idea-abstract'].
				"' and related_dataset_ids = '".$_POST['related-dataset']."' and related_application_ids = '".$_POST['related-application']."' and related_visualization_ids = '".$_POST['related-visualization']."' and type = '".$_POST['idea-select']."' and url = '".$_POST['idea-url']."'"); // 二重送信チェック
			$double = false;
			if(empty($result)){
				$db->executeUpdate(
					"insert into idea_2012 (name, affiliation, affiliation_anonymous, email, email_anonymous, idea_name, abstract, related_dataset_ids, related_application_ids, related_visualization_ids, type, url, hashed_password, timestamp) ".
					"values ('".$_POST['name']."', '".$_POST['affiliation']."', ".$_POST['affiliation_anonymous'].", '".$_POST['email']."', ".$_POST['email_anonymous'].", '".$_POST['idea-name']."', '".$_POST['idea-abstract']."', '".
						$_POST['related-dataset']."', '".$_POST['related-application']."', '".$_POST['related-visualization']."', '".$_POST['idea-select']."', '".$_POST['idea-url']."', '".$hash."', '".date('c')."')");
				$insertId = $db->getLastInsertId();
				
				$db->executeUpdate( // insert history
					"insert into idea_input_2012 (master_id, name, affiliation, affiliation_anonymous, email, email_anonymous, idea_name, abstract, related_dataset_ids, related_application_ids, related_visualization_ids, type, url, timestamp) ".
					"values (".$insertId.", '".$_POST['name']."', '".$_POST['affiliation']."', ".$_POST['affiliation_anonymous'].", '".$_POST['email']."', ".$_POST['email_anonymous'].", '".$_POST['idea-name']."', '".$_POST['idea-abstract']."', '".
						$_POST['related-dataset']."', '".$_POST['related-application']."', '".$_POST['related-visualization']."', '".$_POST['idea-select']."', '".$_POST['idea-url']."', '".date('c')."')");
				
				$ideaId = 'i'.sprintf("%03d", $insertId);
				
				if($_POST['idea-select'] == 'file'){
					//mkdir(dirname(__FILE__). '/dat/idea/'.$ideaId, 0777);
					rename(dirname(__FILE__). '/dat/tmp/'.$_POST['tmpfilename'], dirname(__FILE__). '/dat/idea/'.$ideaId.'_'.$_POST['tmpfilename']);
				}
				
				$content = MailTemplate::ideaMail($insertId, $_POST['name'], $_POST['affiliation'], ($_POST['affiliation_anonymous'] == 'true' ? true : false), 
					$_POST['email'], ($_POST['email_anonymous'] == 'true' ? true : false), $_POST['idea-name'], ($_POST['open'] == 'true' ? true : false), 
					$_POST['idea-abstract'], $_POST['related-dataset'], $_POST['related-application'], $_POST['related-visualization'], $_POST['idea-select'], $_POST['idea-url'], $password);
				$sm->send($_POST['email'], "LODチャレンジ　エントリー内容のご確認 (#i".sprintf("%03d", $insertId).")", $content);
			} else {
				$double = true;
			}
		}
	} else {
		require("apply_idea_category.php");
		return;
	}
?>

<?php echo get_header($pageTitle); ?>
<div id="contents-form">
<?php if(!$double){ ?>
<h2>登録が完了致しました</h2>

<div id="registered-message">
<div class="message">アイデアID： <span><?php echo $ideaId; ?></span></div>
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