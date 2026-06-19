<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../auth/login.php");
    exit();
}

include '../../connDB.php';
$username = $_SESSION['username'];

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

// Function SQL to XML tags
function SQLToXML($tasklists, $tasks, $username) {
    $xml = new SimpleXMLElement("<Assignments/>");

    foreach ($tasklists as $tasklist) {
        $tasklistElement = $xml->addChild("Assignment");
        $tasklistElement->addChild("ID", htmlspecialchars($tasklist['id']));
        $tasklistElement->addChild("Title", htmlspecialchars($tasklist['title']));
        $tasklistElement->addChild("UserName", htmlspecialchars($username));

        if (isset($tasks[$tasklist['id']])) {
            foreach ($tasks[$tasklist['id']] as $task) {
                $taskElement = $tasklistElement->addChild("Task");
                $taskElement->addChild("ID", htmlspecialchars($task['id']));
                $taskElement->addChild("Title", htmlspecialchars($task['title']));
                $taskElement->addChild("DateTime", htmlspecialchars($task['date_time']));
                $taskElement->addChild("Status", htmlspecialchars($task['status']));
                $taskElement->addChild("AssignedTo", htmlspecialchars($task['assigned_to_username']));
                $taskElement->addChild("tasklist_id", htmlspecialchars($task['tasklist_id']));
            }
        }
    }

    return $xml->asXML();
}
# if download tasklists is pressed
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['export'] === 'assigned_tasklists') {
    // Get the assignment lists from the database
    $sql_assigned = "SELECT DISTINCT tl.id, tl.title, tl.user_id, u.username as user_name 
                     FROM tasklists tl 
                     JOIN tasks t ON tl.id = t.tasklist_id 
                     JOIN users u ON tl.user_id = u.id
                     WHERE t.assigned_to = '$user_id' 
                     ORDER BY tl.id DESC";
    $result_assigned = $con->query($sql_assigned);

    $tasklists = [];
    $tasklist_ids = [];
    if ($result_assigned->num_rows > 0) {
        while ($row = $result_assigned->fetch_assoc()) {
            $tasklists[] = $row;
            $tasklist_ids[] = $row['id'];
        }
    }

    // Get the assignments tasks from the database
    $tasks = [];
    if (!empty($tasklist_ids)) {
        $tasklist_ids_str = implode(',', $tasklist_ids);
        $sql_tasks = "SELECT t.id, t.title, t.date_time, t.status, u.username AS assigned_to_username, t.tasklist_id
                      FROM tasks t
                      LEFT JOIN users u ON t.assigned_to = u.id
                      WHERE t.tasklist_id IN ($tasklist_ids_str) AND t.assigned_to = '$user_id'
                      ORDER BY t.date_time DESC";
        $result_tasks = $con->query($sql_tasks);

        if ($result_tasks->num_rows > 0) {
            while ($row = $result_tasks->fetch_assoc()) {
                $tasks[$row['tasklist_id']][] = $row;
            }
        }
    }
    

    // SQL -> XML
    $xmlContent = SQLToXML($tasklists, $tasks, $username);

    // set file name
    $fileName = "assignments.xml";

    // Clear the output buffer to avoid any pre-output
    ob_end_clean();

    // download the file
    header('Content-Type: application/xml');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    echo $xmlContent;

    
    exit();
}

$con->close();
?>
