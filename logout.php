<?php

session_start();

try {
    // Validate session data
    if (!isset($_SESSION["user_id"]) || !is_numeric($_SESSION["user_id"])) {
        throw new Exception("Invalid session data.");
    }

    // Clear all session variables
    $_SESSION = [];

    // Destroy the session
    session_destroy();

    // Ensure that the session is completely closed
    session_regenerate_id(true);

    // Redirect to the login page
    header("Location: login.php");
    exit;
} catch (Exception $e) {
    // Handle exceptions
    // Log the error or redirect to an error page as needed
    die("An error occurred: " . $e->getMessage());
}
