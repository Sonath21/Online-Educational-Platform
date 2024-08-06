<?php 
global $conn;
include 'db_connection.php'; 

// Μέτρηση του συνολικού αριθμού των ανακοινώσεων
$countSql = "SELECT COUNT(id) AS total FROM announcements";
$countResult = $conn->query($countSql);
$totalAnnouncements = 0;
if ($countRow = $countResult->fetch_assoc()) {
    $totalAnnouncements = $countRow['total'];
}
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Ανακοινώσεις</title>
    <style>
        *, *:before, *:after {
            box-sizing: border-box;
        }
        
    .announcement-buttons {
        margin-bottom: 10px; 
    }

    .announcement-button {
    text-decoration: none; 
    padding: 5px 10px; 
    background: #f0f0f0; 
    color: #333; 
    margin-right: 10px; 
    display: inline-block; 
    font-size: 14px; 
    }

    .announcement-button:last-child {
    margin-right: 0; 
    }

    .announcement-button:hover {
    background-color: #d9d9d9; 
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

        #sidebar ul li a, .add-announcement-btn {
            display: block;
            background: #f0f0f0;
            color: #333;
            padding: 15px;
            margin-bottom: 10px;
            transition: background-color 0.3s;
        }

        #sidebar ul li a:hover, .add-announcement-btn:hover {
            background-color: #d9d9d9;
        }

       
        #main-content {
            flex: 1;
            background-color: #fff;
            padding: 30px;
        }

        #main-content .content {

        }

        .add-announcement-btn {
            text-align: center; 
            text-decoration: none; 
            font-weight: bold; 
        }
    </style>
</head>
<body>

<h1>Ανακοινώσεις</h1>

<div id="container">
    <div id="sidebar">
        <ul>
            <li><a href="index_tutor.php">Αρχική σελίδα</a></li>
            <li><a href="announcement_tutor.php">Ανακοινώσεις</a></li>
            <li><a href="communication_tutor.php">Επικοινωνία</a></li>
            <li><a href="documents_tutor.php">Έγγραφα μαθήματος</a></li>
            <li><a href="homework_tutor.php">Εργασίες</a></li>
            <li><a href="users_tutor.php">Χρήστες</a></li>
            <li><a href="login.php">Αποσύνδεση</a></li>
        </ul>
    </div>

    <div id="main-content">
        <a href="add_announcement.php" class="add-announcement-btn">Προσθήκη νέας ανακοίνωσης</a>
        <br>
        <hr>
        <div class="content">
            <?php
            $sql = "SELECT id, date, subject, main_text FROM announcements ORDER BY date DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div>";
                echo "<div class='announcement-buttons'>";
                echo "<a href='delete_announcement.php?id=" . $row['id'] . "' class='announcement-button'>Διαγραφή</a>";
                echo "<a href='edit_announcement.php?id=" . $row['id'] . "' class='announcement-button'>Επεξεργασία</a>";
                echo "</div>";
                echo "<p><strong>Ανακοίνωση " . $totalAnnouncements . "</strong></p>"; 
                echo "<p><strong>Ημερομηνία:</strong> " . htmlspecialchars($row['date']) . "</p>"; 
                echo "<p><strong>Θέμα:</strong> " . htmlspecialchars($row['subject']) . "</p>";
                echo "<p>" . nl2br(htmlspecialchars($row['main_text'])) . "</p>";
                echo "</div><hr>";
                $totalAnnouncements--; 
            }
            } else {
            echo "Δεν βρέθηκαν ανακοινώσεις";
            }
            ?>

            <br>
            <a href="#top">Επιστροφή στην κορυφή</a>
        </div>
    </div>
</div>

</body>
</html>
