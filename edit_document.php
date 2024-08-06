<?php
include 'db_connection.php';

$success = false;
$documentData = ['title' => '', 'description' => '', 'file_name' => ''];

// Έλεγχος αν βρισκόμαστε σε κατάσταση επεξεργασίας και άντληση δεδομένων
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT title, description, file_name FROM documents WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $documentData = $result->fetch_assoc();
    } else {
        echo "Document not found.";
        exit();
    }
    $stmt->close();
} else {
    echo "No document ID provided.";
    exit();
}

// Διαχείριση υποβολής φόρμας επεξεργασίας
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $fileUpdated = false;
    $fileDestination = $documentData['file_name'];

    // Έλεγχος αν έχει μεταφορτωθεί ένα νέο αρχείο
    if (!empty($_FILES['file']['name'])) {
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileDestination = 'uploads/' . $fileName;
        $fileUpdated = move_uploaded_file($fileTmpName, $fileDestination);
    }

    // !!!!------!!!! den xreiazetai delete 
    $removeFile = isset($_POST['remove_file']) && $_POST['remove_file'] == '1';
    if ($removeFile) {
        $fileDestination = '';
        $fileUpdated = true;
    }

    if ($fileUpdated || !$removeFile) {
        // SQL για την ενημέρωση των δεδομένων του εγγράφου
        $updateSql = "UPDATE documents SET title = ?, description = ?, file_name = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("sssi", $title, $description, $fileDestination, $id);
    
        if ($updateStmt->execute()) {
            $success = true;
        } else {
            echo "Error updating document: " . $updateStmt->error;
        }
    
        $updateStmt->close();
    } else {
        echo "Failed to update file.";
    }

    $conn->close();

    if ($success) {
        header("Location: documents_tutor.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Edit Document</title>
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
    <h2>Edit Document</h2>
    <div id="container">
        <div id="main-content">
            <div class="content">
                <form action="edit_document.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
                    <div>
                        <label for="title">Τίτλος:</label>
                        <input type="text" id="title" name="title" required value="<?php echo htmlspecialchars($documentData['title']); ?>">
                    </div>
                    <div>
                        <label for="description">Περιγραφή:</label>
                        <textarea id="description" name="description" required><?php echo htmlspecialchars($documentData['description']); ?></textarea>
                    </div>
                    <div>
                        <label for="file">Αρχείο:</label>
                        <input type="file" id="file" name="file">
                        <?php if (!empty($documentData['file_name'])): ?>
                            <p>Current file: <?php echo htmlspecialchars(basename($documentData['file_name'])); ?></p>
                            
                        <?php endif; ?>
                    </div>
                    <div>
                        <input type="submit" value="Update Document">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html