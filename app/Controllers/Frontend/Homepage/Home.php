<?php
namespace App\Controllers\Frontend\Homepage;
use App\Controllers\FrontendController;

class Home extends FrontendController{

	public $data = [];

	public function __construct(){
		$this->data['module'] = 'home';
		$this->data['language'] = $this->currentLanguage();
	}

	public function index(){
        $session = session();

		$this->data['general'] = $this->general;
		$this->data['meta_title'] = (isset($this->data['general']['seo_meta_title']) ? $this->data['general']['seo_meta_title'] : '');
		$this->data['meta_description'] = (isset($this->data['general']['seo_meta_description']) ? $this->data['general']['seo_meta_description'] : '');
		$this->data['og_type'] = 'website';
		$this->data['canonical'] = BASE_URL;

// 		$this->data['productList']['productFeatured'] = $this->get_product_featured();
// 		$this->data['productList']['productViewed'] = $this->get_product_viewed();
// 		$this->data['productList']['productTrending'] = $this->get_product_trending();
// 		$this->data['productList']['productNewest'] = $this->get_product_newest();
// 		$panel = get_panel([
// 			'locate' => 'home',
// 			'language' => $this->data['language']
// 		]);
// 		foreach ($panel as $key => $value) {
// 			$this->data['panel'][$value['keyword']] = $value;
// 		}
		$this->data['slide'] = get_slide(['keyword' => 'main-slide','language' => $this->data['language']]);
		$this->data['banner'] = get_slide(['keyword' => 'banner','language' => $this->data['language']]);
		$this->data['home'] = 'home';
		// $this->data['template'] = 'frontend/homepage/home/index';
		return view('frontend/homepage/home/index', $this->data);
	}

	public function index_vi(){
        $session = session();

		$this->data['general'] = $this->general;
		$this->data['meta_title'] = (isset($this->data['general']['seo_meta_title']) ? $this->data['general']['seo_meta_title'] : '');
		$this->data['meta_description'] = (isset($this->data['general']['seo_meta_description']) ? $this->data['general']['seo_meta_description'] : '');
		$this->data['og_type'] = 'website';
		$this->data['canonical'] = BASE_URL;

// 		$this->data['productList']['productFeatured'] = $this->get_product_featured();
// 		$this->data['productList']['productViewed'] = $this->get_product_viewed();
// 		$this->data['productList']['productTrending'] = $this->get_product_trending();
// 		$this->data['productList']['productNewest'] = $this->get_product_newest();
// 		$panel = get_panel([
// 			'locate' => 'home',
// 			'language' => $this->data['language']
// 		]);
// 		foreach ($panel as $key => $value) {
// 			$this->data['panel'][$value['keyword']] = $value;
// 		}
		$this->data['slide'] = get_slide(['keyword' => 'main-slide','language' => $this->data['language']]);
		$this->data['banner'] = get_slide(['keyword' => 'banner','language' => $this->data['language']]);
		$this->data['home'] = 'home';
		// $this->data['template'] = 'frontend/homepage/home/index_vi';
		return view('frontend/homepage/home/index_vi', $this->data);
	}
    
    public function Original(){
        $session = session();

		$this->data['general'] = $this->general;
		$this->data['meta_title'] = (isset($this->data['general']['seo_meta_title']) ? $this->data['general']['seo_meta_title'] : '');
		$this->data['meta_description'] = (isset($this->data['general']['seo_meta_description']) ? $this->data['general']['seo_meta_description'] : '');
		$this->data['og_type'] = 'website';
		$this->data['canonical'] = BASE_URL;

		$this->data['productList']['productFeatured'] = $this->get_product_featured();
		$this->data['productList']['productViewed'] = $this->get_product_viewed();
		$this->data['productList']['productTrending'] = $this->get_product_trending();
		$this->data['productList']['productNewest'] = $this->get_product_newest();
		$panel = get_panel([
			'locate' => 'home',
			'language' => $this->data['language']
		]);
		foreach ($panel as $key => $value) {
			$this->data['panel'][$value['keyword']] = $value;
		}
		$this->data['slide'] = get_slide(['keyword' => 'main-slide','language' => $this->data['language']]);
		$this->data['banner'] = get_slide(['keyword' => 'banner','language' => $this->data['language']]);
		$this->data['home'] = 'home';
		// $this->data['template'] = 'frontend/homepage/home/Original';
		return view('frontend/homepage/home/Original', $this->data);
	}
	
	public function Original_vi(){
        $session = session();

		$this->data['general'] = $this->general;
		$this->data['meta_title'] = (isset($this->data['general']['seo_meta_title']) ? $this->data['general']['seo_meta_title'] : '');
		$this->data['meta_description'] = (isset($this->data['general']['seo_meta_description']) ? $this->data['general']['seo_meta_description'] : '');
		$this->data['og_type'] = 'website';
		$this->data['canonical'] = BASE_URL;

		$this->data['productList']['productFeatured'] = $this->get_product_featured();
		$this->data['productList']['productViewed'] = $this->get_product_viewed();
		$this->data['productList']['productTrending'] = $this->get_product_trending();
		$this->data['productList']['productNewest'] = $this->get_product_newest();
		$panel = get_panel([
			'locate' => 'home',
			'language' => $this->data['language']
		]);
		foreach ($panel as $key => $value) {
			$this->data['panel'][$value['keyword']] = $value;
		}
		$this->data['slide'] = get_slide(['keyword' => 'main-slide','language' => $this->data['language']]);
		$this->data['banner'] = get_slide(['keyword' => 'banner','language' => $this->data['language']]);
		$this->data['home'] = 'home';
		// $this->data['template'] = 'frontend/homepage/home/Original_vi';
		return view('frontend/homepage/home/Original_vi', $this->data);
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
