<?php
namespace App\Services;
use CodeIgniter\HTTP\Response;

class ConfigCatalogueService{

   public function __construct($param){
      $this->client = \Config\Services::curlrequest();
   }

   public function getListConfigCatalogue($id){
      try{
         $headers = ['Authorization' => "Bearer ".session()->get('accessToken')];
         $configCatalogues = API_CONFIG_CATALOGUE_GET_BY_SITEID.'/'.$id.'?keyword='.(isset($_GET['keyword']) ? $_GET['keyword'] : '').'&page='.(isset($_GET['page']) ? $_GET['page'] : '0').'&limit='.(isset($_GET['limit']) ? $_GET['limit'] : '20');
         $result = $this->client->get($configCatalogues, [
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

   public function storeConfigCatalogue($request, $id){
      try{
         helper('text');
         $store = [
            'group' => $request->getPost('group'),
            'dataType' => $request->getPost('dataType'),
            'siteId' => $id,
         ];

         if($store['dataType'] == 'RATE'){
            $store['selector'] = json_encode($request->getPost('selector'));
         }else{
            $store['selector'] = $request->getPost('selector');
         }
         return $store;
      }catch(\Exception $e ){
         echo $e->getMessage();die();
      }
   }
}
