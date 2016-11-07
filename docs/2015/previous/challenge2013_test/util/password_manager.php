<?php

class PasswordManager {
	
	private static $instance = null;
	
	
	private function __construct() {
	}
	
	public function password($password) {
		return sha1($password);
	}
	
	public function verify($password, $hash){
		return sha1($password) == $hash;
	}
	
	public function randomString($length){
		$list = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		mt_srand(time());
		for($i=0, $chars=""; $i < $length; $i++){
		  $chars .= $list{mt_rand(0, strlen($list) - 1)};
		}
		return $chars;
	}
	
	public static function getInstance(){
		if(is_null(self::$instance)){
			self::$instance = new self;
		}
		
		return self::$instance;
	}
}

?>