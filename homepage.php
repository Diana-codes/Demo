<?php
include('db.php');
include('functions.php');

$id = $_GET['ID'];

// $id = $_GET['ID'];
$user_id = $_SESSION['user_id'];


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
        $tasks = getTasksByUserId($conn,$id);
        // displayTasks($tasks);
        
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>To-Do List</title>
    <link rel="stylesheet" href="stylesheet/index.css">
    <link rel="stylesheet" href="stylesheet/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
    <div class="container-homepage">
        <div class="container">
        <div class="todo-app">
            <h2>To-Do list<img src="images/to-do list.png"></h2>

           <div class="row">
            <form action="homepage.php" method="post" id="add-task-form">
                <input type="text" id="input-box" placeholder="Add your task" name="task">
                <input type="text" id="result_response" style="display: none;">
                <button type="button" id="add-button" name="add-button" onclick="showAddForm()">Add</button>
            </form>
         </div>

         <div id="editTaskModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeEditModal()">&times;</span>
                <h2>Edit Task <img src="images/edit.png"></h2>
                <div class="row-modal">
                    <input type="text" id="editedTask" class="modal-input">
                    <button id="saveEditedTask" onclick="saveEditedTask()">Save</button>
                </div>
            </div>
         </div>

        <ul id="list-container">
        <?php
        // Fetch the user_id from the session
        if(isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
        } else {
            // Handle the case when user_id is not set (redirect or show an error)
            header('Location: login.php');
            exit();
        }
    
        $tasks = getTasksByUserId($conn, $id);
    
        foreach ($tasks as $taskItem): 
        ?>
        <li class="task-item <?php if ($taskItem['completed']) echo 'completed'; ?>" task_id="<?php echo $taskItem['task_id']; ?>">
            <span class="unchecked">
                <img class="checked" src="images/<?php echo ($taskItem['completed']) ? 'checked.png' : 'unchecked.png'; ?>">
            </span>
            <div class="task-content">
                <?php echo $taskItem['task']; ?>
                <span class="task-icons">
                    <ion-icon name="create-outline" class="edit-icon" onclick="editTask('<?php echo $taskItem['task']; ?>', <?php echo $taskItem['task_id']; ?>)"></ion-icon>

                    <a href="#" class="delete-task" onclick="confirmDelete(<?php echo $taskItem['task_id']; ?>)">
                        <img class="delete-task" src="images/delete.png" alt="Delete Task">
                    </a>
                </span>
            </div>
        </li>
        <?php endforeach; ?>
        </ul>
        
        </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="main.js"></script>
    <script> 
        document.addEventListener("DOMContentLoaded", function () {
            const addButton = document.getElementById("add-button");
            const inputBox = document.getElementById("input-box");
            const listContainer = document.getElementById("list-container");
            const editedTaskInput = document.getElementById("editedTask");
            const taskItems = document.querySelectorAll(".task-item");

          
    taskItems.forEach(taskItem => {
              taskItem.addEventListener("click", function () {
                const task_id = taskItem.getAttribute("task_id");
                const completed = taskItem.classList.contains("completed");

  
                updateTaskStatus(task_id, completed ? 0 : 1);
                location.reload();
                return false;
  
              });
                  });
            function setDefaultValue(taskText) {
                 editedTaskInput.value = taskText;
                   }
                   listContainer.addEventListener("click",function(e){
                    if(e.target.tagName ==="LI"){
                        e.target.classList.toggle("checked");
                   } else{
                    false}});

                   
            addButton.addEventListener("click", function () {
                const taskText = inputBox.value.trim(); 
                const listItem = document.createElement("li");
                createtask();
                if (taskText !== "") {
                    listItem.innerHTML = `
                        <span class="unchecked">
                            <img class="checked" src="images/unchecked.png">
                        </span>
                        ${taskText}
                        <a href="delete_task.php?task_id=" class="delete-task">
                            <img class="delete" src="images/delete.png" alt="Delete Task">
                        </a>`;
                    listContainer.appendChild(listItem);
                    inputBox.value = ""; 
                }

                form.addEventListener("submit", function (event) {
                event.preventDefault(); // Prevent the default form submission
                const taskText = inputBox.value.trim(); 
                if (taskText !== "") {
                   
                }
            });
        });
    });
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script type="nomodule" src="https://unpkg.com/ionicons@7.1.0/dist/ion"></script>

</body>
</html>