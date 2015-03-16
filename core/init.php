<?php 
//start session whenever a connection is made
session_start();

$GLOBALS['config'] = array(
//db details
	'mysql' => array(
		'host' => '127.0.0.1',
		'username' => 'root',
		'password' => 'vosswater',
		'db' => 'i7709966'
		),
		'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expiry' => 60400
		),
		//declare session and token vars
		'session' => array(
			'session_name' => 'user',
			'token_name' => 'token'
			)
		);
spl_autoload_register(function($class) {
	require_once 'classes/' . $class . '.php';
});
require_once 'functions/sanitize.php';
?>