<!DOCTYPE html>
<html lang="en">

<?php
include('head.php');
?>

<body>

    <div class="main-wrapper">

        <?php
        session_start();
        ?>


        <?php
        include('sidebar.php');
        ?>


        <div class="page-wrapper">
            <div class="content container-fluid">

                <?php
                include('header.php');
                ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card invoices-add-card">
                            <div class="card-body">
                                <form action="insert-invoice.php" method="post" class="invoices-form">
                                    <div class="invoices-main-form">
                                        <div class="row" style="justify-content: space-between;">
                                            <div class="col-xl-4 col-md-6 col-sm-12 col-12">
                                                <div class="form-group">
                                                    <label for="customer">Select Customer</label>
                                                    <div class="multipleSelection">
                                                        <div class="selectbox">
                                                            <p class="mb-0" id="selected_customer">Select Customer</p>
                                                            <span class="down-icon"><i data-feather="chevron-down"></i></span>
                                                        </div>
                                                        <div id="checkboxes-one">
                                                            <p class="checkbox-title">Customer Search</p>
                                                            <div class="form-custom mb-3">
                                                                <input type="text" class="form-control bg-grey" placeholder="Enter Customer Name" id="customer_search" onkeyup="searchCustomer()">
                                                            </div>
                                                            <div class="selectbox-cont" id="customer-list">
                                                                <!-- Liste dynamique des clients -->
                                                                <?php
                                                                include 'connexion.php';

                                                                $query = "SELECT id, name_customer, phone_customer, billing_name, billing_address, billing_city, billing_country FROM customer_details ORDER BY name_customer ASC";
                                                                $result = $conn->query($query);

                                                                if ($result->num_rows > 0) {
                                                                    while ($row = $result->fetch_assoc()) {
                                                                        echo '<div class="customer-item" data-id="' . htmlspecialchars($row['id']) . '" 
                                                                        data-name="' . htmlspecialchars($row['name_customer']) . '" 
                                                                        data-number="' . htmlspecialchars($row['phone_customer']) . '" 
                                                                        data-billing-name="' . htmlspecialchars($row['billing_name']) . '"
                                                                        data-billing-address="' . htmlspecialchars($row['billing_address']) . '"
                                                                        data-billing-city="' . htmlspecialchars($row['billing_city']) . '"
                                                                        data-billing-country="' . htmlspecialchars($row['billing_country']) . '">
                                                                        ' . htmlspecialchars($row['name_customer']) . '
                                                                    </div>';
                                                                    }
                                                                } else {
                                                                    echo '<p>No customers found.</p>';
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <input type="hidden" name="customer_id" id="customer_id">

                                                <div class="form-group mt-3">
                                                    <label>Customer Number</label>
                                                    <input class="form-control" type="text" id="customer_number" readonly>
                                                </div>



                                            </div>

                                            <?php
                                            include 'connexion.php';

                                            // Récupérer le dernier numéro de facture
                                            $query = "SELECT invoice_number FROM invoices ORDER BY id DESC LIMIT 1";
                                            $result = $conn->query($query);
                                            $lastInvoice = $result->fetch_assoc();

                                            if ($lastInvoice) {
                                                // Extraire la partie numérique du dernier numéro de facture
                                                preg_match('/(\d+)/', $lastInvoice['invoice_number'], $matches);
                                                $lastNumber = (int)$matches[0];

                                                // Incrémenter le numéro
                                                $newInvoiceNumber = 'IN' . str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT) . '#@' . rand(10, 99);
                                            } else {
                                                // Si c'est la première facture, commencer à un numéro de base
                                                $newInvoiceNumber = 'IN000001#@09';
                                            }


                                            ?>


                                            <div class="col-xl-5 col-md-6 col-sm-12 col-12">
                                                <h4 class="invoice-details-title">Invoice details</h4>
                                                <div class="invoice-details-box">
                                                    <div class="invoice-inner-head">
                                                        <span>Invoice No. <a href="view-invoice.html"><?php echo $newInvoiceNumber; ?></a></span>
                                                        <input type="hidden" name="invoice_number" value="<?php echo $newInvoiceNumber; ?>" />
                                                    </div>
                                                    <div class="invoice-inner-footer">
                                                        <div class="row align-items-center">
                                                            <div class="col-lg-6 col-md-6">
                                                                <div class="facture_date">
                                                                    <span>
                                                                        Date <input class="form-control " name="invoice_date" type="date">
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="invoice-item">
                                        <div class="row" style="justify-content: space-between;">
                                            <div class="col-xl-4 col-lg-6 col-md-6">

                                            </div>
                                            <div class="col-xl-4 col-lg-6 col-md-6">
                                                <div class="invoice-info">
                                                    <strong class="customer-text">Invoice To</strong>
                                                    <p class="invoice-details invoice-details-two" id="invoice_to_details">
                                                        <!-- les infos du client -->
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="invoice-add-table">
                                        <h4>Item Details</h4>
                                        <div class="table-responsive">
                                            <table class="table table-center add-table-items">
                                                <thead>
                                                    <tr>
                                                        <th>Items</th>
                                                        <th>Category</th>
                                                        <th>Quantity</th>
                                                        <th>Price</th>
                                                        <th>Amount</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="add-row">

                                                        <td>
                                                            <input type="text" class="form-control item-name" name="item-name[]" id="item-name">
                                                            <input type="hidden" class="item-id" name="item_id[]"> <!-- Champ caché pour stocker l'ID -->
                                                            <div id="item-suggestions"></div> <!-- Suggestions list -->
                                                        </td>

                                                        <td>
                                                            <input readonly type="text" class="form-control category" name="category[]" id="category">
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control quantity" min="1" name="quantity[]" id="quantity">
                                                        </td>
                                                        <td>
                                                            <input readonly type="text" class="form-control price" name="price[]" id="price">
                                                        </td>
                                                        <td>
                                                            <input readonly type="text" class="form-control amount" name="amount[]" id="amount">
                                                        </td>
                                                        <td class="add-remove text-end">
                                                            <a href="javascript:void(0);" class="add-btn me-2"><i class="fas fa-plus-circle"></i></a>
                                                            <a href="#" class="copy-btn me-2"><i data-feather="copy"></i></a>
                                                            <a href="javascript:void(0);" class="remove-btn"><i data-feather="trash-2"></i></a>
                                                        </td>
                                                    </tr>


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row facture_summary">
                                        <div class="col-lg-5 col-md-6">
                                            <div class="invoice-total-card">
                                                <h4 class="invoice-total-title">Summary</h4>
                                                <button id="calculate-total-btn" type="button" class="btn btn-primary" style="margin-bottom: 10px;">Calculate Total</button>
                                                <div class="invoice-total-box">
                                                    <!-- <div class="invoice-total-inner">
                                                        <p>Taxable Amount <span>$21</span></p>
                                                        <p>Round Off
                                                            <input type="checkbox" id="status_1" class="check">
                                                            <label for="status_1" class="checktoggle">checkbox</label>
                                                            <span>$54</span>
                                                        </p>
                                                        <div class="links-info-one">
                                                            <div class="links-info">
                                                                <div class="links-cont">
                                                                    <a href="#" class="service-trash">
                                                                        <i class="feather-trash-2"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <a href="javascript:void(0);" class="add-links">
                                                            <i class="fas fa-plus-circle me-1"></i> Additional Charges
                                                        </a>
                                                        <div class="links-info-discount">
                                                            <div class="links-cont-discount">
                                                                <a href="javascript:void(0);" class="add-links-one">
                                                                    <i class="fas fa-plus-circle me-1"></i> Add more Discount
                                                                </a>
                                                                <a href="#" class="service-trash-one">
                                                                    <i class="feather-trash-2"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div> -->



                                                    <?php
                                                    include('connexion.php');

                                                    // Récupérer la devise préférée dans la base de données
                                                    $sql_prefs = "SELECT currency FROM preferences LIMIT 1";
                                                    $result_prefs = $conn->query($sql_prefs);
                                                    $preference = $result_prefs->fetch_assoc();

                                                    // Récupérer la devise à partir de la base de données (si elle existe, sinon utiliser un défaut)
                                                    $currency = isset($preference['currency']) ? $preference['currency'] : 'fcfa';
                                                    ?>




                                                    <div class="invoice-total-footer">
                                                        <h4>Total Amount <span id="total-amount"><?php echo strtoupper($currency) ?> 0.00</span></h4>
                                                    </div>
                                                    <div class="invoice-total-footer">

                                                        <h4 style="display: flex;justify-content: space-between;">paid advance <input style="width:100px;border: 0;border-bottom: 1px solid;" type="text" class=" advance" min="0" name="advance" id="advance"></h4>
                                                    </div>

                                                    <input type="hidden" name="total_amount" id="hidden-total-amount" value="0.00">

                                                </div>
                                            </div>
                                            <div class="upload-sign">
                                                <!-- <div class="form-group service-upload">
                                                    <span>Upload Sign</span>
                                                    <input type="file" multiple>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="Name of the Signatuaory">
                                                </div> -->
                                                <div class="form-group float-end mb-0">
                                                    <button class="btn btn-primary" type="submit">Save Invoice</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal custom-modal fade invoices-preview" id="invoices_preview" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="card invoice-info-card">
                                    <div class="card-body pb-0">
                                        <div class="invoice-item invoice-item-one">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="invoice-logo">
                                                        <img src="assets/img/logo.png" alt="logo">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="invoice-info">
                                                        <div class="invoice-head">
                                                            <h2 class="text-primary">Invoice</h2>
                                                            <p>Invoice Number : In983248782</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="invoice-item invoice-item-bg">
                                            <div class="invoice-circle-img">
                                                <img src="assets/img/invoice-circle1.png" alt="" class="invoice-circle1">
                                                <img src="assets/img/invoice-circle2.png" alt="" class="invoice-circle2">
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="invoice-info">
                                                        <strong class="customer-text-one">Billed to</strong>
                                                        <h6 class="invoice-name">Customer Name</h6>
                                                        <p class="invoice-details invoice-details-two">
                                                            9087484288 <br>
                                                            Address line 1, <br>
                                                            Address line 2 <br>
                                                            Zip code ,City - Country
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="invoice-info">
                                                        <strong class="customer-text-one">Invoice From</strong>
                                                        <h6 class="invoice-name">Company Name</h6>
                                                        <p class="invoice-details invoice-details-two">
                                                            9087484288 <br>
                                                            Address line 1, <br>
                                                            Address line 2 <br>
                                                            Zip code ,City - Country
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="invoice-info invoice-info-one border-0">
                                                        <p>Issue Date : 27 Jul 2022</p>
                                                        <p>Due Date : 27 Aug 2022</p>
                                                        <p>Due Amount : $1,54,22 </p>
                                                        <p>Recurring Invoice : 15 Months</p>
                                                        <p class="mb-0">PO Number : 54515454</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="invoice-item invoice-table-wrap">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table class="invoice-table table table-center mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th>Description</th>
                                                                    <th>Category</th>
                                                                    <th>Rate/Item</th>
                                                                    <th>Quantity</th>
                                                                    <th>Discount (%)</th>
                                                                    <th class="text-end">Amount</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Dell Laptop</td>
                                                                    <td>Laptop</td>
                                                                    <td>$1,110</td>
                                                                    <th>2</th>
                                                                    <th>2%</th>
                                                                    <td class="text-end">$400</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>HP Laptop</td>
                                                                    <td>Laptop</td>
                                                                    <td>$1,500</td>
                                                                    <th>3</th>
                                                                    <th>6%</th>
                                                                    <td class="text-end">$3,000</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Apple Ipad</td>
                                                                    <td>Ipad</td>
                                                                    <td>$11,500</td>
                                                                    <th>1</th>
                                                                    <th>10%</th>
                                                                    <td class="text-end">$11,000</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row align-items-center justify-content-center">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="invoice-payment-box">
                                                    <h4>Payment Details</h4>
                                                    <div class="payment-details">
                                                        <p>Debit Card XXXXXXXXXXXX-2541 HDFC Bank</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="invoice-total-card">
                                                    <div class="invoice-total-box">
                                                        <div class="invoice-total-inner">
                                                            <p>Taxable <span>$6,660.00</span></p>
                                                            <p>Additional Charges <span>$6,660.00</span></p>
                                                            <p>Discount <span>$3,300.00</span></p>
                                                            <p class="mb-0">Sub total <span>$3,300.00</span></p>
                                                        </div>
                                                        <div class="invoice-total-footer">
                                                            <h4>Total Amount <span>$143,300.00</span></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="invoice-sign-box">
                                            <div class="row">
                                                <div class="col-lg-8 col-md-8">
                                                    <div class="invoice-terms">
                                                        <h6>Notes:</h6>
                                                        <p class="mb-0">Enter customer notes or any other details</p>
                                                    </div>
                                                    <div class="invoice-terms mb-0">
                                                        <h6>Terms and Conditions:</h6>
                                                        <p class="mb-0">Enter customer notes or any other details</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4">
                                                    <div class="invoice-sign text-end">
                                                        <img class="img-fluid d-inline-block" src="assets/img/signature.png" alt="sign">
                                                        <span class="d-block">Harristemp</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal custom-modal fade bank-details" id="bank_details" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="form-header text-start mb-0">
                            <h4 class="mb-0">Add Bank Details</h4>
                        </div>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="bank-inner-details">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Account Holder Name</label>
                                        <input type="text" class="form-control" placeholder="Add Name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Bank name</label>
                                        <input type="text" class="form-control" placeholder="Add Bank name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>IFSC Code</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Account Number</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="bank-details-btn">
                            <a href="javascript:void(0);" data-bs-dismiss="modal" class="btn bank-cancel-btn me-2">Cancel</a>
                            <a href="javascript:void(0);" class="btn bank-save-btn">Save Item</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal custom-modal fade" id="delete_invoices_details" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Delete Invoice Details</h3>
                            <p>Are you sure want to delete?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-bs-dismiss="modal" class="btn btn-primary paid-continue-btn">Delete</a>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-bs-dismiss="modal" class="btn btn-primary paid-cancel-btn">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal custom-modal fade" id="save_invocies_details" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>Save Invoice Details</h3>
                            <p>Are you sure want to save?</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <div class="row">
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-bs-dismiss="modal" class="btn btn-primary paid-continue-btn">Save</a>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-bs-dismiss="modal" class="btn btn-primary paid-cancel-btn">Cancel</a>
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

    <script>
        function searchCustomer() {
            const searchInput = document.getElementById('customer_search').value.toLowerCase();
            const customerList = document.getElementById('customer-list');
            const customerItems = customerList.getElementsByClassName('customer-item');

            for (let i = 0; i < customerItems.length; i++) {
                const customerName = customerItems[i].textContent.toLowerCase();
                if (customerName.includes(searchInput)) {
                    customerItems[i].style.display = 'block';
                } else {
                    customerItems[i].style.display = 'none';
                }
            }
        }

        document.getElementById('customer-list').addEventListener('click', function(event) {
            if (event.target && event.target.classList.contains('customer-item')) {
                const selectedCustomer = event.target;
                const customerName = selectedCustomer.getAttribute('data-name');
                const customerNumber = selectedCustomer.getAttribute('data-number');
                const billingName = selectedCustomer.getAttribute('data-billing-name');
                const billingAddress = selectedCustomer.getAttribute('data-billing-address');
                const billingCity = selectedCustomer.getAttribute('data-billing-city');
                const billingCountry = selectedCustomer.getAttribute('data-billing-country');

                // Mettre à jour le texte affiché
                document.getElementById('selected_customer').textContent = customerName;

                // Mettre à jour le champ numéro du client
                document.getElementById('customer_number').value = customerNumber;

                // Mettre à jour les informations "Invoice To"
                document.getElementById('invoice_to_details').innerHTML =
                    'Name: ' + billingName + '<br>' +
                    'Address: ' + billingAddress + '<br>' +
                    'City: ' + billingCity + '<br>' +
                    'Country: ' + billingCountry + '<br>' +
                    'Phone: ' + customerNumber;

                // Cacher la liste après la sélection
                document.getElementById('checkboxes-one').style.display = 'none';
            }
        });
    </script>

    <script>
        document.getElementById('item-name').addEventListener('input', function() {
            let query = this.value.trim();

            // Si la recherche est vide, ne rien faire
            if (query.length < 1) {
                document.getElementById('item-suggestions').innerHTML = '';
                return;
            }

            // Requête AJAX vers fetch_items.php
            let xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_items.php?term=' + encodeURIComponent(query), true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    let suggestions = JSON.parse(xhr.responseText);
                    let suggestionsList = '';

                    suggestions.forEach(function(item) {
                        suggestionsList += `
                    <div class="suggestion-item" 
                        onclick="fillItemDetails(${item.id}, '${item.category}', ${item.price_of_sale}, '${item.currency}', '${item.formatted_price}')">
                        ${item.value}
                    </div>`;
                    });

                    document.getElementById('item-suggestions').innerHTML = suggestionsList;
                }
            };
            xhr.send();
        });

        // Fonction pour remplir les champs avec les détails de l'item
        function fillItemDetails(itemId, category, price, currency, formattedPrice) {
            document.getElementById('item-name').value = event.target.innerText.split(' - ')[0]; // Nom de l'item
            document.getElementById('category').value = category; // Catégorie
            document.getElementById('price').value = formattedPrice; // Prix affiché avec devise
            document.getElementById('amount').value = formattedPrice; // Montant initial (Prix * 1)
            $('.item-id').val(itemId); // Met l'id du produit dans l'input caché

            // Effacer la liste des suggestions
            document.getElementById('item-suggestions').innerHTML = '';
        }



        // Calculer le montant en fonction de la quantité
        document.getElementById('quantity').addEventListener('input', function() {
            let quantity = parseFloat(this.value) || 0; // Quantité (évite NaN)

            let priceField = document.getElementById('price');



            // Passer la devise récupérée dans PHP à JavaScript
            let currency = "<?php echo strtoupper($currency); ?>";


            // Supprimer la devise pour ne garder que le nombre
            let convertedPrice = parseFloat(priceField.value.replace(/[^0-9.]/g, '')) || 0;


            let amount = quantity * convertedPrice; // Calcul du montant

            // Ajouter la devise à l'affichage
            document.getElementById('amount').value = amount.toFixed(2) + ' ' + currency;
        });
    </script>

    <?php
    // passer le currency dans  le js des lignes dynamiques tres important
    include('connexion.php');

    $sql_prefs = "SELECT currency FROM preferences LIMIT 1";
    $result_prefs = $conn->query($sql_prefs);
    $preference = $result_prefs->fetch_assoc();

    $currency = isset($preference['currency']) ? strtoupper($preference['currency']) : 'FCFA';

    echo '<script>console.log("Devise envoyée par PHP :", "' . $currency . '");</script>';
    ?>

    <script>
        let currency = "<?php echo $currency; ?>";
    </script>


    <script>
        // Fonction pour récupérer le montant de la première ligne statique
        function calculerMontantPremiereLigne() {
            let montantPremier = parseFloat($("#amount").val()) || 0;
            return montantPremier;
        }

        // Fonction pour calculer le total sur toutes les lignes dynamiques
        function calculerMontantLignesDynamiques() {
            let total = 0;

            $(".add-table-items .add-row").each(function() {
                const montant = parseFloat($(this).find(".item-amount").val()) || 0;
                total += montant;
            });

            return total;
        }

        // Fonction pour calculer le montant total global (première ligne + lignes dynamiques)
        function calculerMontantGlobal() {
            let totalGlobal = calculerMontantPremiereLigne() + calculerMontantLignesDynamiques();

            // Utilisation de la devise dynamique dans l'affichage
            $("#total-amount").text(currency + " " + totalGlobal.toFixed(2)); // Affiche le montant avec la devise dynamique

            $("#hidden-total-amount").val(totalGlobal.toFixed(2));
        }

        // Ajouter un écouteur d'événement au bouton "Calculer"
        $(document).on("click", "#calculate-total-btn", calculerMontantGlobal);
    </script>

    <script>
        // recuperer l'id du client
        document.addEventListener("DOMContentLoaded", function() {
            const customerItems = document.querySelectorAll('.customer-item');
            const customerIdInput = document.getElementById('customer_id');

            customerItems.forEach(item => {
                item.addEventListener('click', function() {
                    const customerId = this.getAttribute('data-id');
                    customerIdInput.value = customerId;

                });
            });


        });
    </script>

    <script>
        $(document).on("input", "#advance", function() {
            let value = $(this).val().replace(",", "."); // Remplace la virgule par un point
            $(this).val(value);
        });
    </script>







</body>

</html>