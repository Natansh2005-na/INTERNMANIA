<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Post an Internship</h1>
    <form action="../php/post_internship.php" method="POST">
        <label for="title">Internship Title:</label>
        <input type="text" id="title" name="title" required>

        <label for="category">Category:</label>
        <select id="category" name="category" required>
            <option value="AI">AI</option>
            <option value="Data Science">Data Science</option>
            <option value="CAD">CAD</option>
        </select>

        <label for="city">City:</label>
        <input type="text" id="city" name="city" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>

        <button type="submit">Post Internship</button>
    </form>
</body>
</html>
