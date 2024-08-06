<?php include 'db_connection.php'; ?>
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

<h1>Αρχική Σελίδα</h1>

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
        <h2>Καλώς Ήρθατε στην Εκπαιδευτική Μας Πλατφόρμα</h2>
        <p>Η πλατφόρμα μας είναι σχεδιασμένη για να παρέχει μια ευέλικτη και διαισθητική εμπειρία εκπαίδευσης, ιδανική τόσο για διδάσκοντες όσο και για μαθητές.</p>
        
        <h2>Χαρακτηριστικά της Πλατφόρμας:</h2>
        <ul>
            <li><strong>Ανακοινώσεις:</strong> Μένετε ενημερωμένοι με τις τελευταίες ανακοινώσεις και ενημερώσεις του μαθήματος.</li>
            <li><strong>Έγγραφα Μαθήματος:</strong> Πρόσβαση σε όλα τα απαραίτητα έγγραφα, σημειώσεις και εκπαιδευτικό υλικό.</li>
            <li><strong>Εργασίες:</strong> Διαχείριση και υποβολή εργασιών, με λεπτομερείς οδηγίες και προθεσμίες.</li>
            <li><strong>Επικοινωνία:</strong> Διευκολύνει την άμεση επικοινωνία μεταξύ διδασκόντων και μαθητών.</li>
            <li><strong>Διαχείριση Χρηστών:</strong> Ευέλικτη διαχείριση προφίλ για όλους τους χρήστες της πλατφόρμας.</li>
        </ul>

        <p>Η πλατφόρμα μας δεσμεύεται να παρέχει ένα περιβάλλον μάθησης που ενθαρρύνει την ανάπτυξη και την αλληλεπίδραση. Είμαστε περήφανοι για την δημιουργία ενός χώρου που ενισχύει την εκπαίδευση και την ανάπτυξη των δεξιοτήτων μέσω της στενής συνεργασίας με τους εκπαιδευτικούς μας.</p>
        <p>Ελπίζουμε να απολαύσετε την εμπειρία μάθησης στην πλατφόρμα μας!</p>
        <img src="maxresdefault.jpg" alt="Description of the image" style="display: block; margin-left: auto; margin-right: auto;">

            

        </div>
    </div>
</div>

</body>
</html>
