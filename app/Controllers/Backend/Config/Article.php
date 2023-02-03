<?php 
namespace App\Controllers\Backend\Config;
use App\Controllers\BaseController;

class Article extends BaseController{

	protected $data;

	public function __construct(){
		$this->data = [];
	}

	public function index(){
		$this->data['title'] = 'Thiết lập bài viết';
		$this->data['module'] = 'config-article';
		$this->data['template'] = 'backend/config/article/index';
		return view('backend/dashboard/layout/home', $this->data);
	}
}
