<?php
	include_once 'po-database.php';
	$tabletime = new PoTable('setting');
	$currentTime = $tabletime->findBy(id_setting, '1');
	$currentTime = $currentTime->current();
	$timezone_set = $currentTime->timezone;

	date_default_timezone_set(''.$timezone_set.'');
?>