<?php 
namespace App\Controllers\Backend\Config;
use App\Controllers\BaseController;

class Catalogue extends BaseController{

	protected $data;

	public function __construct(){
		$this->data = [];
	}

	public function index(){
		$this->data['title'] = 'Trang chủ';
		$this->data['module'] = 'home';
		$this->data['template'] = 'backend/dashboard/home/index';
		return view('backend/dashboard/layout/home', $this->data);
	}
}
