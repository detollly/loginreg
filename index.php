<?php

// Start the session
session_start();

try {
    // Check if the user is logged in
    if (isset($_SESSION["user_id"])) {
        
        // Include the database connection file
        $mysqli = require __DIR__ . "/database.php";
        
        if (!$mysqli) {
            throw new Exception("Failed to include the database connection file.");
        }

        // Use prepared statements to prevent SQL injection
        $userId = $_SESSION["user_id"];
        $sql = "SELECT * FROM user WHERE id = ?";
        
        // Prepare and execute the statement
        $stmt = $mysqli->prepare($sql);

        if (!$stmt) {
            throw new Exception("Failed to prepare the SQL statement.");
        }

        $stmt->bind_param("i", $userId);
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        if (!$result) {
            throw new Exception("Failed to get the result set.");
        }

        // Fetch the user data
        $user = $result->fetch_assoc();
    }
} catch (Exception $e) {
    // Handle exceptions
    // You may log the error, redirect the user to an error page, or display a user-friendly message.
    echo "An error occurred: " . $e->getMessage();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./public/css/style.css">
    <link rel="stylesheet" href="./public/css/form.css">
</head>
<body>
    
    <div class="box">
    <h1>You have been logged out</h1>
    
    <?php if (isset($user)): ?>
        
        <!-- Display user information -->
        <p>Hi, <?= htmlspecialchars($user["name"]) ?></p>
        
        <div class="button">
            <!-- Add CSRF token for security -->
            <a class="btn" href="logout.php">Logout</a>
        </div>
        
    <?php else: ?>
        
        <div class="button">
            <a class="btn" href="login.php">Login</a>
        </div>
        
    <?php endif; ?>

    </div>
    
</body>
</html>
