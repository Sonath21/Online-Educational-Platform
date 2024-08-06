<?php
include 'db_connection.php';

$success = false;

// Έλεγχος αν η φόρμα έχει υποβληθεί
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileDestination = 'uploads/' . $fileName; 

    if (move_uploaded_file($fileTmpName, $fileDestination)) {
        // SQL για την εισαγωγή δεδομένων εγγράφου
        $sql = "INSERT INTO documents (title, description, file_name) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $title, $description, $fileDestination);
    
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            
            header("Location: documents_tutor.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    
        $stmt->close();
    } else {
        echo "Failed to upload file.";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Add Document</title>
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
    <h2>Προσθήκη νέου εγγράφου</h2>
    <div id="container">
        <div id="main-content">
            <div class="content">
                <form action="add_document.php" method="post" enctype="multipart/form-data">
                    <div>
                        <label for="title">Τίτλος:</label>
                        <input type="text" id="title" name="title" required>
                    </div>
                    <div>
                        <label for="description">Περιγραφή:</label>
                        <textarea id="description" name="description" required></textarea>
                    </div>
                    <div>
                        <label for="file">Αρχείο:</label>
                        <input type="file" id="file" name="file">
                    </div>
                    <div>
                        <input type="submit" value="Upload Document">
                    </div>
                </form>
                <?php if ($success) {
                    echo "<p>Document uploaded successfully.</p>";
                } ?>
            </div>
        </div>
    </div>
</body>
</html>