<?php 
namespace App\Controllers\Backend\Author;
use App\Controllers\BaseController;

class Author extends BaseController{
	protected $data;
	
	public function __construct(){
		$this->data = [];
		$this->data['module'] = 'author';
	}

	public function index($page = 1){
		unset($this->data['type']['']);
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/author/author/index'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}

		helper(['mypagination']);
		$page = (int)$page;
		$perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 20;
		$where = $this->condition_where();
		$keyword = $this->condition_keyword();
		$config['total_rows'] = $this->AutoloadModel->_get_where([
			'select' => 'id',
			'table' => $this->data['module'],
			'keyword' => $keyword,
			'where' => $where,
			'count' => TRUE
		]);
		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => 'backend/author/author/index','perpage' => $perpage], $config);

			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();

			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;

			$this->data['authorList'] = $this->AutoloadModel->_get_where([
				'select' => 'job, id, fullname, image, email, phone,  created_at, image, gender,publish',
				'table' => $this->data['module'],
				'where' => $where,
				'keyword' => $keyword,
				'limit' => $config['per_page'],
				'start' => $page * $config['per_page'],
			], TRUE);

		}

		$this->data['template'] = 'backend/author/author/index';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function create(){
		unset($this->data['type']['']);
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/author/author/create'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/author/author/index');
		}
		if($this->request->getMethod() == 'post'){
			$validation = $this->validation();
			if ($this->validate($validation['validate'], $validation['errorValidate'])){
		 		$insert = $this->store();
		 		$insertid = $this->AutoloadModel->_insert(['table' => $this->data['module'],'data' => $insert]);
		 		if($insertid > 0){
		 			insert_router([
			 			'method' => 'create',
			 			'id' => $insertid,
			 			'language' => $this->currentLanguage(),
			 			'module' => $this->data['module'],
			 			'router' => $this->request->getPost('router'),
		 				'canonical' => slug($this->request->getPost('canonical'))
			 		]);
		 			$session->setFlashdata('message-success', 'Thêm mới Tác giả thành công');
		 			return redirect()->to(BASE_URL.'backend/author/author/index');
		 		}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		$this->data['method'] = 'create';
		$this->data['template'] = 'backend/author/author/store';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function update($id = 0){
		unset($this->data['type']['']);
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/author/author/update'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/author/author/index');
		}

		$id = (int)$id;
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'id, fullname, meta_title, meta_description, canonical, router, template, video, signature, job, description, catalogueid, email, phone,  gender,  image',
			'table' => $this->data['module'],
			'where' => ['id' => $id,'deleted_at' => 0]
		]);
		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Tác giả không tồn tại');
 			return redirect()->to(BASE_URL.'backend/author/author/index');
		}
		if($this->request->getMethod() == 'post'){
			$validation = $this->validation();	
			if ($this->validate($validation['validate'], $validation['errorValidate'])){
		 		$update = $this->store();
		 		$flag = $this->AutoloadModel->_update(['table' => $this->data['module'],'data' => $update, 'where' => ['id' =>$id]]);
		 		if($flag > 0){
		 			insert_router([
			 			'method' => 'update',
			 			'id' => $id,
			 			'language' => $this->currentLanguage(),
			 			'module' => $this->data['module'],
			 			'router' => $this->request->getPost('router'),
		 				'canonical' => slug($this->request->getPost('canonical'))
			 		]);
		 			$session->setFlashdata('message-success', 'Cập nhật Tác giả thành công');
		 			return redirect()->to(BASE_URL.'backend/author/author/index');
		 		}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}


		$this->data['method'] = 'update';
		$this->data['template'] = 'backend/author/author/store';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function delete($id = 0){

		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/author/author/delete'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/author/author/index');
		}

		$id = (int)$id;
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'id, fullname, signature, job,  catalogueid, email, phone,  gender,  image',
			'table' => $this->data['module'],
			'where' => ['id' => $id,'deleted_at' => 0]
		]);
		$session = session();
		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Tác giả không tồn tại');
 			return redirect()->to(BASE_URL.'backend/author/author/index');
		}

		if($this->request->getPost('delete')){
			$authorID = $this->request->getPost('id');

			$flag = $this->AutoloadModel->_update([
				'data' => ['deleted_at' => 1],
				'where' => ['id' => $authorID],
				'table' => $this->data['module']
			]);

			$session = session();
			if($flag > 0){
	 			$session->setFlashdata('message-success', 'Xóa bản ghi thành công!');
			}else{
				$session->setFlashdata('message-danger', 'Có vấn đề xảy ra, vui lòng thử lại!');
			}
			return redirect()->to(BASE_URL.'backend/author/author/index');
		}

		$this->data['template'] = 'backend/author/author/delete';
		return view('backend/dashboard/layout/home', $this->data);
	}

	private function validation(){
		$validate = [
			'catalogueid' => 'is_natural_no_zero',
			'fullname' => 'required',
			'canonical' => 'required|check_router[]',
		];
		$errorValidate = [
			'fullname' => [
				'required' => 'Bạn cần phải nhập tên tác giả!',
			],
			'canonical' => [
				'required' => 'Bạn phải nhập giá trị cho trường đường dẫn',
				'check_router' => 'Đường dẫn đã tồn tại, vui lòng chọn đường dẫn khác',
			],
			'catalogueid' => [
				'is_natural_no_zero' => 'Bạn phải lựa chọn giá trị cho trường Nhóm Tác giả'
			]
		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}

	private function condition_where(){
		$where = [];
		$gender = $this->request->getGet('gender');
		if($gender != -1 && $gender != '' && isset($gender)){
			$where['gender'] = $this->request->getGet('gender');
		}

		$publish = $this->request->getGet('publish');
		if(isset($publish)){
			$where['publish'] = $publish;
		}
		$catalogueid = $this->request->getGet('catalogueid');
		if(isset($catalogueid) && $catalogueid != 0){
			$where['catalogueid'] = $catalogueid;
		}

		$deleted_at = $this->request->getGet('deleted_at');
		if(isset($deleted_at)){
			$where['deleted_at'] = $deleted_at;
		}else{
			$where['deleted_at'] = 0;
		}

		return $where;
	}

	private function condition_keyword($keyword = ''): string{
		if(!empty($this->request->getGet('keyword'))){
			$keyword = $this->request->getGet('keyword');
			$keyword = '(fullname LIKE \'%'.$keyword.'%\' OR address LIKE \'%'.$keyword.'%\' OR email LIKE \'%'.$keyword.'%\' OR phone LIKE \'%'.$keyword.'%\')';
		}
		return $keyword;
	}

	private function store(){
		helper(['text']);
		$store = [
 			'email' => $this->request->getPost('email'),
 			'fullname' => $this->request->getPost('fullname'),
 			'catalogueid' => (int)$this->request->getPost('catalogueid'),
 			'image' => $this->request->getPost('image'),
 			'gender' => $this->request->getPost('gender'),
 			'canonical' => slug($this->request->getPost('canonical')),
 			'video' => $this->request->getPost('video'),
 			'meta_title' => $this->request->getPost('meta_title'),
 			'meta_description' => $this->request->getPost('meta_description'),
 			'router' => $this->request->getPost('router'),
 			'template' => $this->request->getPost('template'),
 			'job' => $this->request->getPost('job'),
 			'description' => $this->request->getPost('description'),
 			'signature' => $this->request->getPost('signature'),
 			'phone' => $this->request->getPost('phone'),
 			'publish' => $this->request->getPost('publish'),
 		];
 		if($this->request->getPost('password')){
 			$store['created_at'] = $this->currentTime;
 		}else{
 			$store['updated_at'] = $this->currentTime;
 		}
 		return $store;
	}

}
