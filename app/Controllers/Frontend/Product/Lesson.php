<?php
namespace App\Controllers\Frontend\Product;
use App\Controllers\FrontendController;

class Lesson extends FrontendController{

    protected $data;

    public function __construct(){
        $this->data = [];
        $this->data['module'] = 'lesson';
        $this->data['language'] = $this->currentLanguage();
    }

    public function index($id = 0, $page = 1){
        helper(['mypagination']);
        $session = session();
        $member = (isset($_COOKIE[AUTH.'member']) ? json_decode($_COOKIE[AUTH.'member'], true) : []);
        $memberid = (isset($member['id']) ? $member['id'] : '');
        if(!isset($member) || !is_array($member) || count($member) == 0){
            $session->setFlashdata('message-danger', 'You need to login and enter the code to enter this course!');
            header('location: '.BASE_URL.'buy-lesson.html?id='.$id);die();
        }
        $panel = get_panel([
			'locate' => 'product',
			'language' => $this->currentLanguage()
		]);
        foreach ($panel as $key => $value) {
			$this->data['panel'][$value['keyword']] = $value;
		}
        $id = (int)$id;
        $catid = $id;
        $session = session();
        $module_extract = explode("_", $this->data['module']);
        $this->data['object'] = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id,tb1.time, tb1.catalogueid, tb1.viewed, tb1.album, tb1.image, tb2.title, tb2.canonical,  tb2.meta_title, tb2.sub_title,tb1.video,tb2.meta_description,  tb2.description, tb2.content, tb3.status as accept, tb4.canonical as product_canonical',
            'table' => $module_extract[0].' as tb1',
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
                'tb1.id' => $id
            ],
            'join' => [
                [
                    'lesson_translate as tb2','tb1.id = tb2.objectid AND tb2.module = "lesson" AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
                ],
                [
                    'lesson_relationship as tb3','tb1.catalogueid = tb3.productid AND tb3.memberid = \''.$memberid.'\' ','left'
                ],
                [
                    'product_translate as tb4','tb4.module = "product" AND tb4.objectid = tb1.catalogueid AND tb4.language = \''.$this->currentLanguage().'\'', 'inner'
                ],
            ],
        ]);

        if(!isset($this->data['object']) || is_array($this->data['object']) == false && count($this->data['object']) == 0){
            $session->setFlashdata('message-danger', 'The record does not exist!');
            header('location:'.BASE_URL);
        }

        if(empty($this->data['object']['accept']) == true || $this->data['object']['accept'] != 1){
            $session->setFlashdata('message-danger', 'Please contact the administrator to buy the course!');
            header('location:'.BASE_URL.$this->data['object']['product_canonical'].HTSUFFIX);die();
        }

        $this->data['productList']['productFeatured'] = $this->get_product_featured();
        $this->data['productList']['productViewed'] = $this->get_product_viewed();
        $this->data['productList']['productTrending'] = $this->get_product_trending();
        $this->data['productList']['productNewest'] = $this->get_product_newest();


        $this->data['object'] = $this->convert_data($this->data['object']);
        $this->data['detailCatalogue'] = $this->AutoloadModel->_get_where([
            'select' => ' tb1.id, tb1.image,tb1.author,  tb2.title, tb2.canonical,  tb2.content, tb2.description, tb2.meta_title, tb2.meta_description, tb3.title as cat_title, tb3.canonical as cat_canonical',
            'table' => 'product as tb1',
            'join' => [
                [
                    'product_translate as tb2','tb2.module = "product" AND tb2.objectid = tb1.id AND tb2.language = \''.$this->currentLanguage().'\'', 'inner'
                ],
                [
                    'product_translate as tb3','tb3.module = "product_catalogue" AND tb3.objectid = tb1.catalogueid AND tb3.language = \''.$this->currentLanguage().'\'', 'inner'
                ]
            ],
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
                'tb1.id' => $this->data['object']['catalogueid']
            ]
        ]);

        if(!isset($this->data['detailCatalogue']) || is_array($this->data['detailCatalogue']) == false && count($this->data['detailCatalogue']) == 0){
            $session->setFlashdata('message-danger', 'Bản ghi không tồn tại!');
            header('location:'.BASE_URL);
        }

        $this->data['lessonList'] = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id, tb1.author, tb1.catalogueid as cat_id, tb1.image,tb1.time, tb1.viewed, tb1.order, tb1.created_at,  tb1.publish, tb2.title as article_title, tb1.catalogue, tb2.objectid, tb2.content,  tb2.canonical, tb2.meta_title, tb2.meta_description, tb2.description, tb4.author, tb3.title as cat_title ',
            'table' => 'lesson as tb1',
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.catalogueid' => $this->data['object']['catalogueid'],
                'tb1.publish' => 1
            ],
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
            'order_by'=> 'tb1.order desc, tb1.id desc',
            'group_by' => 'tb1.id'
        ], TRUE);

        $this->data['meta_title'] = (!empty( $this->data['object']['meta_title']) ? $this->data['object']['meta_title']: $this->data['object']['title']);
        $this->data['meta_description'] = (!empty( $this->data['object']['meta_description'])? $this->data['object']['meta_description']:cutnchar(strip_tags( $this->data['object']['description']), 300));
        $this->data['meta_image'] = !empty( $this->data['object']['image'])?base_url( $this->data['object']['image']):((isset($this->data['object']['album'][0])) ? $this->data['object']['album'][0] : '');

        $config['base_url'] = write_url($this->data['object']['canonical'], FALSE, TRUE);
        if(!isset($this->data['canonical']) || empty($this->data['canonical'])){
            $this->data['canonical'] = $config['base_url'].HTSUFFIX;
        }

        $this->data['general'] = $this->general;
        $this->data['template'] = 'frontend/product/lesson/index';
        return view('frontend/homepage/layout/home', $this->data);
    }

    public function buy(){
        $session = session();
        $id = $this->request->getGet('id');
        $this->data['member'] = (isset($_COOKIE[AUTH.'member']) ? json_decode($_COOKIE[AUTH.'member'], true) : []);

        $this->data['object'] = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id,tb1.price,tb1.sub_album, tb1.price_promotion,tb1.catalogueid, tb1.viewed, tb1.album, tb1.image, tb2.title, tb2.canonical,tb2.sub_album_title, tb2.meta_title, tb2.sub_title,tb2.video,tb2.video_2, tb2.sub_content, tb1.productid, tb2.meta_description,  tb2.description, tb2.content, tb1.bar_code, tb1.model, tb1.brandid,tb1.time, tb1.articleid, tb1.icon, tb1.rate,  tb1.author, tb1.author_image',
            'table' => 'product as tb1',
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
                'tb1.id' => $id
            ],
            'join' => [
                [
                    'product_translate as tb2','tb1.id = tb2.objectid AND tb2.module = "product" AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
                ]
            ],
        ]);

        if(!isset($this->data['object']) || !is_array($this->data['object']) || count($this->data['object']) == 0){
            $session->setFlashdata('message-danger', 'No courses to show!');
            header('location: '.BASE_URL);die();
        }
        if($this->request->getMethod() == 'post'){
            if(!isset($this->data['member']) || !is_array($this->data['member']) || count($this->data['member']) == 0){
                $session->setFlashdata('message-danger', 'You need to login to continue using the service!');
            }else{
                $code = $this->request->getPost('code');
                $check = $this->AutoloadModel->_get_where([
                    'select' => 'id',
                    'table' => 'lesson_relationship',
                    'where' => [
                        'memberid' => $this->data['member']['id'],
                        'productid' => $id,
                        'code' => $code,
                    ]
                ]);

                if(isset($check) && is_array($check) && count($check)){
                    $this->AutoloadModel->_update([
                        'table' => 'lesson_relationship',
                        'data' => [
                            'status' => 1
                        ],
                        'where' => [
                            'memberid' => $this->data['member']['id'],
                            'productid' => $id,
                            'code' => $code,
                        ]
                    ]);
                    $session->setFlashdata('message-success', 'Enter the course code successfully!');
                    header('location: '.BASE_URL.$this->data['object']['canonical'].HTSUFFIX);die();
                }else{
                    $session->setFlashdata('message-danger', 'The course code is incorrect, please contact the administrator to get the code!');
                }

                prE($check);
            }
        }

        $this->data['general'] = $this->general;
        $this->data['template'] = 'frontend/product/lesson/buy';
        return view('frontend/homepage/layout/home', $this->data);
    }

    private function convert_data($param = []){
        if(isset($param['album']) && $param['album'] != ''){
            $param['album'] = json_decode($param['album']);
        }
        if(isset($param['info']) && $param['info'] != ''){
            $param['info'] = json_decode($param['info'], TRUE);
        }
        if(isset($param['description']) && $param['description'] != ''){
            $param['description'] = validate_input(base64_decode($param['description']));
        }
        if(isset($param['content']) && $param['content'] != ''){
            $param['content'] = validate_input(base64_decode($param['content']));
        }
        if(isset($param['sub_content']) && $param['sub_content'] != ''){
            $param['sub_content'] = json_decode(base64_decode($param['sub_content']));
        }
        if(isset($param['sub_title']) && $param['sub_title'] != ''){
            $param['sub_title'] = json_decode(base64_decode($param['sub_title']));
        }

        return $param;
    }

    private function get_product_featured(){
        $productList = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id, tb1.author,  tb1.catalogueid as cat_id, tb1.image,tb1.viewed, tb1.order,tb1.created_at,  tb1.album,   tb1.publish, tb3.title , tb1.catalogue, tb3.content,  tb3.canonical, tb3.meta_title, tb3.meta_description, tb1.author, tb1.author_image,   tb1.featured, tb1.trending ',
            'table' => 'product as tb1',
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
                'tb1.featured' => 1
            ],
            'join' => [
                [
                    'product_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "product" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                ]
            ],
            'limit' => 10,
            'order_by'=> 'tb1.order desc, tb1.id desc',
            'group_by' => 'tb1.id'
        ], TRUE);

        return $productList;
    }
    private function get_product_viewed(){
        $productList = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id, tb1.author,  tb1.catalogueid as cat_id, tb1.image,tb1.viewed, tb1.order,tb1.created_at,  tb1.album,   tb1.publish, tb3.title, tb1.catalogue, tb3.content,  tb3.canonical, tb3.meta_title, tb3.meta_description, tb1.author, tb1.author_image,   tb1.featured, tb1.trending ',
            'table' => 'product as tb1',
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
            ],
            'join' => [
                [
                    'product_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "product" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                ]
            ],
            'limit' => 10,
            'order_by'=> 'tb1.viewed desc',
            'group_by' => 'tb1.id'
        ], TRUE);

        return $productList;
    }
    private function get_product_trending(){
        $productList = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id, tb1.author,  tb1.catalogueid as cat_id, tb1.image,tb1.viewed, tb1.order,tb1.created_at,  tb1.album,   tb1.publish, tb3.title, tb1.catalogue, tb3.content,  tb3.canonical, tb3.meta_title, tb3.meta_description, tb1.author, tb1.author_image,   tb1.featured, tb1.trending ',
            'table' => 'product as tb1',
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
                'tb1.trending' => 1
            ],
            'join' => [
                [
                    'product_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "product" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                ]
            ],
            'limit' => 10,
            'order_by'=> 'tb1.order desc, tb1.id desc',
            'group_by' => 'tb1.id'
        ], TRUE);

        return $productList;
    }
    private function get_product_newest(){
        $productList = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id, tb1.author,  tb1.catalogueid as cat_id, tb1.image,tb1.viewed, tb1.order,tb1.created_at,  tb1.album,   tb1.publish, tb3.title, tb1.catalogue, tb3.content,  tb3.canonical, tb3.meta_title, tb3.meta_description, tb1.author, tb1.author_image,   tb1.featured, tb1.trending ',
            'table' => 'product as tb1',
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1,
            ],
            'join' => [
                [
                    'product_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "product" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                ]
            ],
            'limit' => 10,
            'order_by'=> 'tb1.id desc',
            'group_by' => 'tb1.id'
        ], TRUE);

        return $productList;
    }

}
