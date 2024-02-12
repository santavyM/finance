<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

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
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

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
$routes->get('kolik-investicni-kalkulacka', 'Home::method5');
$routes->get('rent-kalkulacka', 'Home::method6');
$routes->get('blog', 'BlogController::index');
$routes->get('post/(:any)','BlogController::readPost/$1',['as'=>'read-post']);
$routes->get('category/(:any)','BlogController::categoryPosts/$1',['as'=>'category-posts']);
$routes->get('tag/(:any)','BlogController::tagPosts/$1',['as'=>'tag-posts']);
$routes->get('search','BlogController::searchPosts',['as'=>'search-posts']);
$routes->get('contact-us','BlogController::contactUs',['as'=>'contact-us']);
$routes->post('contact-us','BlogController::contactUsSend',['as'=>'contact-us-send']);

$routes->group('admin', static function($routes){

       $routes->group('', ['filter'=>'cifilter:auth'], static function($routes){
        //    $routes->view('example-page','example-page');
          $routes->get('home','AdminController::index',['as'=>'admin.home']);
          $routes->get('logout','AdminController::logoutHandler',['as'=>'admin.logout']);
          $routes->get('profile','AdminController::profile',['as'=>'admin.profile']);
          $routes->post('update-personal-details','AdminController::updatePersonalDetails',['as'=>'update-personal-details']);
          $routes->get('settings','AdminController::settings',['as'=>'settings']);
          $routes->post('update-general-settings','AdminController::updateGeneralSettings',['as'=>'update-general-settings']);
          $routes->post('update-blog-logo','AdminController::updateBlogLogo',['as'=>'update-blog-logo']);
          $routes->post('update-blog-favicon','AdminController::updateBlogFavicon',['as'=>'update-blog-favicon']);
          $routes->post('update-social-media','AdminController::updateSocialMedia',['as'=>'update-social-media']);
          //kategorie
          $routes->get('categories','AdminController::categories',['as'=>'categories']);
          $routes->post('add-category','AdminController::addCategory',['as'=>'add-category']);
          $routes->get('get-categories','AdminController::getCategories',['as'=>'get-categories']);
          $routes->get('get-category','AdminController::getCategory',['as'=>'get-category']);
          $routes->post('update-category','AdminController::updateCategory',['as'=>'update-category']);
          $routes->get('delete-category','AdminController::deleteCategory',['as'=>'delete-category']);
          $routes->get('reorder-categories','AdminController::reorderCategories',['as'=>'reorder-categories']);
          $routes->get('get-parent-categories','AdminController::getParentCategories',['as'=>'get-parent-categories']);

          $routes->group('posts', static function($routes){
              $routes->get('new-post','AdminController::addPost',['as'=>'new-post']);
              $routes->post('create-post','AdminController::createPost',['as'=>'create-post']);
              $routes->get('/','AdminController::allPosts',['as'=>'all-posts']);
              $routes->get('get-posts','AdminController::getPosts',['as'=>'get-posts']);
              $routes->get('edit-post/(:any)','AdminController::editPost/$1',['as'=>'edit-post']);
              $routes->post('update-post','AdminController::updatePost',['as'=>'update-post']);
              $routes->get('delete-post','AdminController::deletePost',['as'=>'delete-post']);
          });
          
       });

       $routes->group('', ['filter'=>'cifilter:guest'], static function($routes){
            // $routes->view('example-auth','example-auth');
          $routes->get('login','AuthController::loginForm',['as'=>'admin.login.form']);
          $routes->post('login','AuthController::loginHandler',['as'=>'admin.login.handler']);
          $routes->get('forgot-password','AuthController::forgotForm',['as'=>'admin.forgot.form']);
          $routes->post('forgot-password','AuthController::sendPasswordResetLink',['as'=>'send_password_reset_link']);
          $routes->get('password/reset/(:any)','AuthController::resetPassword/$1',['as'=>'admin.reset-password']);
          $routes->post('reset-password-handler/(:any)','AuthController::resetPasswordHandler/$1',['as'=>'reset-password-handler']);
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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}



