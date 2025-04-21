<?php
session_start();
require_once 'connexion.php';

// Définir le type de contenu comme JSON
header('Content-Type: application/json');

// Taux de conversion FCFA <-> EURO
$conversionRate = 655.957;

// Fonction pour convertir les montants
function convertCurrency($amount, $from, $to, $rate)
{
    if ($from === $to) {
        return number_format((float)$amount, 0, '.', ' ') . ' ' . $to;
    }
    if ($from === 'FCFA' && $to === 'EURO') {
        return number_format($amount / $rate, 2, '.', '') . ' €';
    }
    if ($from === 'EURO' && $to === 'FCFA') {
        return number_format($amount * $rate, 0, '.', ' ') . ' FCFA';
    }
    return number_format((float)$amount, 2, '.', '') . ' ' . $to;
}

// Si ce n’est pas une requête POST, on rejette
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        'success' => false,
        'message' => "Requête invalide."
    ]);
    exit;
}

// Vérifier si les champs attendus sont bien envoyés
if (empty($_POST['invoice_id']) || empty($_POST['amount'])) {
    echo json_encode([
        'success' => false,
        'message' => "Données manquantes."
    ]);
    exit;
}

// Récupérer les données
$invoice_id = intval($_POST['invoice_id']);
$amount_user_currency = floatval($_POST['amount']);

// Récupérer la devise préférée
$sql_prefs = "SELECT currency FROM preferences LIMIT 1";
$result_prefs = $conn->query($sql_prefs);
$preference = $result_prefs->fetch_assoc();
$currency = $_SESSION['currency'] ?? $preference['currency'] ?? 'FCFA';

// 1. Récupérer la facture
$query = "SELECT total_amount, amount_currency FROM invoices WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $invoice_id);
$stmt->execute();
$stmt->bind_result($total_amount, $invoice_currency);

if (!$stmt->fetch()) {
    echo json_encode([
        'success' => false,
        'message' => "Facture introuvable."
    ]);
    exit;
}
$stmt->close();

// 2. Somme déjà avancée
$sql_sum = "SELECT SUM(amount) FROM invoice_payments_advance WHERE invoice_id = ?";
$stmt = $conn->prepare($sql_sum);
$stmt->bind_param("i", $invoice_id);
$stmt->execute();
$stmt->bind_result($sum_advance);
$stmt->fetch();
$stmt->close();

$sum_advance = $sum_advance ?? 0;

// 3. Conversion si nécessaire
$amount_in_invoice_currency = $amount_user_currency;
if ($currency !== $invoice_currency) {
    if ($currency === 'FCFA' && $invoice_currency === 'EURO') {
        $amount_in_invoice_currency = $amount_user_currency / $conversionRate;
    } elseif ($currency === 'EURO' && $invoice_currency === 'FCFA') {
        $amount_in_invoice_currency = $amount_user_currency * $conversionRate;
    }
}

// 4. Comparer avec le montant restant dû
$remaining = $total_amount - $sum_advance;
if ($amount_in_invoice_currency > $remaining) {
    echo json_encode([
        'success' => false,
        'message' => "Le montant dépasse le solde restant à payer (" . convertCurrency($remaining, $invoice_currency, $currency, $conversionRate) . ")."
    ]);
    exit;
}

// 5. Enregistrement dans la table `invoice_payments_advance`
$insert = "INSERT INTO invoice_payments_advance (invoice_id, amount, currency) VALUES (?, ?, ?)";
$stmt = $conn->prepare($insert);
$stmt->bind_param("ids", $invoice_id, $amount_user_currency, $currency);

if (!$stmt->execute()) {
    echo json_encode([
        'success' => false,
        'message' => "Erreur lors de l'enregistrement de l'avance."
    ]);
    exit;
}
$stmt->close();

// 6. Nouveau total avancé
$stmt = $conn->prepare("SELECT SUM(amount) FROM invoice_payments_advance WHERE invoice_id = ?");
$stmt->bind_param("i", $invoice_id);
$stmt->execute();
$stmt->bind_result($new_advance);
$stmt->fetch();
$stmt->close();

// 7. Mise à jour de l'avance dans `invoices`
$update = "UPDATE invoices SET advance = ? WHERE id = ?";
$stmt = $conn->prepare($update);
$stmt->bind_param("di", $new_advance, $invoice_id);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => "Avance enregistrée avec succès.",
        'new_advance' => convertCurrency($new_advance, $currency, $currency, $conversionRate),
        'raw_advance' => $new_advance,
        'currency' => $currency
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => "Erreur lors de la mise à jour de l'avance dans la facture."
    ]);
}
$stmt->close();
