<?php 
namespace App\Controllers\Backend\User;
use App\Controllers\BaseController;

class User extends BaseController{

	protected $data;

	public function __construct(){
		$this->data = [];
		$this->userService = service('UserService');
	}

	public function profile(){
		$this->data['user'] = $this->userService->getCurrentUser();
		$this->data['title'] = 'Thông tin cá nhân';
		$this->data['module'] = 'user';
		$this->data['template'] = 'backend/user/profile';
		return view('backend/dashboard/layout/home', $this->data);
	}
}
