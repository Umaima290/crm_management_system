<?php
require '../db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM notes WHERE id = :id");
$stmt->execute([':id' => $id]);

header("Location: view.php");
?>
