<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Issue List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <?= App\Helpers\PageComponent::import_styles() ?>
  </head>
  <body class="bg-dark">
    <?= App\Helpers\PageComponent::page_header() ?>
    *Work in Progress*<br>
    Can't use right now
    <div id="error_list" class="auth-form">
      <h1>Create New Error</h1>
      <form action="/submit_error.php" method="post">
        <div class="form-group">
          <label for="error_name">Error Name:</label><br>
          <input type="text" id="error_name" name="error_name"><br>
        </div>
        <div class="form-group">
          <label for="description">Description:</label><br>
          <textarea id="description" name="description"></textarea><br>
        </div>
        <div class="form-group">
          <label for="responsible_dev">Responsible Developer:</label><br>
          <input type="text" id="responsible_dev" name="responsible_dev"><br>
        </div>
        <div class="form-group">
          <label for="reproduce_steps">Steps to Reproduce:</label><br>
          <textarea id="reproduce_steps" name="reproduce_steps"></textarea><br>
        </div>
        <div class="form-group">
          <label for="expected_result">Expected Result:</label><br>
          <textarea id="expected_result" name="expected_result"></textarea><br>
        </div>
        <div class="form-group">
          <label for="actual_result">Actual Result:</label><br>
          <textarea id="actual_result" name="actual_result"></textarea><br>
        </div>
        <div class="form-group">
          <label for="illustration">Illustration:</label><br>
          <input type="file" id="illustration" name="illustration"><br>
        </div>
        <div class="form-group">
          <label for="priority">Priority:</label><br>
          <select id="priority" name="priority">
            <option value="high">High</option>
            <option value="medium">Medium</option>
            <option value="low">Low</option>
          </select>
        </div>
        <div class="form-group">
          <label for="status">Status:</label><br>
          <select id="status" name="status">
            <option value="error">Error</option>
            <option value="cancel">Cancel</option>
          </select>
        </div>
        <input type="submit" value="Submit">
      </form>
    </div>
  </body>
</html>