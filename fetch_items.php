<?php
include('connexion.php');

// Récupération du terme tapé par l'utilisateur
$term = $_GET['term']; 

// Requête pour chercher les articles contenant le terme
$sql = "SELECT id, item_name, item_category, price_of_sale FROM items WHERE item_name LIKE ?";
$stmt = $conn->prepare($sql);
$searchTerm = "%" . $term . "%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$data = [];

// Récupérer la devise préférée
$sql_prefs = "SELECT currency FROM preferences LIMIT 1";
$result_prefs = $conn->query($sql_prefs);
$preference = $result_prefs->fetch_assoc();
$currency = $_SESSION['currency'] ?? $preference['currency'] ?? 'fcfa';

// Taux de conversion (1 EUR = 655.957 FCFA)
$conversionRate = 655.957;

// Fonction de conversion
function convertCurrency($amount, $currency, $rate) {
    if ($currency === 'EURO') {
        return $amount / $rate; // Retourne juste la valeur numérique
    } else {
        return $amount; // Retourne le montant en FCFA
    }
}

// Récupération des articles et formatage des données
while ($row = $result->fetch_assoc()) {
    $convertedPrice = convertCurrency($row['price_of_sale'], $currency, $conversionRate);
    $formattedPrice = number_format($convertedPrice, 2, '.', '') . ' ' . strtoupper($currency);

    $data[] = [
        'id' => $row['id'],
        'value' => $row['item_name'],
        'category' => $row['item_category'],
        'price_of_sale' => $convertedPrice, // Prix converti (sans devise)
        'formatted_price' => $formattedPrice, // Prix avec devise pour affichage
        'raw_price' => $row['price_of_sale'], // Prix brut pour édition
        'currency' => strtoupper($currency) // Devise en majuscules (EUR, FCFA, etc.)
    ];
}

// Renvoi des résultats en JSON
echo json_encode($data);
?>
