<?php 
require_once 'core/init.php';

$user = new User();

if (!$user->isLoggedIn()) {
	//Redirect::to('index.php');
}

if (input::exists()) {
	if (token::check(input::get('token'))) {
		$validate = new Validation();
		$validation = $validate->check($_POST, array(
				'name' => array(
					'required' => true,
					'min' => 2,
					'max' => 20)
		));

		if ($validation->passed()) {
			try {
				$user->update(array(
						'name' => input::get('name')
					));

				Session::flash('home','Updated you details');
				Redirect::to('index.php');

			} catch (Exception $e) {
				die($e->getMessage());
			}
		} else {
			foreach ($validation->errors() as $erro) {
				echo $errors,"<br>";
			}
		}
	}
}

 ?>

<form action="" method="post">
 	<div class="field">
 		<label for="name">Name</label>
 		<input type="text" name="name" id="name" autocomplete="off" value="<?php echo escape($user->data()->name); ?>">

 		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
 		<input type="submit" name="" value="Update">

 	</div> 

 	
 </form>