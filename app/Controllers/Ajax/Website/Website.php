<?php 
namespace App\Controllers\Ajax\Website;
use App\Controllers\BaseController;

class Website extends BaseController{

	protected $data;

	public function __construct(){
		$this->data = [];
		$this->websiteService = service('WebsiteService');
	}

	public function delete($id){
		$this->data['website'] = $this->sendAPI(API_WEBSITE_GET_BY_ID.'/'.$id,'get');
		if(isset($this->data['website']['data']) && is_array($this->data['website']['data']) && count($this->data['website']['data'])){
			$response = $this->sendAPI(API_WEBSITE_CREATE.'/'.$this->data['website']['data']['_id'],'delete');
			echo json_encode($response);die();
		}
	}

	// public function crawl_sitemap(){
	// 	$this->data['website'] = $this->sendAPI(API_CRAWL_SITEMAP,'post');
	// 	echo json_encode($this->data['website']);die();
	// }

	// public function crawl_normal(){
	// 	$this->data['website'] = $this->sendAPI(API_CRAWL_NORMAL,'post');
	// 	echo json_encode($this->data['website']);die();
	// }

	// public function crawl_javascript(){
	// 	$this->data['website'] = $this->sendAPI(API_CRAWL_JAVASCRIPT,'post');
	// 	echo json_encode($this->data['website']);die();
	// }
}
