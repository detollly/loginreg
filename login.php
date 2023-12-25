<?php

$isInvalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Include the database connection file
    $mysqli = require __DIR__ . "/database.php";

    // Validate and sanitize user input
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = $_POST["password"];

    if (!$email || !$password) {
        $isInvalid = true; // Invalid input
    } else {
        // Use prepared statement to prevent SQL injection
        $sql = "SELECT id, email, password_hash FROM user WHERE email = ?";
        $stmt = $mysqli->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();

            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($user && password_verify($password, $user["password_hash"])) {
                // Start a secure session
                session_start();
                session_regenerate_id();

                $_SESSION["user_id"] = $user["id"];

                header("Location: public/index.html");
                exit;
            } else {
                $isInvalid = true; // Invalid login credentials
            }

            $stmt->close();
        } else {
            die("Error preparing statement: " . $mysqli->error);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./public/css/style.css">
    <link rel="stylesheet" href="./public/css/form.css">
</head>
<body>
    <div class="box">
        <h2>Login</h2>

        <?php if ($isInvalid): ?>
            <em>Invalid login</em>
        <?php endif; ?>

        <form method="post">
            <label for="email">Email</label>
            <input type="email" name="email" id="email"
                    value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <h3>Don't have an account? <a href="./public/signup.html">Sign up</a></h3> 

            <button type="submit">Log in</button>
        </form>
    </div>
</body>
</html>
