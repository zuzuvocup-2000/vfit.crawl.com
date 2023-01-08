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

$routes->get('/', 'Backend/Authentication/Auth::login_view',['filter' => 'login' ]);
$routes->get('/admin', 'Backend/Authentication/Auth::login_view',['filter' => 'login' ]);
$routes->get('/login', 'Backend/Authentication/Auth::login_view',['filter' => 'login' ]);
$routes->post('/login', 'Backend/Authentication/Auth::login',['filter' => 'login' ]);
$routes->get('/logout', 'Backend/Authentication/Auth::logout');
$routes->get('/dashboard', 'Backend/Dashboard/Dashboard::index',['filter' => 'auth' ]);
$routes->get('/website', 'Backend/Website/Website::index',['filter' => 'auth' ]);

// $routes->get('([a-zA-Z0-9-]+)/([a-zA-Z0-9-]+)'.HTSUFFIX, 'Frontend\Homepage\Router::silo/$1/$2');

$routes->get(BACKEND_DIRECTORY, 'Backend/Authentication/Auth::login', ['filter' => 'login' ]);
$routes->get('backend/authentication/auth/forgot', 'Backend/Authentication/Auth::forgot', ['filter' => 'login' ]);
$routes->get('backend/authentication/auth/logout', 'Backend/Authentication/Auth::logout', ['filter' => 'auth' ]);

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
