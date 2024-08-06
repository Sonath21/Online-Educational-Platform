<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ανάκτηση και καθαρισμός εισόδου
    $objective = mysqli_real_escape_string($conn, $_POST['objective']);
    $deliverables = mysqli_real_escape_string($conn, $_POST['deliverables']);
    $submissionDate = mysqli_real_escape_string($conn, $_POST['submission_date']);

    // Χειρισμός μεταφόρτωσης αρχείων
    $fileName = $_FILES['assignment_text']['name'];
    $fileTmpName = $_FILES['assignment_text']['tmp_name'];
    $fileDestination = 'uploads/' . $fileName; // Ensure 'uploads' directory exists

    if (move_uploaded_file($fileTmpName, $fileDestination)) {
        // SQL για την εισαγωγή δεδομένων εκχώρησης
        $sql = "INSERT INTO assignments (objectives, deliverables, assignment_text, submission_date) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $objective, $deliverables, $fileDestination, $submissionDate);

        if ($stmt->execute()) {
            // Λήψη του id της νεοπροστιθέμενης ανάθεσης
            $newAssignmentId = $stmt->insert_id;

            $currentDate = date('Y-m-d'); // Current date
            $subject = "Υποβλήθηκε η εργασία " . $newAssignmentId;
            $mainText = "Η ημερομηνία παράδοσης της εργασίας είναι " . $submissionDate . ".";

            // SQL για την εισαγωγή δεδομένων ανακοίνωσης
            $announcementSql = "INSERT INTO announcements (date, subject, main_text) VALUES (?, ?, ?)";
            $announcementStmt = $conn->prepare($announcementSql);
            $announcementStmt->bind_param("sss", $currentDate, $subject, $mainText);

            if ($announcementStmt->execute()) {
                // Ανακατεύθυνση στο homework_tutor.php μετά την επιτυχή προσθήκη
                header("Location: homework_tutor.php");
                exit();
            } else {
                echo "Error in adding announcement: " . $announcementStmt->error;
            }

            $announcementStmt->close();
        } else {
            echo "Error in adding assignment: " . $stmt->error;
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
    <title>Add Assignment</title>
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
    <h2>Προσθήκη νέας εργασίας</h2>    
    <div id="container">
    
        <div id="main-content">
            <div class="content">
                
                <form action="add_assignment.php" method="post" enctype="multipart/form-data">
                    <div>
                        <label for="objective">Στόχοι:</label>
                        <textarea id="objective" name="objective" required></textarea>
                    </div>
                    <div>
                        <label for="deliverables">Παραδοτέα:</label>
                        <textarea id="deliverables" name="deliverables" required></textarea>
                    </div>
                    <div>
                        <label for="assignment_text">Εκφώνηση:</label>
                        <input type="file" id="assignment_text" name="assignment_text">
                    </div>
                    <div>
                        <label for="submission_date">Ημερομηνία παράδοσης:</label>
                        <input type="date" id="submission_date" name="submission_date" required>
                    </div>
                    <div>
                        <input type="submit" value="Add Assignment">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>