<?php
session_start();
include 'db_connect.php';

// Ensure the user is logged in as a student
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    die("Unauthorized access. Please log in as a student.");
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_SESSION['user_id'];
    $internship_id = $_POST['internship_id'];

    // Prevent SQL injection
    $student_id = $conn->real_escape_string($student_id);
    $internship_id = $conn->real_escape_string($internship_id);

    // Check if the student already applied for this internship
    $check_query = "SELECT * FROM applications WHERE student_id = ? AND internship_id = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("ii", $student_id, $internship_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>
                alert('You have already applied for this internship.');
                window.history.back();
              </script>";
    } else {
        // Insert the application into the database
        $apply_query = "INSERT INTO applications (student_id, internship_id, applied_at) VALUES (?, ?, NOW())";
        $stmt = $conn->prepare($apply_query);
        $stmt->bind_param("ii", $student_id, $internship_id);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Successfully applied for the internship!');
                    window.location.href = '../dashboard/student.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Error occurred while applying. Please try again later.');
                    window.history.back();
                  </script>";
        }
    }

    $stmt->close();
}

$conn->close();
?>
