<?php
namespace App\Services;
use CodeIgniter\HTTP\Response;
use App\Libraries\Mailbie;

class AuthService{

   public function __construct($param){
      $this->client = \Config\Services::curlrequest();
   }

   public function login($param){
      try{
         $result = $this->client->post(API_LOGIN,['debug' => true,'json' => $param]);
         $body = json_decode($result->getBody(),true);
         return $body;
      }catch(\Exception $e ){
         echo $e->getMessage();die();
      }
   }

   public function sendOtpForgotPassword($email){
      try{
         $result = $this->client->post(API_GET_USER_BY_EMAIL,['debug' => true,'json' => ['email' => $email]]);
         $user = json_decode($result->getBody(),true);
         $otp = $this->otp(); 
         $otp_live = $this->otp_time();
         $mailbie = new MailBie();
         $otpTemplate = otp_template([
            'fullname' => $user['data']['name'],
            'otp' => $otp,
         ]);

         $flag = $mailbie->send([
            'to' => $email,
            'subject' => 'Quên mật khẩu cho tài khoản: '.$email,
            'messages' => $otpTemplate,
         ]);

         $update = [
            'email' => $email,
            'otp' => $otp,
            'otpLive' => $otp_live,
         ];
         
         $result = $this->client->post(SEND_OTP,['debug' => true,'json' => $update]);
         return $user;
      }catch(\Exception $e ){
         echo $e->getMessage();die();
      }
   }

   public function countUserHaveEmail(){
      try{
         $result = $this->client->get(API_GET_USER_BY_EMAIL.session()->get('email'), ['debug' => true,]);

         $body = json_decode($result->getBody(),true);
         if(isset($body) && is_array($body) && count($body)){
            return $body;
         }
         return [];
      }catch(\Exception $e ){
         echo $e->getMessage();die();
      }
   }

   public function resetPassword($token){
      try{
         $user = json_decode(base64_decode($token), TRUE);
         $password = random_string('alnum', 12);
         $result = $this->client->post(API_RESET_PASSWORD,['debug' => true,'json' => ['password' => $password, '_id' => $user['_id']]]);
         $body = json_decode($result->getBody(),true);
         if(isset($body['matchedCount']) && $body['matchedCount'] > 0){
            $mailbie = new Mailbie();
            $mailFlag = $mailbie->send([
               'to' => $user['email'],
               'subject' => 'Quên mật khẩu cho tài khoản: '.$user['email'],
               'messages' => '<h3>Mật khẩu mới của bạn là: '.$password.'</h3><div><a target="_blank" href="'.base_url(BACKEND_DIRECTORY).'">Click vào đây để tiến hành đăng nhập</a></div>',
            ]);
            return true;
         }

         return false;
      }catch(\Exception $e ){
         echo $e->getMessage();die();
      }
   }

   private function otp(){
      helper(['text']);
      $otp = random_string('numeric', 6);
      return $otp;
   }

   private function otp_time(){
      $timeToLive = gmdate('Y-m-d H:i:s', time() + 7*3600 + 300);
      return $timeToLive;
   }
}
