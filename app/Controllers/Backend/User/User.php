<?php 
namespace App\Controllers\Backend\User;
use App\Controllers\BaseController;

class User extends BaseController{

	protected $data;

	public function __construct(){
		$this->data = [];
		$this->userService = service('UserService');
	}

	public function index(){
		$this->data['userList'] = $this->userService->getListUser();
		$this->data['title'] = 'Danh sách tài khoản';
		$this->data['module'] = 'user';
		$this->data['template'] = 'backend/user/index';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function profile(){
		$this->data['user'] = $this->userService->getCurrentUser();
		$this->data['title'] = 'Thông tin cá nhân';
		$this->data['module'] = 'user';
		$this->data['template'] = 'backend/user/profile';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function create(){
		if($this->request->getMethod() == 'post'){
			$session = session();
			$validate = $this->validation_create();
			if ($this->validate($validate['validate'], $validate['errorValidate'])){
				$create = $this->userService->storeUser($this->request, 'create');
        		$response = $this->sendAPI(API_SIGNUP,'post', $create);
        		if(isset($response['statusCode']) && $response['statusCode'] == 200){
        			$session->setFlashdata('message-success', 'Thêm mới tài khoản thành công!');
        		}else{
        			$session->setFlashdata('message-danger', 'Có lỗi xảy ra xin vui lòng thử lại!');
        		}
    			return redirect()->to(BASE_URL.'user/index');
			}else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}

		$this->data['title'] = 'Thêm mới tài khoản';
		$this->data['module'] = 'user';
		$this->data['template'] = 'backend/user/store';
		$this->data['method'] = 'create';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function update($id = ''){
		$this->data['user'] = $this->sendAPI(API_USER_GET_BY_ID.'/'.$id,'get');
		if($this->request->getMethod() == 'post'){
			$validate = $this->validation_update();
			$session = session();
			if ($this->validate($validate['validate'], $validate['errorValidate'])){
				$update = $this->userService->storeUser($this->request, 'update');
        		$response = $this->sendAPI(API_UPDATE_USER,'post', $update);
        		if($response['code'] == 200){
					$user = authentication();
					if($user['email'] == $this->request->getPost('email_original')){
						$session->set('name', $_POST['name']);
	      				$session->set('email', $user['email'] != $_POST['email'] ? $_POST['email'] : $user['email'] );
					}
					$session->setFlashdata('message-success', $response['message']);
				}
				return redirect()->to(BASE_URL.'user/index');
			}else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		$this->data['title'] = 'Cập nhật tài khoản';
		$this->data['module'] = 'website';
		$this->data['method'] = 'update';
		$this->data['template'] = 'backend/user/store';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function change_pass(){
		if($this->request->getMethod() == 'post'){
			$session = session();
			$validate = $this->validation_password();
			if ($this->validate($validate['validate'], $validate['errorValidate'])){
				$changPass = $this->userService->changePassword();
				if($changPass['code'] == 200){
					$session->setFlashdata('message-success', $changPass['message']);
        			return redirect()->to(BASE_URL.'profile');
				}

				$session->setFlashdata('message-danger', $changPass['message']);
    			return redirect()->to(BASE_URL.'profile');
			}else{
	        	$this->data['validate'] = $this->validator->getErrors();
	        	foreach ($this->data['validate'] as $value) {
					$session->setFlashdata('message-danger', $value);
					break;
				}
	        	return redirect()->to(BASE_URL.'profile');
	        }
		}
		
		return redirect()->to(BASE_URL.'profile');
	}

	public function update_user(){
		if($this->request->getMethod() == 'post'){
			$session = session();
			$validate = $this->validation_user();
			if ($this->validate($validate['validate'], $validate['errorValidate'])){
				$updateUser = $this->userService->updateUser();
				if($updateUser['code'] == 200){
					$user = authentication();
					$session->set('name', $_POST['name']);
      				$session->set('email', $user['email'] != $_POST['email'] ? $_POST['email'] : $user['email'] );
					$session->setFlashdata('message-success', $updateUser['message']);
        			return redirect()->to(BASE_URL.'profile');
				}

				$session->setFlashdata('message-danger', $updateUser['message']);
    			return redirect()->to(BASE_URL.'profile');
			}else{
	        	$this->data['validate'] = $this->validator->getErrors();
	        	foreach ($this->data['validate'] as $value) {
					$session->setFlashdata('message-danger', $value);
					break;
				}
	        	return redirect()->to(BASE_URL.'profile');
	        }
		}
		
		return redirect()->to(BASE_URL.'profile');
	}

	private function validation_create(){
		$validate = [
			'name' => 'required',
			'email' => 'required|valid_email|unique_email[create]',
			'password' => 'required|min_length[6]|regex_match[/^[a-zA-Z0-9]+$/]',
	        'confirm_password' => 'required|min_length[6]|matches[password]',
		];
		$errorValidate = [
			'name' => [
				'required' => 'Bạn cần phải nhập họ và tên!',
			],
			'email' => [
				'required' => 'Bạn cần phải nhập Email!',
				'valid_email' => 'Định dạng Email không hợp lệ!',
				'unique_email' => 'Email đã tồn tại trong hệ thống!',
			],
			'password' => [
				'required' => 'Bạn cần phải nhập mật khẩu mới!',
				'min_length' => 'Mật khẩu mới ít nhất 6 kí tự!',
				'regex_match' => 'Mật khẩu mới không được chứa kí tự đặc biệt!',
			],
			'confirm_password' => [
				'required' => 'Bạn cần phải nhập lại mật khẩu mới!',
				'min_length' => 'Mật khẩu nhập lại ít nhất 6 kí tự!',
				'matches' => 'Mật khẩu nhập lại không khớp!',
			],
		];

		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}

	private function validation_update(){
		$validate = [
			'name' => 'required',
			'email' => 'required|valid_email|unique_email[update]',
		];
		$errorValidate = [
			'name' => [
				'required' => 'Bạn cần phải nhập họ và tên!',
			],
			'email' => [
				'required' => 'Bạn cần phải nhập Email!',
				'valid_email' => 'Định dạng Email không hợp lệ!',
				'unique_email' => 'Email đã tồn tại trong hệ thống!',
			],
		];

		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}

	private function validation_user(){
		$validate = [
			'name' => 'required',
			'email' => 'required|valid_email',
		];
		$errorValidate = [
			'name' => [
				'required' => 'Bạn cần phải nhập họ và tên!',
			],
			'email' => [
				'required' => 'Bạn cần phải nhập Email!',
				'valid_email' => 'Định dạng Email không hợp lệ!',
			],
		];

		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}

	private function validation_password(){
		$validate = [
			'password' => 'required|min_length[6]',
	        'new_password' => 'required|min_length[6]|regex_match[/^[a-zA-Z0-9]+$/]',
	        'confirm_password' => 'required|min_length[6]|matches[new_password]',
		];
		$errorValidate = [
			'password' => [
				'required' => 'Bạn cần phải nhập mật khẩu cũ!',
				'min_length' => 'Mật khẩu cũ ít nhất 6 kí tự!',
			],
			'new_password' => [
				'required' => 'Bạn cần phải nhập mật khẩu mới!',
				'min_length' => 'Mật khẩu mới ít nhất 6 kí tự!',
				'regex_match' => 'Mật khẩu mới không được chứa kí tự đặc biệt!',
			],
			'confirm_password' => [
				'required' => 'Bạn cần phải nhập lại mật khẩu mới!',
				'min_length' => 'Mật khẩu nhập lại ít nhất 6 kí tự!',
				'matches' => 'Mật khẩu nhập lại không khớp!',
			],
		];

		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}
}
