<?php
include 'db_connection.php';

$success = false; 

// Έλεγχος αν η φόρμα έχει υποβληθεί
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $main_text = mysqli_real_escape_string($conn, $_POST['main_text']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);

    // Ανάκτηση και καθαρισμός εισόδου
    $sql = "INSERT INTO announcements (subject, main_text, date) VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);

    // Δέσμευση παραμέτρων και εκτέλεση
    $stmt->bind_param("sss", $subject, $main_text, $date);
    $stmt->execute();

    // Έλεγχος αν η εισαγωγή ήταν επιτυχής
    if ($stmt->affected_rows > 0) {
        $success = true; 
    } else {
        echo "<p>Η προσθήκη ανακοίνωσης απέτυχε: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Λήψη ανακοινώσεων από τη βάση δεδομένων
$sql = "SELECT date, subject, main_text FROM announcements ORDER BY date DESC";
$result = $conn->query($sql);

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
    <h2>Προσθήκη νέας ανακοίνωσης</h2>
    <div id="container">
        <div id="main-content">
            <div class="content">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div>
                        <label>Θέμα</label>
                        <input type="text" name="subject" required>
                    </div>
                    <div>
                        <label>Κείμενο Ανακοίνωσης</label>
                        <textarea name="main_text" required></textarea>
                    </div>
                    <div>
                        <label>Ημερομηνία</label>
                        <input type="date" name="date" required>
                    </div>
                    <div>
                        <input type="submit" value="Υποβολή">
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="announcements">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='announcement'>";
                echo "<p><strong>Ημερομηνία:</strong> " . htmlspecialchars($row['date']) . "</p>";
                echo "<p><strong>Θέμα:</strong> " . htmlspecialchars($row['subject']) . "</p>";
                
                //$mainText = str_replace(array("\\r\\n", "\\n", "\\r", "\r\n", "\r", "\n"), "/n", $row['main_text']);
                $mainText = nl2br($mainText);
                
                $mainText = htmlspecialchars($mainText, ENT_QUOTES, 'UTF-8');
            
                echo "<p>" . $mainText . "</p>";
                echo "</div><hr>";
            }
            
        } else {
            echo "Δεν υπάρχουν ανακοινώσεις.";
        }
        ?>
    </div>
    
    <?php
    if ($success) {
        
        echo "<script type='text/javascript'>
                alert('Η ανακοίνωση προστέθηκε με επιτυχία! Ανακατεύθυνση...');
                setTimeout(function(){
                    window.location.href = 'announcement_tutor.php';
                }, 1500);
              </script>";
    }
    ?>
</body>
</html>

