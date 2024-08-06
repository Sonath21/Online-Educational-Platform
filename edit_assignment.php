<?php
include 'db_connection.php';

$assignmentId = $_GET['id'] ?? null;
$assignmentData = ['objective' => '', 'deliverables' => '', 'assignment_text' => '', 'submission_date' => ''];

if ($assignmentId) {
    // Λήψη υπαρχόντων δεδομένων ανάθεσης
    $fetchSql = "SELECT objectives, deliverables, assignment_text, submission_date FROM assignments WHERE id = ?";
    $fetchStmt = $conn->prepare($fetchSql);
    $fetchStmt->bind_param("i", $assignmentId);
    $fetchStmt->execute();
    $result = $fetchStmt->get_result();
    if ($result->num_rows > 0) {
        $assignmentData = $result->fetch_assoc();
    }
    $fetchStmt->close();
}

// Διαχείριση υποβολής φόρμας για επεξεργασία
if ($_SERVER["REQUEST_METHOD"] == "POST" && $assignmentId) {
    $objective = mysqli_real_escape_string($conn, $_POST['objective']);
    $deliverables = mysqli_real_escape_string($conn, $_POST['deliverables']);
    $submissionDate = mysqli_real_escape_string($conn, $_POST['submission_date']);
    
    $fileUpdated = false;
    $fileDestination = $assignmentData['assignment_text']; 

    // Έλεγχος αν έχει μεταφορτωθεί ένα νέο αρχείο
    if (!empty($_FILES['assignment_text']['name'])) {
        $fileName = $_FILES['assignment_text']['name'];
        $fileTmpName = $_FILES['assignment_text']['tmp_name'];
        $fileDestination = 'uploads/' . $fileName;
        $fileUpdated = move_uploaded_file($fileTmpName, $fileDestination);
    }

    // SQL για ενημέρωση δεδομένων ανάθεσης
    $updateSql = "UPDATE assignments SET objectives = ?, deliverables = ?, assignment_text = ?, submission_date = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ssssi", $objective, $deliverables, $fileDestination, $submissionDate, $assignmentId);
    
    if ($updateStmt->execute()) {
        header("Location: homework_tutor.php");
        exit();
    } else {
        echo "Error updating assignment: " . $updateStmt->error;
    }

    $updateStmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Edit Assignment</title>
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
    <h2>Επεξεργασία Εργασίας</h2>    
    <div id="container">
        <div id="main-content">
            <div class="content">
                <form action="edit_assignment.php?id=<?php echo $assignmentId; ?>" method="post" enctype="multipart/form-data">
                    <div>
                        <label for="objective">Στόχοι:</label>
                        <textarea id="objective" name="objective" required><?php echo htmlspecialchars($assignmentData['objectives']); ?></textarea>
                    </div>
                    <div>
                        <label for="deliverables">Παραδοτέα:</label>
                        <textarea id="deliverables" name="deliverables" required><?php echo htmlspecialchars($assignmentData['deliverables']); ?></textarea>
                    </div>
                    <div>
                        <label for="assignment_text">Εκφώνηση:</label>
                        <input type="file" id="assignment_text" name="assignment_text">
                        <?php if (!empty($assignmentData['assignment_text'])): ?>
                            <p>Current file: <?php echo htmlspecialchars(basename($assignmentData['assignment_text'])); ?></p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <label for="submission_date">Ημερομηνία παράδοσης:</label>
                        <input type="date" id="submission_date" name="submission_date" required value="<?php echo htmlspecialchars($assignmentData['submission_date']); ?>">
                    </div>
                    <div>
                        <input type="submit" value="Update Assignment">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
