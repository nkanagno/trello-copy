<?php
include '../connDB.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $username_input = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $simplepush_key = $_POST["simplepush_key"];

    // Use prepared statements to prevent SQL injection
    $stmt = $con->prepare("INSERT INTO users (name, surname, username, password, email, simplepushio_key) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $surname, $username_input, $password, $email, $simplepush_key);

    // Execute the query and check for errors
    if ($stmt->execute()) {
        header("Location: login.php");
        exit;
    } else {
        if ($stmt->errno == 1062) { // Duplicate entry error
            if (strpos($stmt->error, 'username') !== false) {
                echo "<div class='err_msg' style='display:inline;'>username already taken</div>";
            } elseif (strpos($stmt->error, 'email') !== false) {
                echo "<div class='err_msg' style='display:inline;'>email already taken</div>";
            } elseif (strpos($stmt->error, 'simplepushio_key') !== false) {
                echo "<div class='err_msg' style='display:inline;'>Simplepush.io key already taken</div>";
            }
        } else {
            echo "<div class='err_msg'>Data insertion error: " . $stmt->error . "</div>";
        }
    }

    $stmt->close();
    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="el">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up | Trello</title>
    <link rel="icon" href="https://bxp-content-static.prod.public.atl-paas.net/img/favicon.ico">
    <link rel="stylesheet" href="./styles/signup.css">
    <script src="./auth.js"></script>
</head>

<body>
    <div class="signup-container">
        <h2>Sign up</h2>
        <form action="signup.php" method="post">
            <div class="signup-row">
                <label for="name">First name:</label>
                <label for="surname">Last name:</label>
            </div>
            <div class="signup-row">
                <input type="text" id="name" name="name" required>
                <input type="text" id="surname" name="surname" required>
            </div>
            <div class="signup-row">
                <label for="username">Username:</label>
                <label for="password">Password:</label>
            </div>
            <div class="signup-row">
                <input type="text" id="username" name="username" required>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="signup-row">
                <label for="email">Email:</label>
                <label for="simplepush_key">Simplepush.io Key:</label>
            </div>
            <div class="signup-row">
                <input type="email" id="email" name="email" required>
                <input type="text" id="simplepush_key" name="simplepush_key">
            </div>
            <label style="width: 100%; text-align: center;">
                <input type="checkbox" name="terms" required> Accept the terms & conditions
            </label><br><br>
            <input type="submit" value="Sign_up">
        </form>
        <a href="../index.php" id="goback">back</a>
    </div>
</body>

</html>
