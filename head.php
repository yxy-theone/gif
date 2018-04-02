<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
date_default_timezone_set('Asia/Shanghai');
define('ROOT_PATH', str_replace("\\", "/", dirname(__FILE__))); // /www/gif
if(!$_SESSION['request_lasttime']){
	$_SESSION['request_lasttime'] = time();
}