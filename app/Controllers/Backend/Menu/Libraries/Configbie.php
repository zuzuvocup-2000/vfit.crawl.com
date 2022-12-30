<?php
namespace App\Controllers\Backend\Menu\Libraries;
use App\Controllers\BaseController;

class ConfigBie{

	function __construct($params = NULL){
		$this->params = $params;
	}
	public function menu($language = 'vi'){
		if($language == 'vi'){
			$data['article'] =  array(
				'title' => 'Bài viết',
				'translate' => true
			);
			$data['article_catalogue'] =  array(
				'title' => 'Chuyên mục bài viết',
				'translate' => true
			);
			$data['product'] =  array(
				'title' => 'Khóa học',
				'translate' => true
			);
			$data['product_catalogue'] =  array(
				'title' => 'Chuyên mục Khóa học',
				'translate' => true
			);
			$data['media'] =  array(
				'title' => 'Media',
				'translate' => true
			);
			$data['media_catalogue'] =  array(
				'title' => 'Chuyên mục media',
				'translate' => true
			);
		}
		if($language == 'en'){
			$data['article'] =  array(
				'title' => 'Blog',
				'translate' => true
			);
			$data['article_catalogue'] =  array(
				'title' => 'Blog Catalogue',
				'translate' => true
			);
			$data['media'] =  array(
				'title' => 'Media',
				'translate' => true
			);
			$data['media_catalogue'] =  array(
				'title' => 'Media Catalogue',
				'translate' => true
			);
		}

		return $data;
	}
}
