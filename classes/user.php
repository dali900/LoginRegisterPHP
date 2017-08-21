<?php 
class User{
	private $_db,
			$_data,
			$_sessionName,
			$_cookieName,
			$_isLoggedIn;

	public function __construct($user = null){
		$this->_db = DB::getInstance();

		$this->_sessionName = config::get('session/session_name');
		$this->_cookieName = config::get('remember/cookie_name');

		#Checking if the user is loged in
		if (!$user) {
			if (Session::exists($this->_sessionName)) {
				$user = Session::get($this->_sessionName);

				if ($this->find($user)) {
					$this->_isLoggedIn = true;
				} else {
					echo " Error in class :".get_class($this)." /construct/fi/if/if";
				}
			}
		} else {
			$this->find($user);
		}
	}

	public function update($fields = array(), $id=null ){

		if (!$id && $this->isLoggedIn()) {
			$id = $this->data()->id;
		}

		if (!$this->_db->update('user', $id, $fields)) {
			throw new Exception('Doslo je do greske tokom update');
		}
	}

	# Kreiranje novog korisnika 
	public function create($fields = array()){
		if (!$this->_db->insert('user', $fields)) {
			throw new Exception('Problem u kreiranju naloga');
		}
	}

	public function find($user = null){
		if ($user) {
			$field = (is_numeric($user)) ? 'id' : 'username';
			# Ukoliko je unet username $field, query ce traziti po username
			# Ako smo uneli broj (id) query ce traziti usera po id
			$data = $this->_db->get('user', array($field, '=', $user));
			# $data je object koji u sebi sadrzi rezultate querya iz DB
			//print_r($data);

			if ($data->count()) {
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function login($username = null, $password = null, $remember = false){

		if (!$username && !$password && $this->exists()) {
			Session::put($this->_sessionName, $this->data()->id);
		}else{

		$user = $this->find($username);

		if ($user) {
			if ($this->data()->password === Hash::make($password, $this->data()->salt)) {
				//echo "OK, password matches, novi password i hash se poklapa sa onim iz baze";
				# Pokretanje session, sa user ID
				Session::put($this->_sessionName, $this->data()->id);

				if ($remember) {
					# Checks if the user exists in DB 
					$hash = Hash::unique();
					$hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));
					echo "DB check passed ok<br>";
					# If not we insert
					if (!$hashCheck->count()) {
						$this->_db->insert('users_session', array(
								'user_id' => $this->data()->id,
								'hash' => $hash
							));
						echo "DB insert passed ok<br>";
					} else {
						$hash = $hashCheck->first()->hash;
					}

					Cookie::put($this->_cookieName, $hash, config::get('remember/cookie_expiry'));
				} else{echo "Problem u ".get_class($this);}

				return true;
			} else {echo " Error in class :".get_class($this)." function: login, Line: 71 <br> (password cant match hash or username incorect)<br>";}
		}else {echo " Error in class :".get_class($this)." function: login, Line:70 ";}
		# Provera podataka o useru koji se ulogovao
		//print_r($this->_data);
		#Debagovanje, problem, vise istih passworda u 
		#bazi sa razlicitim hashovanjem onemogucavaju
		#kreiranje novog hasha za isti password i da 
		#bude isti kao vec kreirani hash u bazi
		
		/*echo "<br>Pass HASH - ".$this->data()->salt." [".$this->data()->password."]<br>";
		echo "<br>Pssword { ".$password." }<br><br><br>//////////";
		    echo "<br/>New HASH - ".Hash::make($password,$this->data()->salt);
     		echo "<br/>Database hash - ".Hash::make($this->data()->password, $this->data()->salt);*/
		}
		return false;
	}

	public function hasPermission($key){
		# Selectujemo kolonu groups ulugovanog usera i trazimp jednakost 
		# sa tebelom group kolona id, (user3) user/gropus = group/id
		//print_r($this->data());
		$group = $this->_db->get('groups', array('id', '=', $this->data()->groups));
		//print_r($group->first());
		//print_r($this->data()->groups);

		if ($group->count()) {
			# Rezultat selekcije permissions iz tabele groups 
			# true - konverujemo u array umesto obj
			$permissions = json_decode($group->first()->permissions, true);
			//print_r($permissions);
			# Nece '=== true' moze samo sa 2 '=='
			if($permissions[$key] === 1) {
				return true;
			}
		}
		//return false;
	}

	public function exists(){
		return (!empty($this->_data)) ? true : false;
	}

	public function logout(){
		$this->_db->delete('users_session', array('user_id', '=', $this->data()->id));

		Session::delete($this->_sessionName);
		Cookie::delete($this->_cookieName);

	}
	# Podaci samo iz tabele user
	public function data(){
		return $this->_data;
	}

	public function isLoggedIn(){
		return $this->_isLoggedIn;
	}
}


 ?>