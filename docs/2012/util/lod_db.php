<?php

class LodDb {
	
	//var $host = "webpubdb.sfc.keio.ac.jp";
	//var $host = "localhost:13306";
	//var $user = "lod_db";
	//var $passwd = "vT7tUQBT";
	//var $dbname = 'lod_db';
	
	// localhostでの設定
	var $host = "localhost";
	var $user = "lod_db";
	var $passwd = "";
	var $dbname = 'lod_db';
	
	var $db = null;
	
	private static $instance = null;
	
	private function __construct() {
		mb_language("uni");
		mb_internal_encoding("utf-8"); //内部文字コードを変更
		
		mb_http_input("auto");
		mb_http_output("utf-8");
		
		$this->db = mysql_connect($this->host, $this->user, $this->passwd);
		mysql_set_charset("utf8", $this->db); //クエリの文字コードを設定, PHP 5.2 以降, MySQL 5.0.7以降
		mysql_select_db($this->dbname, $this->db);
	}
	
	public function executeQuery($sql){
		$rs = mysql_query($sql, $this->db);
		
		$retArray = array();
		if($rs){
			while($res = mysql_fetch_array($rs, MYSQL_ASSOC)){
				$retArray[] = $res;
			};
		}
		
		return $retArray;
	}
	
	public function executeUpdate($sql){
		mysql_query($sql,$this->db);
	}
	
	public function getLastInsertId(){
		return mysql_insert_id();
	}
	
	public static function getInstance(){
		if(is_null(self::$instance)){
			self::$instance = new self;
		}
		
		return self::$instance;
	}
}

?>