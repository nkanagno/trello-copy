<?php
session_start();

// Ελέγχουμε εάν ο χρήστης είναι συνδεδεμένος
if (!isset($_SESSION['username'])) {
    // Αν δεν είναι συνδεδεμένος, τον ανακατευθύνουμε στη σελίδα σύνδεσης
    header("Location: ../auth/login.php");
    exit;
}

include './include/navbar.php';

// Αν ο χρήστης είναι συνδεδεμένος, εμφανίζουμε τα προσωπικά του στοιχεία
include '../connDB.php';

$username = $_SESSION['username'];

$sql = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($con, $sql);

if (!$result) {
    die("Σφάλμα εκτέλεσης ερωτήματος: " . mysqli_error($con));
}

if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  echo '<div class="profile-container">';
  echo "<h2>Προφίλ Χρήστη</h2>";
  echo "Όνομα: " . $row["name"] . "<br>";
  echo "Επώνυμο: " . $row["surname"] . "<br>";
  echo "Όνομα Χρήστη: " . $row["username"] . "<br>";
  echo "Email: " . $row["email"] . "<br>";
  echo '<div class="form-container">';
  echo '<form action="./php_actions/logout.php" method="post" onsubmit="return submitForm_logout(this, \'' . $row["username"] . '\');">';
  echo '<input type="submit" value="logout">';
  echo '</form>';
  echo '<form action="./php_actions/delete_profile.php" method="post" onsubmit="return submitForm_delete_user(this, \'' . $row["username"] . '\');">';
  echo '<input type="submit" value="Διαγραφή προφίλ">';
  echo '</form>';

  echo '</div>';
  echo '</div>';
} else {
  echo "Δεν βρέθηκαν στοιχεία χρήστη.";
}

mysqli_close($con);

include './include/footer.php';
?>

