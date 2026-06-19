<?php
session_start();

include '../connDB.php';

// Initialize variables
if (!isset($_SESSION['error_msg'])) {
    $_SESSION['error_msg'] = "";
}
if (!isset($_SESSION['insert_username'])) {
    $_SESSION['insert_username'] = "";
}
if (!isset($_SESSION['insert_password'])) {
    $_SESSION['insert_password'] = "";
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(empty($username) || empty($password)) {
        $_SESSION['error_msg'] = "";
        if (empty($username)) {
            $_SESSION['insert_username'] = "<div class='insert'>Please enter your username</div>";
        }
        if (empty($password)) {
            $_SESSION['insert_password'] = "<div class='insert'>Please enter your password</div>";
        }
    } else {
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_array($result);
        $count = mysqli_num_rows($result);
        
        if($count == 1) {
            $_SESSION['username'] = $username;
            header("Location: /private/index.php");
        } else {
              $_SESSION['insert_username'] = "";
            $_SESSION['insert_password'] = "";
            $_SESSION['error_msg'] = "<div class='wrong_pass'>wrong username or password.</div>";
        
        }
    }
}
mysqli_close($con);

?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Trello</title>
    <link rel="icon" href="https://bxp-content-static.prod.public.atl-paas.net/img/favicon.ico">
    <link rel="stylesheet" href="./styles/login.css">
</head>
<body>
    <div class="login-container">
        <h2>Σύνδεση</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username"><br><br>
            <?php echo $_SESSION['insert_username']; ?>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password"><br><br>
            <?php echo $_SESSION['insert_password']; ?>
            <?php echo $_SESSION['error_msg']; ?>
            <input type="submit" value="Σύνδεση">
        </form>
    </div>
    <?php
    // Clear the session variables after displaying the messages
    $_SESSION['error_msg'] = "";
    $_SESSION['insert_username'] = "";
    $_SESSION['insert_password'] = "";
    ?>
    <a href="../index.php" id="goback">back</a>
</body> 
</html>