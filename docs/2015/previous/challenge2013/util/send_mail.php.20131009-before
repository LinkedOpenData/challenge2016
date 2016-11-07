<?php

class SendMail {
	
	var $from = "lod-challenge@sfc.keio.ac.jp";
	var $cc = "suzuki@ic.kanagawa-it.ac.jp";
	
	
	private static $instance = null;
	
	private function __construct(){
		
	}
	
	function send($mailto, $subject, $content){
		mb_send_mail($mailto,$subject,$content,"From: ".$this->from."\nCc: ".$this->cc);
	}
	
	public static function getInstance(){
		if(is_null(self::$instance)){
			self::$instance = new self;
		}
		
		return self::$instance;
	}
}

?>
