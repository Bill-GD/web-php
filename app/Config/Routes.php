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

$routes->get('create-project', 'ProjectController::create');
$routes->get('projects', 'ProjectController::index');
$routes->post('create-new-project', 'ProjectController::create_project');

$routes->get('error-list', 'ErrorList::index');
$routes->get('issues', 'ErrorList::index');
$routes->get('create-issue', 'ErrorList::create');
