<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./include/styles/navbar-private.css">
    <link rel="stylesheet" href="./styles/theme.css">
    <link rel="stylesheet" href="./styles/profile.css">
    <script src="./include/sweetalert.min.js" defer></script>
     <script src="./include/dark_light_mode.js" defer></script>
     <script src="./include/popup.js" defer></script>
</head>
<body>
    <nav>
        <label class="logo">
            Trello
        </label>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="help.php">Help</a></li>
            <li><a href="dashboard.php">Dashboard &#x25BE</a>
                <ul class="dropdown">
                    <li><a href="dashboard.php">Your Board</a></li>
                    <li><a href="assignments.php">Assignments</a></li>
                </ul>
            </li>
            <li><a href="view_profile.php">Profile</a></li>
            <li><a href="export.php">Export</a></li>
            
        </ul>
    </nav>
    <i class="bi bi-brightness-high-fill" id="dark"></i>
</body>
</html>
