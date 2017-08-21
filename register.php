<?php 
require_once 'core/init.php';
/* token check */
//var_dump(Token::check(input::get('token')));

if (input::exists()) {
	if (Token::check(input::get('token'))) {
		
		//echo "Data is submitted";
		//echo input::get('username');
		$validate = new Validation();
		$validation = $validate->check($_POST, array(
				'username' => array(
						'required' => true,
						'min' => 2,
						'max' => 20,
						'unique' => 'user'
					),
				'password' => array(
						'required' => true,
						'min' => 6
					),
				'password_again' => array(
						'required' => true,
						'matches' => 'password'
					),
				'name' => array(
						'required' => true,
						'min' => 2,
						'max' => 50
					)
			));
		if($validate->passed()){
			//echo "Passed";
			$user = new User();
			/* Hashovan password */
			$salt = Hash::salt(32);
			
			try {
				$user->create(array(
						'username' => input::get('username'),
						'password' => Hash::make(input::get('password'), $salt),
						'salt' => $salt,
						'name' => input::get('name'),
						'joined' => date('d-m-Y H:i:s'),
						'groups' => 1
					));
				Session::flash('home', 'Uspesno ste registrovani');
				Redirect::to('index.php');
			} catch (Exception $e) {
				die($e->getMessage());
			}
			
			/* Sassion poruka */
			#Session::flash('uspeh', 'Registrovani uspesno');
			#header('Location: index.php');
		} else {
			//print_r($validate->errors()); echo '<br>';
			foreach ($validate->errors() as $error) {
				echo $error, '<br>';
			}
		}
	}
} else {echo "Press Register Button";}



 ?>

<form action="" method="post">
	<div class="filed">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" value="<?php echo escape(input::get('username')); ?>" autocomplete="off">
	</div>
	<div class="password">
		<label for="password">Password</label>
		<input type="password" name="password" id="password" >
	</div>
	<div class="password_again">
		<label for="password_again">Enter again Password</label>
		<input type="password" name="password_again" id="password_again" >
	</div>
	<div class="field">
		<label for="name">Enter Name</label>
		<input type="text" name="name" value="<?php echo escape(input::get('name')); ?>" id="name" >
	</div>
	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	<input type="submit" name="sub" value="Register">

</form>
