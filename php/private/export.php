
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export SQL to XML</title>
    <link rel="stylesheet" href="./styles/export.css">
</head>
<body>
    <?php include './include/navbar.php'?>
    <div>
        <h1>Export tasklists:</h1></br>
    </div>
    <div>
        <form method="post" action="./php_actions/exportXML_tasklists.php">
            <button type="submit" name="export" value="tasklists_tasks">Download tasklists.xml</button>
        </form>
    </div>
    <div>
        <h1>Export assignments:</h1></br>
    </div>
    <div>
        <form method="post" action="./php_actions/exportXML_assignments.php">
            <button type="submit" name="export" value="assigned_tasklists">Download assignments.xml</button>
        </form>
    </div>
    <?php include './include/footer.php';?>
</body>
</html>