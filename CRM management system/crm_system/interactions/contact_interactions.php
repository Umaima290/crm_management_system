<?php
require_once '../db.php'; 


$contact_name = null;


if (isset($_GET['contact_name'])) {
    $contact_name = $_GET['contact_name'];

 
    $stmt = $conn->prepare("SELECT i.id, i.interaction_type, i.date, i.notes, i.follow_up_date, i.status, u.name AS user_name
                            FROM interactions i
                            JOIN users u ON i.user_id = u.id
                            JOIN contacts c ON i.contact_id = c.id
                            WHERE c.name LIKE :contact_name ORDER BY i.date DESC");
    $like_name = "%" . $contact_name . "%";
    $stmt->bindParam(':contact_name', $like_name, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll();
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
 .title {
    text-align: center;
    margin-bottom: 20px;
}

.search-form {
    width: 50%;
    margin: 40px auto;
    padding: 20px;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.search-form .form-group {
    margin-bottom: 20px;
}

.search-form label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
}

.search-form input {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
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

.interaction-table {
    width: 100%;
    margin: 20px 0;
    border-collapse: collapse;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.interaction-table th, .interaction-table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.interaction-table th {
    background-color: #007BFF;
    color: white;
    font-weight: bold;
}

.interaction-table tr:hover {
    background-color: #f1f1f1;
}

.no-results {
    text-align: center;
    margin-top: 20px;
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
            <a href="contact_interactions.php" class="dropbtn"><i class="fas fa-comments"></i> Interactions</a>
            
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
      
        <div class="top-bar">
            <div class="user-info">
                <a style="color: black;font-size:larger ; margin-left:59rem" href="logout.php" > <i style="font-size: x-large;color:black" class="fa-solid fa-right-from-bracket"></i></a>
            </div>
        </div>
            <header>
                <h1 style="margin-top:3rem;text-align:center">Search Interaction History</h1>
            </header>



      

<form method="get" action="" class="search-form">
    <div class="form-group">
        <label for="contact_name">Enter Contact Name:</label>
        <input type="text" id="contact_name" name="contact_name" required>
    </div>
    <button type="submit" class="submit-btn">Search</button>
  <button style="width: 100%;padding: 7px;margin-top: 1rem;background-color:#A7D477;border-radius:5px;"><a style="color: black;text-decoration:none;"  href="interaction_form.php">Add</a></button>
</form>

<?php if ($contact_name !== null): ?>
    <h2 class="title">Interaction History for Contact Name: <?= htmlspecialchars($contact_name) ?></h2>
    <table class="interaction-table">
        <thead>
            <tr>
                <th>Type</th>
                <th>Date</th>
                <th>Notes</th>
                <th>Follow-up Date</th>
                <th>Status</th>
                <th>Handled By</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result): ?>
                <?php foreach ($result as $interaction): ?>
                    <tr>
                        <td><?= htmlspecialchars($interaction['interaction_type']) ?></td>
                        <td><?= htmlspecialchars($interaction['date']) ?></td>
                        <td><?= htmlspecialchars($interaction['notes']) ?></td>
                        <td><?= htmlspecialchars($interaction['follow_up_date']) ?></td>
                        <td><?= htmlspecialchars($interaction['status']) ?></td>
                        <td><?= htmlspecialchars($interaction['user_name']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No interactions found for this contact name.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="no-results">Please enter a contact name to view interaction history.</p>
<?php endif; ?>



          
    </div>

   <script src="../style.js"></script>
</body>
</html>