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
                            <h3 class="page-title">Expenses Report</h3>
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
                                    <label>Slect Date Range</label>
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
                                    include('connexion.php'); // Connexion à la base de données

                                    $sql = "SELECT 
                                        i.invoice_date AS date,
                                        ii.item_name AS category, 
                                        SUM(ii.quantity) AS total_quantity, 
                                        SUM(ii.amount) AS total_amount
                                    FROM invoices i
                                    JOIN invoice_items ii ON i.id = ii.invoice_id
                                    WHERE i.advance = i.total_amount
                                    GROUP BY i.invoice_date, ii.item_name
                                    ORDER BY i.invoice_date DESC"; // Grouper par date et article

                                    $result = $conn->query($sql);
                                    ?>

                                    <table class="table table-center table-hover datatable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Article</th>
                                                <th>Quantité Totale</th>
                                                <th class="text-end">Montant Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>


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

                                            <?php
                                            if ($result->num_rows > 0) {
                                                $count = 1;
                                                while ($row = $result->fetch_assoc()) {

                                                    // convertion
                                                    $total_amount = convertCurrency($row['total_amount'], $currency, $conversionRate);

                                                    echo "<tr>
                                                    <td>" . $count . "</td>
                                                    <td>" . date("d M Y", strtotime($row['date'])) . "</td>
                                                    <td>" . htmlspecialchars($row['category']) . "</td>
                                                    <td>" . htmlspecialchars($row['total_quantity']) . "</td>
                                                    <td class='text-end'>" . $total_amount ."</td>
                                                </tr>";
                                                    $count++;
                                                }
                                            } else {
                                                echo "<tr><td colspan='5' class='text-center'>Aucune vente enregistrée</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>

                                    <?php $conn->close(); // Fermer la connexion 
                                    ?>

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