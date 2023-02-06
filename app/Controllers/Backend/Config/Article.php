<?php 
namespace App\Controllers\Backend\Config;
use App\Controllers\BaseController;

class Article extends BaseController{

	protected $data;

	public function __construct(){
		$this->data = [];
		$this->configArticleService = service('ConfigArticleService');
	}

	public function index($id){
		$this->data['website'] = $this->sendAPI(API_WEBSITE_GET_BY_ID.'/'.$id,'get');
		$this->data['configArticleList'] = $this->configArticleService->getListConfigArticle($id);
		$this->data['title'] = 'Danh sách thiết lập bài viết';
		$this->data['module'] = 'config-article';
		$this->data['template'] = 'backend/config/article/index';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function create($id){
		$this->data['website'] = $this->sendAPI(API_WEBSITE_GET_BY_ID.'/'.$id,'get');
		if($this->request->getMethod() == 'post'){
			$session = session();
			$validate = $this->validation('create');
			if ($this->validate($validate['validate'], $validate['errorValidate'])){
				$create = $this->configArticleService->storeConfigArticle($this->request, $id);
        		$response = $this->sendAPI(API_CONFIG_ARTICLE_CREATE,'post', $create);
        		if(isset($response['statusCode']) && $response['statusCode'] == 200){
        			$session->setFlashdata('message-success', 'Thêm mới thiết lập bài viết thành công!');
        			return redirect()->to(BASE_URL.'config/article/index/'.$id);
        		}else{
        			$session->setFlashdata('message-success', 'Có lỗi xảy ra xin vui lòng thử lại!');
        			return redirect()->to(BASE_URL.'config/article/index/'.$id);
        		}
			}else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}

		$this->data['title'] = 'Thêm mới thiết lập bài viết cho website: '.$this->data['website']['data']['url'];
		$this->data['module'] = 'article';
		$this->data['template'] = 'backend/config/article/store';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function update($siteId = '', $id = ''){
		$this->data['website'] = $this->sendAPI(API_WEBSITE_GET_BY_ID.'/'.$siteId,'get');
		$this->data['article'] = $this->sendAPI(API_CONFIG_ARTICLE_GET_BY_ID.'/'.$id,'get');
		if($this->request->getMethod() == 'post'){
			$validate = $this->validation('update');
			$session = session();
			if ($this->validate($validate['validate'], $validate['errorValidate'])){
				$update = $this->configArticleService->storeWebsite($this->request);
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
		$this->data['title'] = 'Cập nhật thiết lập bài viết cho website: '.$this->data['website']['data']['url'];
		$this->data['module'] = 'website';
		$this->data['template'] = 'backend/config/article/store';
		return view('backend/dashboard/layout/home', $this->data);
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
