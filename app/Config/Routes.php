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
$routes->get('/dashboard', 'Backend\Statistic\Statistic::index',['filter' => 'auth' ]);
$routes->get('/support', 'Backend\Dashboard\Dashboard::support',['filter' => 'auth' ]);
$routes->get('/support/system', 'Backend\Dashboard\Dashboard::system',['filter' => 'auth' ]);
$routes->get('/support/use', 'Backend\Dashboard\Dashboard::use',['filter' => 'auth' ]);


// User
$routes->get('profile', 'Backend/User/User::profile',['filter' => 'auth' ]);
$routes->post('profile/change-password', 'Backend\User\User::change_pass',['filter' => 'auth' ]);
$routes->post('profile/update', 'Backend\User\User::update_user',['filter' => 'auth' ]);

// Website
$routes->group('/website', ['filter' => 'auth'] , function($routes){
    $routes->add('/', 'Backend\Website\Website::index');
    $routes->add('index', 'Backend\Website\Website::index');
    $routes->add('create', 'Backend\Website\Website::create');
    $routes->add('url/([a-zA-Z0-9-]+)', 'Backend\Website\Website::url/$1');
    $routes->add('url/update-status/([a-zA-Z0-9-]+)', 'Backend\Website\Website::update_status/$1');
    $routes->add('update/([a-zA-Z0-9-]+)', 'Backend\Website\Website::update/$1');
    $routes->add('delete/([a-zA-Z0-9-]+)', 'Ajax\Website\Website::delete/$1');
});

//criteria
$routes->group('/criteria', ['filter' => 'auth'] , function($routes){
    $routes->add('/', 'Backend\Criteria\Criteria::index');
    $routes->add('index', 'Backend\Criteria\Criteria::index');
    $routes->add('create', 'Backend\Criteria\Criteria::create');
    $routes->add('update/([a-zA-Z0-9-]+)', 'Backend\Criteria\Criteria::update/$1');
});

//criteria
$routes->group('/statistic', ['filter' => 'auth'] , function($routes){
    $routes->add('list', 'Backend\Statistic\Statistic::index');
    $routes->add('article/([a-zA-Z0-9-]+)', 'Backend\Statistic\Statistic::article/$1');
});

// Config
$routes->group('/config', ['filter' => 'auth'] , function($routes){
    $routes->add('article/index/([a-zA-Z0-9-]+)', 'Backend\Config\Article::index/$1');
    $routes->add('article/create/([a-zA-Z0-9-]+)', 'Backend\Config\Article::create/$1');
    $routes->add('article/update/([a-zA-Z0-9-]+)/([a-zA-Z0-9-]+)', 'Backend\Config\Article::update/$1/$2');
    $routes->add('article/delete/([a-zA-Z0-9-]+)', 'Backend\Config\Article::delete/$1');
    
    $routes->add('catalogue/index/([a-zA-Z0-9-]+)', 'Backend\Config\Catalogue::index/$1');
    $routes->add('catalogue/create/([a-zA-Z0-9-]+)', 'Backend\Config\Catalogue::create/$1');
    $routes->add('catalogue/update/([a-zA-Z0-9-]+)/([a-zA-Z0-9-]+)', 'Backend\Config\Catalogue::update/$1/$2');
    $routes->add('catalogue/delete/([a-zA-Z0-9-]+)', 'Backend\Config\Catalogue::delete/$1');
});

// User
$routes->group('/user', ['filter' => 'auth'] , function($routes){
    $routes->add('/', 'Backend\User\User::index');
    $routes->add('index', 'Backend\User\User::index');
    $routes->add('create', 'Backend\User\User::create');
    $routes->add('update/([a-zA-Z0-9-]+)', 'Backend\User\User::update/$1');
    $routes->add('delete/([a-zA-Z0-9-]+)', 'Ajax\User\User::delete/$1');
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
