<?php
session_start();

// Ελέγχουμε εάν ο χρήστης είναι συνδεδεμένος
if (!isset($_SESSION['username'])) {
    header("Location: ../../auth/login.php");
    exit;
}

include '../../connDB.php';

$username = $_SESSION['username'];
// Fetch user_id based on the username
$sql_user = "SELECT id FROM users WHERE username = '$username'";
$result_user = $con->query($sql_user);
if ($result_user->num_rows == 1) {
    $row_user = $result_user->fetch_assoc();
    $user_id = $row_user['id'];
} else {
    // Handle the case where the user is not found
    echo "User not found.";
    exit();
}

// random set name-surname-email-username to random strings when pressed delete
function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}
$random_name = generateRandomString(10);
$random_surname = generateRandomString(10);
$random_email = generateRandomString(5) . '@example.com';
$random_username = 'user_' . generateRandomString(5);

$sql_update_user = "UPDATE users SET name='$random_name', surname='$random_surname', email='$random_email', password = '$random_password', username = '$random_username' WHERE id='$user_id'";

if (mysqli_query($con, $sql_update_user)) {
    // Αποσύνδεση του χρήστη
    unset($_SESSION['username']);
    session_destroy();
    header("Location: ../index.php");
    exit;
} else {
    echo "Edit profile error: " . mysqli_error($con);
}

mysqli_close($con);
?>