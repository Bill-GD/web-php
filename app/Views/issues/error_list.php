<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <?= App\Helpers\PageComponent::import_styles() ?>
</head>

<body style="background-color: aliceblue">
    <header class="navbar bg-black border-white fixed-top border-bottom mb-3 py-3">
        <div class="container">
            <a class="navbar-brand text-white" href="/">BugTrackr</a>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link text-white active" href="#">Projects</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Issues</a>
                </li>
            </ul>
            <ul class="nav col-2">
                <li class="nav-item dropdown m-auto">
                    <a href="#" role="button" class="btn btn-outline-light dropdown-toggle" id="accountDropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i>
                        Account
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="accountDropdown">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </header>
    <div id="error_list" class="container">
        <h1>Create New Error</h1>
        <form action="/submit_error.php" method="post">
            <label for="error_name">Error Name:</label><br>
            <input type="text" id="error_name" name="error_name"><br>
            <label for="description">Description:</label><br>
            <textarea id="description" name="description"></textarea><br>
            <label for="responsible_dev">Responsible Developer:</label><br>
            <input type="text" id="responsible_dev" name="responsible_dev"><br>
            <label for="reproduce_steps">Steps to Reproduce:</label><br>
            <textarea id="reproduce_steps" name="reproduce_steps"></textarea><br>
            <label for="expected_result">Expected Result:</label><br>
            <textarea id="expected_result" name="expected_result"></textarea><br>
            <label for="actual_result">Actual Result:</label><br>
            <textarea id="actual_result" name="actual_result"></textarea><br>
            <label for="illustration">Illustration:</label><br>
            <input type="file" id="illustration" name="illustration"><br>
            <label for="priority">Priority:</label><br>
            <select id="priority" name="priority">
                <option value="high">High</option>
                <option value="medium">Medium</option>
                <option value="low">Low</option>
            </select><br>
            <label for="status">Status:</label><br>
            <select id="status" name="status">
                <option value="error">Error</option>
                <option value="cancel">Cancel</option>
            </select><br>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>

</html>