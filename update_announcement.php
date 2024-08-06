<?php
global $conn;
include 'db_connection.php';
session_start();

// Ελέγξτε αν ο χρήστης έχει συνδεθεί και είναι καθηγητής
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'Tutor') {
    header("location: login.php");
    exit;
}

// Έλεγχος ύπαρξης της παραμέτρου id πριν από την περαιτέρω επεξεργασία
if(isset($_POST["id"]) && !empty($_POST["id"])){

    $id = $_POST["id"];

    // Επικύρωση εισόδου
    $date = trim($_POST["date"]);
    $subject = trim($_POST["subject"]);
    $main_text = trim($_POST["main_text"]);

    $sql = "UPDATE announcements SET date=?, subject=?, main_text=? WHERE id=?";

    if($stmt = $conn->prepare($sql)){
        $stmt->bind_param("sssi", $param_date, $param_subject, $param_main_text, $param_id);

        $param_date = $date;
        $param_subject = $subject;
        $param_main_text = $main_text;
        $param_id = $id;

        if($stmt->execute()){
            // Οι εγγραφές ενημερώθηκαν επιτυχώς. Ανακατεύθυνση στη σελίδα προορισμού
            header("location: announcement_tutor.php");
            exit();
        } else{
            echo "Something went wrong. Please try again later.";
        }
    }

    $stmt->close();

    $conn->close();
} else{
    if(empty(trim($_GET["id"]))){
        // Η διεύθυνση URL δεν περιέχει την παράμετρο id. Ανακατεύθυνση σε σελίδα σφάλματος
        header("location: error.php");
        exit();
    }
}
?>
