<?php
	require_once( dirname(__FILE__) . '/template/header.php');
	require_once( dirname(__FILE__) . '/template/footer.php');
	
	require_once dirname(__FILE__) . '/util/lod_db.php';
	require_once dirname(__FILE__) . '/util/password_manager.php';
	require_once dirname(__FILE__) . '/util/base.php';	
	require_once dirname(__FILE__) . '/util/send_mail.php';
	require_once dirname(__FILE__) . '/util/mail_template.php';
	date_default_timezone_set('Asia/Tokyo'); /*  set TimeZone */
	$sm = SendMail::getInstance();
	$db = LodDb::getInstance();
	$pm = PasswordManager::getInstance();
	$pageTitle = "ビジュアライゼーション登録完了";
	if($_POST){
		if(isset($_POST['id'])){
			$db->executeUpdate(
				"update visualization_2013 set name = '".$_POST['name'].
				"' , affiliation = '".$_POST['affiliation']."' , affiliation_anonymous = ".$_POST['affiliation_anonymous']." , is_student = ".$_POST['is_student'].
				" , email = '".$_POST['email']."' , email_anonymous = ".$_POST['email_anonymous']." , set_mailinglist = ".$_POST['set_mailinglist'].
				" , visualization_name = '".$_POST['visualization-name']."' ".
				", abstract = '".$_POST['visualization-abstract']."' , description = '".$_POST['visualization-description'].
				"' , used_dataset_ids = '".$_POST['visualization-used-dataset'].
				"' , related_dataset_ids = '".$_POST['related-dataset'].
				"' , related_idea_ids = '".$_POST['related-idea'].
				"' , related_application_ids = '".$_POST['related-application'].
				"' , related_visualization_ids = '".$_POST['related-visualization'].
				"' , related_basetechnology_ids = '".$_POST['related-basetechnology'].
				"' , timestamp = '".date('c')."' , copyright = '".$_POST['right']."' , license = '".$_POST['license']."' ".
				"where id = ".$_POST['id']);

			$db->executeUpdate( // insert history
		 		"insert into visualization_input_2013 (master_id, name, affiliation, affiliation_anonymous, is_student, email, email_anonymous, set_mailinglist, visualization_name, abstract, description, used_dataset_ids, related_dataset_ids, related_idea_ids, related_application_ids, related_visualization_ids, related_basetechnology_ids, type, url, timestamp, copyright, license) ".
				"values (".$_POST['id'].", '".$_POST['name']."', '".$_POST['affiliation']."', ".$_POST['affiliation_anonymous'].", ".$_POST['is_student'].
					", '".$_POST['email']."', ".$_POST['email_anonymous'].", ".$_POST['set_mailinglist'].
					", '".$_POST['visualization-name']."', '".$_POST['visualization-abstract']."', '".$_POST['visualization-description']."', '".$_POST['visualization-used-dataset'].
					"', '".$_POST['related-dataset']."', '".$_POST['related-idea']."', '".$_POST['related-application']."', '".$_POST['related-visualization']."', '".$_POST['related-basetechnology'].
					"', '".$_POST['visualization-select']."', '".$_POST['visualization-url']."', '".date('c'). "', '".$_POST['right']."', '".$_POST['license']."')");

			$visualizationId = 'v'.sprintf("%03d", $_POST['id']);
			// redirect
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: ".BASE_URL."show_status.php?id=v".sprintf("%03d", $_POST['id']).'&modified=true');
			exit();
		} else {
			$password = $pm->randomString(8);
			$hash = $pm->password($password);
			$result = $db->executeQuery("select * from visualization_2013 where name = '".$_POST['name']."' and affiliation = '".$_POST['affiliation']."' and affiliation_anonymous = ".$_POST['affiliation_anonymous']." and email = '".$_POST['email']."' and email_anonymous = ".$_POST['email_anonymous']." and visualization_name = '".$_POST['visualization-name']."' and abstract = '".$_POST['visualization-abstract'].
				"' and related_dataset_ids = '".$_POST['related-dataset']."' and related_idea_ids = '".$_POST['related-idea']."' and type = '".$_POST['visualization-select']."' and url = '".$_POST['visualization-url']."' and copyright = '".$_POST['right']."' and license = '".$_POST['license']."'"); // 二重送信チェック
			$double = false;
			if(empty($result)){
				$db->executeUpdate(
					"insert into visualization_2013 (name, affiliation, affiliation_anonymous, is_student, email, email_anonymous, set_mailinglist, visualization_name, abstract, description, used_dataset_ids, related_dataset_ids, related_idea_ids, related_application_ids, related_visualization_ids, related_basetechnology_ids, type, url, hashed_password, timestamp, copyright, license) ".
					"values ('".$_POST['name']."', '".$_POST['affiliation']."', ".$_POST['affiliation_anonymous'].", ".$_POST['is_student'].
						", '".$_POST['email']."', ".$_POST['email_anonymous'].", ".$_POST['set_mailinglist'].
						", '".$_POST['visualization-name']."', '".$_POST['visualization-abstract']."', '".$_POST['visualization-description']."', '".$_POST['visualization-used-dataset']."', '".
						$_POST['related-dataset']."', '".$_POST['related-idea']."', '".$_POST['related-application']."', '".$_POST['related-visualization']."', '".$_POST['related-basetechnology'].
						"', '".$_POST['visualization-select']."', '".$_POST['visualization-url']."', '".$hash."', '".date('c'). "', '".$_POST['right']."', '".$_POST['license']."')" );
				$insertId = $db->getLastInsertId();
				
				$db->executeUpdate( // insert history
			 		"insert into visualization_input_2013 (master_id, name, affiliation, affiliation_anonymous, is_student, email, email_anonymous, set_mailinglist, visualization_name, abstract, description, used_dataset_ids, related_dataset_ids, related_idea_ids, related_application_ids, related_visualization_ids, related_basetechnology_ids, type, url, timestamp, copyright, license) ".
					"values (".$insertId.", '".$_POST['name']."', '".$_POST['affiliation']."', ".$_POST['affiliation_anonymous'].", ".$_POST['is_student'].
						", '".$_POST['email']."', ".$_POST['email_anonymous'].", ".$_POST['set_mailinglist'].
						", '".$_POST['visualization-name']."', '".$_POST['visualization-abstract']."', '".$_POST['visualization-description']."', '".$_POST['visualization-used-dataset'].
						"', '".$_POST['related-dataset']."', '".$_POST['related-idea']."', '".$_POST['related-application']."', '".$_POST['related-visualization']."', '".$_POST['related-basetechnology'].
						"', '".$_POST['visualization-select']."', '".$_POST['visualization-url']."', '".date('c'). "', '".$_POST['right']."', '".$_POST['license']."')");
				$visualizationId = 'v'.sprintf("%03d", $insertId);
		/* ファイルの移動 */		
				if($_POST['visualization-select'] === 'file'){
					//mkdir(dirname(__FILE__). '/dat2013/visualization/'.$visualizationId, 0777);
					rename(dirname(__FILE__).'/dat2013/tmp/'.$_POST['tmpfilename'], dirname(__FILE__). '/dat2013/visualization/'.$visualizationId.'_'.$_POST['tmpfilename']);
				}
		/* ファイル名 */
				$splitted = explode("_", $_POST['tmpfilename'], 2);
				$file_name =  $splitted[1];

				$content = MailTemplate::visualizationMail($insertId, $_POST['name'], $_POST['affiliation'], ($_POST['affiliation_anonymous'] == 'true' ? true : false), 
					($_POST['is_student'] == 'true' ? true : false),
					$_POST['email'], ($_POST['email_anonymous'] == 'true' ? true : false),($_POST['set_mailinglist'] == 'true' ? true : false),

					$_POST['visualization-name'], $_POST['visualization-abstract'], $_POST['visualization-description'], 

					$_POST['related-dataset'], $_POST['related-idea'], $_POST['related-application'], $_POST['related-visualization'], $_POST['related-basetechnology'],
					$_POST['visualization-select'], $_POST['visualization-url'], 
					$_POST['right'], $_POST['license'], $file_name, $password);
				$sm->send($_POST['email'], "LODチャレンジ　エントリー内容のご確認 (#v".sprintf("%03d", $insertId).")", $content);
			} else {
				$double = true;
			}
		}
	} else {
		require("apply_visualization_category.php");
		return;
	}
?>

<?php echo get_header($pageTitle); ?>
<div id="contents-form">
<?php if(!$double){ ?>
<h2>登録が完了致しました</h2>

<div id="registered-message">
<div class="message">ビジュアライゼーションID： <span><?php echo $visualizationId; ?></span></div>
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