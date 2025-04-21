<?php
// Connexion à la base de données
include('connexion.php');

// Récupérer le terme de recherche (le texte tapé)
$term = $_GET['term'];

// Recherche des clients dont le nom correspond au terme
$sql = "SELECT name_customer, phone_customer,shipping_address FROM customer_details WHERE name_customer LIKE ?";
$stmt = $conn->prepare($sql);
$searchTerm = "%" . $term . "%"; // Utiliser LIKE pour faire une recherche partielle
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
  // Ajouter chaque client dans le tableau de résultats
  $data[] = [
    'label' => $row['name_customer'],  // Affiché dans la liste de suggestions
    'value' => $row['name_customer'],  // Valeur du champ une fois sélectionné
    'phone' => $row['phone_customer'],  // Le numéro de téléphone du client
    'address' => $row['shipping_address']  // Adresse de livraison du client
  ];
}

// Retourner les résultats sous forme JSON
echo json_encode($data);
?>
