<!DOCTYPE html>
<html lang="en">

<?php
include('head.php');
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

        <?php if (isset($_GET['status']) && $_GET['status'] === 'success') : ?>
            <script src="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var notyf = new Notyf();
                    notyf.success('Order registered successfully.');
                });
            </script>
        <?php elseif (isset($_GET['status']) && $_GET['status'] === 'error') : ?>
            <script src="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var notyf = new Notyf();
                    notyf.error('There was an issue registering the order.');
                });
            </script>
        <?php endif; ?>


        <div class="page-wrapper">
            <div class="content container-fluid">

                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Invoices</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                <li class="breadcrumb-item active">Invoices</li>
                            </ul>
                        </div>
                        <!-- <div class="col-auto">
                            <a href="invoices.html" class="invoices-links active">
                                <i data-feather="list"></i>
                            </a>
                            <a href="invoice-grid.html" class="invoices-links">
                                <i data-feather="grid"></i>
                            </a>
                        </div> -->
                    </div>
                </div>


                <div class="card report-card">
                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="app-listing">
                                    <li>
                                        <div class="multipleSelection">
                                            <div class="selectbox">
                                                <p class="mb-0"><i data-feather="user-plus" class="me-1 select-icon"></i> Select User</p>
                                                <span class="down-icon"><i data-feather="chevron-down"></i></span>
                                            </div>
                                            <div id="checkboxes">
                                                <form action="#">
                                                    <p class="checkbox-title">Customer Search</p>
                                                    <div class="form-custom">
                                                        <input type="text" class="form-control bg-grey" placeholder="Enter Customer Name">
                                                    </div>
                                                    <div class="selectbox-cont">
                                                        <label class="custom_check w-100">
                                                            <input type="checkbox" name="username">
                                                            <span class="checkmark"></span> Brian Johnson
                                                        </label>
                                                        <label class="custom_check w-100">
                                                            <input type="checkbox" name="username">
                                                            <span class="checkmark"></span> Russell Copeland
                                                        </label>
                                                        <label class="custom_check w-100">
                                                            <input type="checkbox" name="username">
                                                            <span class="checkmark"></span> Greg Lynch
                                                        </label>
                                                        <label class="custom_check w-100">
                                                            <input type="checkbox" name="username">
                                                            <span class="checkmark"></span> John Blair
                                                        </label>
                                                        <label class="custom_check w-100">
                                                            <input type="checkbox" name="username">
                                                            <span class="checkmark"></span> Barbara Moore
                                                        </label>
                                                        <label class="custom_check w-100">
                                                            <input type="checkbox" name="username">
                                                            <span class="checkmark"></span> Hendry Evan
                                                        </label>
                                                        <label class="custom_check w-100">
                                                            <input type="checkbox" name="username">
                                                            <span class="checkmark"></span> Richard Miles
                                                        </label>
                                                    </div>
                                                    <button type="submit" class="btn w-100 btn-primary">Apply</button>
                                                    <button type="reset" class="btn w-100 btn-grey">Reset</button>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="multipleSelection">
                                            <div class="selectbox">
                                                <p class="mb-0"><i data-feather="calendar" class="me-1 select-icon"></i> Select Date</p>
                                                <span class="down-icon"><i data-feather="chevron-down"></i></span>
                                            </div>
                                            <div id="checkboxes">
                                                <form action="#">
                                                    <p class="checkbox-title">Date Filter</p>
                                                    <div class="selectbox-cont selectbox-cont-one h-auto">
                                                        <div class="date-picker">
                                                            <div class="form-custom cal-icon">
                                                                <input class="form-control datetimepicker" type="text" placeholder="Form">
                                                            </div>
                                                        </div>
                                                        <div class="date-picker pe-0">
                                                            <div class="form-custom cal-icon">
                                                                <input class="form-control datetimepicker" type="text" placeholder="To">
                                                            </div>
                                                        </div>
                                                        <div class="date-list">
                                                            <ul>
                                                                <li><a href="#" class="btn date-btn">Today</a></li>
                                                                <li><a href="#" class="btn date-btn">Yesterday</a></li>
                                                                <li><a href="#" class="btn date-btn">Last 7 days</a></li>
                                                                <li><a href="#" class="btn date-btn">This month</a></li>
                                                                <li><a href="#" class="btn date-btn">Last month</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- <li>
                                        <div class="multipleSelection">
                                            <div class="selectbox">
                                                <p class="mb-0"><i data-feather="book-open" class="me-1 select-icon"></i> Select Status</p>
                                                <span class="down-icon"><i data-feather="chevron-down"></i></span>
                                            </div>
                                            <div id="checkboxes">
                                                <form action="#">
                                                    <p class="checkbox-title">By Status</p>
                                                    <div class="selectbox-cont">
                                                        <label class="custom_check w-100">
                                                            <input type="checkbox" name="name" checked>
                                                            <span class="checkmark"></span> All Invoices
                                                        </label>
                                                        <label class="custom_check w-100">
                                                            <input type="checkbox" name="name">
                                                            <span class="checkmark"></span> Paid
                                                        </label>
                                                        <label class="custom_check w-100">
                                                            <input type="checkbox" name="name">
                                                            <span class="checkmark"></span> Overdue
                                                        </label>
                                                        <label class="custom_check w-100">
                                                            <input type="checkbox" name="name">
                                                            <span class="checkmark"></span> Draft
                                                        </label>
                                                        <label class="custom_check w-100">
                                                            <input type="checkbox" name="name">
                                                            <span class="checkmark"></span> Recurring
                                                        </label>
                                                        <label class="custom_check w-100">
                                                            <input type="checkbox" name="name">
                                                            <span class="checkmark"></span> Cancelled
                                                        </label>
                                                    </div>
                                                    <button type="submit" class="btn w-100 btn-primary">Apply</button>
                                                    <button type="reset" class="btn w-100 btn-grey">Reset</button>
                                                </form>
                                            </div>
                                        </div>
                                    </li> -->
                                    <li>
                                        <div class="multipleSelection">
                                            <div class="selectbox">
                                                <p class="mb-0"><i data-feather="bookmark" class="me-1 select-icon"></i> By Category</p>
                                                <span class="down-icon"><i data-feather="chevron-down"></i></span>
                                            </div>
                                            <div id="checkboxes">
                                                <form action="#">
                                                    <p class="checkbox-title">Category</p>
                                                    <div class="form-custom">
                                                        <input type="text" class="form-control bg-grey" placeholder="Enter Category Name">
                                                    </div>
                                                    <div class="selectbox-cont">
                                                        <label class="custom_check w-100">
                                                            <input type="checkbox" name="category">
                                                            <span class="checkmark"></span> Advertising
                                                        </label>
                                                        <label class="custom_check w-100">
                                                            <input type="checkbox" name="category">
                                                            <span class="checkmark"></span> Food
                                                        </label>
                                                        <label class="custom_check w-100">
                                                            <input type="checkbox" name="category">
                                                            <span class="checkmark"></span> Marketing
                                                        </label>
                                                        <label class="custom_check w-100">
                                                            <input type="checkbox" name="category">
                                                            <span class="checkmark"></span> Repairs
                                                        </label>
                                                        <label class="custom_check w-100">
                                                            <input type="checkbox" name="category">
                                                            <span class="checkmark"></span> Software
                                                        </label>
                                                        <label class="custom_check w-100">
                                                            <input type="checkbox" name="category">
                                                            <span class="checkmark"></span> Stationary
                                                        </label>
                                                        <label class="custom_check w-100">
                                                            <input type="checkbox" name="category">
                                                            <span class="checkmark"></span> Travel
                                                        </label>
                                                    </div>
                                                    <button type="submit" class="btn w-100 btn-primary">Apply</button>
                                                    <button type="reset" class="btn w-100 btn-grey">Reset</button>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- <li>
                                        <div class="report-btn">
                                            <a href="#" class="btn">
                                                <img src="assets/img/icons/invoices-icon5.svg" alt="" class="me-2"> Generate report
                                            </a>
                                        </div>
                                    </li> -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card invoices-tabs-card">
                    <div class="card-body card-body pt-0 pb-0">
                        <div class="invoices-main-tabs">
                            <div class="row align-items-center ">
                                <div class="col-lg-8 col-md-8">
                                    <div class="invoices-tabs">


                                        <ul>
                                            <li><a href="invoices.php">All Invoice</a></li>
                                            <li><a href="invoices-paid.php">Paid</a></li>
                                            <li><a href="invoices-recurring.php" class="active">In loading</a></li>
                                            <li><a href="invoices-unpaid.php">Unpaid</a></li>
                                            <!-- <li><a href="invoices-cancelled.html">Cancelled</a></li> -->
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="invoices-settings-btn">
                                        <!-- <a href="invoices-settings.html" class="invoices-settings-icon">
                                            <i data-feather="settings"></i>
                                        </a> -->
                                        <a href="add-invoice.php" class="btn">
                                            <i data-feather="plus-circle"></i> New Invoice
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                include('connexion.php');


                // Récupérer les factures totalement payées (advance = total_amount)
                $paidQuery = "SELECT COUNT(*) AS paid_invoices, IFNULL(SUM(total_amount), 0) AS total_paid FROM invoices WHERE advance = total_amount";
                $paidResult = $conn->query($paidQuery);
                $paidRow = $paidResult->fetch_assoc();
                $paidInvoices = $paidRow['paid_invoices'] ?? 0;
                $totalAmountPaid = $paidRow['total_paid'] ?? 0;

                // Récupérer les factures en attente (advance < total_amount)
                $loadingQuery = "SELECT COUNT(*) AS loading_invoices, IFNULL(SUM(advance), 0) AS total_advance FROM invoices WHERE advance < total_amount AND advance != 0";
                $loadingResult = $conn->query($loadingQuery);
                $loadingRow = $loadingResult->fetch_assoc();
                $loadingInvoices = $loadingRow['loading_invoices'] ?? 0;
                $totalAmountAdvance = $loadingRow['total_advance'] ?? 0;

                $unpaidQuery = "SELECT COUNT(*) AS unpaid_invoices, IFNULL(SUM(advance), 0) AS total_advance FROM invoices WHERE advance = 0";
                $unpaidResult = $conn->query($unpaidQuery);
                $unpaidRow = $unpaidResult->fetch_assoc();
                $unpaidInvoices = $unpaidRow['unpaid_invoices'] ?? 0;
                $unpaidAmountAdvance = $unpaidRow['total_advance'] ?? 0;

                // Récupérer le nombre total de factures et la somme des montants
                $allQuery = "SELECT COUNT(*) AS total_invoices FROM invoices";
                $allResult = $conn->query($allQuery);
                $allRow = $allResult->fetch_assoc();
                $totalInvoices = $allRow['total_invoices'] ?? 0;
                $totalAmountAll = $totalAmountAdvance + $totalAmountPaid + $unpaidAmountAdvance;
                ?>

                <?php
                include('connexion.php');

                $sql = "SELECT * FROM preferences";
                $stmt = $conn->query($sql);
                $preference = $stmt->fetch_assoc();
                $currency = $preference['currency'];
                $currency = strtoupper($currency);

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

                if ($currency_invoice != $currency_preference) {
                    // Convertir les montants si les devises sont différentes
                    $totalAmountAll = convertCurrency($totalAmountAll, $currency_invoice, $currency_preference, $conversionRate);
                    $totalAmountPaid = convertCurrency($totalAmountPaid, $currency_invoice, $currency_preference, $conversionRate);
                    $totalAmountAdvance = convertCurrency($totalAmountAdvance, $currency_invoice, $currency_preference, $conversionRate);
                    $unpaidAmountAdvance = convertCurrency($unpaidAmountAdvance, $currency_invoice, $currency_preference, $conversionRate);
                } else {
                    $totalAmountAll = ($totalAmountAdvance + $totalAmountPaid + $unpaidAmountAdvance) . ' ' . $currency;
                    $totalAmountPaid = $paidRow['total_paid'] . ' ' . $currency;
                    $totalAmountAdvance = $loadingRow['total_advance'] . ' ' . $currency;
                    $unpaidAmountAdvance = $unpaidRow['total_advance'] . ' ' . $currency;
                }

                ?>

                <div class="row d-flex justify-content-between">
                    <!-- Toutes les factures -->
                    <!-- <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card inovices-card">
                            <div class="card-body">
                                <div class="inovices-widget-header">
                                    <span class="inovices-widget-icon">
                                        <img src="assets/img/icons/invoices-icon1.svg" alt="">
                                    </span>
                                    <div class="inovices-dash-count">
                                        <div class="inovices-amount" style="font-size: 18px;"><?php echo ($totalAmountAll); ?> FCFA</div>
                                    </div>
                                </div>
                                <p class="inovices-all" style="display: flex;align-items: center;justify-content: end;">All Invoices <span style="font-size: 16px;">3</span></p>
                            </div>
                        </div>
                    </div> -->

                    <!-- Factures payées -->
                    <!-- <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card inovices-card">
                            <div class="card-body">
                                <div class="inovices-widget-header">
                                    <span class="inovices-widget-icon">
                                        <img src="assets/img/icons/invoices-icon2.svg" alt="">
                                    </span>
                                    <div class="inovices-dash-count">
                                        <div class="inovices-amount" style="font-size: 18px;"><?php echo ($totalAmountPaid); ?> FCFA</div>
                                    </div>
                                </div>
                                <p class="inovices-all" style="display: flex;align-items: center;justify-content: end;">Paid Invoices <span style="font-size: 16px;"><?php echo $paidInvoices; ?></span></p>
                            </div>
                        </div>
                    </div> -->

                    <!-- Factures en attente (avance payée mais pas complète) -->
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="card inovices-card">
                            <div class="card-body">
                                <div class="inovices-widget-header">
                                    <span class="inovices-widget-icon">
                                        <img src="assets/img/icons/invoices-icon3.svg" alt="">
                                    </span>
                                    <div class="inovices-dash-count">
                                        <div class="inovices-amount" style="font-size: 18px;"><?php echo ($totalAmountAdvance); ?> </div>
                                    </div>
                                </div>
                                <p class="inovices-all" style="display: flex;align-items: center;justify-content: end;">Loading Invoices <span style="font-size: 16px;"><?php echo $loadingInvoices; ?></span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <?php

                include 'connexion.php'; // Inclusion de la connexion

                // Requête pour récupérer les factures
                $sql_invoices = "SELECT invoices.*, 
                        customers.name_customer AS customer_name, 
                        GROUP_CONCAT(DISTINCT items.item_category SEPARATOR ', ') AS item_category, 
                        GROUP_CONCAT(DISTINCT invoice_items.amount SEPARATOR ', ') AS amounts, 
                        invoices.advance
                    FROM invoices
                    LEFT JOIN customers ON invoices.customer_id = customers.id
                    LEFT JOIN invoice_items ON invoices.id = invoice_items.invoice_id
                    LEFT JOIN items ON invoice_items.item_id = items.id
                     WHERE invoices.advance < invoices.total_amount 
                     AND invoices.advance > 0 
                    GROUP BY invoices.id, customers.name_customer, invoices.advance
                    ORDER BY invoices.invoice_date DESC;
                    ";

                $result_invoices = $conn->query($sql_invoices);

                ?>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card card-table">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-stripped table-hover datatable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Invoice ID</th>
                                                <th>Created on</th>
                                                <th>Invoice to</th>
                                                <th>Amount</th>
                                                <th>advance</th>
                                                <th>Status</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result_invoices->num_rows > 0) {
                                                while ($invoice = $result_invoices->fetch_assoc()) {
                                                    $invoice_id = $invoice['id'];
                                                    $invoice_number = $invoice['invoice_number'] ?? 'N/A';
                                                    $invoice_date = isset($invoice['invoice_date']) ? date("d M Y", strtotime($invoice['invoice_date'])) : 'Date inconnue';
                                                    $client_name = $invoice['customer_name'] ?? 'Client inconnu';
                                                    $total_amount_number = $invoice['total_amount'] ?? 0;
                                                    $advance_number = $invoice['advance'] ?? 0; // Montant de l'avance

                                                    // Récupérer la devise de la facture et la devise préférée de l'utilisateur
                                                    $currency_invoice = $invoice['amount_currency'] ?? 'FCFA'; // Par défaut FCFA
                                                    $currency_preference = ($currency); // Devise actuelle préférée de l'utilisateur




                                                    // Si la devise actuelle est différente de celle de la facture, on effectue la conversion
                                                    if ($currency_invoice != $currency_preference) {
                                                        // Convertir les montants si les devises sont différentes
                                                        $total_amount = convertCurrency($total_amount_number, $currency_invoice, $currency_preference, $conversionRate);
                                                        $advance = convertCurrency($advance_number, $currency_invoice, $currency_preference, $conversionRate);
                                                    } else {
                                                        $total_amount = $invoice['total_amount'] . ' ' . $currency;
                                                        $advance = $invoice['advance'] . ' ' . $currency;
                                                    }

                                                    // Détermination du statut
                                                    if ($advance_number == $total_amount_number) {
                                                        $status = 'Paid';
                                                        $status_class = 'bg-success-light';
                                                        $edit_disabled = "disabled"; // Désactiver le bouton Edit
                                                    } elseif ($advance_number < $total_amount_number && $advance_number > 0) {
                                                        $status = 'Advanced (' . round(($advance_number / $total_amount_number) * 100, 2) . '%)';
                                                        $status_class = 'bg-warning-light';
                                                        $edit_disabled = ""; // Edit activé
                                                    } else {
                                                        $status = 'Unpaid';
                                                        $status_class = 'bg-danger-light';
                                                        $edit_disabled = "";
                                                    }



                                                    echo "<tr>";
                                                    echo "<td><a href='view-invoice.php?id=$invoice_id' class='invoice-link'>$invoice_number</a></td>";
                                                    echo "<td>$invoice_date</td>";
                                                    echo "<td>$client_name</td>";
                                                    echo "<td class='text-primary'>" .  ($total_amount) . "</td>";
                                                    echo "<td class='text-primary'>" . ($advance) . "</td>";
                                                    echo "<td><span class='badge $status_class'>$status</span></td>";
                                                    echo "<td class='text-end'>";
                                                    echo "<div class='call_to_actions'>";

                                                    // Bouton Edit (désactivé si Paid)
                                                    if ($edit_disabled) {
                                                        echo "<a class='dropdown-item disabled' href='#'><i class='far fa-edit me-2'></i>Edit</a>";
                                                    } else {
                                                        echo "<a class='dropdown-item edit-order-btn' data-id='" . $invoice_id . "' data-bs-toggle='modal' data-bs-target='#edit_order'><i class='far fa-edit me-2'></i> edit </a>";
                                                    }

                                                    // Bouton View (toujours activé)
                                                    echo "<a class='dropdown-item' href='view-invoice.php?id=$invoice_id'><i class='far fa-eye me-2'></i>View</a>";

                                                    if ($edit_disabled) {
                                                        echo "<a class='dropdown-item' href='generate_invoice_pdf.php?id=$invoice_id>'><i class='fas fa-download me-1'></i>Download</a>";
                                                    } else {

                                                        echo "<a class='dropdown-item disabled' href='#'><i class='fas fa-download me-1'></i>Download</a>";
                                                    }

                                                    echo "</div>";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='7' class='text-center'>Aucune facture trouvée</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div id="edit_order" class="modal custom-modal fade" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Modifier la commande</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editOrderForm">
                                        <input type="hidden" id="invoice_id" name="invoice_id" value="<?= $invoice_id ?>">

                                        <div class="form-group">
                                            <label>Montant à ajouter <span class="text-danger">*</span></label>
                                            <input class="form-control" type="number" id="amount" name="amount" required>
                                        </div>

                                        <div class="submit-section">
                                            <button type="submit" class="btn btn-primary submit-btn">Enregistrer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

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


    <!-- script pour editer la commande  et affichage des messages pour la modification du invoice avec sweetalert -->
    <!-- Notyf -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".edit-order-btn").click(function() {
                var invoiceId = $(this).data("id");
                $("#invoice_id").val(invoiceId);
            });

            $("#editOrderForm").submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    type: "POST",
                    url: "update_invoice.php",
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        console.log("Réponse reçue :", response);

                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Succès',
                                text: response.message
                            }).then(() => {
                                location.reload(); // Recharge la page après confirmation
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Erreur AJAX :", xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur serveur',
                            text: 'Impossible de traiter la demande.'
                        });
                    }
                });
            });
        });
    </script>

    <?php
    include('script.php');
    ?>


    <script src="assets/js/jquery-3.6.0.min.js"></script>

    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/feather.min.js"></script>

    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <script src="assets/plugins/select2/js/select2.min.js"></script>

    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatables/datatables.min.js"></script>

    <script src="assets/plugins/moment/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>

    <script src="assets/js/script.js"></script>
</body>

</html>