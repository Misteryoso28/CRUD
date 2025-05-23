<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $id = $_POST["id"];

    // Optional: Validate $id is numeric
    if (is_numeric($id)) {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: index.php");
    exit();
} else {
    // If accessed directly or without ID, redirect
    header("Location: index.php");
    exit();
}
