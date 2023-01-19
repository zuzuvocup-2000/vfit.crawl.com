<?php 
namespace App\Controllers\Backend\Website;
use App\Controllers\BaseController;

class Website extends BaseController{

	protected $data;

	public function __construct(){
		$this->data = [];
		$this->websiteService = service('WebsiteService');
	}

	public function index(){
		$this->data['websiteList'] = $this->websiteService->getListWebsite();
		$this->data['title'] = 'Danh sách Website';
		$this->data['module'] = 'website';
		$this->data['template'] = 'backend/website/website/index';
		return view('backend/dashboard/layout/home', $this->data);
	}
}
