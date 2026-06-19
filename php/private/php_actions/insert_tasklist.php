<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../auth/login.php");
    exit();
}

include '../../connDB.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $title = trim($_POST['title']); // Trim whitespace from the input

    // Check if the title is empty
    if (empty($title)) {
        // Redirect back to the dashboard with an error message
        $_SESSION['error_message_tasklist'] = "Task list name cannot be empty.";
        header("Location: ../dashboard.php");
        exit();
    }

    // Fetch the user_id based on the username
    $sql_user = "SELECT id FROM users WHERE username = '$username'";
    $result_user = $con->query($sql_user);
    if ($result_user->num_rows == 1) {
        $row_user = $result_user->fetch_assoc();
        $user_id = $row_user['id'];
    } else {
        // Handle the case where the user is not found
        $_SESSION['error_message_tasklist'] = "User not found.";
        header("Location: ../dashboard.php");
        exit();
    }

    $sql = "INSERT INTO tasklists (title, user_id) VALUES ('$title', '$user_id')";

    if ($con->query($sql) === TRUE) {
        header("Location: ../dashboard.php");
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $con->close();
}
?>
