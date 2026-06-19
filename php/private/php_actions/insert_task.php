<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../auth/login.php");
    exit();
}

include '../../connDB.php';

// use simplepush.io Api
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

    if ($result === FALSE) {
        die('Error sending notification');
    }

    return $result;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // get task new data
    $username = $_SESSION['username'];
    $tasklist_id = $_POST['tasklist_id'];
    $title = $_POST['title'];
    $date_time = date('Y-m-d H:i:s');
    $status = $_POST['status'];

    // get user id
   $sql_user = "SELECT id FROM users WHERE username = '$username'";
   $result_user = $con->query($sql_user);
   if ($result_user->num_rows == 1) {
    $row_user = $result_user->fetch_assoc();
    $user_id = $row_user['id'];
   } else {
    echo "User not found.";
    exit();
   }

   // check for empty task name
    if (empty($title) || $title == null) {
        $_SESSION['error_message_task'] = "Task name cannot be empty.";
        header("Location: ../dashboard.php");
        exit();
    }

    // get users simplepush io key
    $sql_key = "SELECT simplepushio_key FROM users WHERE username = '$username'";
    $result_key = $con->query($sql_key);
    if ($result_key->num_rows > 0) {
        $row = $result_key->fetch_assoc();
        $key = $row["simplepushio_key"];
    } else {
        die('Simplepush key not found for user: ' . $username);
    }
    
    // insert new task data
    $sql = "INSERT INTO tasks (title, date_time, status, assigned_to, tasklist_id) 
            VALUES ('$title', '$date_time', '$status', '$user_id', '$tasklist_id')";

    // sent create task notification
    if ($con->query($sql) === TRUE) {
        sendSimplepushNotification($key, 'Νέα Εργασία', 'Δημιουργήσατε την εργασία: ' . $title);
        header("Location: ../dashboard.php");
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $con->close();
}
?>
