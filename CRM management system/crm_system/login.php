<?php
session_start(); 

require 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    if ($email && $password) {
        try {
          
            $sql = $conn->prepare("SELECT * FROM users WHERE email = :email");
            $sql->execute([':email' => $email]);

     
            $user = $sql->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
    
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                

           
                header("Location: dashboard.php");
                exit;
            } else {
                echo "Invalid email or password.";
            }
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    } else {
        echo "Email and password are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #87ceeb, #6495ed);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #333;
        }

        .login-container {
            background: #f7f7f7;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 1.5rem;
            font-size: 2rem;
            color: #333;
        }

        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 0.5rem 0;
            border: 1px solid #ddd;
            border-radius: 25px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .login-container input[type="email"]:focus,
        .login-container input[type="password"]:focus {
            border: 2px solid #6495ed;
            outline: none;
            box-shadow: 0 0 5px rgba(100, 149, 237, 0.5);
        }

        .login-container button {
            width: 100%;
            padding: 12px;
            background: #6495ed;
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
            font-weight: bold;
        }

        .login-container button:hover {
            background: #4682b4;
            transform: translateY(-2px);
        }

        .login-container p {
            margin-top: 1rem;
            color: #666;
        }

        .login-container a {
            color: #6495ed;
            text-decoration: underline;
        }

        .login-container a:hover {
            color: #4682b4;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Welcome Back</h2>
    <form method="POST" action="">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Sign up</a></p>
</div>

</body>
</html>