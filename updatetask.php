<?php
session_start();
include('db.php');
include('functions.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($action === 'UPDATE_TASK') {
    $task_id = isset($_POST['task_id']) ? intval($_POST['task_id']) : 0;
    $new_status = isset($_POST['new_status']) ? ($_POST['new_status'] == 1 ? 1 : 0) : 0;

    if ($task_id <= 0) {
        $data = array(
            'status' => 400, // Bad Request
            'feedback' => "Invalid task ID"
        );
    } else {
        // Use a prepared statement to update the task status
        $sql = "UPDATE tasks SET completed = ? WHERE task_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $new_status, $task_id);
        

        if ($stmt->execute()) {
            $data = array(
                'status' => 200, // OK
                'feedback' => "SUCCESS"
            );
        } else {
            $data = array(
                'status' => 500, // Internal Server Error
                'feedback' => "FAILED"
            );
        }
        $stmt->close();
    }

    // Return JSON response
    // header('Content-Type: application/json');
    echo json_encode($data);
}
?>
