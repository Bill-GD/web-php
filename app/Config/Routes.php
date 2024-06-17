<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('index', 'Home::index');

$routes->get('github-oauth', 'GitHubAuth::index');
$routes->get('signup', 'SignUp::basic_signup');
$routes->post('signup-validate', 'SignUp::signup_validate');
$routes->get('signup/github', 'SignUp::github_signup');

$routes->get('login', 'Login::basic_login');
$routes->post('login-validate', 'Login::login_validate');
$routes->get('logout', 'Logout::index');

$routes->get('projects', 'ProjectController::index');
$routes->get('projects/(joined|created)', 'ProjectController::filter/$1');
$routes->get('projects/(:num)', 'ProjectController::view_project/$1');
$routes->get('projects/(:num)/(members|settings)', 'ProjectController::view_project/$1/$2');
$routes->post('projects/(:num)/add-member', 'ProjectController::add_member/$1');
$routes->get('create-project', 'ProjectController::create');
$routes->post('create-new-project', 'ProjectController::create_project');

// $routes->get('error-list', 'ErrorList::index');
$routes->get('issues', 'ErrorList::index');
$routes->get('create-issue', 'ErrorList::create');
$routes->post('create', 'CreateError::create');
