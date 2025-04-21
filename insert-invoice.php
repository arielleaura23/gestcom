<?php
include 'connexion.php'; // Connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $customer_id = isset($_POST['customer_id']) ? intval($_POST['customer_id']) : null;
    $invoice_number = isset($_POST['invoice_number']) ? $_POST['invoice_number'] : null;
    $total_amount = isset($_POST['total_amount']) ? floatval($_POST['total_amount']) : 0.0;
    $advance = isset($_POST['advance']) ? floatval($_POST['advance']) : 0.0;

    // Récupérer la devise actuelle depuis les préférences
    $sql_prefs = "SELECT currency FROM preferences LIMIT 1";
    $result_prefs = $conn->query($sql_prefs);
    $preference = $result_prefs->fetch_assoc();
    $currency = strtoupper($preference['currency']); // Devise actuelle

    if (!$customer_id) {
        die("Erreur : Aucun client sélectionné.");
    }

    // Vérification des quantités disponibles en stock
    $valid_quantities = true;

    for ($i = 0; $i < count($_POST['item_id']); $i++) {
        $item_id = intval($_POST['item_id'][$i]);
        $quantity = intval($_POST['quantity'][$i]);

        if ($item_id && $quantity > 0) {
            $sql_stock = "SELECT quantity_rest, item_name FROM items WHERE id = ?";
            $stmt_stock = $conn->prepare($sql_stock);
            $stmt_stock->bind_param("i", $item_id);
            $stmt_stock->execute();
            $stmt_stock->bind_result($quantity_rest, $item_name);
            $stmt_stock->fetch();
            $stmt_stock->close();

            if ($quantity > $quantity_rest) {
                $valid_quantities = false;
                echo "Quantité insuffisante pour l'article $item_name. Stock restant : $quantity_rest.<br>";
            }
        }
    }

    if ($valid_quantities) {
        // Insertion de la facture
        $sql_invoice = "INSERT INTO invoices (invoice_number, customer_id, total_amount, advance, amount_currency, invoice_date) 
                        VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt_invoice = $conn->prepare($sql_invoice);

        if (!$stmt_invoice) {
            die("Erreur de préparation de la requête facture : " . $conn->error);
        }

        $stmt_invoice->bind_param("sidds", $invoice_number, $customer_id, $total_amount, $advance, $currency);

        if ($stmt_invoice->execute()) {
            $invoice_id = $stmt_invoice->insert_id;

            // Insertion de l'avance dans invoice_payments_advance
            if ($advance > 0) {
                $sql_advance = "INSERT INTO invoice_payments_advance (invoice_id, amount, payment_date, currency) 
                                VALUES (?, ?, NOW(), ?)";
                $stmt_advance = $conn->prepare($sql_advance);
                $stmt_advance->bind_param("ids", $invoice_id, $advance, $currency);
                $stmt_advance->execute();
                $stmt_advance->close();
            }

            // Insertion des articles
            $sql_items = "INSERT INTO invoice_items (invoice_id, item_id, item_name, quantity, price, amount) 
                          VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_items = $conn->prepare($sql_items);

            if (!$stmt_items) {
                die("Erreur de préparation de la requête articles : " . $conn->error);
            }

            for ($i = 0; $i < count($_POST['item_id']); $i++) {
                $item_id = intval($_POST['item_id'][$i]);
                $item_name = $_POST['item-name'][$i];
                $quantity = intval($_POST['quantity'][$i]);
                $price = floatval($_POST['price'][$i]);
                $amount = floatval($_POST['amount'][$i]);

                if ($item_id && $item_name && $quantity > 0 && $price > 0) {
                    $stmt_items->bind_param("iisddd", $invoice_id, $item_id, $item_name, $quantity, $price, $amount);
                    $stmt_items->execute();

                    // Mise à jour du stock
                    $sql_get_qty = "SELECT quantity_rest, quantity_buyed FROM items WHERE id = ?";
                    $stmt_get_qty = $conn->prepare($sql_get_qty);
                    $stmt_get_qty->bind_param("i", $item_id);
                    $stmt_get_qty->execute();
                    $stmt_get_qty->bind_result($quantity_rest, $quantity_buyed);
                    $stmt_get_qty->fetch();
                    $stmt_get_qty->close();

                    $new_quantity_rest = $quantity_rest - $quantity;
                    $new_quantity_selled = $quantity_buyed - $new_quantity_rest;

                    $sql_update_stock = "UPDATE items SET quantity_rest = ?, quantity_selled = ? WHERE id = ?";
                    $stmt_update_stock = $conn->prepare($sql_update_stock);
                    $stmt_update_stock->bind_param("iii", $new_quantity_rest, $new_quantity_selled, $item_id);
                    $stmt_update_stock->execute();
                    $stmt_update_stock->close();
                }
            }

            $stmt_items->close();
        }

        header("Location: invoices.php?status=success");
        exit();
    } else {
        echo "Erreur : Quantité insuffisante pour un ou plusieurs articles. La facture n'a pas été enregistrée.";
    }

    $conn->close();
} else {
    echo "Accès non autorisé.";
}
?>
