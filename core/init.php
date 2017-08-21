<?php 
session_start();
include "helpers.php";

$GLOBALS['config'] = array(
		'mysql' => array(
			'host' => '127.0.0.1', 
			'username' => 'root', 
			'password' => '', 
			'db' =>'login',
			//'db' =>'testbase', 
			/*'dali' => array('ime' => 'dali')*/ ),
		'remember' => array(
				'cookie_name' => 'hash',
				'cookie_expiry' => 604800 ),
		'session' => array(
				'session_name' => 'user',
				'token_name' => 'token')
	);
/**/
spl_autoload_register(function($class){
	require_once 'classes/'.$class.'.php';
});
require_once 'functions/sanitaze.php';

if (Cookie::exists(config::get('remember/cookie_name')) && !Session::exists(config::get('session/session_name'))) {
	//echo "User asked to be remembered<br>";
	# Storing the cookie value
	$hash = Cookie::get(config::get('remember/cookie_name'));
	$hashCheck = DB::getInstance()->get('users_session', array('hash','=',$hash));

	if ($hashCheck->count()) {
		//echo "Hash matches<br>";
		$user = new User($hashCheck->first()->user_id);
		$user->login();
	}
}
 ?>
