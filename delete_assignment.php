<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // SQL για τη διαγραφή της εργασίας
    $sql = "DELETE FROM assignments WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Assignment deleted successfully.";
    } else {
        echo "Error deleting assignment: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "No assignment ID provided.";
}

header("Location: homework_tutor.php");
exit();
?>
