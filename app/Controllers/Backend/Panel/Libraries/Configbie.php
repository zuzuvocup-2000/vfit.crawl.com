<?php

namespace App\Controllers\Backend\Panel\Libraries;
use App\Controllers\BaseController;

class ConfigBie{

	function __construct($params = NULL){
		$this->params = $params;
	}
	public function panel(){
		$data['locate'] =  array(
			0 => '-- Chọn vị trí Panel --',
            'all' => 'Tất cả các trang',
            'home' => 'Trang chủ',
            'product' => 'Khoá học',
            'product_catalogue' => 'Danh mục Khoá học',
		);
		$data['dropdown'] =  array(
			0 => '-- Chọn danh mục --',
			'product_catalogue' => 'Danh mục Khoá học',
            'product' => 'Khoá học',
            'article_catalogue' => 'Danh mục Bài viết',
            'article' => 'Bài viết',
            'media_catalogue' => 'Danh mục Media',
            'media' => 'Media',
            'author' => 'Tác giả',
		);

		return $data;
	}
}
