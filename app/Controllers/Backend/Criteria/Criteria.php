<?php 
namespace App\Controllers\Backend\Criteria;
use App\Controllers\BaseController;

class Criteria extends BaseController{

	protected $data;

	public function __construct(){
		$this->data = [];
		$this->criteriaService = service('CriteriaService');
	}

	public function index(){
		try {
			$this->data['criteriaList'] = $this->criteriaService->getListCriteria();
			$this->data['title'] = 'Danh sách Tiêu chí';
			$this->data['module'] = 'criteria';
			$this->data['template'] = 'backend/criteria/criteria/index';
			return view('backend/dashboard/layout/home', $this->data);
		} catch (\Exception $e) {
		    echo $e->getMessage();
		}
	}

	public function create(){
		try {
			if($this->request->getMethod() == 'post'){
				$session = session();
				$validate = $this->validation('create');
				if ($this->validate($validate['validate'], $validate['errorValidate'])){
					$create = $this->criteriaService->storeCriteria($this->request);
	        		$response = $this->sendAPI(API_CRITERIA_UPSERT,'post', $create);
	        		if(isset($response['statusCode']) && $response['statusCode'] == 200){
	        			$session->setFlashdata('message-success', 'Thêm mới tiêu chí thành công!');
	        			return redirect()->to(BASE_URL.'criteria/index');
	        		}else{
	        			$session->setFlashdata('message-success', 'Có lỗi xảy ra xin vui lòng thử lại!');
	        			return redirect()->to(BASE_URL.'criteria/index');
	        		}
				}else{
		        	$this->data['validate'] = $this->validator->listErrors();
		        }
			}

			$this->data['title'] = 'Thêm mới tiêu chí';
			$this->data['module'] = 'criteria';
			$this->data['method'] = 'create';
			$this->data['template'] = 'backend/criteria/criteria/store';
			return view('backend/dashboard/layout/home', $this->data);
		} catch (\Exception $e) {
		    echo $e->getMessage();
		}
	}

	public function update($id){
		try {
			$this->data['criteria'] = $this->sendAPI(API_CRITERIA_GET_BY_ID.'/'.$id,'get');
			if($this->request->getMethod() == 'post'){
				$session = session();
				$validate = $this->validation('create');
				if ($this->validate($validate['validate'], $validate['errorValidate'])){
					$update = $this->criteriaService->storeCriteria($this->request);
	        		$response = $this->sendAPI(API_CRITERIA_UPSERT,'post', $update);
	        		if(isset($response['statusCode']) && $response['statusCode'] == 200){
	        			$session->setFlashdata('message-success', 'Cập nhật tiêu chí thành công!');
	        			return redirect()->to(BASE_URL.'criteria/index');
	        		}else{
	        			$session->setFlashdata('message-success', 'Có lỗi xảy ra xin vui lòng thử lại!');
	        			return redirect()->to(BASE_URL.'criteria/index');
	        		}
				}else{
		        	$this->data['validate'] = $this->validator->listErrors();
		        }
			}

			$this->data['title'] = 'Thêm mới tiêu chí';
			$this->data['module'] = 'criteria';
			$this->data['method'] = 'update';
			$this->data['template'] = 'backend/criteria/criteria/store';
			return view('backend/dashboard/layout/home', $this->data);
		} catch (\Exception $e) {
		    echo $e->getMessage();
		}
	}

	private function validation($method = ''){
		$validate = [
			'typeCriteria' => 'required',
			'typeStatistic' => 'required',
		];
		$errorValidate = [
			'typeCriteria' => [
				'required' => 'Bạn cần phải chọn loại tiêu chí!',
			],
			'typeStatistic' => [
				'required' => 'Bạn cần phải chọn mức độ đánh giá!',
			],
		];

		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}
}
