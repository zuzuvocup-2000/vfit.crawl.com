<?php
namespace App\Services;
use CodeIgniter\HTTP\Response;

class CriteriaService{

   public function __construct($param){
      $this->client = \Config\Services::curlrequest();
   }

   public function getListCriteria(){
      try{
         $headers = ['Authorization' => "Bearer ".session()->get('accessToken')];
         $url = API_CRITERIA_LIST.'?keyword='.(isset($_GET['keyword']) ? $_GET['keyword'] : '').'&page='.(isset($_GET['page']) ? $_GET['page'] : '0').'&limit='.(isset($_GET['limit']) ? $_GET['limit'] : '20');
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

   public function storeCriteria($request){
      try{
         helper('text');
         return [
            'typeCriteria' => $request->getPost('typeCriteria'),
            'typeStatistic' => $request->getPost('typeStatistic'),
            'value' => explode(',', $request->getPost('value')),
         ];
      }catch(\Exception $e ){
         echo $e->getMessage();die();
      }
   }
}
