<?php 
class DB{
	private static $_instance = null;
	private $_pdo, 
			$_query, 
			$_error = false, 
			$_results,
			$_resultsD,
			$_resultsD2, 
			$_count = 0,
			$_queryD;
	private function __construct(){
		try{
			$this->_pdo = new PDO ('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'),Config::get('mysql/username'),Config::get('mysql/password'));
			echo "Konetovano<br>";
		} catch (PDOException $e){
			die ($e->getMessage());
		}
	}

	# Postavljanje instance od DB ukoliko nije kreirana
	public static function 	getInstance(){
		if(!isset(self::$_instance)){
			self::$_instance = new DB();
		}
		return self::$_instance;
	}

	public function query($sql, $params = array()){
		//echo $sql;
		# resetovanje error
		$this->_error = false;
		if($this->_query = $this->_pdo->prepare($sql)){
			echo 'Uspesno prepare <br>';
			//echo $params[0],'<br>'; //test
			$x=1;
			if (count($params)){
				# Radi provere postojanja parametra #
				//echo $this->_count=count($params),'<br>';
				foreach ($params as $param) {
					/* x-prvi '?' u prvi query, param = '?' */
					//echo $param, "<br>";
					$this->_query->bindValue($x, $param);
					$x++;
				}
				# Provera SQL query-a
			} //echo "PROVERA sql-a: ".$sql,'<br>';
			if($this->_query->execute()){
				echo "Query uspesno izvrsen (DB)<br>";
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();
				# rezultat query-a #
				/*foreach ($this->_results as $value) {
					echo $value->name;
				}*/
			} else { $this->_error = true;
					echo "Query ne radi(DB)<br>";
					 }

		} //else { print_r($_query->errorInfo()); }
		# Vracamo ceo object kako bi ocitali error() #
		return $this;
	}

	# OBJECT AND ASSOC array QUERY OUTPUT #
	public function queryD($sql){
		$kolona = explode(" ", $sql);
		$this->_queryD = $this->_pdo->query($sql);
		//$this->_query->execute();
		$this->_resultsD = $this->_queryD->fetchAll(PDO::FETCH_OBJ);

		# ASSOC
		/*foreach ($this->_resultsD as $value) {
			echo strlen($value[$kolona[1]]), "<br>";
		}*/

		#OBJ
		foreach ($this->_resultsD as $value) {
			echo $value->$kolona[1], "<br>";
			echo strlen($value->$kolona[1]), "<br>";

		}
		return $this;
	}

	public function action($action, $table, $where = array()){
		if(count($where)===3){
			$operators = array('=', '<','>','<=','>=');
			$field 		= $where[0];
			$operator	= $where[1];
			$value 		= $where[2];
			
			if(in_array($operator, $operators)){
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
				if(!$this->query($sql, array($value))->error()) {
					return $this;
				} 
			}
		}
		return $this;
	}

	public function get($table, $where){
		return $this->action("SELECT * ", $table, $where);
	}

	public function delete($table, $where){
		return $this->action("DELETE", $table, $where);
	}
	public function insert($table, $fields = array()){
		if(count($fields)){
			$keys = array_keys($fields);
			$values = '';
			$x=1;

			foreach ($fields as $field) {
				$values .= "?";
				if($x < count($fields)){
					$values .= ', ';
				}
				$x++;
			}
			# Provera za values #
			//die($values);

			$sql = "INSERT INTO {$table} (`".implode('`, `',$keys)."`) VALUES ({$values})";
			if(!$this->query($sql, $fields)->error()){
				return true;
			}
			# Konacni sql #
			echo $sql;
		}
		return false;
	}
	public function update($table, $id, $fields){
		$set = '';
		$x = 1;

		foreach ($fields as $name => $value) {
			$set .= "{$name} = ?";
			if($x < count($fields)){
				$set .= ', ';
			}
			$x++;
		}
		# Provera unetih kolona za update #
		//die($set);

		$sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
		# Konacni sql #
		//echo $sql;

		if (!$this->query($sql, $fields)->error()) {
			return true;
		}
		return false;
	}
	public function results(){
		return $this->_results;
	}
	public function first(){
		return $this->_results[0];
	}

	public function error(){
		return $this->_error;
	}	

	public function count(){
		return $this->_count;
	}

	
}



 ?>