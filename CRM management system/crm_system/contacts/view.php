<?php
require '../db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
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
   
     h1 {
            color: #333;
            text-align: center;
        }

        .add-contact {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px auto;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s, transform 0.2s;
        }

        .add-contact:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007BFF;
            color: white;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .actions a {
            margin: 0 5px;
            padding: 5px 10px;
            border-radius: 5px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .actions a:hover {
            background-color: #218838;
        }

        .actions a.delete {
            background-color: #dc3545; 
        }

        .actions a.delete:hover {
            background-color: #c82333; 
        }

        .add-contact {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .add-contact:hover {
            background-color: #218838;
        }
        .add-contact {
    display: inline-block;
    padding: 10px 20px;
    margin: 20px auto;
    background-color: #28a745; 
    color: white;
    border-radius: 5px; 
    text-align: center; 
    text-decoration: none;
    transition: background-color 0.3s, transform 0.2s; 
}

.add-contact:hover {
    background-color: #218838; 
    transform: scale(1.05); 
}
    </style>


<body>
<div class="sidebar">
    <h2>CRM Admin</h2>
    <ul>
        <li><a href="../dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
        
        <!-- Contacts Dropdown -->
        <li class="dropdown">
            <a href="view.php" class="dropbtn"><i class="fas fa-user"></i> Contacts</a>
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
            <header style="padding-top:3rem;">
                <h1 style="text-align: center;" >Your contacts</h1>
            </header>
<?php
$user_id = $_SESSION['user_id'];

$sql = $conn->prepare("SELECT * FROM contacts WHERE user_id = :user_id ORDER BY created_at DESC");
$sql->execute([':user_id' => $user_id]);
$contacts = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<a href="add.php"  class="add-contact">Add New Contact</a><br><br>
<table>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($contacts as $contact): ?>
        <tr>
            <td><?= htmlspecialchars($contact['name']) ?></td>
            <td><?= htmlspecialchars($contact['email']) ?></td>
            <td><?= htmlspecialchars($contact['phone']) ?></td>
            <td><?= htmlspecialchars($contact['address']) ?></td>
            <td>
                <a href="edit.php?id=<?= $contact['id'] ?>">Edit</a> | 
                <a href="delete.php?id=<?= $contact['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
    

   </div>

   <script src="../style.js"></script>
</body>
</html>

