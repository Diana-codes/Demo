<?php
include ('db');
$project_id = $_GET['project_id'];

$query = "SELECT tasks.project_id FROM tasks
          INNER JOIN projects ON tasks.project_id = projects.project_id
          WHERE projects.project_id = ?";
// SELECT  * FROM tasks INNER JOIN projects ON tasks.project_id = projects.project_id 
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $project_id );
$stmt->execute();
// echo "$query";

// Fetch and return the tasks as JSON
$tasks = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
echo json_encode($tasks);

?>