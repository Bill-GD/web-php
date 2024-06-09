<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Document</title>
    <?= App\Helpers\PageComponent::import_bootstrap() ?>
    <link rel="stylesheet" href="../../style/styles.css">
  </head>
  <body>
    <?= App\Helpers\PageComponent::page_header() ?>
    <a href="<?= App\Helpers\Helper::get_github_auth_url() ?>"> Get Your GitHub info </a>
    <pre>
      Will implement later
      Has header: app name, Login, Sign up. Should use condition for logged in or not.
      Content: sidebar of projects (?), main of most recently updated issues. Also should use logged in condition.
    </pre>
  </body>
</html>