<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get("info", 'Info::index');
$routes->get("third", 'Third::index');
$routes->get("github-oauth", 'GitHubAuth::index');