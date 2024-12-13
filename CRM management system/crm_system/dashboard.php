<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Dashboard</title>
    <link rel="stylesheet" href="../style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- For icons -->
</head>
<style>
    
   
        .cards {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-evenly;
            margin-top: 2rem;
         
        }

        .card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 10px;
            flex: 1 1 calc(30% - 20px); 
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden;
        }

        .card h3 {
            margin: 0 0 10px;
            font-size: 1.5rem;
            color: #007bff;
        }

        .card p {
            margin: 0 0 15px;
            color: #555; 
        }

        .card a {
            display: inline-block;
            background-color: #007bff;
            color: white; 
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s, transform 0.3s;
        }

        .card a:hover {
            background-color: #0056b3; 
            transform: translateY(-2px);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            .card {
                flex: 1 1 calc(45% - 20px); 
            }
        }

        @media (max-width: 480px) {
            .card {
                flex: 1 1 100%; 
            }
        }  

</style>
<body>
<div class="sidebar">
    <h2>CRM Admin</h2>
    <ul>
        <li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
        
        <!-- Contacts Dropdown -->
        <li class="dropdown">
     <a href="contacts/view.php" class="dropbtn"><i class="fas fa-user"></i> Contacts</a>
        </li>
        
        <!-- Interactions Dropdown -->
        <li class="dropdown">
            <a href="interactions/contact_interactions.php" class="dropbtn"><i class="fas fa-comments"></i> Interactions</a>
        </li>
        
        <!-- Notes Dropdown -->
        <li class="dropdown">
            <a href="notes/view.php" class="dropbtn"><i class="fas fa-sticky-note"></i> Notes</a>
        </li>
        
        <!-- Tasks Dropdown -->
        <li class="dropdown">
            <a href="tasks/view.php" class="dropbtn"><i class="fas fa-tasks"></i> Tasks</a>
        </li>
        
      
      
    </ul>
</div>

    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="user-info">
              
                <h1 style="">Welcome, <?= htmlspecialchars($_SESSION['name']); ?></h1>
                <a style="color: black;font-size:larger ; margin-left:2rem" href="logout.php" > <i style="font-size: x-large;color:black" class="fa-solid fa-right-from-bracket"></i></a>
            </div>
        </div>
            <header>
                <p>Manage your CRM efficiently.</p>
            </header>

        <div class="cards" style="margin-top: 2rem;">
        <div class="card" style="background-color: #f0f8ff; ">
    <h3 style="color: #2c3e50;">Contacts</h3>
    <p style="color: #34495e;">Manage all customer contacts.</p>
    <a href="contacts/view.php" style=" background-color: #2980b9; color: white;">View Contacts</a>
     </div>


           <div class="card" style="background-color: #fff3e6;">
    <h3 style=" color: #e67e22;">Interactions</h3>
    <p style=" color: #7f8c8d;">Track customer interactions.</p>
    <a href="interactions/contact_interactions.php" style="background-color: #d35400; color: white;">Manage Interactions</a>
</div>
<div class="card" style="background-color: #e8f5e9; border-radius: 10px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); padding: 20px; margin: 10px;">
    <h3 style="color: #388e3c;">Tasks</h3>
    <p style="color: #555555;">Organize tasks efficiently.</p>
    <a href="tasks/view.php" style="display: inline-block; background-color: #4caf50; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none;">View Tasks</a>
</div>
<div class="card" style="background-color: #e0f7fa; border-radius: 10px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); padding: 20px; margin: 10px;">
    <h3 style="color: #00796b;">Interactions</h3>
    <p style="color: #004d40;">Generate Interactions.</p>
    <a href="interactions/interaction_report.php" style="display: inline-block; background-color: #009688; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none;">View Interactions</a>
</div>
<div class="card" style="background-color: #f0f4c3; border-radius: 10px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); padding: 20px; margin: 10px;">
    <h3 style="margin: 0 0 10px; font-size: 1.5rem; color: #8bc34a;">Notes</h3>
    <p style="margin: 0 0 15px; color: #4a4a4a;">Create and manage notes.</p>
    <a href="notes/view.php" style="display: inline-block; background-color: #cddc39; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none;">View Notes</a>
</div>
        </div>
    </div>

   <script src="../style.js"></script>
</body>
</html>

