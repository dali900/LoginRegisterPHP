<?php 
require_once 'core/init.php';
if (input::exists()) {
	if (Token::check(input::get('token'))) {
		$validate = new Validation();
		$validation = $validate->check($_POST, array(
				'username' => array('required' => true),
				'password' => array('required' => true)
			));
		if ($validation->passed()) {
			$user = new User();

			# Remember
			$remember = (input::get('remember') === 'on') ? true : false;

			$login = $user->login(Input::get('username'), Input::get('password'), $remember);

			if ($login) {
				//echo "Uspeno login";
				# For debugging comment out redirect
				Redirect::to('index.php');
			} else{echo "Neuspesan login";}
		} else {
			foreach ($validation->errors() as $error) {
				echo $error, "<br>";
			}
		}
	}
}
/* $db = DB::getInstance();
$dbq = $db->queryD("SELECT hash FROM users_session");*/



 ?>

 <form action="" method="post">
 	<div class="field">
 		<label for="username">Username</label>
 		<input type="text" name="username" id="username" autocomplete="off">
 	</div>

 	<div class="field">
 		<label for="password">Password</label>
 		<input type="password" name="password" id="password" autocomplete="off">
 	</div>	

 	<div class="field">
 		<label for="remember">
 			<input type="checkbox" name="remember" id="remember"> Remember me
 		</label>
 	</div>

 	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
 	<input type="submit" name="" value="Log in">
 </form>