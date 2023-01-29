<?php 
namespace App\Validation;
use App\Models\AutoloadModel;
use CodeIgniter\HTTP\RequestInterface;

class SiteRules {

	protected $AutoloadModel;
	protected $user;
	protected $helper = ['mystring'];
	protected $request;

	public function __construct(){
		$this->client = \Config\Services::curlrequest();

	}

	public function unique_url(string $url = '', string $method = ''){

		$headers = ['Authorization' => "Bearer ".session()->get('accessToken')];
		$result = $this->client->get(API_WEBSITE_GET_BY_URL.'?url='.$url,['headers' => $headers,'debug' => true]);
		$body = json_decode($result->getBody(),true);
		if(isset($body['data']) && is_array($body['data']) && count($body['data'])){
			if($method == 'update'){
				if($url == $_POST['url_original']){
					return true;
				}
				return false;
			}
			return false;
		}
		return true;
	}
}

