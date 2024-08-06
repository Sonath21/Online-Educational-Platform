<?php
session_start();

include 'db_connection.php';

$login_err = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE loginame = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if ($password === $user['password']) {
            // Ο κωδικός πρόσβασης είναι σωστός, οπότε εκκίνηση μιας νέας συνεδρίας
            session_regenerate_id();
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $user['id'];
            $_SESSION['loginame'] = $username;

            // Επανακατεύθυνση χρήστη βάσει του ρόλου του
            if ($user['role'] === 'Tutor') {
                header("location: index_tutor.php");
                exit;
            } elseif ($user['role'] === 'Student') {
                header("location: index.php");
                exit;
            } else {
                $login_err = "Unexpected user role.";
            }
        } else {
            $login_err = "The password you entered was not valid.";
        }
    } else {
        $login_err = "No account found with that username.";
    }

    $stmt->close();
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
  body, html {
    height: 100%;
    margin: 0;
    font-family: Arial, sans-serif;
  }

  .centered-form {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100%;
    max-width: 400px;
    padding: 20px;
    box-sizing: border-box;
  }

  .form-control {
    margin-bottom: 20px;
    font-size: 18px;
  }

  .form-control input {
    width: 100%;
    padding: 10px;
    box-sizing: border-box;
  }

  .form-control label {
    display: block;
    margin-bottom: 5px;
  }

  button {
    width: 100%;
    padding: 10px;
    font-size: 18px;
    cursor: pointer;
  }
</style>
</head>
<body>
<div class="centered-form">
    <div>
        <?php 
        if(!empty($login_err)){
            echo '<div>' . $login_err . '</div>';
        }        
        ?>

          <form action="login.php" method="post">
            <div class="form-control">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-control">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-control">
                <button type="submit">Login</button>
            </div>
        </form>
    </div>
</body>
</html>
