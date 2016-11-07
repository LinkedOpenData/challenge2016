<?php

class Copyright {
	var $info = array(
		"public" => array(
			"image" => "image/cc_licence/public.png",
			"title" => "パブリックドメイン",
			"description" => "パブリックドメインとして一切の権利を放棄する"
		),
		"by" => array(
			"image" => "image/cc_licence/by.png",
			"title" => "表示",
			"description" => "原作者のクレジット（氏名、作品タイトルとURL）を表示することを守れば、改変はもちろん、営利目的での二次利用も許可される最も自由度の高いCCライセンス。"
		),
		"by-sa" => array(
			"image" => "image/cc_licence/by-sa.png",
			"title" => "表示—継承",
			"description" => "原作者のクレジット（氏名、作品タイトルとURL）を表示し、改変した場合には元の作品と同じCCライセンス（このライセンス）で公開することを守れば、営利目的での二次利用も許可されるCCライセンス。"
		),
		"by-nd" => array(
			"image" => "image/cc_licence/by-nd.png",
			"title" => "表示—改変禁止",
			"description" => "原作者のクレジット（氏名、作品タイトルとURL）を表示し、かつ元の作品を改変しない条件で、営利目的での利用（転載、コピー、共有）が行えるCCライセンス。"
		),
		"by-nc" => array(
			"image" => "image/cc_licence/by-nc.png",
			"title" => "表示—非営利",
			"description" => "原作者のクレジット（氏名、作品タイトルとURL）を表示し、かつ非営利目的であれば、改変したり再配布したりすることができるCCライセンス。"
		),
		"by-nc-sa" => array(
			"image" => "image/cc_licence/by-nc-sa.png",
			"title" => "表示—非営利—継承",
			"description" => "原作者のクレジット（氏名、作品タイトルとURL）を表示し、かつ非営利目的に限り、また改変を行った際には元の作品と同じ組み合わせのCCライセンスで公開することを守れば、改変したり再配布したりすることができるCCライセンス。"
		),
		"by-nc-nd" => array(
			"image" => "image/cc_licence/by-nc-nd.png",
			"title" => "表示—非営利—改変禁止",
			"description" => "原作者のクレジット（氏名、作品タイトルとURL）を表示し、かつ非営利目的であり、そして元の作品を改変しないことを守れば、作品を自由に再配布できるCCライセンス。"
		),
		"copyright" => array(
			"image" => "image/cc_licence/copyright.png",
			"title" => "全ての権利の主張",
			"description" => "作品の著作権は応募者に帰属し、いかなる修正、変更、利用も応募者の許可なくしてはできない。"
		),
	);
	
	private static $instance = null;
	
	private function __construct() {
	}
	
	public function image($name){
		return $this->info[$name]["image"];
	}
	
	public function title($name){
		return $this->info[$name]["title"];
	}
	
	public function description($name){
		return $this->info[$name]["description"];
	}
	
	public static function getInstance(){
		if(is_null(self::$instance)){
			self::$instance = new self;
		}
		
		return self::$instance;
	}
}
?>