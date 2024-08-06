<?php 
include 'db_connection.php';

$userId = $_GET['id'] ?? null;
$userData = [];

if ($userId) {
    // Λήψη δεδομένων χρήστη
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
    } else {
        echo "User not found.";
        exit();
    }
    $stmt->close();
}

// Χειρισμός υποβολής φόρμας για την ενημέρωση των δεδομένων του χρήστη
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $loginame = $_POST['loginame'];
    $password = $_POST['password']; 
    $role = $_POST['role'];

    $updateStmt = $conn->prepare("UPDATE users SET name=?, surname=?, loginame=?, password=?, role=? WHERE id=?");
    $updateStmt->bind_param("sssssi", $name, $surname, $loginame, $password, $role, $userId);

    if ($updateStmt->execute()) {
        $updateStmt->close();
        $conn->close();
        
        header("Location: users_tutor.php");
        exit();
    } else {
        echo "Error updating user: " . $updateStmt->error;
    }

    $updateStmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <style>
     
        *, *:before, *:after {
            box-sizing: border-box;
        }

        body, h1, h2, ul, li, a {
            margin: 0;
            padding: 0;
            list-style-type: none;
            text-decoration: none;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            font-size: 18px;
            color: #333;
            background-color: #f7f7f7;
        }

        h2 {
            text-align: center;
            font-size: 2.0em;
            color: #333;
            margin-bottom: 30px;
        }

        #container {
            display: flex;
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
        }

        .content {
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 100%; 
            max-width: 600px; 
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #d9d9d9;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #ccc;
        }
    </style>
</head>
<body>
    <div id="container">
    <div class="content">
        <h2>Επεξεργασία Χρήστη</h2>
        <form action="edit_user.php?id=<?php echo $userId; ?>" method="post">
            <table>
                <tr>
                    <th>Όνομα</th>
                    <td><input type="text" name="name" required value="<?php echo htmlspecialchars($userData['name'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <th>Επώνυμο</th>
                    <td><input type="text" name="surname" required value="<?php echo htmlspecialchars($userData['surname'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <th>Όνομα Χρήστη</th>
                    <td><input type="text" name="loginame" required value="<?php echo htmlspecialchars($userData['loginame'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <th>Κωδικός Πρόσβασης</th>
                    <td><input type="password" name="password" required value="<?php echo htmlspecialchars($userData['password'] ?? ''); ?>"></td>
                </tr>
                <tr>
                    <th>Ρόλος</th>
                    <td>
                        <select name="role" required>
                            <option value="Tutor" <?php if ($userData['role'] == 'Tutor') echo 'selected'; ?>>Tutor</option>
                            <option value="Student" <?php if ($userData['role'] == 'Student') echo 'selected'; ?>>Student</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" value="Ενημέρωση Χρήστη">
                    </td>
                </tr>
            </table>
        </form>
        </div>
    </div>
</body>
</html>
