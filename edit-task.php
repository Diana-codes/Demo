<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task_id']) && isset($_POST['editedTaskText'])) {
    $task_id = $_POST['task_id'];
    $editedTaskText = $_POST['editedTaskText'];
    
    // Update the task text in the database
    $stmt = $conn->prepare("UPDATE tasks SET task = ? WHERE task_id = ?");
    $stmt->bind_param("si", $editedTaskText, $task_id);
    
    if ($stmt->execute()) {
        echo "Task updated successfully!";
    } else {
        echo "Error updating task: " . $stmt->error;
    }
} else {
    echo "Invalid request.";
}
?>

