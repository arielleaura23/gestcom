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
							<h3 class="page-title">Invoice Grid</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
								<li class="breadcrumb-item active">Invoice Grid</li>
							</ul>
						</div>
						<div class="col-auto">
							<a href="add-invoice.php" class="btn btn-primary">
								<i class="fas fa-plus"></i>
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
							<div class="col-md-3">
								<div class="form-group">
									<label>Customer:</label>
									<input type="text" class="form-control">
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Status:</label>
									<select class="select">
										<option>Select Status</option>
										<option>Draft</option>
										<option>Sent</option>
										<option>Viewed</option>
										<option>Expired</option>
										<option>Accepted</option>
										<option>Rejected</option>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>From</label>
									<div class="cal-icon">
										<input class="form-control datetimepicker" type="text">
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>To</label>
									<div class="cal-icon">
										<input class="form-control datetimepicker" type="text">
									</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Invoice Number</label>
									<input type="text" class="form-control">
								</div>
							</div>
						</div>
					</div>
				</div>

				<?php
				include 'connexion.php';

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
					WHERE  advance = total_amount
                    GROUP BY invoices.id, customers.name_customer, invoices.advance
                    ORDER BY invoices.invoice_date DESC;
                    ";

				$result_invoices = $conn->query($sql_invoices);
				?>

				<div class="row">

					<?php
					if ($result_invoices->num_rows > 0) {
						while ($invoice = $result_invoices->fetch_assoc()) {
							$invoice_id = $invoice['id'];
							$invoice_number = $invoice['invoice_number'] ?? 'N/A';
							$invoice_date = isset($invoice['invoice_date']) ? date("d M Y", strtotime($invoice['invoice_date'])) : 'Date inconnue';
							$client_name = $invoice['customer_name'] ?? 'Client inconnu';
							$total_amount = $invoice['total_amount'] ?? 0; // Montant total des articles liés à la facture
							$advance = $invoice['advance'] ?? 0; // Montant de l'avance


			
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
							

							$total_amount = convertCurrency($total_amount, $currency, $conversionRate);
							$advance = convertCurrency($advance, $currency, $conversionRate);
			
			
						
			

							// Détermination du statut
							if ($advance == $total_amount) {
								$status = 'Paid';
								$status_class = 'bg-success-light';
								$edit_disabled = "disabled"; // Désactiver le bouton Edit
							} elseif ($advance < $total_amount && $advance > 0) {
								$status = 'Advanced (' . round(($advance / $total_amount) * 100, 2) . '%)';
								$status_class = 'bg-warning-light';
								$edit_disabled = ""; // Edit activé
							} else {
								$status = 'Unpaid';
								$status_class = 'bg-danger-light';
								$edit_disabled = "";
							}

							echo '					<div class="col-sm-6 col-lg-4 col-xl-3">
						<div class="card">
							<div class="card-body">
								<div class="inv-header mb-3">
									<a href="#" class="avatar avatar-sm me-2">
										<img class="avatar-img rounded-circle" src="assets/img/user.jpeg" alt="User Image">
									</a>
									<a class="text-dark" href="profile.html">' . $client_name . '</a>
								</div>
								<div class="invoice-id mb-3">
									<a  href="view-invoice.php?id=' . $invoice_id . '" class="text-primary btn-link">' . $invoice_number . '</a>
								</div>
								<div class="row align-items-center">
									<div class="col">
										<span class="text-sm text-muted"><i class="far fa-money-bill-alt"></i> Amount</span>
										<h6 class="mb-0">' . ($total_amount) . ' </h6>
									</div>
									<div class="col-auto text-end">
										<span class="text-sm text-muted"><i class="far fa-calendar-alt"></i> Due Date</span>
										<h6 class="mb-0">' . $invoice_date . '</h6>
									</div>
								</div>
							</div>
							<div class="card-footer">
								<div class="row align-items-center">
									<div class="col-auto">
										<span class="badge bg-success-light ' . $status_class . '">' . $status . '</span>
									</div>
									<div class="col d-flex justify-content-end">
										<a href="view-invoice.php?id=' . $invoice_id . '" class="btn btn-light btn-sm me-2 rounded-pill circle-btn">
											<i class="far fa-eye"></i>
										</a>
										<a href="generate_invoice_pdf..php?id=' . $invoice_id . '" class="btn btn-light btn-sm rounded-pill circle-btn">
											<i class="fas fa-download"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>';
						}
					} else {
						echo 'Aucune facture trouvee';
					}
					?>



					<!-- <div class="col-sm-6 col-lg-4 col-xl-3">
						<div class="card">
							<div class="card-body">
								<div class="inv-header mb-3">
									<a href="profile.html" class="avatar avatar-sm me-2">
										<img class="avatar-img rounded-circle" src="assets/img/profiles/avatar-04.jpg" alt="User Image">
									</a>
									<a class="text-dark" href="profile.html">Barbara Moore</a>
								</div>
								<div class="invoice-id mb-3">
									<a href="view-invoice.html" class="text-primary btn-link">#20220001</a>
								</div>
								<div class="row align-items-center">
									<div class="col">
										<span class="text-sm text-muted"><i class="far fa-money-bill-alt"></i> Amount</span>
										<h6 class="mb-0">$118</h6>
									</div>
									<div class="col-auto text-end">
										<span class="text-sm text-muted"><i class="far fa-calendar-alt"></i> Due Date</span>
										<h6 class="mb-0">23 Nov, 2022</h6>
									</div>
								</div>
							</div>
							<div class="card-footer">
								<div class="row align-items-center">
									<div class="col-auto">
										<span class="badge bg-success-light">Paid</span>
									</div>
									<div class="col d-flex justify-content-end">
										<a href="view-invoice.html" class="btn btn-light btn-sm me-2 rounded-pill circle-btn">
											<i class="far fa-eye"></i>
										</a>
										<a href="#" class="btn btn-light btn-sm rounded-pill circle-btn">
											<i class="fas fa-download"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div> -->

				</div>
			</div>
		</div>


		<div class="right-side-views">
			<ul class="sticky-sidebar siderbar-view">
				<li class="sidebar-icons">
					<a class="toggle tipinfo open-layout open-siderbar" href="#" data-toggle="tooltip" data-placement="left" data-bs-original-title="Tooltip on left">
						<div class="tooltip-five ">
							<i data-feather="layout" class="feather-five"></i>
							<span class="tooltiptext">Check Layout</span>
						</div>
					</a>
				</li>
				<li class="sidebar-icons">
					<a class="toggle tipinfo open-settings open-siderbar" href="#" data-toggle="tooltip" data-placement="left" data-bs-original-title="Tooltip on left">
						<div class="tooltip-five">
							<i data-feather="settings" class="feather-five"></i>
							<span class="tooltiptext">Demo Settings</span>
						</div>
					</a>
				</li>
				<li class="sidebar-icons">
					<a class="toggle tipinfo" target="_blank" href="https://themeforest.net/item/kanakku-bootstrap-admin-html-template/29436291?s_rank=11" data-toggle="tooltip" data-placement="left" title="Tooltip on left">
						<div class="tooltip-five">
							<i data-feather="shopping-cart" class="feather-five"></i>
							<span class="tooltiptext">Buy Now</span>
						</div>
					</a>
				</li>
			</ul>
		</div>


		<div class="sidebar-layout">
			<div class="sidebar-content">
				<div class="sidebar-top">
					<div class="container-fluid">
						<div class="row  align-items-center">
							<div class="col-xl-6 col-sm-6 col-12">
								<div class="sidebar-logo">
									<a href="index.html" class="logo">
										<img src="assets/img/logo.png" alt="Logo" class="img-flex">
									</a>
								</div>
							</div>
							<div class="col-xl-6 col-sm-6 col-12">
								<a class="btn-closed" href="#"><i data-feather="x" class="feather-six"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="container-fluid">
					<div class="row  align-items-center">
						<h5 class="sidebar-title">Choose layout</h5>
						<div class="col-xl-6 col-sm-6 col-12">
							<div class="sidebar-image align-center">
								<img class="img-fliud" src="assets/img/demo-one.png" alt="demo">
							</div>
							<div class="row">
								<div class="col-lg-6 layout">
									<h5 class="layout-title">Demo 1</h5>
								</div>
								<div class="col-lg-6 layout">
									<label class="switch">
										<input type="checkbox" onclick="window.location.href='index.html'">
										<span class="slider round"></span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-xl-6 col-sm-6 col-12">
							<div class="sidebar-image align-center">
								<img class="img-fliud" src="assets/img/demo-two.png" alt="demo">
							</div>
							<div class="row">
								<div class="col-lg-6 layout">
									<h5 class="layout-title">Demo 2</h5>
								</div>
								<div class="col-lg-6 layout">
									<label class="switch">
										<input type="checkbox" onclick="window.location.href='index-two.html'">
										<span class="slider round"></span>
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="row  align-items-center">
						<div class="col-xl-6 col-sm-6 col-12">
							<div class="sidebar-image align-center">
								<img class="img-fliud" src="assets/img/demo-three.png" alt="demo">
							</div>
							<div class="row">
								<div class="col-lg-6 layout">
									<h5 class="layout-title">Demo 3</h5>
								</div>
								<div class="col-lg-6 layout">
									<label class="switch">
										<input type="checkbox" onclick="window.location.href='index-three.html'">
										<span class="slider round"></span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-xl-6 col-sm-6 col-12">
							<div class="sidebar-image align-center">
								<img class="img-fliud" src="assets/img/demo-four.png" alt="demo">
							</div>
							<div class="row">
								<div class="col-lg-6 layout">
									<h5 class="layout-title">Demo 4</h5>
								</div>
								<div class="col-lg-6 layout">
									<label class="switch">
										<input type="checkbox" onclick="window.location.href='index-four.html'">
										<span class="slider round"></span>
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="row  align-items-center">
						<div class="col-xl-6 col-sm-6 col-12">
							<div class="sidebar-image align-center">
								<img class="img-fliud" src="assets/img/demo-five.png" alt="demo">
							</div>
							<div class="row">
								<div class="col-lg-6 layout">
									<h5 class="layout-title">Demo 5</h5>
								</div>
								<div class="col-lg-6 layout">
									<label class="switch">
										<input type="checkbox" onclick="window.location.href='index-five.html'">
										<span class="slider round"></span>
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="row  align-items-center">
						<div class="reset-page text-center">
							<a href="index.html">
								<button type="button" class="sidebar-but"><i data-feather="refresh-cw"></i>
									<span>Reset Settings</span>
								</button>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>


		<div class="sidebar-settings">
			<div class="sidebar-content sticky-sidebar-one">
				<div class="sidebar-top">
					<div class="container-fluid">
						<div class="row  align-items-center ">
							<div class="col-xl-6 col-sm-6 col-12">
								<div class="sidebar-logo">
									<a href="index.html" class="logo">
										<img src="assets/img/logo.png" alt="Logo" class="img-flex">
									</a>
								</div>
							</div>
							<div class="col-xl-6 col-sm-6 col-12">
								<a class="btn-closed" href="#"><i data-feather="x" class="feather-six"></i></a>
							</div>
						</div>
					</div>
				</div>
				<div class="container-fluid">
					<div class="row  align-items-center">
						<h5 class="sidebar-title">Preview Setting</h5>
						<h5 class="sidebar-sub-title">Layout Type</h5>
						<div class="col-xl-3 col-sm-6">
							<div class="sidebar-image-one align-center">
								<img src="assets/img/layout-one.png" alt="layout">
							</div>
							<div class="row">
								<div class="col-lg-6 setting">
									<h5 class="setting-title">LTR</h5>
								</div>
								<div class="col-lg-6 setting">
									<label class="switch switch-one">
										<input type="checkbox" onclick="window.location.href='index.html'">
										<span class="slider slider-one round"></span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-sm-6">
							<div class="sidebar-image-one align-center">
								<img src="assets/img/layout-two.png" alt="layout">
							</div>
							<div class="row">
								<div class="col-lg-6 setting">
									<h5 class="setting-title">RTL</h5>
								</div>
								<div class="col-lg-6 setting">
									<label class="switch switch-one">
										<input type="checkbox" onclick="window.location.href='../template-rtl/index.html'">
										<span class="slider slider-one round"></span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-sm-6">
							<div class="sidebar-image-one align-center">
								<img src="assets/img/layout-three.png" alt="layout">
							</div>
							<div class="row">
								<div class="col-lg-6 setting">
									<h5 class="setting-title">BOX</h5>
								</div>
								<div class="col-lg-6 setting">
									<label class="switch switch-one">
										<input type="checkbox" onclick="window.location.href='index-three.html'">
										<span class="slider slider-one round"></span>
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="row  align-items-center">
						<h5 class="sidebar-sub-title">Sidebar Type</h5>
						<div class="col-xl-3 col-sm-6">
							<div class="sidebar-image-one align-center">
								<img src="assets/img/layout-four.png" alt="layout">
							</div>
							<div class="row">
								<div class="col-lg-6 setting">
									<h5 class="setting-title">Normal</h5>
								</div>
								<div class="col-lg-6 setting">
									<label class="switch switch-one">
										<input type="checkbox" onclick="window.location.href='index-two.html'">
										<span class="slider slider-one round"></span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-sm-6">
							<div class="sidebar-image-one align-center">
								<img src="assets/img/layout-five.png" alt="layout">
							</div>
							<div class="row">
								<div class="col-lg-6 setting">
									<h5 class="setting-title">Compact</h5>
								</div>
								<div class="col-lg-6 setting">
									<label class="switch switch-one">
										<input type="checkbox" onclick="window.location.href='index-five.html'">
										<span class="slider slider-one round"></span>
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="row  align-items-center">
						<h5 class="sidebar-sub-title">Header & Sidebar Style</h5>
						<div class="col-xl-3 col-sm-6">
							<div class="sidebar-color align-center">
								<span class="color-one"></span>
							</div>
							<div class="row">
								<div class="col setting">
									<h5 class="setting-title">White</h5>
								</div>
								<div class="col-auto setting">
									<label class="switch switch-one sidebar-type-two">
										<input type="checkbox">
										<span class="slider slider-one round"></span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-sm-6">
							<div class="sidebar-color align-center">
								<span class="color-two"></span>
							</div>
							<div class="row">
								<div class="col setting">
									<h5 class="setting-title">Lite</h5>
								</div>
								<div class="col-auto setting">
									<label class="switch switch-one sidebar-type-three">
										<input type="checkbox">
										<span class="slider slider-one round"></span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-sm-6">
							<div class="sidebar-color align-center">
								<span class="color-three"></span>
							</div>
							<div class="row">
								<div class="col setting">
									<h5 class="setting-title">Dark</h5>
								</div>
								<div class="col-auto setting">
									<label class="switch switch-one sidebar-type-four">
										<input type="checkbox">
										<span class="slider slider-one round"></span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-sm-6">
							<div class="sidebar-color align-center">
								<span class="color-eight"></span>
							</div>
							<div class="row">
								<div class="col setting">
									<h5 class="setting-title">Theme</h5>
								</div>
								<div class="col-auto setting">
									<label class="switch switch-one sidebar-type-five">
										<input type="checkbox">
										<span class="slider slider-one round"></span>
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="row  align-items-center">
						<h5 class="sidebar-sub-title">Primary Skin</h5>
						<div class="col-xl-6 col-sm-6">
							<div class="sidebar-color-one align-center">
								<span class="color-five"></span>
								<span class="color-four"></span>
								<span class="color-six"></span>
							</div>
							<div class="row">
								<div class="col-lg-6 setting">
									<h5 class="setting-title">Theme</h5>
								</div>
								<div class="col-lg-6 setting">
									<label class="switch switch-one primary-skin-one">
										<input type="checkbox">
										<span class="slider slider-one round"></span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-xl-6 col-sm-6">
							<div class="sidebar-color-one align-center">
								<span class="color-five"></span>
								<span class="color-two"></span>
								<span class="color-six"></span>
							</div>
							<div class="row">
								<div class="col-lg-6 setting">
									<h5 class="setting-title">Lite</h5>
								</div>
								<div class="col-lg-6 setting">
									<label class="switch switch-one primary-skin-two">
										<input type="checkbox">
										<span class="slider slider-one round"></span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-xl-6 col-sm-6">
							<div class="sidebar-color-one align-center">
								<span class="color-three"></span>
								<span class="color-four"></span>
								<span class="color-seven"></span>
							</div>
							<div class="row">
								<div class="col-lg-6 setting">
									<h5 class="setting-title">Dark</h5>
								</div>
								<div class="col-lg-6 setting">
									<label class="switch switch-one primary-skin-three">
										<input type="checkbox">
										<span class="slider slider-one round"></span>
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="row  align-items-center">
						<div class="col-xl-12 col-sm-12">
							<div class="reset-page text-center">
								<a href="index.html">
									<button type="button" class="sidebar-but"><i data-feather="refresh-cw"></i>
										<span>Reset Settings</span>
									</button>
								</a>
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