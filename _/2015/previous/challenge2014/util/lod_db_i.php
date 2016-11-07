<?php
// MySQLiを使用する；PHP 5.5.0 からMySQLが非推奨となったため

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
		
		$this->db = mysqli_connect($this->host, $this->user, $this->passwd);
		mysqli_set_charset($this->db, "utf8"); //クエリの文字コードを設定, PHP 5.2 以降, MySQL 5.0.7以降
		mysqli_select_db($this->db, $this->dbname);
		// 自動でPOSTの中身をクォートする
		if($_POST){
			foreach($_POST as $key => $val){
				$_POST[$key] = mysqli_real_escape_string($this->db, $val);
			}
		}
	}

// SQL文を実行して、結果を配列として返す	
	public function executeQuery($sql){
		$rs = mysqli_query($this->db, $sql);
		
		$retArray = array();
		if($rs){
			while($res = mysqli_fetch_array($rs, MYSQL_ASSOC)){
				$retArray[] = $res;
			};
		}
		
		return $retArray;
	}

// SQL文の実行結果を「生」で返す	
	public function executeQueryRaw($sql){
		$rs = mysqli_query($this->db, $sql);
		
		return $rs;
	}
//
	public function executeUpdate($sql){
		mysqli_query($this->db, $sql);
	}
	
// 文字列をクォートする関数 mysql_real_escape_string()を使用
	public function escapeString($sql) {
		mysqli_real_escape_string($this->db, $sql);
	}

// 直前に実行しクエリーで生成されたIDを得る
	public function getLastInsertId(){
		return mysqli_insert_id($this->db);
	}
// データベースのクローズ
	public function closeDB(){
		mysqli_close($this->db);
	}
//	
	public static function getInstance(){
		if(is_null(self::$instance)){
			self::$instance = new self;
		}
		
		return self::$instance;
	}
}

?>