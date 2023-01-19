<?php
namespace App\Services;
use CodeIgniter\HTTP\Response;

class UserService{

   public function __construct($param){
      $this->client = \Config\Services::curlrequest();
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
}
