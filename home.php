<!DOCTYPE html>
<html lang="en">

<?php
include('head.php');
?>

<?php
session_start();
?>

<body
  class="nk-body bg-lighter npc-default has-sidebar no-touch nk-nio-theme">

  <div class="main-wrapper">
    <?php
    include('header.php');
    ?>

    <?php
    include('sidebar.php');
    ?>



    <div class="page-wrapper">
      <div class="content container-fluid" style="width: 100%;">
        <div class="row" style="width: 100%;justify-content:space-between;">
          <!-- <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
              <div class="card-body">
                <div class="dash-widget-header">
                  <span class="dash-widget-icon bg-1">
                    <i class="fas fa-dollar-sign"></i>
                  </span>
                  <div class="dash-count">
                    <div class="dash-title">Ventes</div>
                    <div class="dash-counts">
                      <p>1,642</p>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div> -->
          <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
              <div class="card-body">
                <div class="dash-widget-header">
                  <span class="dash-widget-icon bg-2">
                    <i class="fas fa-users"></i>
                  </span>

                  <?php
                  include('connexion.php');

                  // Requête pour compter le nombre de clients
                  $sql = "SELECT COUNT(*) AS total_customers FROM customers";
                  $result = $conn->query($sql);

                  // Initialiser le nombre de clients à zéro au cas où la requête échoue
                  $total_customers = 0;

                  if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $total_customers = $row['total_customers'];
                  }
                  ?>

                  <?php
                  include('connexion.php');


                  // Récupérer les factures totalement payées (advance = total_amount)
                  $paidQuery = "SELECT COUNT(*) AS paid_invoices, SUM(total_amount) AS total_paid FROM invoices WHERE advance = total_amount";
                  $paidResult = $conn->query($paidQuery);
                  $paidRow = $paidResult->fetch_assoc();
                  $paidInvoices = $paidRow['paid_invoices'] ?? 0;
                  $totalAmountPaid = $paidRow['total_paid'] ?? 0;

                  // Récupérer les factures en attente (advance < total_amount)
                  $loadingQuery = "SELECT COUNT(*) AS loading_invoices, SUM(advance) AS total_advance FROM invoices WHERE advance < total_amount";
                  $loadingResult = $conn->query($loadingQuery);
                  $loadingRow = $loadingResult->fetch_assoc();
                  $loadingInvoices = $loadingRow['loading_invoices'] ?? 0;
                  $totalAmountAdvance = $loadingRow['total_advance'] ?? 0;

                  // Récupérer le nombre total de factures et la somme des montants
                  $allQuery = "SELECT COUNT(*) AS total_invoices FROM invoices";
                  $allResult = $conn->query($allQuery);
                  $allRow = $allResult->fetch_assoc();
                  $totalInvoices = $allRow['total_invoices'] ?? 0;
                  $totalAmountAll = $totalAmountAdvance + $totalAmountPaid;
                  ?>

                  <div class="dash-count">
                    <div class="dash-title">Customers</div>
                    <div class="dash-counts">
                      <p><?php echo number_format($total_customers); ?></p>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
              <div class="card-body">
                <div class="dash-widget-header">
                  <span class="dash-widget-icon bg-2">
                    <i class="fas fa-users"></i>
                  </span>
                  <div class="dash-count">
                    <div class="dash-title">Commandes</div>
                    <div class="dash-counts">
                      <p><?php echo number_format($totalInvoices); ?></p>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <!-- <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
              <div class="card-body">
                <div class="dash-widget-header">
                  <span class="dash-widget-icon bg-3">
                    <i class="fas fa-file-alt"></i>
                  </span>
                  <div class="dash-count">
                    <div class="dash-title">Invoices</div>
                    <div class="dash-counts">
                      <p>1,041</p>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div> -->
          <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
              <div class="card-body">
                <div class="dash-widget-header">
                  <span class="dash-widget-icon bg-3">
                    <i class="fas fa-file-alt"></i>
                  </span>
                  <div class="dash-count">

                    <?php
                    include('connexion.php');

                    $sql = "SELECT COUNT(*) AS total_items FROM items";
                    $result = $conn->query($sql);


                    $total_customers = 0;

                    if ($result->num_rows > 0) {
                      $row = $result->fetch_assoc();
                      $total_items = $row['total_items'];
                    }
                    ?>
                    <div class="dash-title">Produits</div>
                    <div class="dash-counts">
                      <p><?php echo number_format($total_items); ?></p>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
        <div class="row" style="width: 100%">
          <?php
          include('connexion.php');

          // Récupérer la devise préférée
          $sql = "SELECT currency FROM preferences";
          $result = $conn->query($sql);
          $preference = $result->fetch_assoc();
          $currency = $_SESSION['currency'] ?? $preference['currency'] ?? 'fcfa';

          // Taux de conversion (1 EUR = 655.957 FCFA)
          $conversionRate = 655.957;

          // Fonction pour convertir la monnaie
          function convertCurrency($amount, $currency, $rate)
          {
            if ($currency === 'euro') {
              return number_format($amount / $rate, 2, '.', '') . ' €';
            } else {
              return number_format((float)$amount, 0, '.', ' ') . ' FCFA';
            }
          }

          // Récupérer les valeurs des ventes et dépenses depuis la table items
          $sql = "SELECT 
            SUM(price_of_sale * quantity_buyed) AS total_sales, 
            SUM(price_per_unit * quantity_buyed) AS total_expenses 
        FROM items";
          $result = $conn->query($sql);
          $data = $result->fetch_assoc();

          $totalSales = $data['total_sales'] ?? 0;
          $totalExpenses = $data['total_expenses'] ?? 0;

          // Récupérer la somme des montants des factures payées depuis la table invoices
          $sql = "SELECT SUM(total_amount) AS total_receipts FROM invoices WHERE advance = total_amount";
          $result = $conn->query($sql);
          $data = $result->fetch_assoc();
          $receipts = $data['total_receipts'] ?? 0;

          // Calcul des bénéfices (Earnings)
          $earnings = $receipts - $totalExpenses;

          // Convertir les montants en fonction de la devise choisie
          $totalSalesFormatted = convertCurrency($totalSales, $currency, $conversionRate);
          $receiptsFormatted = convertCurrency($receipts, $currency, $conversionRate);
          $totalExpensesFormatted = convertCurrency($totalExpenses, $currency, $conversionRate);
          $earningsFormatted = convertCurrency($earnings, $currency, $conversionRate);
          ?>


          <?php
          include('connexion.php');

          // Récupération des données pour Invoice Analytics
          $sql_total = "SELECT SUM(total_amount) AS total_invoiced FROM invoices";
          $result_total = $conn->query($sql_total);
          $row_total = $result_total->fetch_assoc();
          $totalInvoiced = $row_total['total_invoiced'] ?? 0;

          // Factures payées
          $sql_paid = "SELECT SUM(total_amount) AS total_received FROM invoices WHERE advance = total_amount";
          $result_paid = $conn->query($sql_paid);
          $row_paid = $result_paid->fetch_assoc();
          $totalReceived = $row_paid['total_received'] ?? 0;

          // Factures impayées
          $totalPending = $totalInvoiced - $totalReceived;

          // Conversion si nécessaire
          $currency = $_SESSION['currency'] ?? 'fcfa';
          $exchangeRate = 655.957;

          if (!function_exists('convertCurrency')) {
            function convertCurrency($amount, $currency, $rate)
            {
              if ($currency === 'euro') {
                return number_format($amount / $rate, 2, '.', '') . ' €';
              }
              return number_format((float)$amount, 0, '.', ' ') . ' FCFA';
            }
          }



          $totalInvoiced = convertCurrency($totalInvoiced, $currency, $exchangeRate);
          $totalReceived = convertCurrency($totalReceived, $currency, $exchangeRate);
          $totalPending = convertCurrency($totalPending, $currency, $exchangeRate);
          ?>

          <div class="col-xl-5 d-flex" style="width: 100%;">
            <div class="card flex-fill">
              <div class="card-header">
                <div class="d-flex justify-content-between align-items-center" style="width: 100%;">
                  <h5 class="card-title">Invoice Analytics</h5>
                  <div class="dropdown">
                    <button class="btn btn-white btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1"
                      data-bs-toggle="dropdown" aria-expanded="false">
                      Monthly
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                      <li><a href="javascript:void(0);" class="dropdown-item">Weekly</a></li>
                      <li><a href="javascript:void(0);" class="dropdown-item">Monthly</a></li>
                      <li><a href="javascript:void(0);" class="dropdown-item">Yearly</a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div id="invoice_chart"></div>
                <div class="text-center text-muted">
                  <div class="row">
                    <div class="col-4">
                      <div class="mt-4">
                        <p class="mb-2 text-truncate">
                          <i class="fas fa-circle text-primary me-1"></i>
                          Invoiced
                        </p>
                        <h5><?= $totalInvoiced; ?></h5>
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="mt-4">
                        <p class="mb-2 text-truncate">
                          <i class="fas fa-circle text-success me-1"></i>
                          Received
                        </p>
                        <h5><?= $totalReceived; ?></h5>
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="mt-4">
                        <p class="mb-2 text-truncate">
                          <i class="fas fa-circle text-danger me-1"></i>
                          Pending
                        </p>
                        <h5><?= $totalPending; ?></h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-7 d-flex" style="width: 100%;">
            <div class="card flex-fill">
              <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                  <h5 class="card-title">Sales Analytics</h5>
                  <div class="dropdown">
                    <button
                      class="btn btn-white btn-sm dropdown-toggle"
                      type="button"
                      id="dropdownMenuButton"
                      data-bs-toggle="dropdown"
                      aria-expanded="false">
                      Monthly
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <li><a href="javascript:void(0);" class="dropdown-item">Weekly</a></li>
                      <li><a href="javascript:void(0);" class="dropdown-item">Monthly</a></li>
                      <li><a href="javascript:void(0);" class="dropdown-item">Yearly</a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-between flex-wrap flex-md-nowrap">
                  <div class="w-md-100 d-flex align-items-center mb-3 flex-wrap flex-md-nowrap">
                    <div>
                      <span>Total Sales</span>
                      <p class="h3 text-primary me-5"><?= $totalSalesFormatted; ?></p>
                    </div>
                    <div>
                      <span>Receipts</span>
                      <p class="h3 text-success me-5"><?= $receiptsFormatted; ?></p>
                    </div>
                    <div>
                      <span>Expenses</span>
                      <p class="h3 text-danger me-5"><?= $totalExpensesFormatted; ?></p>
                    </div>
                    <div>
                      <span>Earnings</span>
                      <p class="h3 text-dark me-5"><?= $earningsFormatted; ?></p>
                    </div>
                  </div>
                </div>
                <div id="sales_chart"></div>
              </div>
            </div>
            
          </div>

          <canvas id="sales_chart"></canvas>

          <!-- Script pour afficher le graphique avec Chart.js -->
          <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
          <script>
            document.addEventListener("DOMContentLoaded", function() {
              var ctx = document.getElementById('sales_chart').getContext('2d');
              var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                  labels: ['Total Sales', 'Receipts', 'Expenses', 'Earnings'],
                  datasets: [{
                    label: 'Sales Data',
                    data: [<?= $totalSales; ?>, <?= $receipts; ?>, <?= $totalExpenses; ?>, <?= $earnings; ?>],
                    backgroundColor: ['blue', 'green', 'red', 'black']
                  }]
                },
                options: {
                  responsive: true
                }
              });
            });
          </script>










        </div>

        <?php
        include('connexion.php');
        $sql = "SELECT * FROM customers";
        $result = $conn->query($sql);
        ?>

        <!-- <div class="row" style="width: 100%">
          <div class="col-md-6 col-sm-6" style="width: 100%">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col">
                    <h5 class="card-title">Recent Invoices</h5>
                  </div>
                  <div class="col-auto">
                    <a
                      href="invoices.html"
                      class="btn-right btn btn-sm btn-outline-primary">
                      View All
                    </a>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-stripped table-hover">
                    <thead class="thead-light">
                      <tr>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Registered On</th>
                        <th class="text-right">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                      ?>
                          <tr>
                            <td>
                              <h2 class="table-avatar">
                                <a href="profile.html">
                                  <img
                                    class="avatar avatar-sm me-2 avatar-img rounded-circle"
                                    src="assets/img/user.jpeg"
                                    alt="User Image" />
                                  <?php echo htmlspecialchars($row['name_customer']); ?>
                                </a>
                              </h2>
                            </td>
                            <td><?php echo htmlspecialchars($row['email_customer']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone_customer']); ?></td>
                            <td><?php echo date("d M Y", strtotime($row['register_on'])); ?></td>
                            <td class="text-right">
                              <div class="dropdown dropdown-action">
                                <a
                                  href="#"
                                  class="action-icon dropdown-toggle"
                                  data-bs-toggle="dropdown"
                                  aria-expanded="false">
                                  <i class="fas fa-ellipsis-h"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a
                                    class="dropdown-item"
                                    href="edit-invoice.html">
                                    <i class="far fa-edit me-2"></i>Edit
                                  </a>
                                  <a
                                    class="dropdown-item"
                                    href="view-invoice.html">
                                    <i class="far fa-eye me-2"></i>View
                                  </a>
                                  <a
                                    class="dropdown-item"
                                    href="javascript:void(0);">
                                    <i class="far fa-trash-alt me-2"></i>Delete
                                  </a>
                                  <a
                                    class="dropdown-item"
                                    href="javascript:void(0);">
                                    <i class="far fa-check-circle me-2"></i>Mark as sent
                                  </a>
                                  <a
                                    class="dropdown-item"
                                    href="javascript:void(0);">
                                    <i class="far fa-paper-plane me-2"></i>Send Invoice
                                  </a>
                                  <a
                                    class="dropdown-item"
                                    href="javascript:void(0);">
                                    <i class="far fa-copy me-2"></i>Clone Invoice
                                  </a>
                                </div>
                              </div>
                            </td>
                          </tr>
                      <?php
                        }
                      } else {
                        echo "<tr><td colspan='5'>No customers found.</td></tr>";
                      }
                      ?>
                    </tbody>
                  </table>
                </div>

              </div>
            </div>
          </div>
        </div> -->
      </div>
    </div>
  </div>

  <?php
  include('script.php');
  ?>






</body>

</html>