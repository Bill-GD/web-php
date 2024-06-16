<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?= App\Helpers\PageComponent::import_styles() ?>
  <link rel="stylesheet" href="<?= App\Helpers\Helper::get_resource_path('public/style/error_style.css') ?>">
  <title>Document</title>
</head>

<body class="bg-dark-subtle text-white">
  <?= App\Helpers\PageComponent::page_header() ?>
  <div class="clearfix mt-4 container-xl">
    <form class="new_issues" id="new_issues" accept-charset="UTF-8" method="post">
      <div class="Layout">
        <div class="Layout-main">

          <img src="<?= App\Helpers\Helper::get_resource_path('public/assets/default_avatar.png') ?>" alt="avatar"
            class="rounded-5 float-left" width="40px" height="40px">

          <div style="padding-left: 56px">
            <h3>Add a title</h3>
            <div style="margin-bottom: 16px">
              <input type="text" name="issue[title]" id="issue_title" class="form-control form-input bg-dark-light"
                placeholder="Title" required>
            </div>
            <legend>
              <h3>Add a description</h3>
            </legend>
            <div class="Box" style="margin-bottom: 16px">
              <div class="tab-container">
                <div class="comment-box-header">
                  <button class="tablink" onclick="openTab('Tab1', this)" id="defaultOpen">Write</button>
                  <button class="tablink" onclick="openTab('Tab2', this)">Preview</button>
                </div>
                <div id="Tab1" class="tabcontent">
                  <textarea name="issue[description]" id="issue_description"
                    class="issue_description form-control form-input" placeholder="Add your description here..."
                    required></textarea>
                </div>

                <div id="Tab2" class="tabcontent">
                  <textarea name="issue[description]" id="issue_description"
                    class="issue_description form-control form-input" placeholder="Add your description here..."
                    required></textarea>
                </div>
              </div>

              <script>
                function openTab(tabName, elmnt) {
                  var i, tabcontent, tablinks;
                  tabcontent = document.getElementsByClassName("tabcontent");
                  for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";

                  }
                  tablinks = document.getElementsByClassName("tablink");
                  for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].style.backgroundColor = "#161b22";
                    tablinks[i].style.borderRight = "";
                    tablinks[i].style.borderLeft = "";
                    tablinks[i].style.borderTopLeftRadius = "";
                    tablinks[i].style.borderTopRightRadius = "";

                  }
                  document.getElementById(tabName).style.display = "block";
                  elmnt.style.backgroundColor = "#0d1117";
                  elmnt.style.borderRight = "1px solid #30363d";
                  elmnt.style.borderLeft = "1px solid #30363d";
                  elmnt.style.borderTopLeftRadius = "5px";
                  elmnt.style.borderTopRightRadius = "5px";
                }

                document.getElementById("defaultOpen").click();
              </script>
            </div>
          </div>
        </div>
        <div class="Layout-side-bar">
          <div style="position: relative">
                
          </div>
        </div>
      </div>
    </form>

  </div>
</body>

</html>