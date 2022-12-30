<?php
namespace App\Controllers\Ajax\Frontend;
use App\Controllers\FrontendController;

class Cart extends FrontendController{

	public $cart;
	public function __construct(){
		$this->cart = \Config\Services::cart();
	}

	public function add_combo(){
		$response = [];
		try {
			$sku = $this->request->getPost('sku');
			$id = $this->request->getPost('id');
			$combo = $this->AutoloadModel->_get_where([
                'select' => 'tb1.id, tb1.type, tb1.value, tb1.time_end,tb3.canonical, tb2.objectid, tb3.title, tb4.image, tb4.price, tb4.price_promotion',
                'table' => 'combo as tb1',
                'join' => [
                    [
                        'combo_relationship as tb2', 'tb1.id = tb2.comboid AND tb2.module = "product" ','inner'
                    ],
                    [
                        'product_translate as tb3', 'tb2.objectid = tb3.objectid AND tb3.module = "product" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
                    ],
                    [
                        'product as tb4', 'tb2.objectid = tb4.id AND tb4.publish = 1 AND tb4.deleted_at = 0 ','inner'
                    ],
                ],
                'group_by' => 'tb2.objectid, tb1.id',
                'order_by' => 'tb1.time_end asc',
                'where_in' => $id,
                'where_in_field' => 'tb1.id',
            ], TRUE);
            $cartData = [];
            if(isset($combo) && is_array($combo) && count($combo)){
            	foreach ($combo as $key => $value) {
            		$price = price($value['price'], $value['price_promotion']);
            		$new_price = $price['finalPrice'];
            		if($value['type'] == 'normal'){
						$new_price = (($price['finalPrice'] > $value['value']) ? ($price['finalPrice'] - $value['value']) : $price['finalPrice']);
					}else if($value['type'] == 'percent'){
						$new_price = (($value['value'] > 0) ? ($price['finalPrice'] - ($price['finalPrice'] * $value['value'] / 100) ) : $price['finalPrice']);
					}
            		$cartData = [
						'id'      		=> strtoupper($value['type']).'_'.$value['id'].'_'.$value['objectid'],
						'qty'     		=> 1,
						'price'   		=> $new_price,
						'name'    		=> $value['title'],
						'combo_price'   => $value['value'],
						'type'	  		=> $value['type'],
						'comboid'	  	=> $value['id'],
					];
					$flag = $this->cart->insert($cartData);

            	}
            }


			$response['message'] = 'Thêm sản phẩm vào giỏ hàng thành công';
			$response['code'] = '10';
			$response['totalItems'] = count($this->cart->contents());

		}catch(Exception $e) {
			$response['message'] = $e->getMessage();
			$response['code'] = '99';
		}

		echo json_encode([
			'response' => $response
		]);die();
	}

	public function insert(){
		$response = [];
		try {
			$sku = $this->request->getPost('sku');
			$qty = $this->request->getPost('qty');
			$objectId = str_replace('SKU_','', $sku);
			$object = $this->AutoloadModel->_get_where([
				'select' => 'tb1.id, tb2.title, tb1.price, tb1.price_promotion',
				'table' => 'product as tb1',
				'join' => [
					['product_translate as tb2', 'tb1.id = tb2.objectid', 'inner']
				],
				'where' => ['tb1.publish' => 1,'tb1.deleted_at' => 0,'tb1.id' => $objectId, 'tb2.module' => 'product']
			]);

			$price = price($object['price'], $object['price_promotion']);
			$option = makeCartOption();
			if(isset($option) && is_array($option) && count($option)){
				$cart['options'] = $option;
			}
			$cartData = [
				'id'      => $sku,
				'qty'     => (int)$qty,
				'price'   => $price['finalPrice'],
				'name'    => $object['title'],
			];


			$flag = $this->cart->insert($cartData);
			$response['message'] = 'Thêm sản phẩm vào giỏ hàng thành công';
			$response['code'] = '10';
			$response['totalItems'] = count($this->cart->contents());

		}catch(Exception $e) {
			$response['message'] = $e->getMessage();
			$response['code'] = '99';
		}

		echo json_encode([
			'response' => $response
		]);die();
	}

	public function change_quantity(){
		$qty = $this->request->getPost('quantity');
		$rowid = $this->request->getPost('code');
		$cart = $this->cart->contents();

		$cartUpdate = array(
		   'rowid'   => $rowid,
		   'qty'     => $qty,
	   );
		$this->cart->update($cartUpdate);

	}


	public function remove(){
		$rowid= $this->request->getPost('code');
		$content = $this->cart->remove($rowid);
		die();
	}

	public function remove_combo(){
		$response = [];
		try {
			$param['code']= $this->request->getPost('code');
			$param['comboid']= $this->request->getPost('comboid');
			$param['type']= $this->request->getPost('type');
			$param['value']= $this->request->getPost('value');
			$cart = $this->cart->contents();
			$object = [];
			if(isset($cart) && is_array($cart) && count($cart)){
				foreach ($cart as $key => $value) {
					if(isset($value['comboid']) && $value['comboid'] == $param['comboid']){
				    	$object[] = $value;
					}
				}
			}

			if(isset($object) && is_array($object) && count($object)){
				foreach ($object as $key => $value) {
					$content = $this->cart->remove($value['rowid']);
				}
			}

			$response['message'] = 'Xóa combo thành công';
			$response['code'] = '10';
			$response['totalItems'] = count($this->cart->contents());

		}catch(Exception $e) {
			$response['message'] = $e->getMessage();
			$response['code'] = '99';
		}

		echo json_encode([
			'response' => $response
		]);die();
	}
}
