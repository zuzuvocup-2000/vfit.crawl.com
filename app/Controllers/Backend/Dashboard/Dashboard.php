<?php 
namespace App\Controllers\Backend\Dashboard;
use App\Controllers\BaseController;

class Dashboard extends BaseController{

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

	public function support(){
		$this->data['title'] = 'Hướng dẫn cài đặt';
		$this->data['module'] = 'support';
		$this->data['template'] = 'backend/dashboard/home/support';
		return view('backend/dashboard/layout/home', $this->data);
	}
}
