<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST["id"]);
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $number = trim($_POST["number"]);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address.");
    }

    // Validate number
    if (!preg_match("/^\d{11}$/", $number)) {
        die("Phone number must be exactly 11 digits.");
    }

    if (!empty($id) && !empty($name) && !empty($email) && !empty($number)) {
        $stmt = $conn->prepare("UPDATE users SET name=?, email=?, number=? WHERE id=?");
        $stmt->bind_param("sssi", $name, $email, $number, $id);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: index.php");
    exit();
}
?>
