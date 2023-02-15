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
		try {
			$this->data['websiteList'] = $this->websiteService->getListWebsite();
			$this->data['title'] = 'Danh sách Website';
			$this->data['module'] = 'website';
			$this->data['template'] = 'backend/website/website/index';
			return view('backend/dashboard/layout/home', $this->data);
		} catch (\Exception $e) {
		    // handle the exception here
		    echo $e->getMessage();
		}
	}

	public function url($id){
		try {
			$this->data['website'] = $this->sendAPI(API_WEBSITE_GET_BY_ID.'/'.$id,'get');
			$this->data['urlList'] = $this->websiteService->getListUrlFromWebsite($id);
			$this->data['title'] = 'Danh sách Url của Website: '.$this->data['website']['data']['url'];
			$this->data['module'] = 'website';
			$this->data['template'] = 'backend/website/website/url';
			return view('backend/dashboard/layout/home', $this->data);
		} catch (\Exception $e) {
		    // handle the exception here
		    echo $e->getMessage();
		}
	}

	public function update_status($id){
		try {
			$this->data['website'] = $this->sendAPI(API_UPDATE_STATUS_URL.'/'.$id,'get',[
				'status' => $this->request->getPost('status')
			]);
		} catch (\Exception $e) {
		    // handle the exception here
		    echo $e->getMessage();
		}
	}

	public function create(){
		try {
			if($this->request->getMethod() == 'post'){
				$session = session();
				$validate = $this->validation('create');
				if ($this->validate($validate['validate'], $validate['errorValidate'])){
					$create = $this->websiteService->storeWebsite($this->request);
	        		$response = $this->sendAPI(API_WEBSITE_CREATE,'post', $create);
	        		if(isset($response['statusCode']) && $response['statusCode'] == 200){
	        			$session->setFlashdata('message-success', 'Thêm mới Url Website thành công!');
	        			return redirect()->to(BASE_URL.'website/create');
	        		}else{
	        			$session->setFlashdata('message-danger', 'Có lỗi xảy ra xin vui lòng thử lại!');
	        			return redirect()->to(BASE_URL.'website/index');
	        		}
				}else{
		        	$this->data['validate'] = $this->validator->listErrors();
		        }
			}

			$this->data['title'] = 'Thêm mới Website';
			$this->data['module'] = 'website';
			$this->data['template'] = 'backend/website/website/store';
			return view('backend/dashboard/layout/home', $this->data);
		} catch (\Exception $e) {
		    // handle the exception here
		    echo $e->getMessage();
		}
	}

	public function update($id = ''){
		try {
			$this->data['website'] = $this->sendAPI(API_WEBSITE_GET_BY_ID.'/'.$id,'get');
			if($this->request->getMethod() == 'post'){
				$validate = $this->validation('update');
				$session = session();
				if ($this->validate($validate['validate'], $validate['errorValidate'])){
					$update = $this->websiteService->storeWebsite($this->request);
	        		$response = $this->sendAPI(API_WEBSITE_CREATE.'/'.$this->data['website']['data']['_id'],'put', $update);
	        		if(isset($response['statusCode']) && $response['statusCode'] == 200){
	        			$session->setFlashdata('message-success', 'Cập nhật Url Website thành công!');
	        			return redirect()->to(BASE_URL.'website/index');
	        		}else{
	        			$session->setFlashdata('message-danger', 'Có lỗi xảy ra xin vui lòng thử lại!');
	        			return redirect()->to(BASE_URL.'website/index');
	        		}
				}else{
		        	$this->data['validate'] = $this->validator->listErrors();
		        }
			}
			$this->data['title'] = 'Cập nhật Website';
			$this->data['module'] = 'website';
			$this->data['template'] = 'backend/website/website/store';
			return view('backend/dashboard/layout/home', $this->data);
		} catch (\Exception $e) {
		    // handle the exception here
		    echo $e->getMessage();
		}
	}

	private function validation($method = ''){
		$validate = [
			'url' => 'required|unique_url['.$method.']',
			'typeCrawl' => 'required',
			'type' => 'required',
			'status' => 'required',
		];
		$errorValidate = [
			'url' => [
				'required' => 'Bạn cần phải nhập Url Website!',
				'unique_url' => 'Url đã tồn tại trong hệ thống!',
			],
			'typeCrawl' => [
				'required' => 'Xin vui lòng chọn kiểu thu thập dữ liệu!',
			],
			'type' => [
				'required' => 'Xin vui lòng chọn loại Website!',
			],
			'status' => [
				'required' => 'Xin vui lòng chọn trạng thái Website!',
			],
		];

		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}
}
