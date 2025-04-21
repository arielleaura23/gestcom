

<?php
// Connexion à la base de données
include('connexion.php');

session_start();

$username=$_SESSION['username'];
$currency = strtoupper($_POST['currency']);
$language = $_POST['language'];
$appname = $_POST['appname'];
$financialyear = $_POST['financialyear'];

if (isset($_POST['save_preferences'])) {
    $sql= "UPDATE preferences SET app_name='$appname', currency='$currency',language='$language',financial_year='$financialyear'
    WHERE id= 1";


    if ($conn->query($sql) == TRUE) {
        header("Location: preferences.php?status=success");
        exit;
    } else {
        header("Location: preferences.php?status=success");
        exit;
    }
}




$conn->close();


?>




