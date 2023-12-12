<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
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

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::method1');
$routes->get('finance1', 'Home::method1');
$routes->get('hypotecni-kalkulacka', 'Home::method2');
$routes->get('investicni-kalkulacka', 'Home::method3');


$routes->group('admin', static function($routes){
    $routes->group('', ['filter'=>'cifilter:auth'], static function($routes){
        //$routes->get('example-page','Home::method3');
        $routes->get('home', 'AdminController::index', ['as' => 'admin.home']);
        $routes->get('logout', 'AdminController::LogoutHandler', ['as' => 'admin.logout']);
    });

    $routes->group('', ['filter'=>'cifilter:guest'], static function($routes) {
        //$routes->get('example-auth','Home::method4');
        $routes->get('login', 'AuthController::loginForm', ['as'=>'admin.login.form']);
        $routes->post('login', 'AuthController::loginHandler', ['as'=>'admin.login.handler']);
        $routes->get('forgot-password', 'AuthController::forgotForm', ['as'=>'admin.forgot.form']);
        $routes->post('forgot-password', 'AuthController::sendPasswordResetLink', ['as'=>'send_password_reset_link']);
        $routes->get('password/reset/(:any)', 'AuthController::resetPassword/$1', ['as'=>'admin.reset-password']);
        $routes->post('password/reset/(:any)','AuthController::resetPasswordHandler/$1');
    });
});


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
