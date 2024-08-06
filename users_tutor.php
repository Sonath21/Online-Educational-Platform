<?php 
include 'db_connection.php';

// Χειρισμός προσθήκης νέου χρήστη
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'], $_POST['surname'], $_POST['loginame'], $_POST['password'], $_POST['role'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $surname = mysqli_real_escape_string($conn, $_POST['surname']);
    $loginame = mysqli_real_escape_string($conn, $_POST['loginame']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Εισαγωγή νέου χρήστη στη βάση δεδομένων
    $insertSql = "INSERT INTO users (name, surname, loginame, password, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("sssss", $name, $surname, $loginame, $password, $role);

    if ($stmt->execute()) {
        echo "<p>Ο χρήστης προστέθηκε επιτυχώς.</p>";
    } else {
        echo "<p>Σφάλμα κατά την προσθήκη χρήστη: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];

    // SQL για τη διαγραφή του χρήστη
    $deleteSql = "DELETE FROM users WHERE id = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param("i", $deleteId);

    if ($deleteStmt->execute()) {
        echo "<p>User deleted successfully.</p>";
    } else {
        echo "<p>Error deleting user: " . $conn->error . "</p>";
    }

    $deleteStmt->close();

    header("Location: users_tutor.php");
    exit();
}

// Ανάκτηση χρηστών
$sql = "SELECT id, name, surname, loginame, role FROM users";
$result = $conn->query($sql);
$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Διαχείριση Χρηστών</title>
    <style>
    .user-buttons {
    margin-bottom: 10px; 
    }

    .user-button {
        text-decoration: none; 
        padding: 5px 10px; 
        background: #f0f0f0; 
        color: #333; 
        margin-right: 10px; 
        display: inline-block; 
        font-size: 14px; 
    }

    .user-buttons a {
        padding: 5px 10px;
        background-color: #d9d9d9; 
        color: #333; 
        text-decoration: none; 
        margin-right: 5px; 
    }

    .user-buttons a:hover {
        background-color: #d9d9d9; 
    }

    input[type="submit"] {
        background-color: #d9d9d9; 
        color: #333; 
        padding: 10px 20px; 
        border: none; 
        cursor: pointer; 
    }

    input[type="submit"]:hover {
        background-color: #d9d9d9; 
    }

    .user-button:last-child {
        margin-right: 0; 
    }

    .user-button:hover {
        background-color: #d9d9d9; 
    }

    table {
        width: 100%; 
        border-collapse: collapse; 
    }

    table, th, td {
        border: 1px solid #e6e6e6; 
    }

    th, td {
        padding: 10px; 
        text-align: left; 
    }

    th {
        background-color: #f0f0f0; 
        color: #333; 
    }

    td {
        background-color: #f0f0f0; 
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

        
        h1 {
            text-align: center;
            font-size: 2.5em;
            color: #333;
            background-color: #fff;
            padding: 15px 0;
            margin-bottom: 30px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        
        #container {
            display: flex;
            flex-wrap: wrap;
            min-height: calc(100vh - 70px); 
        }

      
        #sidebar {
            width: 250px;
            background: #e6e6e6;
            padding: 20px;
            height: 100%;
            box-shadow: -1px 0 5px rgba(0, 0, 0, 0.05);
        }

        #sidebar h2 {
            color: #333;
            text-transform: uppercase;
            text-align: center;
            margin-bottom: 30px;
        }

        #sidebar ul li a {
            display: block;
            background: #f0f0f0;
            color: #333;
            padding: 15px;
            margin-bottom: 10px;
            transition: background-color 0.3s;
        }

        #sidebar ul li a:hover {
            background-color: #d9d9d9;
        }

       
        #main-content {
            flex: 1;
            background-color: #fff;
            padding: 30px;
        }

        #main-content .content {

        }
    </style>
</head>
<body>

<h1>Διαχείριση Χρηστών</h1>

<div id="container">
    <div id="sidebar">
        <ul>
            <li><a href="index_tutor.php">Αρχική σελίδα</a></li>
            <li><a href="announcement_tutor.php">Ανακοινώσεις</a></li>
            <li><a href="communication.php">Επικοινωνία</a></li>
            <li><a href="documents_tutor.php">Έγγραφα μαθήματος</a></li>
            <li><a href="homework_tutor.php">Εργασίες</a></li>
            <li><a href="users_tutor.php">Χρήστες</a></li>
            <li><a href="login.php">Αποσύνδεση</a></li>

        </ul>
    </div>
    <div id="main-content">
        <div class="content">
            
            <table>
                <thead>
                    <tr>
                        <th>Όνομα Χρήστη</th>
                        <th>Ονοματεπώνυμο</th>
                        <th>Ρόλος</th> 
                        <th>Ενέργειες</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['loginame']); ?></td>
                            <td><?php echo htmlspecialchars($user['name'] . " " . $user['surname']); ?></td>
                            <td><?php echo htmlspecialchars($user['role']); ?></td> 
                            <td class="user-buttons">
                            <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="user-button">Επεξεργασία</a>
                            <a href="users_tutor.php?delete_id=<?php echo $user['id']; ?>" class="user-button">Διαγραφή</a>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <br>               

            <h2>Προσθήκη Νέου Χρήστη</h2>
            <form action="users_tutor.php" method="post" enctype="multipart/form-data">
                <table>
                    <tr>
                        <th>Όνομα</th>
                        <td><input type="text" name="name" required></td>
                    </tr>
                    <tr>
                        <th>Επώνυμο</th>
                        <td><input type="text" name="surname" required></td>
                    </tr>
                    <tr>
                        <th>Όνομα Χρήστη</th>
                        <td><input type="text" name="loginame" required></td>
                    </tr>
                    <tr>
                        <th>Κωδικός Πρόσβασης</th>
                        <td><input type="password" name="password" required></td>
                    </tr>
                    <tr>
                        <th>Ρόλος</th>
                        <td>
                            <select name="role" required>
                                <option value="Tutor">Tutor</option>
                                <option value="Student">Student</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" value="Προσθήκη Χρήστη">
                        </td>
                    </tr>
                </table>
            </form>
            


        </div>
    </div>
    
</div>

</body>
</html>
