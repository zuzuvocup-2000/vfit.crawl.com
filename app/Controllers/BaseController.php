<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;
use App\Models\AutoloadModel;
use App\Libraries\Authentication;
use App\Libraries\Pagination;
use App\Libraries\Mobile_Detect;

class BaseController extends Controller
{

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['form','url','myauthentication','mystring','nestedtset', 'myurl', 'mypagination'];
    public $currentTime;
    public $AutoloadModel;
    public $request;
    protected $pagination;
    public $authentication;
    public $defaulLanguage;
    public $currentLanguage;
    /**
     * Constructor.
     */
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        $this->AutoloadModel = new AutoloadModel();
        $this->authentication = new Authentication();
        $this->pagination = new Pagination();
        // E.g.:
        // $this->session = \Config\Services::session();
        // $this->db = \Config\Database::connect();
        $this->request = \Config\Services::request();

        //
        $this->client = new \CodeIgniter\HTTP\CURLRequest(
            new \Config\App(),
            new \CodeIgniter\HTTP\URI(),
            new \CodeIgniter\HTTP\Response(new \Config\App())
        );
        $this->currentTime =  gmdate('Y-m-d H:i:s', time() + 7*3600);
        helper($this->helpers);
    }
}
