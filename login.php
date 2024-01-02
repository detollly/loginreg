<?php

$is_invalid = false;


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // the database connection file

    $mysqli = require __DIR__ . "/database.php";

    $sql = sprintf("SELECT * FROM user
                   WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($_POST["password"], $user["password_hash"])) {

            session_start();

            session_regenerate_id();

            $_SESSION["user_id"] = $user["id"];

            header("Location: public/index.html");
            exit;
        }
    }

    $is_invalid = true;

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

<?php if ($is_invalid): ?>
    <em>Invalid login</em>
<?php endif; ?>


<form method="post">
    <label for="email">email</label>
    <input type="email" name="email" id="email"
            value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">

    <label for="password">password</label>
    <input type="password" name="password" id="password">

    <h3>Don't have an account? <a href="./public/signup.html">Sign up</a></h3> 

    <button>Log in</button>
</form>
    </div>

</body>
</html>