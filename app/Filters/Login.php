<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\AutoloadModel;

class Login implements FilterInterface
{
	protected $auth;
	protected $user;
	protected $AutoloadModel;

	public function __construct(){
		$this->AutoloadModel = new AutoloadModel();
        helper(['mystring']);
	}

    public function before(RequestInterface $request, $arguments = null)
    {
        if(session()->get('isLoggedIn') == true){
            return redirect()->to(BASE_URL.'statistic/list');
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}