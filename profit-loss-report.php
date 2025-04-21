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

                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Profit & Loss Report</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                <li class="breadcrumb-item active">Reports</li>
                            </ul>
                        </div>
                        <div class="col-auto">
                            <a href="#" class="btn btn-primary">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                            <a class="btn btn-primary filter-btn" href="javascript:void(0);" id="filter_search">
                                <i class="fas fa-filter"></i>
                            </a>
                        </div>
                    </div>
                </div>


                <div id="filter_inputs" class="card filter-card">
                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Select Date Range</label>
                                    <select class="select">
                                        <option>Select</option>
                                        <option>Today</option>
                                        <option>This Week</option>
                                        <option>This Month</option>
                                        <option>This Quarter</option>
                                        <option>This Year</option>
                                        <option>Previous Week</option>
                                        <option>Previous Month</option>
                                        <option>Previous Quarter</option>
                                        <option>Previous Year</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>From</label>
                                    <div class="cal-icon">
                                        <input class="form-control datetimepicker" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>To</label>
                                    <div class="cal-icon">
                                        <input class="form-control datetimepicker" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card card-table">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <?php
                                    include('connexion.php');

                                    // Tableau des ventes
                                    $sql_ventes = "
                                                SELECT 
                                                    DATE(i.invoice_date) AS date_vente,
                                                    it.item_name AS nom_article,
                                                    SUM(ii.quantity) AS quantite_totale,
                                                    SUM(ii.quantity * it.price_of_sale) AS montant_total
                                                FROM invoices i
                                                JOIN invoice_items ii ON i.id = ii.invoice_id
                                                JOIN items it ON ii.item_id = it.id
                                                WHERE i.advance = i.total_amount
                                                GROUP BY DATE(i.invoice_date), it.item_name
                                                ORDER BY DATE(i.invoice_date) DESC, it.item_name ASC
                                            ";
                                    $result_ventes = $conn->query($sql_ventes);

                                    // Tableau des profits
                                    $sql_profits = "
                                            SELECT 
                                                it.item_name AS nom_article,
                                                SUM(ii.quantity * it.price_per_unit) AS income_amount,
                                                SUM(ii.quantity * it.price_of_sale) AS sale_amount,
                                                (SUM(ii.quantity * it.price_of_sale) - SUM(ii.quantity * it.price_per_unit)) AS net_profit
                                            FROM invoice_items ii
                                            JOIN items it ON ii.item_id = it.id
                                            JOIN invoices i ON ii.invoice_id = i.id
                                            WHERE i.advance = i.total_amount
                                            GROUP BY it.item_name
                                            ORDER BY net_profit DESC
                                        ";
                                    $result_profits = $conn->query($sql_profits);
                                    ?>

                                    <?php
                                    include('connexion.php');
                                    $sql = "SELECT * FROM preferences";
                                    $stmt = $conn->query($sql);
                                    $preference = $stmt->fetch_assoc();

                                    // Taux de conversion (1 EUR = 655.957 FCFA)
                                    $conversionRate = 655.957;

                                    // Récupérer la devise depuis la session ou la base de données
                                    $currency = $_SESSION['currency'] ?? $preference['currency'] ?? 'fcfa';

                                    // Fonction de conversion
                                    if (!function_exists('convertCurrency')) {
                                        function convertCurrency($amount, $currency, $rate)
                                        {
                                            if ($currency === 'euro') {
                                                return number_format($amount / $rate, 2, '.', '') . ' €';
                                            } else {
                                                return number_format((float)$amount, 0, '.', ' ') . ' FCFA';
                                            }
                                        }
                                    }




                                    ?>


                                    <!-- Tableau des profits -->
                                    <table class="table table-center table-hover datatable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Item Name</th>
                                                <th>Income Amount</th>
                                                <th>Sale Amount</th>
                                                <th class="text-end">Net Profit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $num = 1;
                                            while ($row = $result_profits->fetch_assoc()) {

                                                // conversion
                                                $income_amount = convertCurrency($row['income_amount'], $currency, $conversionRate);
                                                $sale_amount = convertCurrency($row['sale_amount'], $currency, $conversionRate);
                                                $net_profit = convertCurrency($row['net_profit'], $currency, $conversionRate);

                                                echo "<tr>
                                                    <td>{$num}</td>
                                                    <td>{$row['nom_article']}</td>
                                                    <td>" . ($income_amount) . "</td>
                                                    <td>" . ($sale_amount) . "</td>
                                                    <td class='text-end'>" . ($net_profit) . "</td>
                                                </tr>";
                                                $num++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>

                                </div>
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
</body>

</html>