<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>BugTrackr</title>
    <?= App\Helpers\PageComponent::import_styles() ?>
    <style>
      body {
        padding-top: 95px;
      }
    </style>
  </head>
  <body class="bg-dark">
    <?= App\Helpers\PageComponent::page_header() ?>
    <pre class="fg-white">
      Will implement later
      Has header: app name, Login, Sign up. Should use condition for logged in or not.
      Content: sidebar of projects (?), main of most recently updated issues. Also should use logged in condition.
    </pre>
  </body>
</html>