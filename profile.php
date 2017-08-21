<?php 
require_once 'core/init.php';

if (!$username = input::get('user')) {
	Redirect::to('index.php');
} else {
	# Output from the url bar
	//echo $username;
	$user = new User($username);
	if (!$user->exists()) {
		Redirect::to(404);
	}else{
		//echo "User Postoji";
		$data = $user->data();
	}

 ?>

 <h3> <?php echo escape($data->username); ?> </h3>
 <p>Full Name: <?php echo escape($data->name); ?> </p>

 <?php 

}

 ?>