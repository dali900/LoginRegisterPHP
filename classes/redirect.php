<?php 
class Redirect{
	public static function to($location = null){
		if ($location){
			if(is_numeric($location)){
				switch ($location) {
					case 404:
						header('HTTP/1.0 404 Not Found');
						include 'includes/404.php';
						exit();
						break;

					case 504:
						# code...
						break;
					
					default:
						# code...
						break;
				}
			} else {echo "Error :".get_class($this)."if/switch";}
			header('Location: '.$location);
			exit();
		}
	}
}

 ?>