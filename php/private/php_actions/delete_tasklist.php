<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../auth/login.php");
    exit();
}

include '../../connDB.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tasklist_id = $_POST['tasklist_id'];

    // Delete all tasks from this tasklist 
    $sql_tasks = "DELETE FROM tasks WHERE tasklist_id='$tasklist_id'";
    if ($con->query($sql_tasks) === TRUE) {
        // Then delete the tasklist
        $sql_tasklist = "DELETE FROM tasklists WHERE id='$tasklist_id'";
        if ($con->query($sql_tasklist) === TRUE) {
            header("Location: ../dashboard.php");
        } else {
            echo "Error deleting tasklist: " . $con->error;
        }
    } else {
        echo "Error deleting tasks: " . $con->error;
    }

    $con->close();
}
?>
