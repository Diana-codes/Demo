<?php
include('db.php');
include('functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['task_id'])) {
    $task_id = $_GET['task_id'];

    try {
        deleteTaskByID($conn, $task_id);
        header('Location: homepage.php');
        exit();
    } catch (PDOException $e) {
        echo "Error deleting task: " . $e->getMessage();
    }
}
?>
