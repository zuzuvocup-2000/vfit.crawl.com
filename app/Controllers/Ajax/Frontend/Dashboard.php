<?php
namespace App\Controllers\Ajax\Frontend;
use App\Controllers\FrontendController;

class Dashboard extends FrontendController{
	public function __construct(){

	}

	public function get_select2(){
		$id = $this->request->getPost('id');
		$end = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id, tb2.title',
            'table' => 'location as tb1',
            'join' => [
                [
                    'location_translate as tb2', 'tb1.id = tb2.objectid AND tb2.module = "location" AND tb2.language = \''.$this->currentLanguage().'\'', 'inner'
                ]
            ],
            'where' => [
            	'catalogueid' => $id,
            	'deleted_at' => 0
            ],
            'order_by' => 'tb1.catalogueid asc'
        ],TRUE);
        if(isset($end) && is_array($end) && count($end)){
            $data = convert_array([
                'data' => $end,
                'field' => 'id',
                'value' => 'title',
                'text' => 'điểm đến',
            ]);
        }
        $html = '';
        foreach ($data as $key => $value) {
        	$html = $html.'<option value="'.$key.'">'.$value.'</option>';
        }
		echo json_encode([
			'html' => $html
		]); die();
	}

    public function get_modal_product(){
        $param['id'] = $this->request->getPost('id');
        $param['module'] = $this->request->getPost('module');

        $flag = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id,tb1.price,tb1.sub_album, tb1.price_promotion,tb1.catalogueid, tb1.viewed, tb1.album, tb1.image, tb2.title, tb2.canonical,tb2.sub_album_title, tb2.meta_title, tb2.sub_title,tb2.video, tb2.sub_content, tb1.productid, tb2.meta_description,  tb2.description, tb2.content, tb1.bar_code, tb1.model',
            'table' => $param['module'].' as tb1',
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
                'tb1.id' => $param['id']
            ],
            'join' => [
                [
                    'product_translate as tb2','tb1.id = tb2.objectid AND tb2.module = "product" AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
                ]
            ],
        ]);
        if(isset($flag['album']) && $flag['album'] != ''){
            $flag['album'] = json_decode($flag['album']);
        }
        if(isset($flag['info']) && $flag['info'] != ''){
            $flag['info'] = json_decode($flag['info'], TRUE);
        }
        if(isset($flag['description']) && $flag['description'] != ''){
            $flag['description'] = validate_input(base64_decode($flag['description']));
        }
        if(isset($flag['content']) && $flag['content'] != ''){
            $flag['content'] = validate_input(base64_decode($flag['content']));
        }
        if(isset($flag['sub_content']) && $flag['sub_content'] != ''){
            $flag['sub_content'] = json_decode(base64_decode($flag['sub_content']));
        }
        if(isset($flag['sub_title']) && $flag['sub_title'] != ''){
            $flag['sub_title'] = json_decode(base64_decode($flag['sub_title']));
        }
        if(isset($flag['price']) && $flag['price'] != ''){
            $flag['price'] = number_format($flag['price'],0,',','.');
        }
        if(isset($flag['price_promotion']) && $flag['price_promotion'] != ''){
            $flag['price_promotion'] = number_format($flag['price_promotion'],0,',','.');
        }
        echo json_encode($flag);die();
    }

    public function send_comment(){
        $param['fullname'] = $this->request->getPost('fullname');
        $param['email'] = $this->request->getPost('email');
        $param['comment'] = $this->request->getPost('comment');
        $param['module'] = $this->request->getPost('module');
        $param['url'] = $this->request->getPost('canonical');
        $param['language'] = $this->currentLanguage();
        $param['comment'] = base64_encode($param['comment']);
        $param['created_at'] = $this->currentTime;

        $flag = $this->AutoloadModel->_insert([
            'table' => 'comment',
            'data' => $param
        ]);
        echo $flag;die();
    }

     public function view_sub_comment(){
        $value = json_decode(base64_decode($this->request->getPost('val')),TRUE);

        $flag = $this->AutoloadModel->_get_where([
            'select' => 'fullname, id, parentid, comment, created_at, image, album',
            'table' => 'comment',
            'where' => [
                'parentid' => $value['id'],
                'module' => $value['module'],
                'language' => $this->currentLanguage(),
                'deleted_at' => 0
            ],
            'order_by' => 'created_at asc'
        ],TRUE);
        if(isset($flag) && is_array($flag) && count($flag)){
            foreach ($flag as $key => $value) {
                $flag[$key]['comment'] = base64_decode($value['comment']);
                $flag[$key]['data_info'] = base64_encode(json_encode($flag[$key]));
                $flag[$key]['album'] = json_decode($value['album']);
            }
        }

        echo json_encode($flag);die();
    }

    public function reply_comment(){
        $param['user'] = json_decode(base64_decode($this->request->getPost('user')),true);
        $param['value'] = json_decode(base64_decode($this->request->getPost('value')),true);
        $param['reply'] = $this->request->getPost('reply');
        $param['album'] = $this->request->getPost('album');
        $store = [
            'language' => $this->currentLanguage(),
            'module' => $param['value']['module'],
            'parentid' => $param['value']['id'],
            'url' => $param['value']['url'],
            'image' => 'public/avatar.png',
            'fullname' => $param['user']['fullname'],
            'comment' => base64_encode($param['reply']),
            'created_at' => $this->currentTime,
            'album' => json_encode($param['album'])
        ];
        $flag = 0;
        $flag = $this->AutoloadModel->_insert([
            'table' => 'comment',
            'data' => $store
        ]);
        $store['comment'] = base64_decode($store['comment']);
        $store['album'] = json_decode($store['album']);
        $store['data_info'] = base64_encode(json_encode($store));
        if($flag > 0){
            echo json_encode($store);die();
        }
        else{
            echo '';die();
        }
    }

    public function update_comment(){
        $param['param'] = $this->request->getPost('param');
        $param['comment'] = $this->request->getPost('comment');
        $store = [
            'comment' => base64_encode($param['comment']),
            'updated_at' => $this->currentTime,
            'album' => json_encode($param['param']['album'])
        ];
        $flag = $this->AutoloadModel->_update([
            'table' => 'comment',
            'data' => $store,
            'where' => [
                'id' => $param['param']['id']
            ]
        ]);
        if($flag > 0){
            echo 0;die();
        }else{
            echo 1;die();
        }
    }

    public function ajax_delete(){
        $param['table'] = $this->request->getPost('table');
        $param['id'] = $this->request->getPost('id');
        $flag = $this->AutoloadModel->_update([
            'table' => $param['table'],
            'data' => [
                'deleted_at' => 1
            ],
            'where' => [
                'id' => $param['id']
            ]
        ]);
        if($flag > 0){
            echo 0;die();
        }else{
            echo 1;die();
        }
    }

    public function language(){
        $keyword = $this->request->getPost('keyword');
        setcookie('language', $keyword , time() + 1*24*3600, "/");
        pre($keyword);
    }

    public function view_combo(){
        $param['id'] = $this->request->getPost('id');
        $param['module'] = $this->request->getPost('module');
        $catalogueid = $this->AutoloadModel->_get_where([
            'select' => 'comboid',
            'table' => 'combo_relationship',
            'where' => [
                'module' => $param['module'],
                'objectid' => $param['id']
            ],
            'group_by' => 'comboid'
        ], true);
        $catalogue = [];
        $object = [];
        if(isset($catalogueid) && is_array($catalogueid) && count($catalogueid)){
            foreach ($catalogueid as $key => $value) {
                $catalogue[] = $value['comboid'];
            }
        }
        if(isset($catalogue) && is_array($catalogue) && count($catalogue)){
            $object = $this->AutoloadModel->_get_where([
                'select' => 'tb1.id, tb1.type, tb1.value, tb1.time_end,tb3.canonical, tb2.objectid, tb3.title, tb4.image, tb4.price, tb4.price_promotion',
                'table' => 'combo as tb1',
                'join' => [
                    [
                        'combo_relationship as tb2', 'tb1.id = tb2.comboid AND tb2.module = \''.$param['module'].'\' ','inner'
                    ],
                    [
                        'product_translate as tb3', 'tb2.objectid = tb3.objectid AND tb3.module = \''.$param['module'].'\' AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                    ],
                    [
                        'product as tb4', 'tb2.objectid = tb4.id AND tb4.publish = 1 AND tb4.deleted_at = 0 ','inner'
                    ],
                ],
                'group_by' => 'tb2.objectid, tb1.id',
                'order_by' => 'tb1.time_end asc',
                'where_in' => $catalogue,
                'where_in_field' => 'tb1.id',
            ], TRUE);
        }
        $arr['data'] = [];
        $arr['count'] = 0;

        if(isset($object) && is_array($object) && count($object)){
            foreach ($object as $key => $value) {
                $arr['data'][$value['id']][] = $value;
            }
        }
        $arr['count'] = count($arr['data']);
        echo json_encode($arr);die();
    }
}
