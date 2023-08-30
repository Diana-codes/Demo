<?php
session_start();
include('db.php');

function getTasksByUserId($conn, $user_id) {
    $stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $tasks = $result->fetch_all(MYSQLI_ASSOC);
    return $tasks;
}

// Function to delete a task by task_id
function deleteTaskByID($conn, $task_id) {
    $stmt = $conn->prepare("DELETE FROM tasks WHERE task_id = ?");
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $stmt->close();
}


// Function to add a new task
function addTask($conn, $user_id, $task) {
    if (!empty($task)){
        $stmt = $conn->prepare("INSERT INTO tasks (user_id, task, completed) VALUES (?, ?, 0)");
        $stmt->bind_param("is", $user_id, $task);
        if( $stmt->execute()){
            echo "Task added successfully!";
        }else{
            echo "Error adding task:" .$stmt->error;
        }
    }  
}

function getTaskById($conn, $task_id) {
    $sql = "SELECT * FROM tasks WHERE task_id = $task_id";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}


function getProjectsByUserId($conn, $user_id) {
    $projects = array();

    $query = "SELECT * FROM projects WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
    $stmt->close();
    return $projects;
}



function updateTaskStatus($conn, $task_id, $new_status) {
    // Check if task_id is valid (greater than 0)
    if ($task_id <= 0) {
        return json_encode(array(
            'status' => 400,
            'feedback' => "Invalid task ID"
        ));
    }

    $sql = "UPDATE tasks SET completed = ? WHERE task_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $new_status, $task_id);

    if ($stmt->execute()) {
        return json_encode(array(
            'status' => 200, // OK
            'feedback' => "SUCCESS"
        ));
    } else {
        return json_encode(array(
            'status' => 500, 
            'feedback' => "FAILED"
        ));
    }

    $stmt->close();
}




