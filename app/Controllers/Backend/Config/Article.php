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

	public function create(){
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
        			$session->setFlashdata('message-success', 'Có lỗi xảy ra xin vui lòng thử lại!');
        			return redirect()->to(BASE_URL.'website/index');
        		}
			}else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}

		$this->data['title'] = 'Thêm mới Bài Viết';
		$this->data['module'] = 'article';
		$this->data['template'] = 'backend/config/article/store';
		return view('backend/dashboard/layout/home', $this->data);
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
