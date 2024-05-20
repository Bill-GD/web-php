## CodeIgniter 4.5

### Redirecting

- Create Controller in `app/Controllers`. Follow Controller class template:
  ```php
  <?php

  namespace App\Controllers;

  class Page extends BaseController {
    public function index(): string {
      return view('new_view'); // view file name with or without extension (.php)
    }
  }
  ```

- Create View in `app/Views`. View can be a php file that display anything.
  ```php
  <?php
  echo 'Hello from new_view.php';
  /* More code below */
  ```

- Create a `route` in `app/Config/Routes.php` like so:
  ```php
  $routes->get('/new_view', 'Page::index');
  ```

- Redirect code: for whatever reason, any variant of `redirect()` will **NOT** work. Use `header()` instead and also `exit` afterward.
  ```php
    <form method="get">
      <button type="submit" name="button_name">To view</button>
    </form>
    <?php
    if (isset($_GET) && isset($_GET['button_name'])) {
      header("Location: /new_view"); // location is the route declared in Routes.php
      exit; // important
    }
    ?>
  ```

- Run server command:
  - `php spark serve`: no `public/index.php` so `header("Location: /new_view")` is fine
  - `php -S localhost:<port>`: has `public/index.php` so it'll need `header("Location: public/index.php/new_view")`  
  &rarr; process a conditional for url every redirection
    - Can't use `include`, `include_once`, `require` or `require_once` &rarr; **ERROR**  
    &rarr; Boilerplate code everywhere

- Notes for `header()` redirects
  - Obvious 1: use `"Location: ..."`
  - Obvious 2: use `exit` afterward
  - The `Location` value:
    - `/info` will assume route `info` is direct child of root (`/` or `public/index.php/`), it may not be true
    - Use `info` (no slash) to redirect to route of the same (directory) depth