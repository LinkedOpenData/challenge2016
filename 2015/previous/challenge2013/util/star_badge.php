<?php

class StarBadge {
	var $info = array(
		"0" => array(
			"image" => "image/5star/data-badge-0.png",
			"title" => "no star Web data",
			"description" => "Web data (whatever format) without an open license"
		),
		"1" => array(
			"image" => "image/5star/data-badge-1.png",
			"title" => "one star open Web data",
			"description" => "make your stuff available on the Web (whatever format) under an open license"
		),
		"2" => array(
			"image" => "image/5star/data-badge-2.png",
			"title" => "two star open Web data",
			"description" => "make it available as structured data (e.g., Excel instead of image scan of a table) so that it can be reused"
		),
		"3" => array(
			"image" => "image/5star/data-badge-3.png",
			"title" => "three star open Web data",
			"description" => "use non-proprietary, open formats (e.g., CSV instead of Excel)"
		),
		"4" => array(
			"image" => "image/5star/data-badge-4.png",
			"title" => "four star open Web data",
			"description" => "use URIs to identify things, so that people can point at your stuff and serve RDF from it"
		),
		"5" => array(
			"image" => "image/5star/data-badge-5.png",
			"title" => "five star open Web data",
			"description" => "link your data to other data to provide context"
		)
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