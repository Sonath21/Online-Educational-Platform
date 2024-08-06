<?php
include 'db_connection.php';

$success = false;

// check αν το id έχει οριστεί στη διεύθυνση URL
if (isset($_GET['id'])) {
    $announcement_id = $_GET['id'];

    // Λήψη των δεδομένων της ανακοίνωσης
    $sql = "SELECT * FROM announcements WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $announcement_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $announcement = $result->fetch_assoc();
}

// Έλεγχος αν η φόρμα έχει υποβληθεί
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ανάκτηση και καθαρισμός εισόδου
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $main_text = mysqli_real_escape_string($conn, $_POST['main_text']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);

    $sql = "UPDATE announcements SET subject = ?, main_text = ?, date = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("sssi", $subject, $main_text, $date, $announcement_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $success = true;
    } else {
        echo "<p>Η επεξεργασία ανακοίνωσης απέτυχε: " . $stmt->error . "</p>";
    }

    $stmt->close();

    if ($success) {
        header("Location: announcement_tutor.php");
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="el">
<head>
<meta charset="UTF-8">
    <title>Αρχική Σελίδα</title>
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
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 70px); 
        }

        form {
            width: 100%; 
            max-width: 500px; 
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background: #ffffff;
            margin-bottom: 30px;
        }

        form div {
            margin-bottom: 15px;
            text-align: left;
        }

        form label {
            display: block;
            margin-bottom: 5px;
        }

        form input[type="text"],
        form input[type="date"],
        form textarea,
        form input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px; 
        }

        form textarea {
            height: 100px; 
        }
    </style>
</head>
<body>
    <h2>Επεξεργασία Ανακοίνωσης</h2>
    <div id="container">
        <div id="main-content">
            <div class="content">
                <form action="edit_announcement.php?id=<?php echo $announcement_id; ?>" method="post">
                    <div>
                        <label>Θέμα</label>
                        <input type="text" name="subject" value="<?php echo htmlspecialchars($announcement['subject']); ?>" required>
                    </div>
                    <div>
                        <label>Κείμενο Ανακοίνωσης</label>
                        <textarea name="main_text" required><?php echo htmlspecialchars($announcement['main_text']); ?></textarea>
                    </div>
                    <div>
                        <label>Ημερομηνία</label>
                        <input type="date" name="date" value="<?php echo htmlspecialchars($announcement['date']); ?>" required>
                    </div>
                    <div>
                        <input type="submit" value="Ενημέρωση">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
