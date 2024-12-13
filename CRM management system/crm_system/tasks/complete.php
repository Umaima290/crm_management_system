<?php
require '../db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'];

$sql = $conn->prepare("UPDATE tasks SET status = 'completed' WHERE id = :id");
$sql->execute([':id' => $id]);

header("Location: view.php");
?>
