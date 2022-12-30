<?php 
namespace App\Controllers\Ajax\Frontend;
use App\Controllers\FrontendController;
use App\Libraries\Mailbie;
use App\Controllers\Backend\Contact\Libraries\Configbie;

class Action extends FrontendController{
	public $contact_configbie;
	
	public function __construct(){
		$this->contact_configbie = new ConfigBie();
	}

    public function create_cookie_order(){
        $param['id'] = $this->request->getPost('id');
        $param['title'] = $this->request->getPost('title');
        $param['image'] = $this->request->getPost('image');
        $cookie  = (isset($_COOKIE[AUTH.'order']) ? json_decode($_COOKIE[AUTH.'order'],true) : []);
        if(isset($cookie) && is_array($cookie) && count($cookie)){
            $check = true;
            foreach ($cookie as $key => $value) {
                if($value['id'] == $param['id']){
                    $check = false;
                }
            }
            if($check == true){
                $cookie[] = [
                    'id' => $param['id'] ,
                    'title' => $param['title'] ,
                    'image' => $param['image'] ,
                    'quantity' => 1 ,
                ];
            }
        }else{
            $cookie[] = [
                'id' => $param['id'] ,
                'title' => $param['title'] ,
                'image' => $param['image'] ,
                'quantity' => 1 ,
            ];
        }


        setcookie(AUTH.'order', json_encode($cookie), time() + 1*24*3600, "/");
        $html = $this->render_order($cookie);
        echo json_encode([
            'html' => $html
        ]);die();
    }

    public function change_quantity_order(){
        $param['id'] = $this->request->getPost('id');
        $param['val'] = $this->request->getPost('val');
        $cookie  = (isset($_COOKIE[AUTH.'order']) ? json_decode($_COOKIE[AUTH.'order'],true) : []);
        if(isset($cookie) && is_array($cookie) && count($cookie)){
            foreach ($cookie as $key => $value) {
                if($value['id'] == $param['id']){
                    $cookie[$key]['quantity'] = $param['val'];
                }
            }
        }
        setcookie(AUTH.'order', json_encode($cookie), time() + 1*24*3600, "/");
    }

    public function delete_order(){
        $param['id'] = $this->request->getPost('id');
        $param['val'] = $this->request->getPost('val');
        $cookie  = (isset($_COOKIE[AUTH.'order']) ? json_decode($_COOKIE[AUTH.'order'],true) : []);
        if(isset($cookie) && is_array($cookie) && count($cookie)){
            foreach ($cookie as $key => $value) {
                if($value['id'] == $param['id']){
                    unset($cookie[$key]);
                }
            }
        }
        setcookie(AUTH.'order', json_encode($cookie), time() + 1*24*3600, "/");
        echo 1;die();
    }

    public function submit_order(){
        try{
            $session = session();
            $response['message'] = '';
            $response['code'] = 0;
            $param['form'] = $this->request->getPost('form');
            $form = [];
            if(isset($param['form']) && is_array($param['form']) && count($param['form'])){
                foreach ($param['form'] as $key => $value) {
                    if($value['name'] != 'name' && $value['name'] != 'phone'){
                        $form[$value['name']][] = $value['value'];
                    }else{
                        $form[$value['name']] = $value['value'];
                    }
                }
            }
            if($form['name'] == '' || $form['phone'] == ''){
                $response['message'] = 'Bạn phải nhập họ tên và số điện thoại!';
                $response['code'] = '23';
                echo json_encode($response);die();
            }
            $store = [];
            if(isset($form['id']) && is_array($form['id']) && count($form['id'])){
                $store = [
                    'fullname' => $form['name'],
                    'phone' => $form['phone'],
                    'title' => 'Xin vui lòng báo giá cho sản phẩm' ,
                    'contactid' => $this->contact_id_generator(),
                    'created_at' => $this->currentTime,
                    'type' => 'baogia'
                ];
                $store['content'] = 'Báo giá cho sản phẩm:';
                foreach ($form['id'] as $key => $value) {
                    $store['content'] = $store['content'] .'<br><a href="/backend/product/product/index?id='.$value.'" target="_blank">'.$form['title'][$key].'</a> với số lượng là: '.$form['modal_quantity'][$key].'';
                }
            }
            $flag = 0;
            if(isset($store) && is_array($store) && count($store)){
                $flag = $this->AutoloadModel->_insert([
                    'table' => 'contact',
                    'data' => $store
                ]);
            }
            if($flag > 0){
                unset($_COOKIE[AUTH.'order']); 
                setcookie(AUTH.'order', null, -1, '/'); 
                $response['message'] = 'Báo giá thành công!';
                $response['code'] = '10';
                echo json_encode($response);die();
            }else{
                $response['message'] = 'Có lỗi xảy ra xin vui lòng thử lại!';
                $response['code'] = '10';
                echo json_encode($response);die();
            }
        }catch(\Exception $e){
            $response['message'] = $e->getMessage();
            $response['code'] = '24';
            echo json_encode($response);die();
        }
    }

    public function render_order($cookie = []){
        $html = '';
        $count = 1;
        if(isset($cookie) && is_array($cookie) && count($cookie)){
            foreach ($cookie as $key => $value) {
                $html = $html .'<tr class="post-order" data-id="'.$value['id'].'">';
                    $html = $html .'<td class="uk-text-center">'.$count.'</td>';
                    $html = $html .'<td class="uk-flex uk-flex-middle">';
                        $html = $html .'<img src="'.$value['image'].'" class="img-order mr10" alt="">';
                        $html = $html .$value['title'];
                        $html = $html .'<input type="hidden" name="id" value="'.$value['id'].'">';
                        $html = $html .'<input type="hidden" name="title" value="'.$value['title'].'">';
                        $html = $html .'<input type="hidden" name="image" value="'.$value['image'].'">';
                    $html = $html .'</td>';
                    $html = $html .'<td class="uk-text-center"><input style="width: 60px;" type="text" name="modal_quantity" value="'.$value['quantity'].'" class="form-control int"></td>';
                    $html = $html .'<td><a href="" class="remove-modal-order uk-display-block uk-text-center"><i class="fa fa-trash" aria-hidden="true"></i></a></td>';
                $html = $html .'</tr>';
                $count++;
            }
        }
        return $html;
    }

 	public function contact_email(){
        $email = $this->request->getPost('email');
        $type = $this->contact_configbie->select();
        $store = [
            'email' => $email,
            'type' => 'email',
            'contactid' => $this->contact_id_generator(),
            'deleted_at' => 0,
            'title' => str_replace('[email]', $email, $type['text']['email']),
            'created_at' => $this->currentTime
        ];

        $insert = $this->AutoloadModel->_insert([
            'table' => 'contact',
            'data' => $store
        ]);
        if($insert > 0){
            return 'success';
        }else{
            return 'error';
        }
    }

    public function contact_full(){
        $email = $this->request->getPost('email');
        $fullname = $this->request->getPost('fullname');
        $message = $this->request->getPost('message');
        $phone = $this->request->getPost('phone');
        $type = $this->contact_configbie->select();
        $store = [
            'email' => $email,
            'fullname' => $fullname,
            'phone' => $phone,
            'content' => $message,
            'type' => 'ticket',
            'contactid' => $this->contact_id_generator(),
            'deleted_at' => 0,
            'title' => str_replace('[fullname]', $fullname, $type['text']['ticket']),
            'created_at' => $this->currentTime
        ];
        $insert = $this->AutoloadModel->_insert([
            'table' => 'contact',
            'data' => $store
        ]);
        if($insert > 0){
            return 'success';
        }else{
            return 'error';
        }
    }

    public function contact_support(){
        $email = $this->request->getPost('email');
        $fullname = $this->request->getPost('fullname');
        $phone = $this->request->getPost('phone');
        $message = $this->request->getPost('message');
        $type = $this->contact_configbie->select();
        $store = [
            'email' => $email,
            'fullname' => $fullname,
            'phone' => $phone,
            'content' => $message,
            'type' => 'support',
            'contactid' => $this->contact_id_generator(),
            'deleted_at' => 0,
            'title' => str_replace('[fullname]', $fullname, $type['text']['support']),
            'created_at' => $this->currentTime
        ];
        $insert = $this->AutoloadModel->_insert([
            'table' => 'contact',
            'data' => $store
        ]);
        if($insert > 0){
            return 'success';
        }else{
            return 'error';
        }
    }

    private function contact_id_generator(){
        $order = $this->AutoloadModel->_get_where([
            'select' => 'id',
            'table' => 'contact',
            'order_by' => 'id desc'
        ]);
        $lastId = 0;
        if(!isset($order) || is_array($order) == false || count($order) == 0){
            $lastId = 1;
        }else{
            $lastId = $order['id']+1;
        }
        $orderId = 'CT_'.str_pad($lastId, 6, '0', STR_PAD_LEFT);
        return $orderId;
    }
}
