<!DOCTYPE html>
<html lang="en">

<?php
// Connexion à la base de données
require_once 'connexion.php'; // Fichier contenant la connexion à la base

// Récupérer l'ID du client depuis l'URL
$id = $_GET['id'] ?? null;

if (!$id) {
  die("Client ID is missing.");
}

// Récupérer les informations du client
$queryCustomer = "SELECT * FROM customers WHERE id = ?";
$queryDetails = "SELECT * FROM customer_details WHERE id = ?";

$stmtCustomer = $conn->prepare($queryCustomer);
$stmtCustomer->bind_param('i', $id);
$stmtCustomer->execute();
$resultCustomer = $stmtCustomer->get_result();
$customer = $resultCustomer->fetch_assoc();

$stmtDetails = $conn->prepare($queryDetails);
$stmtDetails->bind_param('i', $id);
$stmtDetails->execute();
$resultDetails = $stmtDetails->get_result();
$customerDetails = $resultDetails->fetch_assoc();

// Vérifier si le client existe
if (!$customer) {
  die("Customer not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<?php
include('head.php');
?>




<body class="nk-body bg-lighter npc-default has-sidebar no-touch nk-nio-theme">
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
          <div class="row">
            <div class="col-sm-12">
              <h3 class="page-title">Edit Customer</h3>
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="customers.php">Customers</a></li>
                <li class="breadcrumb-item active">Edit Customer</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form method="POST" action="update_customer.php">
                  <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

                  <h4>Basic Info</h4>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="basic_name" value="<?= htmlspecialchars($customer['name_customer']) ?>" class="form-control" />
                      </div>
                      <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="basic_email" value="<?= htmlspecialchars($customer['email_customer']) ?>" class="form-control" />
                      </div>
                      <!-- <div class="form-group">
                        <label>Primary Currency</label>
                        <select name="basic_currency" class="select">
                          <option value="">Select Currency</option>
                          <option value="EUR" <?= $customer['basic_currency'] === 'EUR' ? 'selected' : '' ?>>EUR Euro</option>
                          <option value="INR" <?= $customer['basic_currency'] === 'INR' ? 'selected' : '' ?>>INR Indian Rupee</option>
                          <option value="USD" <?= $customer['basic_currency'] === 'USD' ? 'selected' : '' ?>>USD US Dollar</option>
                        </select>
                      </div> -->
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="basic_phone" value="<?= htmlspecialchars($customer['phone_customer']) ?>" class="form-control" />
                      </div>
                    </div>
                  </div>

                  <!-- Billing Address -->
                  <h4>Billing Address</h4>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Name</label>
                        <input
                          type="text"
                          name="billing_name"
                          value="<?= htmlspecialchars($customerDetails['name_customer']) ?>"
                          class="form-control" />
                        <span class="error-message text-danger"></span>
                      </div>
                      <div class="form-group">
                        <label>Address</label>
                        <textarea
                          name="billing_address"
                          rows="5"
                          class="form-control"
                          placeholder="Enter Address"><?= htmlspecialchars($customerDetails['billing_address']) ?></textarea>
                        <span class="error-message text-danger"></span>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Country</label>
                        <select name="billing_country" class="form-control select">
                          <option value="">Select Country</option>
                          <option value="United States" selected>
                            United States
                          </option>
                          <!-- Add more countries -->
                        </select>
                        <span class="error-message text-danger"></span>
                      </div>
                      <div class="form-group">
                        <label>City</label>
                        <input
                          type="text"
                          name="billing_city"
                          value="<?= htmlspecialchars($customerDetails['billing_city']) ?>"
                          class="form-control" />
                        <span class="error-message text-danger"></span>
                      </div>
                      <div class="form-group">
                        <label>Phone</label>
                        <input
                          type="text"
                          name="billing_phone"
                          value="<?= htmlspecialchars($customerDetails['billing_phone']) ?>"
                          class="form-control" />
                        <span class="error-message text-danger"></span>
                      </div>
                      <div class="form-group">
                        <label>Zip Code</label>
                        <input
                          type="text"
                          name="billing_zip"
                          value="<?= htmlspecialchars($customerDetails['billing_zip']) ?>"
                          class="form-control" />
                        <span class="error-message text-danger"></span>
                      </div>
                    </div>
                  </div>

                  <!-- Shipping Address -->
                  <h4>Shipping Address</h4>
                  <!-- <div class="text-end mt-4">
                    <button type="button" id="copyBillingAddress" class="btn btn-primary">
                      Copy billing address
                    </button>
                  </div> -->

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Name:</label>
                        <input
                          type="text"
                          name="shipping_name"
                          id="shipping_name"
                          value="<?= htmlspecialchars($customerDetails['shipping_name']) ?>"
                          class="form-control" />
                        <span class="error-message text-danger"></span>
                      </div>
                      <div class="form-group">
                        <label>Address:</label>
                        <textarea
                          name="shipping_address"
                          id="shipping_address"
                          rows="5"
                          class="form-control"
                          placeholder="Enter Address"><?= htmlspecialchars($customerDetails['shipping_address']) ?></textarea>
                        <span class="error-message text-danger"></span>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Country:</label>
                        <select name="shipping_country" id="shipping_country" value="<?= htmlspecialchars($customerDetails['shipping_country']) ?>" class="form-control select">
                          <option value="">Select Country</option>
                          <option value="United States">United States</option>
                          <!-- Add more countries -->
                        </select>
                        <span class="error-message text-danger"></span>
                      </div>
                      <div class="form-group">
                        <label>City:</label>
                        <input
                          type="text"
                          name="shipping_city"
                          id="shipping_city"
                          value="<?= htmlspecialchars($customerDetails['shipping_city']) ?>"
                          class="form-control" />
                        <span class="error-message text-danger"></span>
                      </div>
                      <div class="form-group">
                        <label>Phone:</label>
                        <input
                          type="text"
                          name="shipping_phone"
                          id="shipping_phone"
                          value="<?= htmlspecialchars($customerDetails['shipping_phone']) ?>"
                          class="form-control" />
                        <span class="error-message text-danger"></span>
                      </div>
                      <div class="form-group">
                        <label>Zip Code:</label>
                        <input
                          type="text"
                          name="shipping_zip"
                          id="shipping_zip"
                          value="<?= htmlspecialchars($customerDetails['shipping_zip']) ?>"
                          class="form-control" />
                        <span class="error-message text-danger"></span>
                      </div>
                    </div>
                  </div>

                  <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update Customer</button>
                  </div>
                </form>
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