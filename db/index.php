<?php 
require_once 'db.php';



$user = DB::getInstance()->get('user', array('username','=','alex'));

var_dump($user->count());
//var_dump($user->error());

if($user->error()){
	echo 'Nema rezultata<br>';
}else{
	echo "Rezultat OK!<br>";
}

//$user->pdo();


 ?>

