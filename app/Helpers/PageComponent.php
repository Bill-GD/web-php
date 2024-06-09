<?php
namespace App\Helpers;

use Exception;

class PageComponent {
  static function import_bootstrap(): string {
    return '
    <link rel="stylesheet" href="../../style/bootstrap.min.css">
    <script src="../../style/bootstrap.bundle.min.js"></script>';
  }

  static function page_header(): string {
    $is_logged_in = isset($_COOKIE['is_logged_in']) && $_COOKIE['is_logged_in'] === 'true';

    $nav_bar =
      '<header class="navbar bg-black border-white fixed-top border-bottom mb-3 py-3">
      <div class="container">
        <a class="navbar-brand text-white" href="/">BugTrackr</a>';
    $nav_bar .=
      $is_logged_in ?
      '<ul class="nav">
        <li class="nav-item">
          <a class="nav-link text-white active" href="#">Projects</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="#">Issues</a>
        </li>
      </ul>
      <div class="nav-item dropdown text-white">
        <a class="dropdown-toggle nav-link" data-bs-toggle="dropdown" role="button" aria-expanded="false">
          <img src="../../assets/default_avatar.png" width=40, height=40>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark">
          <li class="px-3 py-2">dropdown-menu</li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="#">Logout</a></li>
        </ul>
      </div>
      '
      :
      '<ul class="nav col-2">
        <li class="nav-item m-auto">
          <a href="login" role="button" class="btn btn-outline-light">Log in</a>
        </li>
        <li class="nav-item">
          <button type="button" class="btn btn-light">Sign up</button>
        </li>
      </ul>';
    return $nav_bar . '
      </div>
      </header>
    ';
  }

  private static function throw_not_implemented(string $method_name): void {
    throw new Exception("Component {$method_name} is not implemented");
  }
}