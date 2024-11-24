<?php
session_start();
include '../php/db_connect.php';

// Check if the user is logged in as a student
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    die("Unauthorized access. Please log in as a student.");
}

// Fetch available internships
$query = "SELECT * FROM internships";
$result = $conn->query($query);
$internships = $result->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Welcome, Student!</h1>
            <nav>
                <ul>
                    <li><a href="student.php">Dashboard</a></li>
                    <li><a href="../php/logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section class="filter">
            <h2>Find Your Internship</h2>
            <form method="GET" action="student.php">
                <label for="category">Category:</label>
                <select name="category" id="category">
                    <option value="">All Categories</option>
                    <option value="AI">AI</option>
                    <option value="Data Science">Data Science</option>
                    <option value="CAD">CAD</option>
                </select>

                <label for="city">City:</label>
                <input type="text" name="city" id="city" placeholder="Enter city">

                <button type="submit">Search</button>
            </form>
        </section>

        <section class="internships">
            <h2>Available Internships</h2>
            <?php
            // Apply filters if any
            $category_filter = isset($_GET['category']) ? $_GET['category'] : '';
            $city_filter = isset($_GET['city']) ? $_GET['city'] : '';

            $sql = "SELECT * FROM internships WHERE 1=1";
            if (!empty($category_filter)) {
                $sql .= " AND category = '$category_filter'";
            }
            if (!empty($city_filter)) {
                $sql .= " AND city LIKE '%$city_filter%'";
            }

            $filtered_result = $conn->query($sql);

            if ($filtered_result->num_rows > 0) {
                while ($internship = $filtered_result->fetch_assoc()) {
                    echo "<div class='internship'>
                            <h3>{$internship['title']}</h3>
                            <p><strong>Category:</strong> {$internship['category']}</p>
                            <p><strong>City:</strong> {$internship['city']}</p>
                            <p>{$internship['description']}</p>
                            <form action='../php/apply_internship.php' method='POST'>
                                <input type='hidden' name='internship_id' value='{$internship['id']}'>
                                <button type='submit'>Apply</button>
                            </form>
                        </div>";
                }
            } else {
                echo "<p>No internships found matching your criteria.</p>";
            }
            ?>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 InternMaina. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
