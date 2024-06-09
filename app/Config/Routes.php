<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('github-oauth', 'GitHubAuth::index');
$routes->get('login', 'Login::basic_login');
$routes->get('login/(:segment)/(:segment)', 'Login::github_login/$1/$2');