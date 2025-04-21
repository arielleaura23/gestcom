<?php
include("connexion.php");

$message = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Préparer la requête SQL sécurisée
    $query_verify = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $query_verify->bind_param("s", $username);
    $query_verify->execute();
    $query_verify->store_result();

    if ($query_verify->num_rows == 1) {
        $query_verify->bind_result($hashed_password);
        $query_verify->fetch();

        // Vérifier le mot de passe hashé
        if (password_verify($password, $hashed_password)) {
            session_start();
            $_SESSION['username'] = $username;
            header("Location: home.php"); // Redirection après connexion
            exit();
        } else {
            $message = "⚠️ Identifiants incorrects.";
        }
    } else {
        $message = "⚠️ Identifiants incorrects.";
    }
}
?>


