<?php

session_start();

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/database.php";
    
            throw new Exception("Failed to include the database connection file.");
    $user = $result->fetch_assoc();
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
        
        <p>Hi, <?= htmlspecialchars($user["name"]) ?></p>
        
        <div class="button">
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
    
    
    
    
    
    
    
    
    
    
    