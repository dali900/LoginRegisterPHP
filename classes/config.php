<?php 
class Config{
	
	public static function get($path = null){
		if($path){
			$config = $GLOBALS['config']; 
			
			//print_r ($config);
			$path = explode('/', $path);
			//print_r($path);

			foreach ($path as $bit) { 
				//print_r($config[$bit]);
				printr($bit);
				//echo $bit.', ';
				# Prvi loop da li mysql postoji u confi
				#  Drugi loop da li host postoji u mysql 
				if(isset($config[$bit])){
					# Uzimamo zadnji bit i njegovu vrednost
					$config = $config[$bit]; # 127.0.0.1 #
				} //print_r($config);
			}
			return $config;
		}
		return false;
	}
}


 ?>