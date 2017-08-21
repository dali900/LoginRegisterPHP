<?php 
$GLOBALS['config'] = array(
		'mysql' => array(
			'host' => '127.0.0.1', 
			'username' => 'root', 
			'password' => '', 
			'db' =>'login',
			//'db' =>'testbase', 
			/*'dali' => array('ime' => 'dali')*/ ),
		'remeber' => array(
				'coockie_name' => 'hash',
				'coockie_expiry' => 604800 ),
		'session' => array(
				'session_name' => 'user')

	);
/**/
spl_autoload_register(function($class){
	require_once 'classes/'.$class.'.php';
});



class Config{
	
	public static function get($path = null){
		if($path){
			$config = $GLOBALS['config']; 
			
			//print_r ($config);
			$path = explode('/', $path);
			//print_r($path);

			foreach ($path as $bit) { 
				//print_r($config[$bit]);
				//echo $bit.', ';
				/*Prvi loop da li mysql postoji u confi
				  Drugi loop da li host postoji u mysql*/
				if(isset($config[$bit])){
					/*Uzimamo zadnji bit i njegovu vrednost*/
					$config = $config[$bit]; /* 127.0.0.1 */
				}
			}
			return $config;
		}
		return false;
	}
}


 

class DB{
	private static $_instance = null;
	private $_pdo, 
			$_query, 
			$_error = false, 
			$_results, 
			$_count = 0;
	private function __construct(){
		try{
			$this->_pdo = new PDO ('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'),Config::get('mysql/username'),Config::get('mysql/password'));
			echo "Konetovano<br>";
		} catch (PDOException $e){
			die ($e->getMessage());
		}
	}

	/* Postavljanje instance od DB ukoliko nije kreirana*/
	public static function 	getInstance(){
		if(!isset(self::$_instance)){
			self::$_instance = new DB();
		}
		return self::$_instance;
	}

	public function query($sql, $params = array()){
		/*resetovanje error*/
		$this->_error = false;
		if($this->_query = $this->_pdo->prepare($sql)){
			echo 'Uspesno prepare <br>';
			//echo $params[0]; //test
			
			
					/* x-prvi '?' u prvi query, param = '?' */
					$this->_query->bindValue(1, 'alex');
					
				
			
			if($this->_query->execute()){
				echo "Query uspesno izvrsen<br>";
				$this->_results = $this->fetchAll(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();
				print_r($this->_results);
			} else { $this->_error = true;
					echo "Query ne radi<br>";
					 }

		} //else { print_r($_query->errorInfo()); }
		/* Vracamo ceo object kako bi ocitali error() */
		return $this;
	}

	public function action($action, $table, $where = array()){
		if(count($where)===3){
			$operators = array('=', '<','>','<=','>=');
			$field 		= $where[0];
			$operator	= $where[1];
			$value 		= $where[2];
			
			if(in_array($operator, $operators)){
				$sql = "{$action} * FROM {$table} WHERE {$field} {$operator} ?";
				if(!$this->query($sql, array($value))->error()) {
					return $this->query($sql, array($value));
				} 
			}
		}
		return $this;
	}

	public function get($table, $where){
		return $this->action('SELECT *', $table, $where);
	}

	public function delete($table, $where){
		return $this->action("DELETE", $table, $where);
	}



	public function error(){
		return $this->_error;
	}	

	public function count(){
		return $this->_count;
	}

	
}



 ?>