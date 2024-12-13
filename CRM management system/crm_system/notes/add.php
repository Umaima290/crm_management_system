<?php
require '../db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $note = $_POST['note'];
    $contact_id = $_POST['contact_id'] ?? null;
    $task_id = $_POST['task_id'] ?? null;
    $user_id = $_SESSION['user_id'];

    try {
        $sql = $conn->prepare("INSERT INTO notes (note, user_id, contact_id, task_id) 
                                VALUES (:note, :user_id, :contact_id, :task_id)");
        $sql->execute([
            ':note' => $note,
            ':user_id' => $user_id,
            ':contact_id' => $contact_id,
            ':task_id' => $task_id
        ]);
      
        header("Location: view.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


$sql = $conn->prepare("SELECT id, name FROM contacts WHERE user_id = :user_id");
$sql->execute([':user_id' => $_SESSION['user_id']]);
$contacts = $sql->fetchAll(PDO::FETCH_ASSOC);


$sql = $conn->prepare("SELECT id, title FROM tasks WHERE user_id = :user_id");
$sql->execute([':user_id' => $_SESSION['user_id']]);
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
.note-form {
    width: 50%;
    margin: 40px auto;
    padding: 20px;
    background-color: #f2f2f2;
    border: 1px solid #ccc;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 20px;
}

.form-group textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    height: 150px;
    resize: vertical;
}

.form-group select {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.submit-btn {
    width: 100%;
    padding: 10px;
    background-color: #8BC34A;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.submit-btn:hover {
    background-color: #6B9467;
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
            <a href="add.php" class="dropbtn"><i class="fas fa-sticky-note"></i> Notes</a>
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
                <h1 style="margin-top:3rem;text-align:center;">Add Notes</h1>
            </header>


 <form method="POST" action="" class="note-form">
    <div class="form-group">
        <textarea name="note" placeholder="Enter your note here..." required></textarea>
    </div>

    <div class="form-group">
        <select name="contact_id">
            <option value="">Select Contact</option>
            <?php foreach ($contacts as $contact): ?>
                <option value="<?= $contact['id'] ?>"><?= htmlspecialchars($contact['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <select name="task_id">
            <option value="">Select Task</option>
            <?php foreach ($tasks as $task): ?>
                <option value="<?= $task['id'] ?>"><?= htmlspecialchars($task['title']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="submit-btn">Add Note</button>
</form>

</div>

   <script src="../style.js"></script>
</body>
</html>