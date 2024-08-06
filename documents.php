<?php global $conn;
include 'db_connection.php'; ?>
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

<h1>Έγγραφα μαθήματος</h1>

<div id="container">
    <div id="sidebar">
        <ul>
            <li><a href="index.php">Αρχική σελίδα</a></li>
            <li><a href="announcement.php">Ανακοινώσεις</a></li>
            <li><a href="communication.php">Επικοινωνία</a></li>
            <li><a href="documents.php">Έγγραφα μαθήματος</a></li>
            <li><a href="homework.php">Εργασίες</a></li>
            <li><a href="login.php">Αποσύνδεση</a></li>
        </ul>
    </div>

    <div id="main-content">
        <div class="content">          
            <?php
            $sql = "SELECT id, title, description, file_name FROM documents ORDER BY id DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div>";
                    echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
                    echo "<p><strong>Περιγραφή:</strong> " . nl2br(htmlspecialchars($row['description'])) . "</p>";
                    echo "<a href='" . htmlspecialchars($row['file_name']) . "' target='_blank'>Download</a>";
                    echo "</div><hr>";
                }
            } else {
                echo "Δεν βρέθηκαν έγγραφα";
            }
            ?>
            <br>
            <a href="#top">Επιστροφή στην κορυφή</a>
        </div>
    </div>
</div>

</body>
</html>

