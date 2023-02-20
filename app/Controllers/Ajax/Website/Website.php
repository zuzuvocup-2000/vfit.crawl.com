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

	public function crawl_sitemap(){
		$response = $this->sendAPI(API_CRAWL_SITEMAP,'post');
		pre($response);
	}

	public function crawl_normal(){
		$response = $this->sendAPI(API_CRAWL_NORMAL,'post');
		pre($response);
	}

	public function crawl_sitemap_pending(){
		$response = $this->sendAPI(API_CRAWL_SITEMAP_PENDING,'post');
		pre($response);
	}

	public function chunk_site(){
		$response = $this->sendAPI(API_CHUNK_SITE,'post');
		pre($response);
	}

	public function chunk_article(){
		$response = $this->sendAPI(API_CHUNK_ARTICLE,'post');
		pre($response);
	}

	public function crawl_data(){
		$id = $this->request->getPost('id');
		$response = $this->sendAPI(API_CRAWL_DATA.'/'.$id,'post');
		pre($response);
	}

	public function statistic(){
		$id = $this->request->getPost('id');
		$response = $this->sendAPI(API_STATISTIC_ARTICLE.'/'.$id,'post');
		pre($response);
	}

	public function result(){
		$response = $this->sendAPI(API_START_RESULT,'post');
		pre($response);
	}
}
