<?php

namespace App\Helpers;

class Helpers {
  static function redirect_to(string $route): void {
    if ($route[0] === '/') {
      $route = substr($route, 1);
    }
    $uri = str_contains($_SERVER['REQUEST_URI'], 'index.php') ? 'index.php' : '';
    header("Location: {$uri}/{$route}");
    exit;
  }
}