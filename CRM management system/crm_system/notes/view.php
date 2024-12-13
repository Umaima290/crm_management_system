<?php
require '../db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = $conn->prepare("SELECT n.*, c.name as contact_name, t.title as task_title  FROM notes n  LEFT JOIN contacts c on n.contact_id = c.id   LEFT JOIN tasks t on n.task_id = t.id WHERE n.user_id = :user_id   ORDER BY n.created_at DESC");
$sql->execute([':user_id' => $user_id]);
$notes = $sql->fetchAll(PDO::FETCH_ASSOC);
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
.title {
    text-align: center;
    margin-bottom: 20px;
    font-size: 36px;
    font-weight: bold;
    color: #333;
}

.add-btn {
    display: block;
    margin: 0 auto;
    padding: 10px ;
    text-align: center;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: 18%;
}

.add-btn:hover {
    background-color: #3e8e41;
}

.notes-table {
    width: 80%;
    margin: 40px auto;
    border-collapse: collapse;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.notes-table th, .notes-table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.notes-table th {
    background-color: #4CAF50;
    color: white;
    font-weight: bold;
}

.notes-table tr:hover {
    background-color: #f1f1f1;
}

.edit-btn, .delete-btn {
    padding: 5px 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.edit-btn {
    background-color: #8BC34A;
    color: white;
}

.edit-btn:hover {
    background-color: #6B9467;
}

.delete-btn {
    background-color: #FF0000;
    color: white;
}

.delete-btn:hover {
    background-color: #CC0000;
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
            <a href="view.php" class="dropbtn"><i class="fas fa-sticky-note"></i> Notes</a>
        </li>
        
        <!-- Tasks Dropdown -->
        <li class="dropdown">
            <a href="../tasks/view.php" class="dropbtn"><i class="fas fa-tasks"></i> Tasks</a>
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
            <header>
                <h1 style="margin-top:3rem;text-align:center;">View Notes</h1>
        
            </header>


     
<a href="add.php" class="add-btn">Add New Note</a><br><br>
<table class="notes-table">
    <tr>
        <th>Note</th>
        <th>Contact</th>
        <th>Task</th>
        <th>Created At</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($notes as $note): ?>
        <tr>
            <td><?= htmlspecialchars($note['note']) ?></td>
            <td><?= htmlspecialchars($note['contact_name'] ?? 'None') ?></td>
            <td><?= htmlspecialchars($note['task_title'] ?? 'None') ?></td>
            <td><?= htmlspecialchars($note['created_at']) ?></td>
            <td>
                <a href="edit.php?id=<?= $note['id'] ?>" class="edit-btn">Edit</a> | 
                <a href="delete.php?id=<?= $note['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
        
    </div>

   <script src="../style.js"></script>
</body>
</html>