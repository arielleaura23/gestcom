<?php
// Connexion à la base de données
include('connexion.php');

// Vérifier si un client doit être supprimé
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Supprimer le client de la table 'customer_details'
    $sql_details = "DELETE FROM customer_details WHERE id = ?";
    $stmt_details = $conn->prepare($sql_details);
    $stmt_details->execute([$id]);

    // Supprimer ensuite le client de la table 'customers'
    $sql_customers = "DELETE FROM customers WHERE id = ?";
    $stmt_customers = $conn->prepare($sql_customers);
    $stmt_customers->execute([$id]);
    

    // Rediriger vers la même page après la suppression
    header("Location: customers.php?status=deleted");
    exit();
}
?>
