<?php
require_once '../db.php'; 

try {

    $stmt = $conn->prepare("SELECT id , name FROM contacts");
    $stmt->execute();
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching contacts: " . $e->getMessage());
}
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
.interaction-form {
    width: 50%;
    margin: 40px auto;
    padding: 20px;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 10px;
}

.form-group label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
}

.form-group select, .form-group textarea, .form-group input[type="date"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.form-group textarea {
    height: 100px;
    resize: vertical;
}

.submit-btn {
    width: 100%;
    padding: 10px;
    background-color: #007BFF;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.submit-btn:hover {
    background-color: #0056b3;
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
         <a href="interaction_form.php" class="dropbtn"><i class="fas fa-comments"></i> Interactions</a>
        </li>
        
        <!-- Notes Dropdown -->
        <li class="dropdown">
            <a href="../notes/view.php" class="dropbtn"><i class="fas fa-sticky-note"></i> Notes</a>
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
                <h1 style="margin-top:3rem;text-align:center">Add Interactions</h1>
        
            </header>

            <form method="POST" action="save_interaction.php" class="interaction-form">
    <div class="form-group">
        <label for="contact_id">Contact:</label>
        <select name="contact_id" required>
        <?php
           
            foreach ($contacts as $contact) {
                echo "<option value='{$contact['id']}'>{$contact['name']}</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="interaction_type">Interaction Type:</label>
        <select name="interaction_type" required>
            <option value="Call">Call</option>
            <option value="Meeting">Meeting</option>
            <option value="Email">Email</option>
            <option value="Message">Message</option>
            <option value="Other">Other</option>
        </select>
    </div>

    <div class="form-group">
        <label for="notes">Notes:</label>
        <textarea name="notes" rows="4" cols="50"></textarea>
    </div>

    <div class="form-group">
        <label for="follow_up_date">Follow-up Date:</label>
        <input type="date" name="follow_up_date">
    </div>

    <div class="form-group">
        <label for="status">Status:</label>
        <select name="status" required>
            <option value="Completed">Completed</option>
            <option value="Pending">Pending</option>
            <option value="Canceled">Canceled</option>
        </select>
    </div>

    <button type="submit" class="submit-btn">Save Interaction</button>
</form>

        
    </div>

   <script src="../style.js"></script>
</body>
</html>