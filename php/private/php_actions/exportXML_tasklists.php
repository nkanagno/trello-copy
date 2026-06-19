<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../auth/login.php");
    exit();
}

include '../../connDB.php';
$username = $_SESSION['username'];

// Assuming user_id is stored in session or retrieve it from the database
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

function SQLToXML($tasklists, $tasks, $username) {
    $xml = new SimpleXMLElement("<Tasklists/>");

    // Array of Tasklists to XML tags
    foreach ($tasklists as $tasklist) {
        $tasklistElement = $xml->addChild("Tasklist");
        $tasklistElement->addChild("ID", htmlspecialchars($tasklist['id']));
        $tasklistElement->addChild("Title", htmlspecialchars($tasklist['title']));
        $tasklistElement->addChild("UserName", htmlspecialchars($username));

        // Array of Tasks to XML tags
        if (isset($tasks[$tasklist['id']])) {
            foreach ($tasks[$tasklist['id']] as $task) {
                $taskElement = $tasklistElement->addChild("Task");
                $taskElement->addChild("ID", htmlspecialchars($task['id']));
                $taskElement->addChild("Title", htmlspecialchars($task['title']));
                $taskElement->addChild("DateTime", htmlspecialchars($task['date_time']));
                $taskElement->addChild("Status", $task['status']);
                $taskElement->addChild("AssignedTo", htmlspecialchars($task['assigned_to_username']));
                $taskElement->addChild("tasklist_id", htmlspecialchars($task['tasklist_id']));
            }
        }
    }

    return $xml->asXML();
}

# if download tasklists is pressed
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['export'] === 'tasklists_tasks') {
    // Get the tasklists from the database
    $sql_1 = "SELECT * FROM tasklists WHERE user_id = '$user_id' ORDER BY id DESC";
    $result_1 = $con->query($sql_1);

    $tasklists = [];
    $tasklist_ids = [];
    if ($result_1->num_rows > 0) {
        while ($row = $result_1->fetch_assoc()) {
            $tasklists[] = $row;
            $tasklist_ids[] = $row['id'];
        }
    } else {
        echo "No tasklists found for user_id: $user_id";
    }

    // Get the tasks from the database
    $tasks = [];
    if (!empty($tasklist_ids)) {
        $tasklist_ids_str = implode(',', $tasklist_ids);
        $sql_2 = "SELECT t.id, t.title, t.date_time, t.status, u.username AS assigned_to_username, t.tasklist_id
                  FROM tasks t
                  LEFT JOIN users u ON t.assigned_to = u.id
                  WHERE t.tasklist_id IN ($tasklist_ids_str)
                  ORDER BY t.date_time DESC";
        $result_2 = $con->query($sql_2);

        if ($result_2->num_rows > 0) {
            while ($row_2 = $result_2->fetch_assoc()) {
                $tasks[$row_2['tasklist_id']][] = $row_2;
            }
        } else {
            echo "No tasks found for tasklist_ids: $tasklist_ids_str";
        }
    }

    $xmlContent = SQLToXML($tasklists, $tasks, $username); // Pass $username as a parameter
    $fileName = "tasklists.xml";

    // Clear the output buffer to avoid any pre-output
    ob_end_clean();

    header('Content-Type: application/xml');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    echo $xmlContent;

    // Ensure no further output is sent
    exit();
}

$con->close();
?>
