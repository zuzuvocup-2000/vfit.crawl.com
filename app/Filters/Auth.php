<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\UserModel;

class Auth implements FilterInterface
{
	protected $AutoloadModel;
    protected $auth;
	public function __construct(){
        $this->usermodel = new UserModel();
        helper(['mystring']);
	}
    public function before(RequestInterface $request, $arguments = null)
    {
        if(!session()->get('isLoggedIn')) {
            return redirect()->to(BASE_URL.BACKEND_DIRECTORY);
        }
        // $user = $this->usermodel->get_user(session()->get('id')['$oid']);
        // if(!$user){
        //     $session = session();
        //     $session->destroy();
        //     return redirect()->to(BASE_URL.BACKEND_DIRECTORY);
        // }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}