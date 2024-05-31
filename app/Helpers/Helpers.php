<?php

namespace App\Helpers;

class Helpers {
  static function redirect_to(string $route): void {
    if ($route === '/' || $route[0] !== '/') {
      header("Location: {$route}");
      exit;
    }
    $uri = str_contains($_SERVER['REQUEST_URI'], 'public') ? 'public' : '';
    header("Location: {$uri}{$route}");
    exit;
  }
}