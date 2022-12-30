<?php 
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;

class Code extends BaseController{

	public function __construct(){
	}

	public function add_code(){
		try{
			$session = session();
			$response['message'] = '';
			$response['code'] = 0;
			$param['code'] = $this->request->getPost('code');
			$param['id'] = $this->request->getPost('id');
			$param['productid'] = $this->request->getPost('productid');
			
			$check = $this->AutoloadModel->_get_where([
				'select' => 'id',
				'table' => 'lesson_relationship',
				'where' => [
					'memberid' => $param['id'],
					'productid' => $param['productid'],
				],
				'count' => true
			]);

			if($check > 0){
				$response['message'] = 'Code của khóa học dành cho tài khoản này đã được tạo, xin vui lòng thử lại!';
 				$response['code'] = '23';
				echo json_encode($response);die();
			}

			$store = [
				'memberid' => $param['id'],
				'productid' => $param['productid'],
				'code' => $param['code'],
				'created_at' => $this->currentTime,
				'userid_created' => $this->auth['id']
			];

			$flag = $this->AutoloadModel->_insert([
				'table' => 'lesson_relationship',
				'data' => $store
			]);

			if($flag > 0){
				$response['message'] = 'Tạo Code khoá học cho tài khoản thành công!';
 				$response['code'] = '10';
				echo json_encode($response);die();
			}else{
				$response['message'] = 'Có lỗi xảy ra xin vui lòng thử lại!';
 				$response['code'] = '23';
				echo json_encode($response);die();
			}
		}catch(\Exception $e){
			$response['message'] = $e->getMessage();
			$response['code'] = '24';
			echo json_encode($response);die();
		}
	}

	public function render_lesson(){
		try{
			$session = session();
			$response['message'] = '';
			$response['code'] = 0;
			$param['productid'] = $this->request->getPost('productid');
			
			$data = $this->AutoloadModel->_get_where([
				'select' => 'tb1.code, tb2.email, tb1.memberid',
				'table' => 'lesson_relationship as tb1',
				'join' => [
					[
						'member as tb2', 'tb1.memberid = tb2.id AND tb2.publish = 1 AND tb2.deleted_at = 0', 'inner'
					]
				],
				'where' => [
					'productid' => $param['productid'],
				],
			], true);
			$html = '';
			if(isset($data) && is_array($data) && count($data)){
				$count = 1;
				foreach ($data as $key =>  $value) {
				    $html = $html .'<tr>';
	                    $html = $html .'<td class="text-center">'.$count.'</td>';
	                    $html = $html .'<td class="text-center">'.$value['memberid'].'</td>';
	                    $html = $html .'<td>'.$value['email'].'</td>';
	                    $html = $html .'<td class="text-center">'.$value['code'].'</td>';
	                $html = $html .'</tr>';
				$count++;}
			}else{
				$html = $html .'<tr>';
                    $html = $html .'<td colspan="100%"><span class="text-danger">Không có dữ liệu phù hợp...</span></td>';
                $html = $html .'</tr>';
			}

			$response['message'] = 'Tạo Code khoá học cho tài khoản thành công!';
			$response['code'] = '10';
			$response['html'] = $html;
			echo json_encode($response);die();
			
		}catch(\Exception $e){
			$response['message'] = $e->getMessage();
			$response['code'] = '24';
			echo json_encode($response);die();
		}
	}

}