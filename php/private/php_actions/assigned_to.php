<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../auth/login.php");
    exit();
}

include '../../connDB.php';

// call simplepushio api 
function sendSimplepushNotification($key, $title, $message) {
    $url = 'https://api.simplepush.io/send';

    $data = array(
        'key' => $key,
        'title' => $title,
        'msg' => $message
    );

    $options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
        ),
    );

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    return $result;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_id = $_POST['task_id'];
    $assigned_to = $_POST['assigned_to'];

    // Fetch the user_id and simplepushio_key based on the username
    $sql_check_user = "SELECT id, simplepushio_key FROM users WHERE username='$assigned_to'";
    $result_check_user = $con->query($sql_check_user);
    if ($result_check_user->num_rows > 0) {
        $user = $result_check_user->fetch_assoc();
        $assigned_to_id = $user['id'];
        $simplepush_key = $user['simplepushio_key']; 

        $sql_assign = "UPDATE tasks SET assigned_to='$assigned_to_id' WHERE id='$task_id'";
        if ($con->query($sql_assign) === TRUE) {
            $_SESSION['success_message'] = "Task assigned successfully.";
            $task_title = "New Task Assigned: ";
            $message = "You have been assigned a new task.";
            sendSimplepushNotification($simplepush_key, $task_title, $message);
        } else {
            $_SESSION['error_message'] = "Error: " . $con->error;
        }
    } else {
        $_SESSION['error_message'] = "User does not exist.";
    }

    $con->close();
    header("Location: ../dashboard.php");
    exit();
}
?>
