<?php
if (isset($_POST["submit"])) {
    include "dbcon.php";

    $username = $_POST['username'];
    $userPassword = $_POST['password'];

    $sql = "INSERT INTO users(username, password) VALUES('$username', '$userPassword')";
    if($conn->query($sql)) {
        header("Location: login.php");
        exit();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewpsort" content="width=device-width, initial-scale=1.0">
    <title>To-Do List App</title>
    <style>
        body {
            background: url("bg.jpg") center/cover no-repeat fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        h3 {
            color: #0073e6;
            text-align: center;
            margin-bottom: 20px;
            font-size: 18px;
        }

        form {
            width: 300px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            padding: 20px 30px;
        }

        input[type="text"],
        input[type="password"],
        textarea {
            padding: 10px;
            background: rgba(255, 255, 255, 1);
            color: black;
            border: none;
            outline: none;
            margin-bottom: 15px;
            border-radius: 10px;
            width: 100%;
            font-family: inherit;
            box-sizing: border-box;
        }

        textarea {
            height: 80px;
            resize: none;
        }

        input[type="submit"],
        .cancel-btn {
            width: 100%;
            height: 40px;
            font-size: 16px;
            color: #fff;
            cursor: pointer;
            border-radius: 30px;
            border: none;
            outline: none;
            transition: all 0.3s ease;
        }

        input[type="submit"] {
            background: #0073e6;
            margin-bottom: 10px;
        }

        input[type="submit"]:hover {
            background: #0073e6;
            transform: scale(1.03);
        }


    </style>
</head>
<body>
    <form action="signup.php" method="POST">
        <h3>SIGN UP</h3>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password"  name="password" placeholder="Password" required>
        <input type="submit" name="submit" value="Sign Up">
        <input type="submit" name="cancel" value="Cancel" onclick="window.location.href='login.php'">
    </form>
</body>
</html>
