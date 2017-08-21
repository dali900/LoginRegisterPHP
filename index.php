<?php 
require_once 'core/init.php';

echo Config::get('mysql/host');

//var_dump(Config::get('x/mysql'));

/*$users = DB::getInstance()->query('SELECT username FROM user');
if($users->count()){
	foreach ($users as $user) {
		echo $user->username;
	}
}*/

/*$user = DB::getInstance()->query("SELECT * FROM user WHERE username = ?", array('alex'));
if($user->error()){
	echo 'No user<br>';
}else{
	echo "OK!<br>";
}*/
/*
$where = array('username','=','alex');
$operators = array('=', '<','>','<=','>=');
			$field 		= $where[0];
			$operator	= $where[1];
			$value 		= $where[2];

$user = DB::getInstance()->query("SELECT * FROM user WHERE {$field} {$operator} ?", array('alex'));
*/
$user = DB::getInstance();
/*$user->get('user', array('username','=','alex'));

var_dump($user->count());
var_dump($user->error());

# Provera greske #
/*if($user->error()){
	echo 'Nema rezultata<br>';
}else{
	echo "Rezultat OK!<br>";
}*/

# Prikaz podataka #
/*$user->query("SELECT * FROM user");
if(!$user->count()){
	echo 'Nema rezultata<br>';
}else{
	foreach ($user->results() as $user) {
		echo $user->username."<br>";
	}
}*/

# Unos novih podataka #
/*$user->insert('user', array(
		'username' => 'Dale',
		'password' => 'password',
		'salt' => 'salt'
	));*/

# Update podataka #
/*$user->update('user', 3, array(
		'username' => 'Dale',
		'password' => 'newpassword',
		'name' => 'Dale Barett',
		'salt' => 'salt'
	));*/

# Session poruka #
/*if (Session::exists('home')) {
	# Parametar za exists() mora isto 'uspe' #
	//echo Session::flash('uspeh');	
	echo '<p>'.Session::flash('home').'</p>';
}
echo "User ID: "Session::get(config::get('session/session_name'));*/

# If the user is loged in
$user = new User();
//echo $user->data()->username;
#Cheks if user logged in
if ($user->isLoggedIn()) {
	//echo "Loged In";
?>
<p>Hello <a href="profile.php?user=<?php echo escape($user->data()->username); ?>"> <?php echo escape($user->data()->username); ?></a></p>

<ul>
	<li><a href="logout.php">Log Out</a></li>
	<li><a href="update.php">Update</a></li>
	<li><a href="changepassword.php">Change password</a></li>
</ul>

<?php 
	if ($user->hasPermission('admin')) {
		echo "Imate ADMIN<br>";
	}

} else {	
	echo '<p>You need to <a href="login.php">log in</a> for <a href="register.php.php">register</a></p>';
}


 ?>