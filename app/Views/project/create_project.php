<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Create Project</title>
    <?= App\Helpers\PageComponent::import_styles() ?>
  </head>
  <body class="bg-dark-subtle text-white">
    <?= App\Helpers\PageComponent::page_header() ?>
    <div class="clearfix mt-4 container w-25">
      <?php if (isset($_GET['error_message'])) {
        echo App\Helpers\PageComponent::alert_danger($_REQUEST['error_message']);
      } ?>
      <h3>Create a new project</h3>
      <hr class="bg-dark-subtle">
      <form action="create-new-project" accept-charset="UTF-8" method="post">
        <div class="form-group">
          <h5>Project name</h5>
          <input type="text" name="project_name" class="form-control form-input bg-dark-subtle" required>
        </div>
        <div class="form-group my-3">
          <h5>Description</h5>
          <textarea name="project_description" class="form-control form-input bg-dark-subtle" required></textarea>
        </div>
        <hr class="bg-dark-subtle my-4">
        <div class="mt-3 d-flex justify-content-end">
          <button type="submit" class="btn btn-success <?= App\Helpers\Helper::is_admin() ? 'disabled' : '' ?>">
            Create project
          </button>
        </div>
      </form>
    </div>
  </body>
</html>