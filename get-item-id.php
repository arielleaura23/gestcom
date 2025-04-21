<?php
include 'connexion.php';

if (isset($_POST['item_name'])) {
    $itemName = $_POST['item_name'];
    
    // Vérifier si l'item existe
    $stmt = $conn->prepare("SELECT id FROM items WHERE item_name = ?");
    $stmt->bind_param("s", $itemName);
    $stmt->execute();
    $stmt->bind_result($itemId);
    $stmt->fetch();
    $stmt->close();

    echo $itemId ? $itemId : ""; // Retourne juste l'ID
}
?>
