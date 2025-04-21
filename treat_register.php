<?php
session_start();
include("connexion.php");

$message = '';
$username_error = '';
$email_error = '';
$password_error = '';
$confirm_password_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validation des champs
    if (empty($username)) {
        $username_error = 'Le nom d\'utilisateur est requis.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = 'L\'adresse email est invalide.';
    }

    if ($password !== $confirm_password) {
        $confirm_password_error = 'Les mots de passe ne correspondent pas.';
    }

    // Si tous les champs sont valides
    if (empty($username_error) && empty($email_error) && empty($confirm_password_error)) {
        // Hash du mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insertion dans la base de données
        $sql = "INSERT INTO users (email, username, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            // Lier les paramètres et exécuter la requête
            $stmt->bind_param("sss", $email, $username, $hashed_password);

            try {
                $result = $stmt->execute();

                if ($result) {
                    $message = 'Inscription réussie ! ';
                    $_SESSION['username'] = $username;
                    header('Location: home.php');
                    exit();
                } else {
                    $message = 'Erreur lors de l\'inscription. Veuillez réessayer.';
                }
            } catch (mysqli_sql_exception $e) {
                $message = 'Erreur : ' . $e->getMessage();
            }
        } else {
            $message = 'Erreur dans la préparation de la requête.';
        }
    }
}
?>
