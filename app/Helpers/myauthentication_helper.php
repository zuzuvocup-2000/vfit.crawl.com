<?php 
use App\Models\AutoloadModel;

if (! function_exists('authentication')){
	function authentication(){
		$model = new App\Models\UserModel();
	 	$user = $model->get_user(session()->get('id')['$oid']);
	 	return $user;
		
	}
}

?>

