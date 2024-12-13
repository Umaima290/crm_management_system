<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    try {
        $sql = $conn->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $sql->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => $password
        ]);
        echo "Registration successful." ;
     
        header("Location: dashboard.php");
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
    <title>Sign Up Form</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #333;
        }

        .signup-container {
            background: #ffffff;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }

        .signup-container h2 {
            margin-bottom: 1.5rem;
            font-size: 2rem;
            color: #333;
        }

        .signup-container input[type="text"],
        .signup-container input[type="email"],
        .signup-container input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 0.5rem 0;
            border: 1px solid #ddd;
            border-radius: 25px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .signup-container input[type="text"]:focus,
        .signup-container input[type="email"]:focus,
        .signup-container input[type="password"]:focus {
            border: 2px solid #ff7e5f;
            outline: none;
            box-shadow: 0 0 5px rgba(255, 126, 95, 0.5);
        }

        .signup-container button {
            width: 100%;
            padding: 12px;
            background: #ff7e5f;
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
            font-weight: bold;
        }

        .signup-container button:hover {
            background: #feb47b;
            transform: translateY(-2px);
        }

        .signup-container p {
            margin-top: 1rem;
            color: #666;
        }

        .signup-container a {
            color: #ff7e5f;
            text-decoration: underline;
        }

        .signup-container a:hover {
            color: #feb47b;
        }
    </style>
</head>
<body>

<div class="signup-container">
    <h2>Create Account</h2>
    <form method="POST" action="">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</div>

</body>
</html>