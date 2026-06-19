<?php
session_start();
// Ελέγχουμε εάν ο χρήστης είναι συνδεδεμένος
if (!isset($_SESSION['username'])) {
    // Αν δεν είναι συνδεδεμένος, τον ανακατευθύνουμε στη σελίδα σύνδεσης
    header("Location: ../auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Πλατφόρμα Διαχείρισης Λιστών Εργασιών</title>
    <link rel="stylesheet" href="./styles/theme.css">
    <link rel="stylesheet" href="./styles/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


</head>

<body>
    <?php include './include/navbar.php'?>
    <header>
        <?php

        if(isset($_SESSION['username'])) {
            echo "<h1>Καλώς ήρθες, <span>" . $_SESSION['username'] . "</span>!</h1>";
        } else {
            echo '';
        }

        ?>
        <div class="i">
        <p>Αυτή η πλατφόρμα, σας επιτρέπει να διαχειρίζεστε προσωπικές και ομαδικές λίστες εργασιών.
        Κύριος στόχος, είναι να σας βοηθήσει να οργανώνετε 
        τις εργασίες σας με μια απλή και αποτελεσματική διαχείριση λιστών εργασιών.</p>
        <a href="dashboard.php">Ξεκίνα τώρα</a>
        </div>
    </header>
    <main>
        <div id="Home-img"></div>
    </main>
    <?php include "./include/footer.php"; ?>
</body>
</html>