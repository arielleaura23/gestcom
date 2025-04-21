<?php
include('connexion.php');

$sql = "SELECT item_name, quantity_rest, created_at FROM items WHERE quantity_rest <= 5";
$result = $conn->query($sql);

$notifications = [];

while ($row = $result->fetch_assoc()) {
    $notifications[] = [
        'message' => "Le stock du produit <strong>" . $row['item_name'] . "</strong> est faible (" . $row['quantity_rest'] . " restants)",
        'time' => $row['created_at'] 
    ];
}

echo json_encode($notifications);
?>
