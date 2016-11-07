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
		// 自動でPOSTの中身をクォートする(とすると、表示がおかしくなるので非使用)
//		if($_POST){
//			foreach($_POST as $key => $val){
//				$_POST[$key] = mysql_real_escape_string($val, $this->db);  // 
//				$_POST[$key] = htmlspecialchars($val, ENT_QUOTES | ENT_HTML401 , 'UTF-8', false);
//			}
//		}
	}

// SQL文を実行して、結果を配列として返す	
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

// SQL文の実行結果を「生」で返す	
	public function executeQueryRaw($sql){
		$rs = mysql_query($sql, $this->db);
		
		return $rs;
	}
// SQL文を実行する
	public function executeUpdate($sql){
		mysql_query($sql,$this->db);
	}
	
// 文字列をクォートする関数 mysql_real_escape_string()を使用
	public function escapeString($sql) {
		mysql_real_escape_string($sql , $this->db);
		return $sql;
	}

// 文字列の中の「& < > "」と「'」(ENT_QUOTES)をクォートする関数
	public function escapeQuote($sql) {
		htmlspecialchars($sql, ENT_QUOTES, 'UTF-8', false);
//		mysql_real_escape_string($sql, $this->db);
	}


// 直前に実行しクエリーで生成されたIDを得る
	public function getLastInsertId(){
		return mysql_insert_id();
	}

	public function closeDB(){
		mysql_close($this->db);
	}
	
	public static function getInstance(){
		if(is_null(self::$instance)){
			self::$instance = new self;
		}
		
		return self::$instance;
	}
}

?>