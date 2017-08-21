<?php 
class Validation{
	private $_passed = false,
			$_errors = array(),
			$_db = null;

	public function __construct(){
		$this->_db = DB::getInstance();
	}

	public function check($source, $items = array()){
		foreach ($items as $item => $rules) {
			//echo "{$item}<br>";
			foreach ($rules as $rule => $rule_value) {
				# Lista iz $validate 
				//echo "{$item} [ {$rule} ] => {$rule_value} <br>";
				
				# Podaci koji se salju iz forme 
				$value = $source[$item];
				$item = escape($item);
				//echo "Input value [{$item}]: ".$value."<br>";
				
				if ($rule == 'required' && empty($value)) {
					$this->addError("{$item} is required");
				} else if(!empty($value)){
					switch ($rule) {
						case 'min':
							if(strlen($value) < $rule_value){
								$this->addError("{$item} mora da ima minimum {$rule_value} karaktera");
							}
							break;
						case 'max':
							if(strlen($value) > $rule_value){
								$this->addError("{$item} mora da ima maksimum {$rule_value} karaktera");
							}
							break;
						case 'matches':
							if ($value != $source[$rule_value]) {
								$this->addError("{$rule_value} mora da odgovara {$item}");
							}
							break;
						case 'unique':
							$check = $this->_db->get($rule_value, array($item,'=', $value));
							if ($check->count()) {
								$this->addError("{$item} vec postoji");
							}
							break;
						
						default:
							# code...
							break;
					}
				} else {echo " Error in class :".get_class($this)." Line: 25 <br>";}
			}
		}
		if(empty($this->_errors)){
				$this->_passed = true;
		}
		return $this;
	}
	private function addError($error){
		$this->_errors[] = $error;
	}

	public function errors(){
		return $this->_errors;
	}

	public function passed(){
		return $this->_passed;
	}
}	
?>