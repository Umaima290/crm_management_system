<?php
require '../db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = $conn->prepare("SELECT t.*, c.name as contact_name FROM tasks t LEFT JOIN contacts c ON t.contact_id = c.id WHERE t.user_id = :user_id 
  ORDER BY t.due_date ASC");

$sql->execute([':user_id' => $user_id]);
$tasks = $sql->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Dashboard</title>
    <link rel="stylesheet" href="../../style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- For icons -->
</head>
<style>
   
   .task-list-title {
    text-align: center;
    margin-bottom: 20px;
}

.add-task-btn {
    display: block;
    margin: 0 auto;
    padding: 10px ;
    background-color: #2196F3;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-align: center;
    width: 30%;
}

.add-task-btn:hover {
    background-color: #1A237E;
}

.task-list-table {
    width: 90%;
    margin: 0 auto;
    border-collapse: collapse;
}

.task-list-header {
    background-color: #f9f9f9;
    border-bottom: 1px solid #ccc;
}

.task-list-header th {
    padding: 10px;
    text-align: left;
}

.task-list-row {
    border-bottom: 1px solid #ccc;
}

.task-list-row td {
    padding: 10px;
}

.task-list-actions {
    text-align: center;
}

.edit-task-btn, .delete-task-btn, .complete-task-btn {
    padding: 5px 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.edit-task-btn {
    background-color: #4CAF50;
    color: white;
}

.edit-task-btn:hover {
    background-color: #3e8e41;
}

.delete-task-btn {
    background-color: #f44336;
    color: white;
}

.delete-task-btn:hover {
    background-color: #e91e63;
}

.complete-task-btn {
    background-color: #03A9F4;
    color: white;
}

.complete-task-btn:hover {
    background-color: #0288D1;
}
    </style>


<body>
<div class="sidebar">
    <h2>CRM Admin</h2>
    <ul>
        <li><a href="../dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
        
        <!-- Contacts Dropdown -->
        <li class="dropdown">
            <a href="../contacts/view.php" class="dropbtn"><i class="fas fa-user"></i> Contacts</a>
        </li>
        
        <!-- Interactions Dropdown -->
        <li class="dropdown">
            <a href="../interactions/contact_interactions.php" class="dropbtn"><i class="fas fa-comments"></i> Interactions</a>
        </li>
        
        <!-- Notes Dropdown -->
        <li class="dropdown">
            <a href="../notes/view.php" class="dropbtn"><i class="fas fa-sticky-note"></i> Notes</a>
        </li>
        
        <!-- Tasks Dropdown -->
        <li class="dropdown">
            <a href="view.php" class="dropbtn"><i class="fas fa-tasks"></i> Tasks</a>
        </li>
      
    </ul>
</div>

    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="user-info">
                <a style="color: black;font-size:larger ; margin-left:59rem" href="logout.php" > <i style="font-size: x-large;color:black" class="fa-solid fa-right-from-bracket"></i></a>
            </div>
        </div>
            <header style="padding-top:3rem;">
                <h1 style="text-align: center;" >Your Tasks</h1>
            </header>

<a href="add.php" class="add-task-btn">Add New Task</a><br><br>
<table class="task-list-table">
    <tr class="task-list-header">
        <th>Title</th>
        <th>Description</th>
        <th>Due Date</th>
        <th>Status</th>
        <th>Contact</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($tasks as $task): ?>
        <tr class="task-list-row">
            <td><?= htmlspecialchars($task['title']) ?></td>
            <td><?= htmlspecialchars($task['description']) ?></td>
            <td><?= htmlspecialchars($task['due_date']) ?></td>
            <td><?= htmlspecialchars($task['status']) ?></td>
            <td><?= htmlspecialchars($task['contact_name'] ?? 'None') ?></td>
            <td class="task-list-actions">
                <a href="edit.php?id=<?= $task['id'] ?>" class="edit-task-btn">Edit</a> | 
                <a href="delete.php?id=<?= $task['id'] ?>" class="delete-task-btn" onclick="return confirm('Are you sure?')">Delete</a> | 
                <?php if ($task['status'] === 'pending'): ?>
                    <a href="complete.php?id=<?= $task['id'] ?>" class="complete-task-btn">Mark as Complete</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

   </div>

   <script src="../style.js"></script>
</body>
</html>