<?php 
namespace App\Controllers\Ajax\User;
use App\Controllers\BaseController;

class User extends BaseController{

	protected $data;

	public function __construct(){
		$this->data = [];
	}

	public function delete($id){
		$this->data['user'] = $this->sendAPI(API_USER_GET_BY_ID.'/'.$id,'get');
		$user = authentication();
		if(isset($this->data['user']['data']) && is_array($this->data['user']['data']) && count($this->data['user']['data'])){
			$response = $this->sendAPI(API_GET_CURRENT_USER_BY_EMAIL.$this->data['user']['data']['_id'],'delete');
			$response['reload'] = false;
			if(isset($response['statusCode']) && $response['statusCode'] == 200){
				if($user['email'] == $this->data['user']['data']['email']) {
					$session = session();
	        		$session->destroy();
	        		$response['reload'] = true;
				}
			}
			echo json_encode($response);die();
		}
	}
}
