<?php

require_once dirname(__FILE__) . '/copyright.php';

class MailTemplate {
	
	static function datasetMail($id, $name, $affiliation, $affiliation_anonymous, $email, $email_anonymous, 
		$dataset_name, $dataset_url, $abstract, $propose, $related_dataset_ids, $related_idea_ids, $right, $password, $creator){
			
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
		$str .= "ご氏名	".$name."\n";
		$str .= "ご所属	".$affiliation." [".($affiliation_anonymous ? "非公開" : "公開")."]\n";
		$str .= "e-mailアドレス	".$email." [".($email_anonymous ? "非公開" : "公開")."]\n";
		$str .= "\n";
		$str .= "◆　応募したデータセットの情報\n";
		$str .= "\n";
		$str .= "データセットの名称	".$dataset_name."\n";
		$str .= "データセットのURL	".$dataset_url."\n";
		$str .= "データセットの概略説明	 ".$abstract."\n";
		$str .= "アプリ提案・希望	".$propose."\n";
		$str .= "関連するデータセット	".$related_dataset_ids."\n";
		$str .= "関連するアイデア	".$related_idea_ids."\n";
		$str .= "データセットの権利指定	".$cr->title($right)."\n";
		if($creator){
			$str .= "著作者または製作者	".$creator."\n";
		}
		$str .= "\n";
		$str .= "\n";
		$str .= "登録内容の確認・修正は以下のURLから行えます。\n";
		$str .= "\n";
		$str .= "http://lod.sfc.keio.ac.jp/challenge2011/show_status.php?id=d".sprintf("%03d", $id)."\n";
		$str .= "修正パスワード： ".$password."\n";
		$str .= "\n";
		$str .= "作品の応募後は、「応募者の情報」「応募したデータセットの情報のうち\n";
		$str .= "データセットの名称/データセットの概略説明/関連するデータセット/関連する\n";
		$str .= "アイデア」の修正しかできません。\n";
 		$str .= "また応募作品の取り消しはできません。（応募規程7,応募規程9)\n";
 		$str .= "本欄以外での修正、取り消しなどの要望がありましたらlod-challenge@sfc.keio.ac.jp\n";
 		$str .= "までご連絡下さい。\n";
		$str .= "\n";
		$str .= "\n";
		$str .= "※このメールにお心当たりがない場合は、lod-challenge@sfc.keio.ac.jp まで\n";
		$str .= "お問い合わせください。\n";

    	return $str;
	}
	
	static function ideaMail($id, $name, $affiliation, $affiliation_anonymous, $email, $email_anonymous, 
		$idea_name, $open, $abstract, $related_dataset_ids, $related_application_ids, $type, $idea_url, $password){
			
		$str = $name."　様\n".
		$str .= "\n";
		$str .= "LODチャレンジ　アイデア部門にエントリー頂きありがとうございました。"."\n";
		$str .= "\n";
		$str .= "ご登録内容をご確認ください。"."\n";
		$str .= "\n";
		$str .= "\n";
		$str .= "◆　応募者の情報"."\n";
		$str .= "\n";
		$str .= "ご氏名	".$name."\n";
		$str .= "ご所属	".$affiliation." [".($affiliation_anonymous ? "非公開" : "公開")."]"."\n";
		$str .= "e-mailアドレス	".$email." [".($email_anonymous ? "非公開" : "公開")."]"."\n";
		$str .= "\n";
		$str .= "◆　応募したアイデアの情報"."\n";
		$str .= "\n";
		$str .= "アイデアの名称	".$idea_name."\n";
		$str .= "アイデアの公開	 ".($open ? "公開" : "非公開")."\n";
		$str .= "アイデアの概略説明	 ".$abstract."\n";
		$str .= "関連するデータセット	".$related_dataset_ids."\n";
		$str .= "関連するアプリケーション	".$related_application_ids."\n";
		$str .= "投稿したアイデア	".($type == 'url' ? $idea_url : $type)."\n";
		$str .= "\n";
		$str .= "\n";
		$str .= "なお、アイデア作品は非公開時期が設定されており、その期間の間、\n";
		$str .= "応募作品はその公開設定によらず非公開となります。\n";
		$str .= "詳しくは「募集要項」をご確認ください。\n";
		$str .= "http://lod.sfc.keio.ac.jp/challenge2011/outline.html\n";
		$str .= "\n";
		$str .= "\n";
		$str .= "作品が公開された後、登録内容の確認・修正は以下のURLから行えます。";
		$str .= "\n";
		$str .= "http://lod.sfc.keio.ac.jp/challenge2011/show_status.php?id=i".sprintf("%03d", $id)."\n";
		$str .= "修正パスワード： ".$password."\n";
		$str .= "\n";
		$str .= "作品の応募後は、「応募者の情報」「応募したアイデアの情報のうち\n";
		$str .= "アイデアの名称/アイデアの概略説明/関連するデータセット/関連する\n";
		$str .= "アプリケーション」の修正しかできません。\n";
 		$str .= "また応募作品の取り消しはできません。（応募規程7,応募規程9)\n";
 		$str .= "本欄以外での修正、取り消しなどの要望がありましたらlod-challenge@sfc.keio.ac.jp\n";
 		$str .= "までご連絡下さい。\n";
		$str .= "\n";
		$str .= "\n";
		$str .= "なお、作品公開前に登録内容の修正がございましたら、\n";
		$str .= "lod-challenge@sfc.keio.ac.jp までご連絡ください。\n";
		$str .= "\n";
		$str .= "\n";
		$str .= "※このメールにお心当たりがない場合は、lod-challenge@sfc.keio.ac.jp まで\n";
		$str .= "お問い合わせください。\n";

    	return $str;
	}
	
	static function applicationMail($id, $name, $affiliation, $affiliation_anonymous, $email, $email_anonymous, 
		$application_name, $application_url, $abstract, $related_dataset_ids, $related_idea_ids, $right, $password, $license){
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
		$str .= "ご氏名	".$name."\n";
		$str .= "ご所属	".$affiliation." [".($affiliation_anonymous ? "非公開" : "公開")."]\n";
		$str .= "e-mailアドレス	".$email." [".($email_anonymous ? "非公開" : "公開")."]\n";
		$str .= "\n";
		$str .= "◆　応募したアプリケーションの情報\n";
		$str .= "\n";
		$str .= "アプリケーションの名称	".$application_name."\n";
		$str .= "アプリケーションのURL	".$application_url."\n";
		$str .= "アプリケーションの概略説明	 ".$abstract."\n";
		$str .= "関連するデータセット	".$related_dataset_ids."\n";
		$str .= "関連するアイデア	".$related_idea_ids."\n";
		$str .= "アプリケーションの権利指定	".$cr->title($right)."\n";
		if($license){
			$str .= "ライセンス	".$license."\n";
		}
		$str .= "\n";
		$str .= "\n";
		$str .= "登録内容の確認・修正は以下のURLから行えます。\n";
		$str .= "\n";
		$str .= "http://lod.sfc.keio.ac.jp/challenge2011/show_status.php?id=a".sprintf("%03d", $id)."\n";
		$str .= "修正パスワード： ".$password."\n";
		$str .= "\n";
		$str .= "作品の応募後は、「応募者の情報」「応募したアプリケーションの情報のうち\n";
		$str .= "アプリケーションの名称/アプリケーションの概略説明/関連するデータセット/関連する\n";
		$str .= "アイデア」の修正しかできません。\n";
 		$str .= "また応募作品の取り消しはできません。（応募規程7,応募規程9)\n";
 		$str .= "本欄以外での修正、取り消しなどの要望がありましたらlod-challenge@sfc.keio.ac.jp\n";
 		$str .= "までご連絡下さい。\n";
		$str .= "\n";
		$str .= "\n";
		$str .= "※このメールにお心当たりがない場合は、lod-challenge@sfc.keio.ac.jp まで\n";
		$str .= "お問い合わせください。\n";

    	return $str;
	}
}

?>