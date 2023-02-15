<?php 
namespace App\Controllers\Backend\Config;
use App\Controllers\BaseController;

class Catalogue extends BaseController{

	protected $data;

	public function __construct(){
		$this->data = [];
		$this->configCatalogueService = service('ConfigCatalogueService');
	}

	public function index($id){
		try {
		    $this->data['website'] = $this->sendAPI(API_WEBSITE_GET_BY_ID.'/'.$id,'get');
			$this->data['configCatalogueList'] = $this->configCatalogueService->getListConfigCatalogue($id);
			$this->data['title'] = 'Danh sách thiết lập nhóm bài viết';
			$this->data['module'] = 'catalogue';
			$this->data['template'] = 'backend/config/catalogue/index';
			return view('backend/dashboard/layout/home', $this->data);
		} catch (\Exception $e) {
		    echo $e->getMessage();
		}
	}

	public function create($id){
		try {
			$this->data['website'] = $this->sendAPI(API_WEBSITE_GET_BY_ID.'/'.$id,'get');
			if($this->request->getMethod() == 'post'){
				$session = session();
				$validate = $this->validation('create');
				if ($this->validate($validate['validate'], $validate['errorValidate'])){
					$create = $this->configCatalogueService->storeConfigCatalogue($this->request, $id);
	        		$response = $this->sendAPI(API_CONFIG_CATALOGUE_CREATE,'post', $create);
	        		if(isset($response['statusCode']) && $response['statusCode'] == 200){
	        			$session->setFlashdata('message-success', 'Thêm mới thiết lập nhóm bài viết thành công!');
	        			return redirect()->to(BASE_URL.'config/catalogue/index/'.$id);
	        		}else{
	        			$session->setFlashdata('message-success', 'Có lỗi xảy ra xin vui lòng thử lại!');
	        			return redirect()->to(BASE_URL.'config/catalogue/index/'.$id);
	        		}
				}else{
		        	$this->data['validate'] = $this->validator->listErrors();
		        }
			}

			$this->data['title'] = 'Thêm mới thiết lập nhóm bài viết cho website: '.$this->data['website']['data']['url'];
			$this->data['module'] = 'catalogue';
			$this->data['template'] = 'backend/config/catalogue/store';
			return view('backend/dashboard/layout/home', $this->data);
		} catch (\Exception $e) {
		    echo $e->getMessage();
		}
	}

	public function update($siteId = '', $id = ''){
		try {
			$this->data['website'] = $this->sendAPI(API_WEBSITE_GET_BY_ID.'/'.$siteId,'get');
			$this->data['catalogue'] = $this->sendAPI(API_CONFIG_CATALOGUE_GET_BY_ID.'/'.$id,'get');
			if($this->request->getMethod() == 'post'){
				$validate = $this->validation('update');
				$session = session();
				if ($this->validate($validate['validate'], $validate['errorValidate'])){
					$update = $this->configCatalogueService->storeConfigCatalogue($this->request, $siteId);
	        		$response = $this->sendAPI(API_CONFIG_CATALOGUE_UPDATE.'/'.$id,'put', $update);
	        		if(isset($response['statusCode']) && $response['statusCode'] == 200){
	        			$session->setFlashdata('message-success', 'Cập nhật thiết lập nhóm bài viết thành công!');
	        			return redirect()->to(BASE_URL.'config/catalogue/index/'.$siteId);
	        		}else{
	        			$session->setFlashdata('message-danger', 'Có lỗi xảy ra xin vui lòng thử lại!');
	        			return redirect()->to(BASE_URL.'config/catalogue/index/'.$siteId);
	        		}
				}else{
		        	$this->data['validate'] = $this->validator->listErrors();
		        }
			}
			$this->data['title'] = 'Cập nhật thiết lập nhóm bài viết cho website: '.$this->data['website']['data']['url'];
			$this->data['module'] = 'catalogue';
			$this->data['template'] = 'backend/config/catalogue/store';
			return view('backend/dashboard/layout/home', $this->data);
		} catch (\Exception $e) {
		    echo $e->getMessage();
		}
	}


   	public function delete($id){
      	try{
         	$this->data['catalogue'] = $this->sendAPI(API_CONFIG_CATALOGUE_GET_BY_ID.'/'.$id,'get');
	         	if(isset($this->data['catalogue']['data']) && is_array($this->data['catalogue']['data']) && count($this->data['catalogue']['data'])){
	            $response = $this->sendAPI(API_CONFIG_CATALOGUE_UPDATE.'/'.$this->data['catalogue']['data']['_id'],'delete');
	            echo json_encode($response);die();
     	}
      	}catch(\Exception $e ){
         	echo $e->getMessage();die();
      	}
   	}

	private function validation($method = ''){
		$validate = [
			'selector' => 'required',
			'dataType' => 'required',
			'group' => 'required',
		];
		$errorValidate = [
			'selector' => [
				'required' => 'Bạn cần phải nhập bộ chọn HTML!',
			],
			'dataType' => [
				'required' => 'Bạn cần phải chọn loại thu thập!',
			],
			'group' => [
				'required' => 'Bạn cần phải chọn nhóm thu thập!',
			],
		];

		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}
}
