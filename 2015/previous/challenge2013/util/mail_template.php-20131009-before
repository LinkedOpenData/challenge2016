<?php

require_once dirname(__FILE__) . '/copyright.php';

define('URL_SOURCE', '');
define('CHALLENGE_BASE_DIR', 'challenge2013_test');
define('LOD_CHALLENGE_MAIL_ADDRESS', 'lod-challenge@sfc.keio.ac.jp');

class MailTemplate {

	static function datasetMail($id, $name, $affiliation, $affiliation_anonymous, $is_student, $email, $email_anonymous, $set_mailinglist,
		$dataset_name, $dataset_url, $abstract, $description, $propose,
		$related_dataset_ids, $related_idea_ids, $related_application_ids, $related_visualization_ids, $related_basetechnology_ids,
		$right, $password, $creator){
			
		$cr = Copyright::getInstance();
			
		$str = $name."　様\n".
		$str .= "\n";
		$str .= "LODチャレンジ　データセット部門にエントリー頂きありがとうございました。\n";
		$str .= "\n";
		$str .= "ご登録内容をご確認ください。\n";
		$str .= "\n";
		$str .= "\n";
		$str .= "◆　応募者の情報\n";
		$str .= "\n";
		$str .= "ご氏名	".$name.($is_student ? "[学生]" : "")."\n";
		$str .= "ご所属	".$affiliation." [".($affiliation_anonymous ? "非公開" : "公開")."]\n";
		$str .= "e-mailアドレス	".$email." [".($email_anonymous ? "非公開" : "公開")."]\n";
		$str .= "メールで情報を受け取る	"." [ ".($set_mailinglist ? "希望する" : "希望しない")."]\n";
		$str .= "\n";
		$str .= "◆　応募したデータセットの情報\n";
		$str .= "\n";
		$str .= "データセットの名称	".$dataset_name."\n";
		$str .= "データセットのURL	".$dataset_url."\n";
		$str .= "データセットの概略説明	 ".$abstract."\n";
		$str .= "データセットの詳細説明	 ".$description."\n";
		$str .= "アプリ提案・希望	".$propose."\n";
		$str .= "データセットの権利指定	".$cr->title($right)."\n";
		if($creator){
			$str .= "著作者または製作者	".$creator."\n";
		}
		$str .= "◆　関連する作品の情報\n";
		$str .= "関連するデータセット	".$related_dataset_ids."\n";
		$str .= "関連するアイデア	".$related_idea_ids."\n";
		$str .= "関連するアプリケーション	".$related_application_ids."\n";
		$str .= "関連するビジュアライゼーション作品	".$related_visualization_ids."\n";
		$str .= "関連する基盤技術作品	".$related_basetechnology_ids."\n";
		$str .= "\n";
		$str .= "\n";
		$str .= "登録内容の確認・修正は以下のURLから行えます。\n";
		$str .= "\n";
		$str .= "http://lod.sfc.keio.ac.jp/". CHALLENGE_BASE_DIR ."/show_status.php?id=d".sprintf("%03d", $id)."\n";
		$str .= "修正パスワード： ".$password."\n";
		$str .= "\n";
		$str .= "作品の応募後は、「応募者の情報」「応募したデータセットの情報」のうち\n";
		$str .= "データセットの名称/データセットの概略説明/関連する作品の修正しかできません。\n";
 		$str .= "また応募作品の取り消しはできません。（応募規程7,応募規程9)\n";
 		$str .= "本欄以外での修正、取り消しなどの要望がありましたら". LOD_CHALLENGE_MAIL_ADDRESS ."\n";
 		$str .= "までご連絡下さい。\n";
		$str .= "\n";
		$str .= "\n";
		$str .= "※このメールにお心当たりがない場合は、". LOD_CHALLENGE_MAIL_ADDRESS ." まで\n";
		$str .= "お問い合わせください。\n";

    	return $str;
	}
	
	static function ideaMail($id, $name, $affiliation, $affiliation_anonymous, $is_student, $email, $email_anonymous, $set_mailinglist,
		$idea_name, $open, $abstract, $description,
		$related_dataset_ids, $related_idea_ids, $related_application_ids, $related_visualization_ids, $related_basetechnology_ids,
		$type, $idea_url, $file_name, $password){
			
		$str = $name."　様\n".
		$str .= "\n";
		$str .= "LODチャレンジ　アイデア部門にエントリー頂きありがとうございました。"."\n";
		$str .= "\n";
		$str .= "ご登録内容をご確認ください。"."\n";
		$str .= "\n";
		$str .= "\n";
		$str .= "◆　応募者の情報"."\n";
		$str .= "\n";
		$str .= "ご氏名	".$name.($is_student ? "[学生]" : "")."\n";
		$str .= "ご所属	".$affiliation." [".($affiliation_anonymous ? "非公開" : "公開")."]"."\n";
		$str .= "e-mailアドレス	".$email." [".($email_anonymous ? "非公開" : "公開")."]"."\n";
		$str .= "メールで情報を受け取る	"." [ ".($set_mailinglist ? "希望する" : "希望しない")."]\n";
		$str .= "\n";
		$str .= "◆　応募したアイデアの情報"."\n";
		$str .= "\n";
		$str .= "アイデアの名称	".$idea_name."\n";
		$str .= "アイデアの概略説明	 ".$abstract."\n";
		$str .= "アイデアの詳細説明	 ".$description."\n";
		$str .= "投稿したアイデア	".($type === 'url' ? $idea_url : $file_name)."\n";
		$str .= "◆　関連する作品の情報\n";
		$str .= "関連するデータセット	".$related_dataset_ids."\n";
		$str .= "関連するアイデア	".$related_idea_ids."\n";
		$str .= "関連するアプリケーション	".$related_application_ids."\n";
		$str .= "関連するビジュアライゼーション作品	".$related_visualization_ids."\n";
		$str .= "関連する基盤技術作品	".$related_basetechnology_ids."\n";
		$str .= "\n";
		$str .= "\n";
		$str .= "作品が公開された後、登録内容の確認・修正は以下のURLから行えます。";
		$str .= "\n";
		$str .= "http://lod.sfc.keio.ac.jp/". CHALLENGE_BASE_DIR ."/show_status.php?id=i".sprintf("%03d", $id)."\n";
		$str .= "修正パスワード： ".$password."\n";
		$str .= "\n";
		$str .= "作品の応募後は、「応募者の情報」「応募したアイデアの情報」のうち\n";
		$str .= "アイデアの名称/アイデアの概略説明/関連する作品の修正しかできません。\n";
 		$str .= "また応募作品の取り消しはできません。（応募規程7,応募規程9)\n";
 		$str .= "本欄以外での修正、取り消しなどの要望がありましたら". LOD_CHALLENGE_MAIL_ADDRESS ."\n";
 		$str .= "までご連絡下さい。\n";
		$str .= "\n";
		$str .= "\n";
		$str .= "※このメールにお心当たりがない場合は、". LOD_CHALLENGE_MAIL_ADDRESS ." まで\n";
		$str .= "お問い合わせください。\n";

    	return $str;
	}
	
	static function visualizationMail($id, $name, $affiliation, $affiliation_anonymous, $is_student, $email, $email_anonymous, $set_mailinglist,
		$visualization_name, $abstract, $description,
		$related_dataset_ids, $related_idea_ids, $related_application_ids, $related_visualization_ids, $related_basetechnology_ids,
		$type, $visualization_url, $copyright, $license, $file_name, $password){
			
		$cr = Copyright::getInstance();
			
		$str = $name."　様\n".
		$str .= "\n";
		$str .= "LODチャレンジ　ビジュアライゼーション部門にエントリー頂きありがとうございました。"."\n";
		$str .= "\n";
		$str .= "ご登録内容をご確認ください。"."\n";
		$str .= "\n";
		$str .= "\n";
		$str .= "◆　応募者の情報"."\n";
		$str .= "\n";
		$str .= "ご氏名	".$name.($is_student ? "[学生]" : "")."\n";
		$str .= "ご所属	".$affiliation." [".($affiliation_anonymous ? "非公開" : "公開")."]"."\n";
		$str .= "e-mailアドレス	".$email." [".($email_anonymous ? "非公開" : "公開")."]"."\n";
		$str .= "\n";
		$str .= "◆　応募したビジュアライゼーション作品の情報"."\n";
		$str .= "\n";
		$str .= "ビジュアライゼーション作品の名称	".$visualization_name."\n";
		$str .= "ビジュアライゼーション作品の概略説明	 ".$abstract."\n";
		$str .= "ビジュアライゼーション作品の詳細説明	 ".$description."\n";
		$str .= "投稿したビジュアライゼーション作品	".($type == 'url' ? $visualization_url : $file_name)."\n";
		$str .= "ビジュアライゼーションの権利指定	".$cr->title($copyright)."\n";
		if($license){
			$str .= "ライセンス	".$license."\n";
		}
		$str .= "◆　関連する作品の情報\n";
		$str .= "関連するデータセット	".$related_dataset_ids."\n";
		$str .= "関連するアイデア	".$related_idea_ids."\n";
		$str .= "関連するアプリケーション作品	".$related_application_ids."\n";
		$str .= "関連するビジュアライゼーション作品	".$related_visualization_ids."\n";
		$str .= "関連する基盤技術作品	".$related_basetechnology_ids."\n";
		$str .= "\n";
		$str .= "\n";
		$str .= "作品が公開された後、登録内容の確認・修正は以下のURLから行えます。";
		$str .= "\n";
		$str .= "http://lod.sfc.keio.ac.jp/". CHALLENGE_BASE_DIR ."/show_status.php?id=v".sprintf("%03d", $id)."\n";
		$str .= "修正パスワード： ".$password."\n";
		$str .= "\n";
		$str .= "作品の応募後は、「応募者の情報」「応募したビジュアライゼーション作品の情報」のうち\n";
		$str .= "ビジュアライゼーション作品の名称/ビジュアライゼーション作品の概略説明/関連する作品の\n";
		$str .= "修正しかできません。\n";
 		$str .= "また応募作品の取り消しはできません。（応募規程7,応募規程9)\n";
 		$str .= "本欄以外での修正、取り消しなどの要望がありましたら". LOD_CHALLENGE_MAIL_ADDRESS ."\n";
 		$str .= "までご連絡下さい。\n";
		$str .= "\n";
		$str .= "\n";
		$str .= "※このメールにお心当たりがない場合は、". LOD_CHALLENGE_MAIL_ADDRESS ." まで\n";
		$str .= "お問い合わせください。\n";

    	return $str;
	}
	
	static function applicationMail($id, $name, $affiliation, $affiliation_anonymous, $is_student, $email, $email_anonymous, $set_mailinglist,
		$application_name, $application_url, $abstract, $description, $used_dataset_ids,
		$related_dataset_ids, $related_idea_ids, $related_application_ids, $related_visualization_ids, $related_basetechnology_ids, 
		$right, $password, $license){
		$cr = Copyright::getInstance();
			
		$str = $name."　様\n".
		$str .= "\n";
		$str .= "LODチャレンジ　アプリケーション部門にエントリー頂きありがとうございました。\n";
		$str .= "\n";
		$str .= "ご登録内容をご確認ください。\n";
		$str .= "\n";
		$str .= "\n";
		$str .= "◆　応募者の情報\n";
		$str .= "\n";
		$str .= "ご氏名	".$name.($is_student ? "[学生]" : "")."\n";
		$str .= "ご所属	".$affiliation." [".($affiliation_anonymous ? "非公開" : "公開")."]\n";
		$str .= "e-mailアドレス	".$email." [".($email_anonymous ? "非公開" : "公開")."]\n";
		$str .= "メールで情報を受け取る	"." [ ".($set_mailinglist ? "希望する" : "希望しない")."]\n";
		$str .= "\n";
		$str .= "◆　応募したアプリケーションの情報\n";
		$str .= "\n";
		$str .= "アプリケーションの名称	".$application_name."\n";
		$str .= "アプリケーションのURL	".$application_url."\n";
		$str .= "アプリケーションの概略説明	 ".$abstract."\n";
		$str .= "アプリケーションの詳細説明	 ".$description."\n";
		$str .= "利用したデータセット		 ".$used_dataset_ids."\n";
		$str .= "アプリケーションの権利指定	".$cr->title($right)."\n";
		if($license){
			$str .= "ライセンス	".$license."\n";
		}
		$str .= "◆　関連する作品の情報\n";
		$str .= "関連するデータセット	".$related_dataset_ids."\n";
		$str .= "関連するアイデア	".$related_idea_ids."\n";
		$str .= "関連するアプリケーション	".$related_application_ids."\n";
		$str .= "関連するビジュアライゼーション作品	".$related_visualization_ids."\n";
		$str .= "関連する基盤技術作品	".$related_basetechnology_ids."\n";
		$str .= "\n";
		$str .= "\n";
		$str .= "登録内容の確認・修正は以下のURLから行えます。\n";
		$str .= "\n";
		$str .= "http://lod.sfc.keio.ac.jp/". CHALLENGE_BASE_DIR ."/show_status.php?id=a".sprintf("%03d", $id)."\n";
		$str .= "修正パスワード： ".$password."\n";
		$str .= "\n";
		$str .= "作品の応募後は、「応募者の情報」「応募したアプリケーションの情報」のうち\n";
		$str .= "アプリケーションの名称/アプリケーションの概略説明/関連する作品の修正しかできません。\n";
 		$str .= "また応募作品の取り消しはできません。（応募規程7,応募規程9)\n";
 		$str .= "本欄以外での修正、取り消しなどの要望がありましたら". LOD_CHALLENGE_MAIL_ADDRESS ."\n";
 		$str .= "までご連絡下さい。\n";
		$str .= "\n";
		$str .= "\n";
		$str .= "※このメールにお心当たりがない場合は、". LOD_CHALLENGE_MAIL_ADDRESS ." まで\n";
		$str .= "お問い合わせください。\n";

    	return $str;
	}

	static function basetechnologyMail($id, $name, $affiliation, $affiliation_anonymous, $is_student, $email, $email_anonymous, $set_mailinglist,
		$basetechnology_name, $basetechnology_url, $abstract, $description,
		$related_dataset_ids, $related_idea_ids, $related_application_ids, $related_visualization_ids, $related_basetechnology_ids, 
		$right, $password, $license){
		$cr = Copyright::getInstance();
			
		$str = $name."　様\n".
		$str .= "\n";
		$str .= "LODチャレンジ　基盤技術部門にエントリー頂きありがとうございました。\n";
		$str .= "\n";
		$str .= "ご登録内容をご確認ください。\n";
		$str .= "\n";
		$str .= "\n";
		$str .= "◆　応募者の情報\n";
		$str .= "\n";
		$str .= "ご氏名	".$name.($is_student ? "[学生]" : "")."\n";
		$str .= "ご所属	".$affiliation." [".($affiliation_anonymous ? "非公開" : "公開")."]\n";
		$str .= "e-mailアドレス	".$email." [".($email_anonymous ? "非公開" : "公開")."]\n";
		$str .= "メールで情報を受け取る	"." [ ".($set_mailinglist ? "希望する" : "希望しない")."]\n";
		$str .= "\n";
		$str .= "◆　応募した基盤技術の情報\n";
		$str .= "\n";
		$str .= "基盤技術の名称	".$basetechnology_name."\n";
		$str .= "基盤技術のURL	".$basetechnology_url."\n";
		$str .= "基盤技術の概略説明	 ".$abstract."\n";
		$str .= "基盤技術の詳細説明	 ".$description."\n";
		$str .= "基盤技術の権利指定	".$cr->title($right)."\n";
		if($license){
			$str .= "ライセンス	".$license."\n";
		}
		$str .= "◆　関連する作品の情報\n";
		$str .= "関連するデータセット	".$related_dataset_ids."\n";
		$str .= "関連するアイデア	".$related_idea_ids."\n";
		$str .= "関連するアプリケーション	".$related_application_ids."\n";
		$str .= "関連するビジュアライゼーション作品	".$related_visualization_ids."\n";
		$str .= "関連する基盤技術作品	".$related_basetechnology_ids."\n";
		$str .= "\n";
		$str .= "\n";
		$str .= "登録内容の確認・修正は以下のURLから行えます。\n";
		$str .= "\n";
		$str .= "http://lod.sfc.keio.ac.jp/". CHALLENGE_BASE_DIR ."/show_status.php?id=b".sprintf("%03d", $id)."\n";
		$str .= "修正パスワード： ".$password."\n";
		$str .= "\n";
		$str .= "作品の応募後は、「応募者の情報」「応募した基盤技術の情報」のうち\n";
		$str .= "基盤技術の名称/基盤技術の概略説明/関連する作品の修正しかできません。\n";
 		$str .= "また応募作品の取り消しはできません。（応募規程7,応募規程9)\n";
 		$str .= "本欄以外での修正、取り消しなどの要望がありましたら". LOD_CHALLENGE_MAIL_ADDRESS ."\n";
 		$str .= "までご連絡下さい。\n";
		$str .= "\n";
		$str .= "\n";
		$str .= "※このメールにお心当たりがない場合は、". LOD_CHALLENGE_MAIL_ADDRESS ." まで\n";
		$str .= "お問い合わせください。\n";

    	return $str;
	}
}

?>