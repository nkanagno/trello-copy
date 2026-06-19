<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../auth/login.php");
    exit();
}

include './include/navbar.php';
include '../connDB.php';
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasklists & Tasks</title>

    <link rel="stylesheet" href="./styles/assignments.css">
    <link rel="stylesheet" href="./styles/dashboard-theme.css">
    <script src="./scripts/search.js" defer></script>
    
</head>
<body>
    <ul class="header">
        <li>
            <h2>Search Assignment:</h2>
            <input type="text" placeholder="Search task lists..." class="search-tasklist" onkeyup="filterAssignments()" style="margin-bottom: 20px;">
        </li>
        <li>
            <!-- Display error messages if any -->
            <?php
            if (isset($_SESSION['error_message'])) {
                echo "<p style='color: red;'>" . $_SESSION['error_message'] . "</p>";
                unset($_SESSION['error_message']); // Clear the error message after displaying it
            }
            ?>
        </li>
    </ul>
    <h1>Assigned Tasklists:</h1>
    <?php
        $count_tasklists = 0;
        $sql_assigned = "SELECT DISTINCT tl.id, tl.title, tl.user_id, u.username as user_name 
                         FROM tasklists tl 
                         JOIN tasks t ON tl.id = t.tasklist_id 
                         JOIN users u ON tl.user_id = u.id
                         WHERE t.assigned_to = '$user_id' 
                         ORDER BY tl.id DESC";
        $result_assigned = $con->query($sql_assigned);
        echo "<div class='tasklist-container' id='assigned-tasklist-container'>";
        if ($result_assigned->num_rows > 0) {
            echo "<div class='tasklist'>";
            $count = 0;
            while ($row = $result_assigned->fetch_assoc()) {
                $tasklist_id = $row["id"];
                echo "<div class='tasklist-item' data-title='" . strtolower($row["title"]) . "'>";
                echo "<div class='tasklist-title'>" . $row["title"] . " (Created by: " . $row["user_name"] . ")</div>";
                echo "<div><input type='text' placeholder='Search tasks...' class='search-task' id='search-task-$tasklist_id' onkeyup='filterTasks($tasklist_id)'></div>";
                echo "<select id='task-status-$tasklist_id' onchange='filterTasks($tasklist_id)'>";
                echo "<option value=''>All statuses</option>";
                echo "<option value='σε αναμονή'>σε αναμονή</option>";
                echo "<option value='σε εξέλιξη'>σε εξέλιξη</option>";
                echo "<option value='ολοκληρωμένη'>ολοκληρωμένη</option>";
                echo "</select>";
                echo "<div class='task-container' id='task-container-$tasklist_id'>";
                    $sql_assigned_tasks = "SELECT * FROM tasks WHERE tasklist_id = '$tasklist_id' AND assigned_to = '$user_id'";
                    $result_assigned_tasks = $con->query($sql_assigned_tasks);
                    if ($result_assigned_tasks->num_rows > 0) {
                        while ($row_2 = $result_assigned_tasks->fetch_assoc()) {
                            echo "<div class='task'>" . 
                            "<div class='task-title'>" . $row_2["title"] . "</div>" . 
                            "<div><button class='info_button' onclick='info(". $count .")'>&#x25BE</button></div>" . 
                            "<div class='info' style='display: none;'>
                            <div class='date_time'><div>Datetime created:</div>" . $row_2["date_time"] . "</div>" . 
                            "<div class='status'><div>Current status:</div>" . $row_2["status"] . "</div></div>" .
                            "</div>";
                            $count++;
                        }
                    } else {
                        echo "<p>No tasks assigned to you in this list.</p>";
                    }
                echo "<div id='results-$tasklist_id' style='display: none;color:red;font-size:20px;'>0 search results</div>";
                echo "</div>";
                echo "</div>";
            $count_tasklists++;
            }
            echo "<div class='center'>";
            echo "<div id='results' style='display: none;color:red;font-size:20px;'>no search results</div>";
            echo "</div>";
            echo "</div>";
        } else {
            echo "You have 0 Assignment lists";
        }
        echo "</div>";
    include './include/footer.php';
    ?>
</body>
</html>
