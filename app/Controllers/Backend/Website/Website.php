<?php 
namespace App\Controllers\Backend\Website;
use App\Controllers\BaseController;

class Website extends BaseController{

	protected $data;

	public function __construct(){
		$this->data = [];
	}

	public function index(){
		
		$this->data['template'] = 'backend/website/website/index';
		return view('backend/dashboard/layout/home', $this->data);
	}
}
