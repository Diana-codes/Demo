<?php
session_start();
include('db.php');
include('functions');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-button'])) {
    $task = $_POST['task'];
    addTask("i", $user_id, $task);
}

header('Location: homepage.php');
exit();
?>
