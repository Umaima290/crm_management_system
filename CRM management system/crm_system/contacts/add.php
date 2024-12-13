<?php
require '../db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $user_id = $_SESSION['user_id'];

    try {
        $sql = $conn->prepare("INSERT INTO contacts (name, email, phone, address, user_id) 
                                VALUES (:name, :email, :phone, :address, :user_id)");
        $sql->execute([
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':address' => $address,
            ':user_id' => $user_id
        ]);
     
        header("Location: view.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
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
    .form-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            font-size: 16px;
        }

        h2 {
           
            margin-bottom: 20px;
       
        }

        form {
            display: flex;
            flex-direction: column;
           
        }

        input[type="text"], input[type="email"], textarea {
            padding: 12px 20px;
            margin-bottom: 20px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            outline: none;
            transition: border 0.3s ease;
        }

        input[type="text"]:focus, input[type="email"]:focus, textarea:focus {
            border-color: #1abc9c;
        }

        input[type="text"], input[type="email"] {
            width: 50%;
        }

        textarea {
            width: 50%;
            height: 100px;
            resize: none;
            font-family: Arial, sans-serif;
            font-size: 16px;
        }

        button {
            padding: 12px 20px;
            background-color: #1abc9c;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 50%;
        }

        button:hover {
            background-color: #16a085;
        }

        button:focus {
            outline: none;
        }

        /* Small screen responsiveness */
        @media (max-width: 500px) {
            .form-container {
                padding: 20px;
            }
        }

    </style>


<body>
<div class="sidebar">
    <h2>CRM Admin</h2>
    <ul>
        <li><a href="../dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
        
        <!-- Contacts Dropdown -->
        <li class="dropdown">
            <a href="add.php" class="dropbtn"><i class="fas fa-user"></i> Contacts</a>   
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
    <header style="margin-left: 10rem;padding-top:3rem;">
                <h1 >Add contact</h1>
    </header>

    <form method="POST" action="">
    <input type="text" name="name" placeholder="Name" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="text" name="phone" placeholder="Phone"><br>
    <textarea name="address" placeholder="Address"></textarea><br>
    <button type="submit">Add Contact</button>
    </form>

    </div>

   <script src="../style.js"></script>
</body>
</html>

