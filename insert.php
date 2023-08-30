<?php
session_start();
include('db.php');

$action= mysqli_real_escape_string($conn, $_POST['action']);
$c_year = date("Y");

if ($action === 'NEW_TASK') {

    $task=mysqli_real_escape_string($conn, $_POST['task']);

    $sql1="INSERT INTO tasks set user_id= $_SESSION[user_id], task='$task'";

if ($conn->query($sql1)===TRUE) {
                                              
                            
    $data = array(
    'status' => 200,
    'feedback' => "SUCCESS"
    );
    $display_data = json_encode($data);
    echo $display_data;
                                
    }else{
    $data = array(
    'status' => 200,
    'feedback' => "FAILED"
    );
    $display_data = json_encode($data);
    echo $display_data;
}


}

if ($action === 'UPDATE_TASK') {
        $task_id = isset($_POST['task_id']) ? intval($_POST['task_id']) : 0;
        $new_status = isset($_POST['new_status']) ? ($_POST['new_status'] == 1 ? 1 : 0) : 0;
        $result = updateTaskStatus($conn, $task_id, $new_status);

    // Check if task_id is valid (greater than 0)
    if ($task_id <= 0) {
        $data = array(
            'status' => 400, // Bad Request
            'feedback' => "Invalid task ID"
        );
    } else {
        // Use a prepared statement to update the task status
        $sql1 = "UPDATE tasks SET completed = ? WHERE task_id = ?";

        $stmt = $conn->prepare($sql1);
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
    $display_data = json_encode($data);
    echo $display_data;
}

// Add a new action to handle unchecking a task
if ($action === 'UNCHECK_TASK') {
    $task = mysqli_real_escape_string($conn, $_POST['task']);

    $sql = "UPDATE tasks SET completed = 0 WHERE task_id = $task";

    if ($conn->query($sql) === TRUE) {
        $data = array(
            'status' => 200,
            'feedback' => "SUCCESS"
        );
        $display_data = json_encode($data);
        echo $display_data;
    } else {
        $data = array(
            'status' => 200,
            'feedback' => "FAILED"
        );
        $display_data = json_encode($data);
        echo $display_data;
    }
}
