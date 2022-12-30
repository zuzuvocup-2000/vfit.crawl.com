<?php
namespace App\Controllers\Backend\Product;
use App\Controllers\BaseController;

class Lesson extends BaseController{
	protected $data;
	public $nestedsetbie;


	public function __construct(){
		$this->data = [];
		$this->data['module'] = 'lesson';
	}

	public function index($page = 1){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/product/lesson/index'
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
			'select' => 'tb1.id, tb2.title',
			'table' => $this->data['module'].' as tb1',
			'keyword' => $keyword,
			'where' => $where,
			'join' => [
				[
					'lesson_translate as tb2','tb1.id = tb2.objectid AND tb2.module = "lesson" AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
				],
				[
					'product_translate as tb3', 'tb1.catalogueid = tb3.objectid AND tb3.module = "product" AND tb3.language = \''.$this->currentLanguage().'\'','inner'
				],
				[
					'product as tb4', 'tb1.catalogueid = tb4.id AND tb4.deleted_at = 0','inner'
				]
			],
			'group_by' => 'tb1.id',
			'count' => TRUE,
		]);
		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => 'backend/product/lesson/index','perpage' => $perpage], $config);
			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();

			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$languageDetact = $this->detect_language();
			$this->data['lessonList'] = $this->AutoloadModel->_get_where([
				'select' => 'tb1.id, tb1.author, tb1.catalogueid as cat_id, tb1.image, tb1.viewed, tb1.order, tb1.created_at,  tb1.publish, tb2.title as article_title, tb1.catalogue, tb2.objectid, tb2.content,  tb2.canonical, tb2.meta_title, tb2.meta_description, tb4.author, tb3.title as cat_title '.((isset($languageDetact['select'])) ? $languageDetact['select'] : ''),
				'table' => $this->data['module'].' as tb1',
				'where' => $where,
				'keyword' => $keyword,
				'join' => [
					[
						'lesson_translate as tb2','tb1.id = tb2.objectid AND tb2.module = "lesson" AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
					],
					[
						'product_translate as tb3', 'tb1.catalogueid = tb3.objectid AND tb3.module = "product" AND tb3.language = \''.$this->currentLanguage().'\'', 'inner'
					],
					[
						'product as tb4', 'tb1.catalogueid = tb4.id AND tb4.deleted_at = 0', 'inner'
					]
				],
				'limit' => $config['per_page'],
				'start' => $page * $config['per_page'],
				'order_by'=> 'tb1.order desc, tb1.id desc',
				'group_by' => 'tb1.id'
			], TRUE);
		}
		$productList = $flag = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, tb2.title',
			'table' => 'product as tb1',
			'join' =>  [
					[
						'product_translate as tb2','tb1.id = tb2.objectid AND tb2.module = "product" AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
					]
				],
			'where' => ['tb1.deleted_at' => 0, 'tb1.publish' => 1],
			'order_by' => 'tb2.title asc'
		],true);

		$this->data['dropdown'] = convert_array([
			'data' => $productList,
			'field' => 'id',
			'value' => 'title',
			'text' => 'Khoá học',
		]);
		$this->data['template'] = 'backend/product/lesson/index';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function create(){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/product/lesson/create'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}

		$productList = $flag = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, tb2.title',
			'table' => 'product as tb1',
			'join' =>  [
					[
						'product_translate as tb2','tb1.id = tb2.objectid AND tb2.module = "product" AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
					]
				],
			'where' => ['tb1.deleted_at' => 0, 'tb1.publish' => 1],
			'order_by' => 'tb2.title asc'
		],true);

		$this->data['dropdown'] = convert_array([
			'data' => $productList,
			'field' => 'id',
			'value' => 'title',
			'text' => 'Khoá học',
		]);

		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
			if ($this->validate($validate['validate'], $validate['errorValidate'])){
		 		$insert = $this->store(['method' => 'create']);
		 		$resultid = $this->AutoloadModel->_insert([
		 			'table' => $this->data['module'],
		 			'data' => $insert,
		 		]);

		 		if($resultid > 0){
		 			$sub_content = $this->request->getPost('sub_content');
		 			$storeLanguage = $this->storeLanguage($resultid);
		 			$storeLanguage = $this->convert_content($sub_content, $storeLanguage);
		 			$insertid = $this->AutoloadModel->_insert([
			 			'table' => 'lesson_translate',
			 			'data' => $storeLanguage,
			 		]);
		 			insert_router([
			 			'method' => 'create',
			 			'id' => $resultid,
			 			'language' => $this->currentLanguage(),
			 			'module' => $this->data['module'],
			 			'router' => $this->request->getPost('router'),
		 				'canonical' => slug($this->request->getPost('canonical'))
			 		]);

		 			insert_tags([
		 				'module' => $this->data['module'],
		 				'language' => $this->currentLanguage(),
		 				'objectid' => $resultid,
		 				'tags' => $this->request->getPost('tags')
		 			]);
	 				$flag = $this->create_relationship($resultid);
	 				if($flag > 0){
	 					$session->setFlashdata('message-success', 'Tạo Bài học Thành Công! Hãy tạo danh mục tiếp theo.');
 						return redirect()->to(BASE_URL.'backend/product/lesson/index');
	 				}else{
	 					$session->setFlashdata('message-danger', 'Có vấn đề xảy ra, vui lòng thử lại!');
	 					return redirect()->to(BASE_URL.'backend/product/lesson/index');
	 				}
		 		}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		$this->data['fixWrapper'] = 'fix-wrapper';
		$this->data['method'] = 'create';
		$this->data['template'] = 'backend/product/lesson/create';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function update($id = 0){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/product/lesson/update'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}

		$id = (int)$id;
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, tb1.author,tb1.time, tb1.author_image, tb4.title, tb4.canonical, tb4.description, tb4.content, tb4.meta_title, tb4.meta_description, tb1.catalogueid, tb1.image, tb1.album, tb1.publish, tb1.catalogue,tb1.video, tb4.router, tb4.icon, tb4.template, tb4.sub_title, tb4.sub_content,  tb4.album_title',
			'table' => $this->data['module'].' as tb1',
			'join' => [
				[
					'lesson_translate as tb4','tb1.id = tb4.objectid AND tb4.module = "lesson" AND tb4.language = \''.$this->currentLanguage().'\' ','inner'
				]
			],
			'where' => ['tb1.id' => $id,'tb1.deleted_at' => 0]
		]);


		$this->data['tags'] = get_tag([
			'module' => $this->data['module'],
			'objectid' => $id,
			'language' => $this->currentLanguage(),
		]);
		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Bài học không tồn tại');
 			return redirect()->to(BASE_URL.'backend/product/lesson/index');
		}

		$this->data[$this->data['module']]['description'] = base64_decode($this->data[$this->data['module']]['description']);
		$this->data[$this->data['module']]['content'] = base64_decode($this->data[$this->data['module']]['content']);
		$this->data[$this->data['module']]['sub_title'] = json_decode(base64_decode($this->data[$this->data['module']]['sub_title']));
		$this->data[$this->data['module']]['sub_content'] = json_decode(base64_decode($this->data[$this->data['module']]['sub_content']));

		if($this->request->getMethod() == 'post'){
			$validate = $this->validation();
			if ($this->validate($validate['validate'], $validate['errorValidate'])){
		 		$update = $this->store(['method' => 'update']);
	 			$sub_content = $this->request->getPost('sub_content');
		 		$updateLanguage = $this->storeLanguage($id);
	 			$updateLanguage = $this->convert_content($sub_content, $updateLanguage);
		 		$flag = $this->AutoloadModel->_update([
		 			'table' => $this->data['module'],
		 			'where' => ['id' => $id],
		 			'data' => $update
		 		]);

		 		if($flag > 0){
		 			$flagLang = $this->AutoloadModel->_update([
			 			'table' => $this->data['module'].'_translate',
			 			'where' => ['objectid' => $id, 'module' => 'lesson', 'language' => $this->currentLanguage()],
			 			'data' => $updateLanguage,
			 		]);
			 		$flag = $this->create_relationship($id);
			 		insert_tags([
		 				'module' => $this->data['module'],
		 				'language' => $this->currentLanguage(),
		 				'objectid' => $id,
		 				'tags' => $this->request->getPost('tags')
		 			]);
	 				insert_router([
		 				'method' => 'update',
		 				'id' => $id,
		 				'language' => $this->currentLanguage(),
		 				'module' => $this->data['module'],
		 				'router' => $this->request->getPost('router'),
		 				'canonical' => slug($this->request->getPost('canonical'))
		 			]);
		 			$session->setFlashdata('message-success', 'Cập Nhật Bài học Thành Công!');
 					return redirect()->to(BASE_URL.'backend/product/lesson/index');
		 		}

	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		$productList = $flag = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, tb2.title',
			'table' => 'product as tb1',
			'join' =>  [
					[
						'product_translate as tb2','tb1.id = tb2.objectid AND tb2.module = "product" AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
					]
				],
			'where' => ['tb1.deleted_at' => 0, 'tb1.publish' => 1],
			'order_by' => 'tb2.title asc'
		],true);

		$this->data['dropdown'] = convert_array([
			'data' => $productList,
			'field' => 'id',
			'value' => 'title',
			'text' => 'Khoá học',
		]);
		$this->data['fixWrapper'] = 'fix-wrapper';
		$this->data['method'] = 'update';
		$this->data['template'] = 'backend/product/lesson/update';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function delete($id = 0){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/product/lesson/delete'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}

		$id = (int)$id;
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, tb1.author, tb1.author_image, tb4.title, tb4.canonical, tb4.description, tb4.content, tb4.meta_title, tb4.meta_description, tb1.catalogueid, tb1.image, tb1.album, tb1.publish, tb1.catalogue,tb1.video, tb4.router, tb4.icon, tb4.template, tb4.sub_title, tb4.sub_content,  tb4.album_title',
			'table' => $this->data['module'].' as tb1',
			'join' => [
				[
					'lesson_translate as tb4','tb1.id = tb4.objectid AND tb4.module = "lesson" AND tb4.language = \''.$this->currentLanguage().'\' ','inner'
				]
			],
			'where' => ['tb1.id' => $id,'tb1.deleted_at' => 0]
		]);
		$session = session();
		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Bài học không tồn tại');
 			return redirect()->to(BASE_URL.'backend/product/lesson/index');
		}

		if($this->request->getPost('delete')){
			$_id = $this->request->getPost('id');

			$flag = $this->AutoloadModel->_update([
				'table' => $this->data['module'],
				'data' => ['deleted_at' => 1],
				'where' => [
					'id' => $_id
				]
			]);
			delete_router($id,$this->data['module'], $this->currentLanguage());

			$session = session();
			if($flag > 0){
	 			$session->setFlashdata('message-success', 'Xóa bản ghi thành công!');
			}else{
				$session->setFlashdata('message-danger', 'Có vấn đề xảy ra, vui lòng thử lại!');
			}
			return redirect()->to(BASE_URL.'backend/product/lesson/index');
		}

		$this->data['template'] = 'backend/product/lesson/delete';
		return view('backend/dashboard/layout/home', $this->data);
	}

	private function create_relationship($objectid = 0, $catalogue = []){
		$relationshipId = $this->request->getPost('catalogueid');
		$this->AutoloadModel->_delete([
			'table' => 'object_relationship',
			'where' => [
				'module' => $this->data['module'],
				'objectid' => $objectid
			]
		]);
		$insert = array(
			'objectid' => $objectid,
			'catalogueid' => $relationshipId,
			'module' => $this->data['module'],
		);

		$flag = $this->AutoloadModel->_insert([
			'data' => $insert,
			'table' => 'object_relationship'
		]);

		return $flag;
	}

	private function condition_where(){
		$where = [];
		$publish = $this->request->getGet('publish');
		if(isset($publish)){
			$where['tb1.publish'] = $publish;
		}

		$deleted_at = $this->request->getGet('deleted_at');
		if(isset($deleted_at)){
			$where['tb1.deleted_at'] = $deleted_at;
		}else{
			$where['tb1.deleted_at'] = 0;
		}

		return $where;
	}

	private function condition_keyword($keyword = ''): string{
		if(!empty($this->request->getGet('keyword'))){
			$keyword = $this->request->getGet('keyword');
			$keyword = '(tb3.title LIKE \'%'.$keyword.'%\')';
		}
		return $keyword;
	}

	private function storeLanguage($objectid = 0){
		helper(['text']);
		$store = [
			'objectid' => $objectid,
			'title' => validate_input($this->request->getPost('title')),
			'canonical' => slug($this->request->getPost('canonical')),
			'description' => base64_encode($this->request->getPost('description')),
			'router' => $this->request->getPost('router'),
			'template' => $this->request->getPost('template'),
			'icon' => $this->request->getPost('icon'),
			'content' => base64_encode($this->request->getPost('content')),
			'meta_title' => validate_input($this->request->getPost('meta_title')),
			'meta_description' => validate_input($this->request->getPost('meta_description')),
			'language' => $this->currentLanguage(),
			'module' => $this->data['module'],
		];
		return $store;
	}

	private function store($param = []){
		helper(['text']);
		$store = [
 			'catalogueid' => (int)$this->request->getPost('catalogueid'),
 			'image' => $this->request->getPost('image'),
 			'time' => $this->request->getPost('time'),
 			'video' => $this->request->getPost('video'),
 			'publish' => $this->request->getPost('publish'),
 		];
 		if($param['method'] == 'create' && isset($param['method'])){
 			$store['created_at'] = $this->currentTime;
 			$store['userid_created'] = $this->auth['id'];

 		}else{
 			$store['updated_at'] = $this->currentTime;
 			$store['userid_updated'] = $this->auth['id'];
 		}
 		return $store;
	}

	private function detect_language(){
		$languageList = $this->AutoloadModel->_get_where([
			'select' => 'id, canonical',
			'table' => 'language',
			'where' => ['publish' => 1,'deleted_at' => 0,'canonical !=' =>  $this->currentLanguage()]
		], TRUE);


		$select = '';
		$i = 3;
		if(isset($languageList) && is_array($languageList) && count($languageList)){
			foreach($languageList as $key => $val){
				$select = $select.'(SELECT COUNT(objectid) FROM article_translate WHERE article_translate.objectid = tb1.id AND article_translate.module = "article" AND  article_translate.language = "'.$val['canonical'].'") as '.$val['canonical'].'_detect, ';
				$i++;
			}
		}


		return [
			'select' => $select,
		];

	}

	private function convert_content($content = [], $store = []){
		$count_1 = 0;
		$count_2 = 0;
		if($content != []){
			foreach ($content['title'] as $key => $value) {
	 			$title[] = $content['title'][$count_1];
	 			$count_1++;
	 		}
	 		foreach ($content['title'] as $key => $value) {
	 			$description[] = $content['description'][$count_2];
	 			$count_2++;
	 		}
	 		$title = base64_encode(json_encode($title));
	 		$description = base64_encode(json_encode($description));
	 		$store['sub_title'] = $title;
	 		$store['sub_content'] = $description;
			return $store;
		}else{
			return $store;
		}
	}

	private function validation(){
		$validate = [
			'title' => 'required',
			'canonical' => 'required|check_router[]',
			'catalogueid' => 'is_natural_no_zero',
		];
		$errorValidate = [
			'title' => [
				'required' => 'Bạn phải nhập vào trường tiêu đề'
			],
			'canonical' => [
				'required' => 'Bạn phải nhập giá trị cho trường đường dẫn',
				'check_router' => 'Đường dẫn đã tồn tại, vui lòng chọn đường dẫn khác',
			],
			'catalogueid' => [
				'is_natural_no_zero' => 'Bạn Phải chọn danh mục cha cho bài học',
			],
		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}

}
