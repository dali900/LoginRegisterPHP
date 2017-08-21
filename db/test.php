<?php 
/*$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$conn = new mysqli('localhost', 'root', '', 'login');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name='alex';

if($stmt = $conn->prepare("SELECT * FROM user WHERE username = ?")){
	$stmt->bindValue(1, 'Alex');
	if($stmt->execute()){
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
	    echo $row['username'];
		}
	}
	
}


if($stmt->execute()){
	echo "OK";
}else {
	echo "NO";
}

/*
$stmt->close();
$conn->close();
*/
$conn = null;

/*
$calories = 150;
$colour = 'red';



$sth = $dbh->prepare('SELECT name, colour, calories
    FROM fruit
    WHERE calories < ? AND colour = ?');
$sth->bindValue(1, $calories, PDO::PARAM_INT);
$sth->bindValue(2, $colour, PDO::PARAM_STR);
$sth->execute();

*/

class db {
	private $_pdo, 
			$_query, 
			$_error = false, 
			$_results, 
			$_count = 0,
			$servername = "localhost",
			$username = "root",
			$password = "",
			$dbname = "login";

	 function __construct(){
		try{
			$this->_pdo = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
		    echo "<br>Konetovano<br>";
		    
		}
		catch (PDOException $e){
			die ($e->getMessage());
		}
	}

	public function get($value){
		
		$sql = "SELECT * FROM user WHERE username = ?";
		return $this->query($sql, $value);
	}

	public function query($sql, $value){
		/*resetovanje error*/
		$this->_error = false;
		if($this->_query = $this->_pdo->prepare($sql)){
			echo 'Uspesno prepare <br>';
			//echo $params[0]; //test
			
			
					/* x-prvi '?' u prvi query, param = '?' */
					$this->_query->bindValue(1, $value);
					
				
			
			if($this->_query->execute()){
				echo "Query uspesno izvrsen<br>";
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();
				foreach ($this->_results as $value) {
					echo $value->name;
				}
				//$this->_count = $this->_query->rowCount();
				echo "<pre>"; print_r($this->_results); echo "</pre>";
			} else { $this->_error = true;
					echo "Query ne radi<br>";
					 }

		} //else { print_r($_query->errorInfo()); }
		/* Vracamo ceo object kako bi ocitali error() */
		return $this;
	}
}

$db = new db();
$db->get('dali');

 ?>