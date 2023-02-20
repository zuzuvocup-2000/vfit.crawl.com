<?php
namespace App\Services;
use CodeIgniter\HTTP\Response;

class WebsiteService{

   public function __construct($param){
      $this->client = \Config\Services::curlrequest();
   }

   public function getListWebsite(){
      try{
         $headers = ['Authorization' => "Bearer ".session()->get('accessToken')];
         $url = API_WEBSITE_LIST.'?keyword='.(isset($_GET['keyword']) ? $_GET['keyword'] : '').'&page='.(isset($_GET['page']) ? $_GET['page'] : '0').'&limit='.(isset($_GET['limit']) ? $_GET['limit'] : '20');
         $result = $this->client->get($url, [
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

   public function storeWebsite($request){
      try{
         helper('text');
         return [
            'url' => $request->getPost('url'),
            'type' => $request->getPost('type'),
            'typeCrawl' => $request->getPost('typeCrawl'),
            'status' => $request->getPost('status'),
         ];
      }catch(\Exception $e ){
         echo $e->getMessage();die();
      }
   }

   public function getListUrlFromWebsite($id){
      try{
         $headers = ['Authorization' => "Bearer ".session()->get('accessToken')];
         $urls = API_WEBSITE_GET_ALL_URLS.'/'.$id.'?keyword='.(isset($_GET['keyword']) ? $_GET['keyword'] : '').'&page='.(isset($_GET['page']) ? $_GET['page'] : '0').'&limit='.(isset($_GET['limit']) ? $_GET['limit'] : '100');
         $result = $this->client->get($urls, [
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
