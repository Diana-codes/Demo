<?php
include("db.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['project_name'])) {
        echo "Project name cannot be empty.";
    } else {
        // Retrieve data from the form
        $projectName = $_POST['project_name'];
        $startDate = $_POST['project_date_from'];
        $endDate = $_POST['project_date_to'];

        session_start();
        $user_id = $_SESSION['user_id'];

        // Prepare an SQL statement to insert the project data
        $stmt = $conn->prepare("INSERT INTO projects (project_name, project_date_from, project_date_to, user_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $projectName, $startDate, $endDate, $user_id);

        // Execute the SQL statement
        if ($stmt->execute()) {
            echo "Project added successfully!";
        } else {
            echo "Error adding project: " . $stmt->error;
        }
        $stmt->close();
        $conn->close();
    }
}
?>
