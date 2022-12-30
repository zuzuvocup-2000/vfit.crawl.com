<?php
namespace App\Controllers\Frontend\Search;
use App\Controllers\FrontendController;

class Search extends FrontendController{

    protected $data;

    public function __construct(){
        $this->data = [];
        $this->data['module'] = 'product';
        $this->data['language'] = $this->currentLanguage();
    }

    public function index($page = 1){
        helper(['mypagination']);
        $session = session();
        $module_extract = explode("_", $this->data['module']);
        $seoPage = '';
        $page = (int)$page;
        $perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 16;
        $keyword = $this->condition_keyword();
        $catalogue = $this->condition_catalogue();
        $config['total_rows'] = $this->AutoloadModel->_get_where([
            'select' => 'tb1.id',
            'table' => $module_extract[0].' as tb1',
            'keyword' => $keyword,
            'where_in' => $catalogue['where_in'],
            'where_in_field' => $catalogue['where_in_field'],
            'where' => [
                'tb1.deleted_at' => 0,
                'tb1.publish' => 1
            ],
            'join' => [
                [
                    'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$module_extract[0].'\' ', 'inner'
                ],
                [
                    'product_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "product" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                ]
            ],
            'count' => TRUE
        ]);
        $config['base_url'] = write_url('tim-kiem', FALSE, TRUE);
        if($config['total_rows'] > 0){
            $config = pagination_frontend(['url' => $config['base_url'],'perpage' => $perpage], $config, $page);
            $this->pagination->initialize($config);
            $this->data['pagination'] = $this->pagination->create_links();
            $totalPage = ceil($config['total_rows']/$config['per_page']);
            $page = ($page <= 0)?1:$page;
            $page = ($page > $totalPage)?$totalPage:$page;
            $seoPage = ($page >= 2)?(' - Trang '.$page):'';
            if($page >= 2){
                $this->data['canonical'] = $config['base_url'].'/trang-'.$page.HTSUFFIX;
            }
            $page = $page - 1;
            $this->data['productList'] = $this->AutoloadModel->_get_where([
                'select' => 'tb1.id,tb1.viewed,tb1.productid, tb1.image, tb3.video,tb1.price,tb1.rate, tb1.price_promotion,  tb1.album,tb1.author, tb1.author_image,  tb3.title, tb3.canonical, tb3.meta_title, tb3.meta_description, tb3.module, tb3.description, tb3.content',
                'table' => $module_extract[0].' as tb1',
                'where' => [
                    'tb1.deleted_at' => 0,
                    'tb1.publish' => 1
                ],
                'where_in' => $catalogue['where_in'],
                'where_in_field' => $catalogue['where_in_field'],
                'keyword' => $keyword,
                'join' => [
                    [
                        'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$module_extract[0].'\' ', 'inner'
                    ],
                    [
                        'product_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "product" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                    ]
                ],
                'limit' => $config['per_page'],
                'start' => $page * $config['per_page'],
                'order_by'=> 'tb1.order desc, tb1.id desc',
                'group_by' => 'tb1.id'
            ], TRUE);
        }

        $this->data['meta_title'] = (!empty( $this->data['detailCatalogue']['meta_title'])? $this->data['detailCatalogue']['meta_title']: '');
        $this->data['meta_description'] = (!empty( $this->data['detailCatalogue']['meta_description'])? $this->data['detailCatalogue']['meta_description']:'');
        $this->data['meta_image'] = !empty( $this->data['detailCatalogue']['image'])?base_url( $this->data['detailCatalogue']['image']):'';

        if(!isset($this->data['canonical']) || empty($this->data['canonical'])){
            $this->data['canonical'] = $config['base_url'].HTSUFFIX;
        }
        $this->data['detailCatalogue'] = [
            'title' => 'Search by keyword: '.$this->request->getGet('keyword'),
            'canonical' => $this->data['canonical'],
            'content' => '' ,
            'description' => ''
        ];
        $this->data['general'] = $this->general;
        $panel = get_panel([
            'locate' => 'product_catalogue',
            'language' => $this->currentLanguage()
        ]);
        foreach ($panel as $key => $value) {
            $this->data['panel'][$value['keyword']] = $value;
        }
        $this->data['template'] = 'frontend/search/index';
        return view('frontend/homepage/layout/home', $this->data);
    }

    private function condition_keyword($keyword = ''): string{
        if(!empty($this->request->getGet('keyword'))){
            $keyword = $this->request->getGet('keyword');
            $keyword = '(tb3.title LIKE \'%'.$keyword.'%\' OR tb1.author LIKE \'%'.$keyword.'%\')';
        }
        return $keyword;
    }
    public function condition_catalogue($catalogueid = 0){
        $id = [];
        $module_extract = explode("_", $this->data['module']);
        if($catalogueid > 0){
            $catalogue = $this->AutoloadModel->_get_where([
                'select' => 'tb1.id, tb1.lft, tb1.rgt, tb3.title',
                'table' => $module_extract[0].'_catalogue as tb1',
                'join' =>  [
                    [
                        'product_translate as tb3','tb1.id = tb3.objectid AND tb3.language = \''.$this->currentLanguage().'\' AND tb3.module = "product_catalogue"','inner'
                    ],
                ],
                'where' => ['tb1.id' => $catalogueid],
            ]);
            $catalogueChildren = $this->AutoloadModel->_get_where([
                'select' => 'id',
                'table' => $module_extract[0].'_catalogue',
                'where' => ['lft >=' => $catalogue['lft'],'rgt <=' => $catalogue['rgt']],
            ], TRUE);

            $id = array_column($catalogueChildren, 'id');
        }
        return [
            'where_in' => $id,
            'where_in_field' => 'tb2.catalogueid'
        ];

    }
}
