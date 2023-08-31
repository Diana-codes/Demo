<?php
include('db.php');
include('functions.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
    
}

$user_id = $_SESSION['user_id'];
$projectItem = array();



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-button'])) {
    $task = $_POST['task'];
    if(!empty($task)){
        var_dump($task);
        addTask($conn,$user_id, $task);
    }else{
        echo"Task cannot be empty.Please enter a task!";
    }

}
if(isset($_POST['submit'])) {
    // if (!logged_in()) 
    echo '<script>alert("Welcome to Geeks for Geeks")</script>';
  }
        // Reload tasks from the database and display them
        $projectItem = getProjectsByUserId($conn, $user_id);       
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Project</title>
    <link rel="stylesheet" href="stylesheet/index.css">
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>

    <div class="container mt-5">
    <div class="input-field-button">
    <form action="logout.php" method="post">
        <button type="submit" name="logout_submit" class="logout-button">Logout</button>
    </form>
</div>
    <div class="todo-app">
        <div class="row-project">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3>Add a New Project</h3>
                    </div>
                    <div class="card-body">
                        <form action="add_project.php" method="post">
                            <div class="mb-3">
                                <label for="project_name" class="form-label">Project Name</label>
                                <input type="text" class="form-control" id="project_name" name="project_name" required>
                            </div>
                            <div class="mb-3">
                            <label for="project_date_from">From:</label>
                             <input type="text" class="form-control" id="project_date_from" name="project_date_from" placeholder="e.g., 2023-08-28" required>
                            <label for="project_date_to">To:</label>
                            <input type="text" class="form-control" id="project_date_to" name="project_date_to" placeholder="e.g., 2023-08-30" required>

                            </div>
                            <button type="submit" class="btn btn-primary" name="submit">Add Project</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="project-container">
    <?php
    $projects = getProjectsByUserId($conn, $user_id);

    // Loop through the projects and generate HTML for each project
    foreach ($projectItem as $project) {
        $proj_id = intval($project['project_id']);
        // var_dump($proj_id);
        echo '<div class="project">';
        echo "<a href='homepage.php?ID=$proj_id'>";
        echo '<h4>' . htmlspecialchars($project['project_name']) . '</h4>';
        echo '<p>From: ' . htmlspecialchars($project['project_date_from']) . '</p>';
        echo '<p>To: ' . htmlspecialchars($project['project_date_to']) . '</p>';
        // echo '<div class="project" data-project-id="' . $project['project_id'] . '">';
        echo '</a>';
        echo '</div>';
    }
    ?>
    <li class="project-item <?php if ($project['completed']) echo 'completed'; ?>" project_id="<?php echo $project['project_id']; ?>">
    <span class="unchecked">
        <img class="checked" src="images/<?php echo ($project['completed']) ? 'checked.png' : 'unchecked.png'; ?>">
    </span>
    <div class="project-content">
        <?php echo htmlspecialchars($project['project_name']); ?>
        <span class="task-icons">
            <ion-icon name="create-outline" class="edit-icon" onclick="editProject('<?php echo htmlspecialchars($project['project_name']); ?>', <?php echo $project['project_id']; ?>)"></ion-icon>
            <a href="#" class="delete-project" onclick="confirmDelete(<?php echo $project['project_id']; ?>)">
                <img class="delete-project" src="images/delete.png" alt="Delete Project">
            </a>
        </span>
    </div>
</li>

  </div>
  </div>
</div>
<script>
document.querySelectorAll('.project').forEach(function (project) {
    project.addEventListener('click', function () {
        var project_id = project.getAttribute('data-project_id'); 

        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_tasks.php?project_id=' + project_id, true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                var tasks = JSON.parse(xhr.responseText);
            }
        };

        xhr.send();
    });
});

    </script>
   

    <!-- Include Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.min.js" integrity="sha384-9aIt2nRpC12Uk9gBfen2rRl5lwz5S5+5z5n0t2O1w5m5F5w5d5E5w5f5V5l5i5s5V5f5i5s5V5f5i5s5V5f5w5d5E5w5f5i5s5V5f5i5s5V5f5A=="></script>
    <script type="text/javascript" src="main.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script type="nomodule" src="https://unpkg.com/ionicons@7.1.0/dist/ion"></script>
</body>
</html>
