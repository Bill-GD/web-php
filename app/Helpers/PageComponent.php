<?php
namespace App\Helpers;

class PageComponent {
  static function import_styles(): string {
    return '
    <link rel="icon" href="' . Helper::get_resource_path('public/assets/bug-solid.svg') . '" type="image/x-icon">
    <link rel="stylesheet" href="' . Helper::get_resource_path('public/style/bootstrap.min.css') . '">
    <script src="' . Helper::get_resource_path('public/style/bootstrap.bundle.min.js') . '"></script>
    <link rel="stylesheet" href="' . Helper::get_resource_path('public/style/styles.css') . '">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.js">
    ';
  }
  static function page_header(?string $bottom_header = null): string {
    return
      '<style> body { padding-top: 90px; } </style>
      <header class="navbar bg-dark fixed-top border-dark-subtle border-bottom py-2">
        <div class="container">
          <a class="navbar-brand text-white" href="/">
            <i class="fa-solid fa-bug-slash"></i>
            <span>BugTrackr</span>
          </a>'
      . self::nav_content()
      . '</div>'
      . ($bottom_header ?? '') .
      '</header>';
  }

  static function alert_danger(string $error_message): string {
    return '
    <div class="alert alert-danger row align-items-center py-3 m-0 mb-2" role="alert">
      <svg class="col-auto" height="16" width="16" viewBox="0 0 16 16" fill="#ff7984" class="h-100 mt-2 col-2">
        <path
          d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
      </svg>
      <div class="col align-content-center">' . $error_message . '</div>
    </div>
    ';
  }

  static function table_with_header(string $table_classes = '', string $header, string $content): string {
    return
      '<div class="border border-dark-subtle rounded-2 ' . $table_classes . '">
        <div class="bg-dark-light p-3 border-bottom rounded-top-2 border-dark-subtle">
          <div class="d-flex">
            ' . $header . '
          </div>
        </div>
        <div class="d-flex flex-column m-6 align-items-center justify-content-center">
          ' . $content . '
        </div>
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
      'Projects' => ['/public/projects', true, str_contains($access_uri, 'projects')],
      'Issues' => ['/public/issues', true, str_contains($access_uri, 'issues')],
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
    return self::dropdown(
      '<img class="rounded-5" src="' . $user_pfp . '" width=30, height=30>',
      '',
      [
        '<li class="px-3 py-2">' . $_COOKIE['username'] . '</li>',
        '<li><hr class="dropdown-divider"></li>',
        '<li><a class="dropdown-item disabled" href="#">Profile</a></li>',
        '<li><a class="dropdown-item disabled" href="#">Settings</a></li>',
        '<li><hr class="dropdown-divider"></li>',
        '<li><a class="dropdown-item" href="/public/logout">Logout</a></li>',
      ],
      'text-white',
      'nav-link',
    );
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

  static function dropdown(string $title, string $dropdown_header = '', array $items, string $extra_dropdown_classes = '', string $extra_title_classes = ''): string {
    $dropdown_items = implode(array_map(fn($item) => '<li>' . $item . '</li>', $items));
    return
      '<div class="dropdown ' . $extra_dropdown_classes . '">
        <a class="dropdown-toggle ' . $extra_title_classes . ' link-no-deco" data-bs-toggle="dropdown" role="button">' . $title . '</a>
        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end border border-dark-light rounded-1">
          <li>' . $dropdown_header . '</li>
          ' . $dropdown_items . '
        </ul>
      </div>';
  }

  static function home_background(bool $logged_in): string {
    return
      $logged_in
      ? ''
      : '<img class="bg-image fixed-top z-n1 w-100 h-auto" src="' . Helper::get_resource_path('public/assets/generic_code_bg.png') . '" alt="Code background image">';
  }

  static function closed_issue_svg(int $size): string {
    return
      '<svg height="' . $size . '" width="' . $size . '" viewBox="0 0 16 16" class="svg-white">
        <path
          d="M13.78 4.22a.75.75 0 0 1 0 1.06l-7.25 7.25a.75.75 0 0 1-1.06 0L2.22 9.28a.751.751 0 0 1 .018-1.042.751.751 0 0 1 1.042-.018L6 10.94l6.72-6.72a.75.75 0 0 1 1.06 0Z">
        </path>
      </svg>';
  }
  static function open_issue_svg(int $size): string {
    return
      '<svg height="' . $size . '" width="' . $size . '" viewBox="0 0 16 16" class="svg-white">
        <path d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z"></path>
        <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0ZM1.5 8a6.5 6.5 0 1 0 13 0 6.5 6.5 0 0 0-13 0Z"></path>
      </svg>';
  }

  
}

