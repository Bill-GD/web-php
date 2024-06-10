<?php
namespace App\Helpers;

class PageComponent {
  static function import_styles(): string {
    return '
    <link rel="stylesheet" href="' . Helper::get_resource_path('/public/style/bootstrap.min.css') . '">
    <script src="' . Helper::get_resource_path('/public/style/bootstrap.bundle.min.js') . '"></script>
    <link rel="stylesheet" href="' . Helper::get_resource_path('/public/style/styles.css') . '">
    ';
  }

  static function page_header(): string {
    return
      '<header class="navbar bg-black fixed-top border-secondary border-bottom py-3">
        <div class="container">
          <a class="navbar-brand text-white" href="/">BugTrackr</a>'
      . self::nav_content()
      . '</div>
      </header>';
  }

  static function alert_danger(string $error_message): string {
    return '
    <div class="alert alert-danger row m-0 mb-2" role="alert">
      <svg height="16" width="16" viewBox="0 0 16 16" fill="#ff7984" class="h-100 mt-2 col-2">
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

  static private function nav_content(): string {
    $is_logged_in = isset($_COOKIE['is_logged_in']) && $_COOKIE['is_logged_in'] === '1';
    return $is_logged_in
      ? self::nav_links() . self::account_drop_down()
      : self::sign_up_in_buttons();
  }

  static private function nav_links(): string {
    $links = [
      'Projects' => '#',
      'Issues' => '#',
    ];

    $nav_links = '';
    foreach ($links as $text => $href) {
      $nav_links .= '<li class="nav-item">
        <a class="nav-link text-white" href="' . $href . '">' . $text . '</a>
      </li>';
    }
    return '<ul class="nav">' . $nav_links . '</ul>';
  }

  static private function account_drop_down(): string {
    $user_pfp = empty($_COOKIE['avatar_url']) ? 'assets/default_avatar.png' : $_COOKIE['avatar_url'];

    if (!str_contains($user_pfp, 'http')) {
      assert(str_contains($user_pfp, 'assets'), 'User profile picture should be in assets folder, got ' . $user_pfp);
      $user_pfp = Helper::get_resource_path($user_pfp);
    }
    return
      '<div class="nav-item dropdown text-white">
        <a class="dropdown-toggle nav-link" data-bs-toggle="dropdown" role="button" aria-expanded="false">
          <img class="rounded-5" src="' . $user_pfp . '" width=40, height=40>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark">
          <li class="px-3 py-2">' . $_COOKIE['username'] . '</li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="logout">Logout</a></li>
        </ul>
      </div>';
  }

  static private function sign_up_in_buttons(): string {
    return
      '<ul class="nav col-2">
        <li class="nav-item m-auto">
          <a href="login" role="button" class="btn btn-outline-light">Log in</a>
        </li>
        <li class="nav-item">
          <a href="signup" role="button" type="button" class="btn btn-light">Sign up</a>
        </li>
      </ul>';
  }

  private static function throw_not_implemented(string $method_name): void {
    throw new \Exception("Component {$method_name} is not implemented");
  }
}