<!DOCTYPE html>
<html lang="en">

<?php
include('head.php');
?>

<?php
session_start();
?>

<body>

    <div class="main-wrapper">

        <?php
        include('header.php');
        ?>


        <?php
        include('sidebar.php');
        ?>


        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xl-10">
                        <div class="card invoice-info-card">
                            <div class="card-body">
                                <div class="invoice-item invoice-item-one">
                                    <div class="row" style="width: 100%;">
                                        <div class="col-md-6" style="display: flex;justify-content: space-between; width: 100%;">
                                            <div class="invoice-logo">
                                                <a href="home.php" class="logo">
                                                    <h1 style="    color: #42cdff;margin: 10px 0;">GESTCOM</h1>
                                                </a>
                                            </div>

                                            <?php
                                            include('connexion.php');
                                            if (isset($_GET['id'])) {
                                                $invoice_id = $_GET['id'];


                                                $result = $conn->query("SELECT invoice_number,invoice_date FROM invoices WHERE id = '$invoice_id'");

                                                if ($result->num_rows > 0) {
                                                    $row = $result->fetch_assoc();
                                                    $invoice_number = $row['invoice_number'];
                                                    $invoice_date = $row['invoice_date'];
                                                } else {
                                                    $invoice_number = 'Invoice not found';
                                                }
                                            } else {
                                                $invoice_number = 'No invoice ID provided';
                                            }

                                            $conn->close();
                                            ?>



                                            <div class="invoice-head" style="text-align: end;">
                                                <h2>Invoice</h2>
                                                <p>Invoice Number : <?php echo $invoice_number; ?></p>

                                            </div>
                                        </div>
                                        <!-- <div class="col-md-6">
                                            <div class="invoice-info">
                                                <strong class="customer-text-one">Invoice From</strong>
                                                <h6 class="invoice-name">Company Name</h6>
                                                <p class="invoice-details">
                                                    9087484288 <br>
                                                    Address line 1, Address line 2<br>
                                                    Zip code ,City - Country
                                                </p>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>

                                <div class="invoice-item invoice-item-two" style="display: flex;width: 100%;flex-direction: column;align-items: end;white-space: nowrap;">
                                    <div class="row">

                                        <?php
                                        include('connexion.php');

                                        if (isset($_GET['id'])) {
                                            $invoice_id = intval($_GET['id']); // Sécurisation de l'ID

                                            // Récupérer les informations du client à partir de l'ID de la facture
                                            $query = "SELECT c.name_customer, c.billing_name, c.billing_address, 
                                                    c.billing_country, c.billing_city, c.billing_phone, c.billing_zip
                                            FROM customer_details c
                                            JOIN invoices i ON i.customer_id = c.id
                                            WHERE i.id = ?";

                                            $stmt = $conn->prepare($query);

                                            if (!$stmt) {
                                                die("Erreur SQL : " . $conn->error);
                                            }

                                            $stmt->bind_param("i", $invoice_id);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            if ($result->num_rows > 0) {
                                                $customer = $result->fetch_assoc();
                                            } else {
                                                die("Aucun client trouvé pour cette facture.");
                                            }

                                            $stmt->close();
                                        } else {
                                            die("Aucun ID de facture fourni.");
                                        }
                                        ?>







                                        <div class="col-md-6" style="width: 100%;">
                                            <div class="invoice-info" style="text-align: end;">
                                                <strong class="customer-text-one">Billed to</strong>
                                                <h6 class="invoice-name"><?php echo htmlspecialchars($customer['billing_name']); ?></h6>
                                                <p class="invoice-details invoice-details-two" style="text-align: end;">
                                                    <?php echo htmlspecialchars($customer['billing_phone']); ?><br>
                                                    <?php echo htmlspecialchars($customer['billing_address']); ?><br>
                                                    <?php echo htmlspecialchars($customer['billing_zip']) . ", " . htmlspecialchars($customer['billing_city']); ?><br>
                                                    <?php echo htmlspecialchars($customer['billing_country']); ?>
                                                </p>
                                            </div>

                                        </div>
                                        <!-- <div class="col-md-6">
                                            <div class="invoice-info invoice-info2">
                                                <strong class="customer-text-one">Payment Details</strong>
                                                <p class="invoice-details">
                                                    Debit Card <br>
                                                    XXXXXXXXXXXX-2541 <br>
                                                    HDFC Bank
                                                </p>
                                                <div class="invoice-item-box">
                                                    <p>Recurring : 15 Months</p>
                                                    <p class="mb-0">PO Number : 54515454</p>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>


                                <div class="invoice-issues-box">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4">
                                            <div class="invoice-issues-date">
                                                <p> Date : <?php
                                                            echo $invoice_date;
                                                            ?></p>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <div class="invoice-item invoice-table-wrap">
                                    <div class="row">

                                        <div class="col-md-12">
                                            <?php
                                            include('connexion.php');

                                            if (isset($_GET['id'])) {
                                                $invoice_id = intval($_GET['id']); // Sécurisation de l'ID


                                                // Requête SQL avec jointure pour récupérer les articles avec leur catégorie
                                                $query = "SELECT ii.item_name, i.item_category, ii.quantity, ii.price, ii.amount
                                                FROM invoice_items ii
                                                INNER JOIN items i ON ii.item_id = i.id
                                                WHERE ii.invoice_id = $invoice_id";

                                                $result = $conn->query($query);

                                                if (!$result) {
                                                    die("Erreur SQL : " . $conn->error);
                                                }
                                            } else {
                                                die("No invoice ID provided.");
                                            }
                                            ?>

                                            <?php
                                            include('connexion.php');

                                            $sql = "SELECT * FROM preferences";
                                            $stmt = $conn->query($sql);
                                            $preference = $stmt->fetch_assoc();
                                            $currency = $preference['currency'];
                                            $currency = strtoupper($currency);

                                            ?>

                                            <?php
                                            // Taux de conversion (1 EUR = 655.957 FCFA)
                                            $conversionRate = 655.957;

                                            // Fonction de conversion avec prise en compte des devises source et cible
                                            function convertCurrency($amount, $currency_from, $currency_to, $rate)
                                            {
                                                // Si les devises sont identiques, on retourne le montant sans conversion
                                                if ($currency_from === $currency_to) {
                                                    return number_format($amount, 2, '.', ' ') . ' ' . $currency_to;
                                                }

                                                // Si la devise source est FCFA et la devise cible est EUR
                                                if ($currency_from === 'FCFA' && $currency_to === 'EURO') {
                                                    return number_format($amount / $rate, 2, '.', '') . ' €';
                                                }

                                                // Si la devise source est EUR et la devise cible est FCFA
                                                if ($currency_from === 'EURO' && $currency_to === 'FCFA') {
                                                    return number_format($amount * $rate, 0, '.', ' ') . ' FCFA';
                                                }

                                                // Si les devises sont différentes mais ne sont pas FCFA/EUR
                                                return number_format((float)$amount, 2, '.', '') . ' ' . $currency_to;
                                            }

                                            $sql_invoices_currency = "SELECT invoices.*, 
                                            customers.name_customer AS customer_name, 
                                            GROUP_CONCAT(DISTINCT items.item_category SEPARATOR ', ') AS item_category, 
                                            GROUP_CONCAT(DISTINCT invoice_items.amount SEPARATOR ', ') AS amounts, 
                                            invoices.advance
                                        FROM invoices
                                        LEFT JOIN customers ON invoices.customer_id = customers.id
                                        LEFT JOIN invoice_items ON invoices.id = invoice_items.invoice_id
                                        LEFT JOIN items ON invoice_items.item_id = items.id
                                        GROUP BY invoices.id, customers.name_customer, invoices.advance
                                        ORDER BY invoices.invoice_date DESC;
                                        ";
                            
                                            $result_invoices_currency = $conn->query($sql_invoices_currency);
                            
                            
                            
                            
                                            $invoice_currency = $result_invoices_currency->fetch_assoc();
                            
                                            $currency_invoice = $invoice_currency['amount_currency'] ?? 'FCFA'; // Par défaut FCFA
                                            $currency_preference = ($currency); // Devise actuelle préférée de l'utilisateur
                            


                                            ?>






                                            <div class="table-responsive">
                                                <table class="invoice-table table table-center mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Description</th>
                                                            <th>Category</th>
                                                            <th>Price</th>
                                                            <th>Quantity</th>
                                                            <th class="text-end">Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        // Vérifier si des articles existent
                                                        if ($result->num_rows > 0) {
                                                            // Parcourir les résultats et afficher les lignes
                                                            while ($row = $result->fetch_assoc()) {
                                                                echo "<tr>";
                                                                echo "<td>" . htmlspecialchars($row['item_name']) . "</td>";
                                                                echo "<td>" . htmlspecialchars($row['item_category']) . "</td>";



                                                                // Conversion du prix et du montant
                                                                echo "<td>" . convertCurrency($row['price'], $currency_invoice, $currency_preference, $conversionRate) . "</td>";
                                                                echo "<td>" . $row['quantity'] . "</td>";
                                                                echo "<td class='text-end'>" . convertCurrency($row['amount'],$currency_invoice, $currency_preference, $conversionRate) . "</td>";

                                                                echo "</tr>";
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='5' class='text-center'>No items found</td></tr>";
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>


                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row align-items-center justify-content-end">
                                    <!-- <div class="col-lg-6 col-md-6">
                                        <div class="invoice-terms">
                                            <h6>Notes:</h6>
                                            <p class="mb-0">Enter customer notes or any other details</p>
                                        </div>
                                        <div class="invoice-terms">
                                            <h6>Terms and Conditions:</h6>
                                            <p class="mb-0">Enter customer notes or any other details</p>
                                        </div>
                                    </div> -->
                                    <div class="col-lg-6 col-md-6">
                                        <div class="invoice-total-card">
                                            <div class="invoice-total-box">
                                                <!-- <div class="invoice-total-inner">
                                                    <p>Taxable <span>$6,660.00</span></p>
                                                    <p>Additional Charges <span>$6,660.00</span></p>
                                                    <p>Discount <span>$3,300.00</span></p>
                                                    <p class="mb-0">Sub total <span>$3,300.00</span></p>
                                                </div> -->


                                                <?php
                                                include('connexion.php');

                                                if (isset($_GET['id'])) {
                                                    $invoice_id = intval($_GET['id']); // Sécurisation de l'ID

                                                    // Requête SQL pour récupérer les articles et calculer le total
                                                    $query = "SELECT ii.item_name, i.item_category, ii.quantity, ii.price, ii.amount
                                                    FROM invoice_items ii
                                                    INNER JOIN items i ON ii.item_id = i.id
                                                    WHERE ii.invoice_id = $invoice_id";

                                                    $result = $conn->query($query);

                                                    // Requête pour calculer le total des montants
                                                    $totalQuery = "SELECT SUM(amount) AS total_amount FROM invoice_items WHERE invoice_id = $invoice_id";
                                                    $totalResult = $conn->query($totalQuery);
                                                    $totalRow = $totalResult->fetch_assoc();
                                                    $totalAmount = $totalRow['total_amount'] ?? 0; // Mettre 0 si aucun résultat
                                                } else {
                                                    die("No invoice ID provided.");
                                                }
                                                ?>

                                                <div class="invoice-total-footer">
                                                    <h4>Total Amount <span><?php echo convertCurrency($totalAmount,  $currency_invoice, $currency_preference, $conversionRate); ?></span></h4>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="invoice-sign text-end">
                                    <img class="img-fluid d-inline-block" src="assets/img/signature.png" alt="sign">
                                    <span class="d-block">Harristemp</span>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <?php
    include('script.php');
    ?>

    <script>
        document.getElementById("currencyLabel").addEventListener("change", function() {
            let currency = this.value;

            // Envoyer la devise en session via AJAX
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "set_currency.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("currency=" + currency);

            // Recharger la page pour appliquer la conversion
            location.reload();
        });
    </script>
</body>

</html>