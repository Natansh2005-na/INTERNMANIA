<?php
include 'db_connect.php';
session_start();

if ($_SESSION['role'] != 'faculty') {
    die("Unauthorized access");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $city = $_POST['city'];
    $faculty_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO internships (title, description, category, city, faculty_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $title, $description, $category, $city, $faculty_id);

    if ($stmt->execute()) {
        echo "Internship posted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
