<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../auth/login.php");
    exit();
}

include '../../connDB.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = $_POST['task_id'];
    
    // delete task
    $sql = "DELETE FROM tasks WHERE id='$task_id'";

    if ($con->query($sql) === TRUE) {
        header("Location: ../dashboard.php");
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $con->close();
}
?>
