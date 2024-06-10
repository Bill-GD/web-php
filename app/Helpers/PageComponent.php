<?php
namespace App\Helpers;

class PageComponent {
  static function import_styles(): string {
    return '
    <link rel="stylesheet" href="' . base_url('../../style/bootstrap.min.css') . '">
    <script src="' . base_url('../../style/bootstrap.dundle.min.js') . '"></script>
    <link rel="stylesheet" href="' . base_url('../../style/styles.css') . '">
    ';
  }

  static function page_header(): string {
    $is_logged_in = isset($_COOKIE['is_logged_in']) && $_COOKIE['is_logged_in'] === 'true';

    $nav_bar =
      '<header class="navbar bg-black fixed-top border-secondary border-bottom py-3">
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
          <li><a class="dropdown-item" href="/logout">Logout</a></li>
        </ul>
      </div>
      '
      :
      '<ul class="nav col-2">
        <li class="nav-item m-auto">
          <a href="login" role="button" class="btn btn-outline-light">Log in</a>
        </li>
        <li class="nav-item">
          <a href="signup" role="button" type="button" class="btn btn-light">Sign up</a>
        </li>
      </ul>';
    return $nav_bar . '
      </div>
      </header>
    ';
  }

  static function alert_danger(string $error_message): string {
    return '
    <div class="alert alert-danger" role="alert">
      <svg height="16" width="16" viewBox="0 0 16 16" fill="#EA868F" class="me-1 mb-1">
        <path
          d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
      </svg>
      ' . $error_message . '
    </div>
    ';
  }

  private static function throw_not_implemented(string $method_name): void {
    throw new \Exception("Component {$method_name} is not implemented");
  }
}