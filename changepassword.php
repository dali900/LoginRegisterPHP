<?php 
require_once 'core/init.php';

$user = new User();
if (!$user->isLoggedIn()) {
	Redirect::to('index.php');

}

if (input::exists()) {
	if (Token::check(input::get('token'))) {
		//echo "Token OK";
		$validate = new Validation();
		$validation = $validate->check($_POST, array(
				'password_current' => array(
					'required' => true,
					'min' => 6
					),
				'password_new' => array(
					'required' => true,
					'min' => 6
					),
				'password_new_again' => array(
					'required' => true,
					'min' => 6,
					'matches' => 'password_new'
					)
			));
		if ($validation->passed()) {
			# Change password
			if (Hash::make(input::get('password_current'), $user->data()->salt) !== $user->data()->password) {
				echo 'Trenutni pasword je pogresan';
			} else {
				//echo "Pass is ok to be updated";
				$salt = Hash::salt(32);
				$user->update(array(
					'password' => Hash::make(input::get('password_new'), $salt),
					'salt' => $salt
				));
				session::flash('home', 'Vasa sifra je promenjena');
				Redirect::to('index.php');
			}
		} else {
			foreach ($validation->errors() as $error) {
				echo $error, '<br>';
			}
		}
	}
}

 ?>

 <form action="" method="post">
	<div class="field">
		<label for="password_current">Current password</label>
		<input type="password" name="password_current" id="password_current">
	</div>
	<div class="field">
		<label for="password_new">New Password</label>
		<input type="password" name="password_new" id="password_new" >
	</div>
	<div class="field">
		<label for="password_new_againe">password_new_againe</label>
		<input type="password" name="password_new_again" id="password_new_againe" >
	</div>
	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	<input type="submit" name="sub" value="Change">

</form>
<a href="index.php"><button>Cancel</button></a>