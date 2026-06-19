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
    <link rel="stylesheet" href="./styles/your-board.css">
    <link rel="stylesheet" href="./styles/dashboard-theme.css">
    <script src="./scripts/search.js" defer></script>
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body>
    <ul class="header">
        <li>
            <h2>Search tasklist:</h2>
            <input type="text" placeholder="Search task lists..." class="search-tasklist" onkeyup="filterTaskLists()" style="margin-bottom: 20px;">
        </li>
        <li>
            <!-- Form to add a new task list -->
            <h2>Create a new tasklist:</h2>
            <form action="./php_actions/insert_tasklist.php" method="POST" style="margin-bottom: 20px;">
                <input type="text" name="title" placeholder="Enter new task list name" class="add-task-list" required>
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <button class="add_tasklist" type="submit">Add Task List</button>
            
            <!-- Display error messages if any -->
            <?php
            if (isset($_SESSION['error_message'])) {
                echo "<p style='color: red;'>" . $_SESSION['error_message'] . "</p>";
                unset($_SESSION['error_message']); // Clear the error message after displaying it
            }
            
            if (isset($_SESSION['error_message_task'])) {
                echo "<p style='color: red;text-align:center;font-size:1em;'>" . $_SESSION['error_message_task'] . "</p>";
                unset($_SESSION['error_message_task']); // Clear the error message after displaying it
            }

            if (isset($_SESSION['success_message'])) {
                echo "<p style='color: green;'>" . $_SESSION['success_message'] . "</p>";
                unset($_SESSION['success_message']); // Clear the error message after displaying it
            }
            ?>
            </form>
        </li>
    </ul>
    <?php
        $count_tasklists = 0;
        $sql_1 = "SELECT * FROM tasklists WHERE user_id = '$user_id' ORDER BY id DESC";
        $result_1 = $con->query($sql_1);
        echo "<h1>Tasklists:</h1><br>";
        echo "<div class='tasklist-container' id='tasklist-container'>";
        if ($result_1->num_rows > 0) {
            echo "<div class='tasklist'>";
            $count = 0;
            while ($row = $result_1->fetch_assoc()) {
                $tasklist_id = $row["id"];
                echo    "<div class='tasklist-item' data-title='" . strtolower($row["title"]) . "'>";
                echo    " <div class='tasklist-title'>" . $row["title"] ."</div>" . 
                            "<form action='./php_actions/delete_tasklist.php' method='POST' style='display:inline-block; margin-bottom: 0px;float:right;'>
                                <input type='hidden' name='tasklist_id' value='" . $tasklist_id . "'>
                                <button type='submit' class='delete-button-tasklist'>x</button>
                            </form>";
                echo "<div><input type='text' placeholder='Search tasks...' class='search-task' id='search-task-$tasklist_id' onkeyup='filterTasks($tasklist_id)'></div>";
                echo "<select id='task-status-$tasklist_id' onchange='filterTasks($tasklist_id)'>";
                echo "<option value=''>All statuses</option>";
                echo "<option value='σε αναμονή'>σε αναμονή</option>";
                echo "<option value='σε εξέλιξη'>σε εξέλιξη</option>";
                echo "<option value='ολοκληρωμένη'>ολοκληρωμένη</option>";
                echo "</select>";

                
                echo "<div class='task-container' id='task-container-$tasklist_id'>";
                    $sql_2 = "SELECT t.id, t.title, t.date_time, t.status, u.username AS assigned_to_username, t.tasklist_id
                              FROM tasks t
                              LEFT JOIN users u ON t.assigned_to = u.id
                              WHERE t.tasklist_id = '$tasklist_id'
                              ORDER BY t.date_time DESC";
                    $result_2 = $con->query($sql_2);
                    if ($result_2->num_rows > 0) {
                        while ($row_2 = $result_2->fetch_assoc()) {
                            echo "<div class='task'>" . 
                            "<div class='task-title'><h3>" . 
                                $row_2["title"] . 
                            "</h3><div><button class='info_button' onclick='info(". $count .")'>&#x25BE</button></div></div>" . 
                            "<div class='info' style='display: none;'>
                            <div class='date_time'><div>Datetime created:</div>" . 
                                $row_2["date_time"] . 
                            "</div>" . 
                            "<div class='status'><div>Current status:</div>" . 
                                $row_2["status"] . 
                            "</div>";
                            
                            echo "<div class='status'><div>Assigned to:</div>" . 
                                $row_2["assigned_to_username"] . 
                            "</div>";
                            
                            echo "<form class ='assign-to' action='./php_actions/assigned_to.php' method='POST' style='display:inline-block; margin-top: 10px;'>
                                <input type='hidden' name='task_id' value='" . $row_2["id"] . "'>
                                <h4>Assign task to:</h4>
                                <input type='text' name='assigned_to' placeholder='write a username...' class='assigned_to-searchbar' required>
                                <button type='submit'>Assign</button>
                             </form></div>" .

                            "
                            <form action='./php_actions/delete_task.php' method='POST' style='display:inline-block;'>
                                <input type='hidden' name='task_id' value='" . $row_2["id"] . "'>
                                <button type='submit' class='delete-button'>x</button>
                             </form></div>";
                            
                            $count++;
                        }
                    }
                echo "<div id='results-$tasklist_id' style='display: none;color:red;font-size:20px;'>0 search results</div>";
                echo "<div class='add-task-container'>";
                echo "<form action='./php_actions/insert_task.php' method='POST'>";
                echo "<input type='hidden' name='tasklist_id' value='" . $tasklist_id . "'>";
                echo "<h3>Add a new task:</h3>" ;
                echo "<input type='text' name='title' placeholder='Add a new task...' class='add-task-bar'>";
                echo "<span>";
                echo "<label>State: </label>";
                echo "<select name='status'>";
                    echo "<option value='σε αναμονή'>σε αναμονή</option>";
                    echo "<option value='σε εξέλιξη'>σε εξέλιξη</option>";
                    echo "<option value='ολοκληρωμένη'>ολοκληρωμένη</option>";
                echo "</select>";
                 echo "</span>";
                echo "<button class='add_task' type='submit'>+</button>";
                echo "</form>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            $count_tasklists++;
            echo "<div class='center'>";
            echo "<div id='results' style='display: none;color:red;font-size:20px;'>no search results</div>";
            echo "</div>";
            echo "</div>";
        } else {
            echo "You have 0 Tasklists";
        }
        echo "<div class='results' style='display: none;color:red;font-size:20px;'>no search results</div>";
        echo "</div>";
    include './include/footer.php';
    ?>

</body>
</html>
