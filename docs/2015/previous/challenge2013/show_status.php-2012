<?php
	$id = $_GET['id'];
	
	if(preg_match('/^a[0-9]{3}$/', $id)){
		require("show_application_status.php");
		return;
	} else if(preg_match('/^i[0-9]{3}$/', $id)){
		require("show_idea_status.php");
		return;
	} else if(preg_match('/^d[0-9]{3}$/', $id)){
		require("show_dataset_status.php");
		return;
	} else if(preg_match('/^v[0-9]{3}$/', $id)){
		require("show_visualization_status.php");
		return;
	}
?>
不正なURLです。