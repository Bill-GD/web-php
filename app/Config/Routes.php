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

$routes->get('profiles', 'Profile::index');
$routes->get('profiles/(:num)', 'Profile::view_profile/$1');

$routes->get('projects', 'ProjectController::index');
$routes->get('projects/(joined|created)', 'ProjectController::filter/$1');
$routes->get('projects/(:num)', 'ProjectController::view_project/$1');
$routes->get('projects/(:num)/(members|settings)', 'ProjectController::view_project/$1/$2');
$routes->post('projects/(:num)/add-member', 'ProjectController::add_member/$1');
$routes->get('projects/(:num)/remove-member/(:num)', 'ProjectController::remove_member/$1/$2');
$routes->get('create-project', 'ProjectController::create');
$routes->post('create-new-project', 'ProjectController::create_project');
$routes->get('projects/(:num)/delete', 'ProjectController::delete_project/$1');

$routes->get('issues', 'IssueController::index');
$routes->get('issues/(created|assigned)', 'IssueController::filter/$1');
$routes->get('issues/(:num)', 'IssueController::view_issue/$1');
$routes->get('create-issue', 'IssueController::create_issue');
$routes->post('create', 'IssueController::create');
