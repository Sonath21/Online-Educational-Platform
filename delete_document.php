<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // SQL για τη διαγραφή του εγγράφου
    $sql = "DELETE FROM documents WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Document deleted successfully.";
        header("Location: documents_tutor.php");
        exit();
    } else {
        echo "Error deleting document: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
