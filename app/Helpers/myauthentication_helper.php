<?php 
use App\Models\AutoloadModel;

if (! function_exists('authentication')){
	function authentication(){
		$user = session()->get();
	 	return $user;
	}
}

?>

