<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();
// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}
/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

$routes->get('/', 'Backend\Authentication\Auth::login_view',['filter' => 'login' ]);
$routes->get('/admin', 'Backend\Authentication\Auth::login_view',['filter' => 'login' ]);
$routes->get('/login', 'Backend\Authentication\Auth::login_view',['filter' => 'login' ]);
$routes->post('/login', 'Backend\Authentication\Auth::login',['filter' => 'login' ]);
$routes->get('/logout', 'Backend\Authentication\Auth::logout', ['filter' => 'auth' ]);
$routes->get(BACKEND_DIRECTORY, 'Backend\Authentication\Auth::login', ['filter' => 'login' ]);
$routes->match(['get','post'],'forgot', 'Backend\Authentication\Auth::forgot', ['filter' => 'login' ]);
$routes->match(['get','post'],'verify', 'Backend\Authentication\Auth::verify', ['filter' => 'login' ]);
$routes->get('/dashboard', 'Backend\Dashboard\Dashboard::index',['filter' => 'auth' ]);


// User
$routes->get('/profile', 'Backend/User/User::profile',['filter' => 'auth' ]);

// Website
$routes->group('/website', ['filter' => 'auth'] , function($routes){
    $routes->add('/', 'Backend\Website\Website::index');
    $routes->add('index', 'Backend\Website\Website::index');
    $routes->add('create', 'Backend\Website\Website::create');
    $routes->add('update/([a-zA-Z0-9-]+)', 'Backend\Website\Website::update/$1');
    $routes->add('delete/([a-zA-Z0-9-]+)', 'Ajax\Website\Website::delete/$1');
    $routes->add('crawl-sitemap', 'Ajax\Website\Website::crawl_sitemap');
    $routes->add('crawl-normal', 'Ajax\Website\Website::crawl_normal');
    $routes->add('crawl-javascript', 'Ajax\Website\Website::crawl_javascript');
});

// Config
$routes->group('/config', ['filter' => 'auth'] , function($routes){
    $routes->add('article/index', 'Backend\Config\Article::index');
    $routes->add('catalogue/index', 'Backend\Config\Catalogue::index');
});

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
