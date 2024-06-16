<?php
namespace App\Helpers;

class PageComponent {
  static function import_styles(): string {
    return '
    <link rel="icon" href="' . Helper::get_resource_path('public/assets/bug-solid.svg') . '" type="image/x-icon">
    <link rel="stylesheet" href="' . Helper::get_resource_path('public/style/bootstrap.min.css') . '">
    <script src="' . Helper::get_resource_path('public/style/bootstrap.bundle.min.js') . '"></script>
    <link rel="stylesheet" href="' . Helper::get_resource_path('public/style/styles.css') . '">
    <link rel="stylesheet" href="' . Helper::get_resource_path('public/style/error_style.css') . '">
    ';
  }
  static function page_header(): string {
    return
      '<style> body { padding-top: 90px; } </style>
      <header class="navbar bg-dark fixed-top border-dark-subtle border-bottom py-2">
        <div class="container">
          <a class="navbar-brand text-white" href="/">
            <svg class="pb-1" fill="#fff" height="32" width="32" viewBox="0 0 512 512">
            <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
              <path d="M256 0c53 0 96 43 96 96v3.6c0 15.7-12.7 28.4-28.4 28.4H188.4c-15.7 0-28.4-12.7-28.4-28.4V96c0-53 43-96 96-96zM41.4 105.4c12.5-12.5 32.8-12.5 45.3 0l64 64c.7 .7 1.3 1.4 1.9 2.1c14.2-7.3 30.4-11.4 47.5-11.4H312c17.1 0 33.2 4.1 47.5 11.4c.6-.7 1.2-1.4 1.9-2.1l64-64c12.5-12.5 32.8-12.5 45.3 0s12.5 32.8 0 45.3l-64 64c-.7 .7-1.4 1.3-2.1 1.9c6.2 12 10.1 25.3 11.1 39.5H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H416c0 24.6-5.5 47.8-15.4 68.6c2.2 1.3 4.2 2.9 6 4.8l64 64c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0l-63.1-63.1c-24.5 21.8-55.8 36.2-90.3 39.6V240c0-8.8-7.2-16-16-16s-16 7.2-16 16V479.2c-34.5-3.4-65.8-17.8-90.3-39.6L86.6 502.6c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l64-64c1.9-1.9 3.9-3.4 6-4.8C101.5 367.8 96 344.6 96 320H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H96.3c1.1-14.1 5-27.5 11.1-39.5c-.7-.6-1.4-1.2-2.1-1.9l-64-64c-12.5-12.5-12.5-32.8 0-45.3z"/>
            </svg>
            <span>BugTrackr</span>
          </a>'
      . self::nav_content()
      . '</div>
      </header>';
  }

  static function alert_danger(string $error_message): string {
    return '
    <div class="alert alert-danger row align-items-center py-3 m-0 mb-2" role="alert">
      <svg class="col-2" height="16" width="16" viewBox="0 0 16 16" fill="#ff7984" class="h-100 mt-2 col-2">
        <path
          d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
      </svg>
      <div class="col-10 align-content-center">' . $error_message . '</div>
    </div>
    ';
  }

  static function home_button(): string {
    return '<a class="home-button btn btn-outline-light m-4" href="/">Home</a>';
  }

  static function page_footer(): string {
    return '<footer class="bg-dark text-white text-center py-2">© 2024 BugTrackr</footer>';
  }

  static private function nav_content(): string {
    $is_logged_in = Helper::is_logged_in();
    return $is_logged_in
      ? self::nav_links() . self::account_drop_down()
      : self::sign_up_in_buttons();
  }

  static private function nav_links(): string {
    $access_uri = $_SERVER['REQUEST_URI'];

    $links = [
      // title => [href, enabled, is_active]
      'Projects' => ['#', false, str_contains($access_uri, 'projects')],
      'Issues' => ['error-list', true, str_contains($access_uri, 'error-list')],
    ];

    $nav_links = '';
    foreach ($links as $text => $val) {
      $nav_links .= '<li class="nav-item">
        <a class="nav-link' . (!$val[1] ? ' disabled' : '') . ($val[2] ? ' active' : ' text-white') . '" href="' . $val[0] . '">' . $text . '</a>
      </li>';
    }
    return '<ul class="nav">' . $nav_links . '</ul>';
  }

  static private function account_drop_down(): string {
    $user_pfp = empty($_COOKIE['avatar_url']) ? 'public/assets/default_avatar.png' : $_COOKIE['avatar_url'];

    if (!str_contains($user_pfp, 'http')) {
      assert(str_contains($user_pfp, 'assets'), 'User profile picture should be in assets folder, got ' . $user_pfp);
      $user_pfp = Helper::get_resource_path($user_pfp);
    }
    return
      '<div class="nav-item dropdown text-white">
        <a class="dropdown-toggle nav-link" data-bs-toggle="dropdown" role="button" aria-expanded="false">
          <img class="rounded-5" src="' . $user_pfp . '" width=30, height=30>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark">
          <li class="px-3 py-2">' . $_COOKIE['username'] . '</li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item disabled" href="#">Profile</a></li>
          <li><a class="dropdown-item disabled" href="#">Settings</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="logout">Logout</a></li>
        </ul>
      </div>';
  }

  static private function sign_up_in_buttons(): string {
    return
      '<ul class="nav col-2">
        <li class="nav-item m-auto">
          <a href="login" role="button" class="btn btn-outline-light">Sign in</a>
        </li>
        <li class="nav-item">
          <a href="signup" role="button" type="button" class="btn btn-light">Sign up</a>
        </li>
      </ul>';
  }

  static function code_background(bool $logged_in): string {
    return
      $logged_in
      ? ''
      : '<img class="bg-image fixed-top z-n1 w-100 h-auto" src="' . Helper::get_resource_path('public/assets/generic_code_bg.png') . '" alt="Code background image">';
  }


}