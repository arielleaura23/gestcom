<?php
// Connexion à la base de données
include('connexion.php');
session_start();

$username = $_SESSION['username'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];

// Vérifier si une image a été envoyée
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $target_dir = "assets/photos/"; // Dossier des images
    $image_name = time() . "_" . basename($_FILES["image"]["name"]); // Renommage unique
    $target_file = $target_dir . $image_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Vérifier le format du fichier (JPG, PNG, JPEG seulement)
    $allowed_types = ['jpg', 'jpeg', 'png'];
    if (in_array($imageFileType, $allowed_types)) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Mettre à jour avec l'image
            $sql = "UPDATE users SET username='$name', email='$email', phone='$phone', address='$address', image='$image_name' WHERE username='$username'";
        } else {
            header("Location: settings.php?status=upload_error");
            exit;
        }
    } else {
        header("Location: settings.php?status=invalid_file");
        exit;
    }
} else {
    // Mise à jour sans image
    $sql = "UPDATE users SET username='$name', email='$email', phone='$phone', address='$address' WHERE username='$username'";
}

if ($conn->query($sql) === TRUE) {
    header("Location: profile.php?status=success");
    exit;
} else {
    header("Location: profile.php?status=error");
    exit;
}

$conn->close();
?>
