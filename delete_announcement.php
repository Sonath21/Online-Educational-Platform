<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id']; 

    // SQL για τη διαγραφή της ανακοίνωσης
    $sql = "DELETE FROM announcements WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // 'i' δηλώνει ότι ο τύπος της παραμέτρου είναι ακέραιος
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Η ανακοίνωση διαγράφηκε επιτυχώς.";
    } else {
        echo "Σφάλμα κατά τη διαγραφή: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: announcement_tutor.php");
    exit();
}
?>
