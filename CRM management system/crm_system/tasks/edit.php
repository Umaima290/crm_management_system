<?php
require '../db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $contact_id = $_POST['contact_id'];

    

    $sql = $conn->prepare("UPDATE tasks SET title = :title, description = :description, due_date = :due_date, contact_id = :contact_id WHERE id = :id");

                                
    $sql->execute([
        ':title' => $title,
        ':description' => $description,
        ':due_date' => $due_date,
        ':contact_id' => $contact_id,
        ':id' => $id
    ]);
    header("Location: view.php");
}

$sql = $conn->prepare("SELECT * FROM tasks WHERE id = :id");
$sql->execute([':id' => $id]);
$task = $sql->fetch(PDO::FETCH_ASSOC);
$sql = $conn->prepare("SELECT id, name FROM contacts WHERE user_id = :user_id");
$sql->execute([':user_id' => $_SESSION['user_id']]);
$contacts = $sql->fetchAll(PDO::FETCH_ASSOC);
$selectedContactId = $task['contact_id'] ?? ''; 
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
    .task-form {
    width: 60%;
    margin: 40px auto;
    padding: 20px;
    background-color: #f9f9f9;
    border: 1px solid #ccc;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
    color: #666;
}

.form-group input[type="text"], .form-group textarea, .form-group select {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.form-group input[type="date"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.update-btn {
    width: 100%;
    padding: 10px;
    background-color: #2196F3;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.update-btn:hover {
    background-color: #1A237E;
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
            <a href="" class="dropbtn"><i class="fas fa-tasks"></i> Tasks</a>
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
                <h1 style="text-align: center;" >Edit Task</h1>
            </header>

            <form method="POST" action="" class="task-form">
    <div class="form-group">
        <label for="title">Task Title:</label>
        <input type="text" name="title" id="title" value="<?= htmlspecialchars($task['title']) ?>" required>
    </div>

    <div class="form-group">
        <label for="description">Task Description:</label>
        <textarea name="description" id="description" required><?= htmlspecialchars($task['description']) ?></textarea>
    </div>

    <div class="form-group">
        <label for="due_date">Due Date:</label>
        <input type="date" name="due_date" id="due_date" value="<?= htmlspecialchars($task['due_date']) ?>" required>
    </div>

    <div class="form-group">
        <label for="contact_id">Contact:</label>
        <select name="contact_id" id="contact_id" required>
            <option value="">No Contact</option>
            <?php foreach ($contacts as $contact): ?>
                <option value="<?= $contact['id'] ?>" <?= $contact['id'] == $selectedContactId ? 'selected' : '' ?>>
                    <?= htmlspecialchars($contact['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="update-btn">Update</button>
</form>

   </div>

   <script src="../style.js"></script>
</body>
</html>