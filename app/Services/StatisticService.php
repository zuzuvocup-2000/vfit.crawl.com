<?php
namespace App\Services;
use CodeIgniter\HTTP\Response;

class StatisticService{

   public function __construct($param){
      $this->client = \Config\Services::curlrequest();
   }

   public function getListStatistic(){
      try{
         $headers = ['Authorization' => "Bearer ".session()->get('accessToken')];
         $url = API_STATISTIC_LIST.'?point='.(isset($_GET['point']) ? $_GET['point'] : '').'&page='.(isset($_GET['page']) ? $_GET['page'] : '0').'&limit='.(isset($_GET['limit']) ? $_GET['limit']*2 : 100*2);
         $result = $this->client->get($url, [
            'debug' => true,
            'headers'=>$headers,
         ]);

         $body = json_decode($result->getBody(),true);
         $new_array = [];
         // if(isset($body['data']) && is_array($body['data']) && count($body['data'])){
         //    foreach ($body['data'] as $key => $value) {
         //       $body['data'][$key]['total'] = 0;
         //       $body['data'][$key]['total_bad'] = 0;
         //       $body['data'][$key]['total_good'] = 0;
         //       if(isset($body['data'][$key]['bad']) && is_array($body['data'][$key]['bad']) && count($body['data'][$key]['bad'])){
         //          $bad = $body['data'][$key]['bad'];
         //          $body['data'][$key]['bad'] = [];
         //          foreach ($bad as $item) {
         //             $keyItem = key($item);
         //             $valueItem = $item[$keyItem];
         //             $body['data'][$key]['bad'][$keyItem] = $valueItem;
         //          }
         //          // pre($body['data'][$key]['bad']);

         //          foreach ($body['data'][$key]['bad'] as $valueBad) {
         //             $body['data'][$key]['total']+= (int)$valueBad;
         //             $body['data'][$key]['total_bad']+= (int)$valueBad;
         //          }
         //       }

         //       if(isset($body['data'][$key]['good']) && is_array($body['data'][$key]['good']) && count($body['data'][$key]['good'])){
         //          $good = $body['data'][$key]['good'];
         //          $body['data'][$key]['good'] = [];

         //          foreach ($good as $item) {
         //             $keyItem = key($item);
         //             $valueItem = $item[$keyItem];
         //             $body['data'][$key]['good'][$keyItem] = $valueItem;
         //          }
         //          foreach ($body['data'][$key]['good'] as $valueGood) {
         //             $body['data'][$key]['total']+= (int)$valueGood;
         //             $body['data'][$key]['total_good']+= (int)$valueGood;
         //          }
         //       }
         //    }

         //    foreach ($body['data'] as $key => $value) {
         //       $new_array[$value['articleId']['_id']] = [
         //          'title' => $value['articleId']['title'],
         //          'articleId' => $value['articleId']['_id'],
         //          'url' => $value['articleId']['url'],
         //          '_id' => $value['_id'],
         //          'total' => 0,
         //       ];

         //       $body['data'][$key]['articleId'] = $value['articleId']['_id'];

         //    }
         //    foreach ($body['data'] as $key => $value) {
         //       foreach ($new_array as $keyChild => $valueChild) {
         //          if($value['articleId'] == $keyChild){
         //             if($value['typeCriteria'] == 'CONTENT') {
         //                $new_array[$keyChild]['content'] = $value;
         //                $new_array[$keyChild]['total'] += $value['total'];
         //             }
         //             if($value['typeCriteria'] == 'RATE') {
         //                $new_array[$keyChild]['rate'] = $value;
         //                $new_array[$keyChild]['total'] += $value['total'];
         //             }
         //          }
         //       }
         //    }
         //    $body['data'] = $new_array;
         // }
         return $body;
      }catch(\Exception $e ){
         echo $e->getMessage();die();
      }
   }
}
