<?php
include('libs/tcpdf/tcpdf/tcpdf.php');
include('connexion.php'); // Connexion à la base de données

if (!isset($_GET['id'])) {
    die("Aucun ID de facture fourni.");
}

$invoice_id = intval($_GET['id']);



// Récupération des données de la facture
$query = "SELECT i.invoice_number, i.invoice_date, c.billing_name, c.billing_address, 
                 c.billing_country, c.billing_city, c.billing_phone, c.billing_zip
          FROM invoices i
          JOIN customer_details c ON i.customer_id = c.id
          WHERE i.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $invoice_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Facture introuvable.");
}

$invoice = $result->fetch_assoc();

// Récupération des articles
$query_items = "SELECT ii.item_name, i.item_category, ii.quantity, ii.price, ii.amount
                FROM invoice_items ii
                INNER JOIN items i ON ii.item_id = i.id
                WHERE ii.invoice_id = ?";
$stmt_items = $conn->prepare($query_items);
$stmt_items->bind_param("i", $invoice_id);
$stmt_items->execute();
$result_items = $stmt_items->get_result();

// Calcul du total
$query_total = "SELECT SUM(amount) AS total_amount FROM invoice_items WHERE invoice_id = ?";
$stmt_total = $conn->prepare($query_total);
$stmt_total->bind_param("i", $invoice_id);
$stmt_total->execute();
$result_total = $stmt_total->get_result();
$total = $result_total->fetch_assoc()['total_amount'] ?? 0;

// Création du PDF
$pdf = new TCPDF();
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// Contenu du PDF
$html = '
<h1 style="color: #42cdff; text-align: center;">GESTCOM</h1>
<h2 style="text-align: center;">Facture</h2>
<p><strong>Numéro de facture :</strong> ' . htmlspecialchars($invoice['invoice_number']) . '</p>
<p><strong>Date :</strong> ' . htmlspecialchars($invoice['invoice_date']) . '</p>
<h3>Billed To</h3>
<p>' . htmlspecialchars($invoice['billing_name']) . '<br>' . htmlspecialchars($invoice['billing_phone']) . '<br>'
    . htmlspecialchars($invoice['billing_address']) . ', ' . htmlspecialchars($invoice['billing_zip']) . ', '
    . htmlspecialchars($invoice['billing_city']) . ', ' . htmlspecialchars($invoice['billing_country']) . '</p>

<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>Description</th>
            <th>Catégorie</th>
            <th>Prix</th>
            <th>Quantité</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>';

// Ajout des lignes d'articles
while ($row = $result_items->fetch_assoc()) {
    $html .= '<tr>
        <td>' . htmlspecialchars($row['item_name']) . '</td>
        <td>' . htmlspecialchars($row['item_category']) . '</td>
        <td>' . number_format($row['price'], 2) . ' FCFA</td>
        <td>' . $row['quantity'] . '</td>
        <td>' . number_format($row['amount'], 2) . ' FCFA</td>
    </tr>';
}

$html .= '</tbody></table>';

$html .= '<h3 style="text-align: right;">Total : ' . number_format($total, 2) . ' FCFA</h3>';

// Générer le PDF
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('facture_' . $invoice_id . '.pdf', 'D'); // 'D' pour forcer le téléchargement
