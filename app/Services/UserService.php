<?php
namespace App\Services;
use CodeIgniter\HTTP\Response;

class UserService{

   public function __construct($param){
      $this->client = \Config\Services::curlrequest();
   }

   public function getListUser(){
      try{
         $headers = ['Authorization' => "Bearer ".session()->get('accessToken')];
         $users = API_USER_LIST.'?keyword='.(isset($_GET['keyword']) ? $_GET['keyword'] : '').'&page='.(isset($_GET['page']) ? $_GET['page'] : '0').'&limit='.(isset($_GET['limit']) ? $_GET['limit'] : '20');
         $result = $this->client->get($users, [
            'debug' => true,
            'headers'=>$headers,
         ]);

         $body = json_decode($result->getBody(),true);
         if(isset($body) && is_array($body) && count($body)){
            return $body;
         }
         return [];
      }catch(\Exception $e ){
         echo $e->getMessage();die();
      }
   }

   public function getCurrentUser(){
      try{
         $headers = ['Authorization' => "Bearer ".session()->get('accessToken')];
         $result = $this->client->get(API_GET_CURRENT_USER_BY_EMAIL.session()->get('email'), [
            'debug' => true,
            'headers'=>$headers,
         ]);

         $body = json_decode($result->getBody(),true);
         if(isset($body) && is_array($body) && count($body)){
            return $body;
         }
         return [];
      }catch(\Exception $e ){
         echo $e->getMessage();die();
      }
   }

   public function changePassword(){
      $user = authentication();
      $headers = ['Authorization' => "Bearer ".session()->get('accessToken')];
      $result = $this->client->post(API_CHANGE_PASSWORD,['debug' => true,'headers'=>$headers,'json' => ['password' => $_POST['password'],'newPassword' => $_POST['new_password'], 'email' => $user['email']]]);
      return json_decode($result->getBody(),true);
   }

   public function updateUser(){
      $user = authentication();
      $headers = ['Authorization' => "Bearer ".session()->get('accessToken')];
      $result = $this->client->post(API_UPDATE_USER,['debug' => true,'headers'=>$headers,'json' => [
         'name' => $_POST['name'],
         'newEmail' => $_POST['email'], 
         'email' => $user['email']
      ]]);
      return json_decode($result->getBody(),true);
   }

   public function storeUser($request, $method){
      try{
         helper('text');
         $data = [
            'name' => $request->getPost('name'),
         ];

         if($method == 'create'){
            $data['email'] = $request->getPost('email');
            $data['password'] = $request->getPost('password');
         }else{
            $data['newEmail'] = $request->getPost('email');
            $data['email'] = $request->getPost('email_original');
         }
         return $data;
      }catch(\Exception $e ){
         echo $e->getMessage();die();
      }
   }
}
