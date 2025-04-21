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
      <div class="content container-fluid">
        <div class="page-header">
          <div class="row">
            <div class="col-sm-12">
              <h3 class="page-title">Customers</h3>
              <ul class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="index.html">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="customers.html">Customers</a>
                </li>
                <li class="breadcrumb-item active">Add Customers</li>
              </ul>
            </div>
          </div>
        </div>

        <?php if (isset($_GET['status']) && $_GET['status'] === 'success') : ?>
          <script src="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.js"></script>
          <script>
            document.addEventListener('DOMContentLoaded', function() {
              var notyf = new Notyf();
              notyf.success('Customer has been registered successfully.');
            });
          </script>
        <?php elseif (isset($_GET['status']) && $_GET['status'] === 'error') : ?>
          <script src="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.js"></script>
          <script>
            document.addEventListener('DOMContentLoaded', function() {
              var notyf = new Notyf();
              notyf.error('There was an issue registering the customer.');
            });
          </script>
        <?php endif; ?>

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form
                  id="customerForm"
                  method="POST"
                  action="save_customer.php">
                  <!-- Basic Info -->
                  <h4>Basic Info</h4>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Name</label>
                        <input
                          type="text"
                          name="basic_name"
                          class="form-control" />
                        <span class="error-message text-danger"></span>
                      </div>
                      <div class="form-group">
                        <label>Email</label>
                        <input
                          type="email"
                          name="basic_email"
                          class="form-control" />
                        <span class="error-message text-danger"></span>
                      </div>
                      <!-- <div class="form-group">
                        <label>Primary Currency</label>
                        <select name="basic_currency" class="select">
                          <option value="">Select Currency</option>
                          <option value="EUR">EUR Euro</option>
                          <option value="INR">INR Indian Rupee</option>
                          <option value="USD">USD US Dollar</option>
                        </select>
                        <span class="error-message text-danger"></span>
                      </div> -->
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Phone</label>
                        <input
                          type="text"
                          name="basic_phone"
                          class="form-control" />
                        <span class="error-message text-danger"></span>
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
                          class="form-control" />
                        <span class="error-message text-danger"></span>
                      </div>
                      <div class="form-group">
                        <label>Address</label>
                        <textarea
                          name="billing_address"
                          rows="5"
                          class="form-control"
                          placeholder="Enter Address"></textarea>
                        <span class="error-message text-danger"></span>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Country</label>
                        <select name="billing_country" class="select">
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
                          class="form-control" />
                        <span class="error-message text-danger"></span>
                      </div>
                      <div class="form-group">
                        <label>Phone</label>
                        <input
                          type="text"
                          name="billing_phone"
                          class="form-control" />
                        <span class="error-message text-danger"></span>
                      </div>
                      <div class="form-group">
                        <label>Zip Code</label>
                        <input
                          type="text"
                          name="billing_zip"
                          class="form-control" />
                        <span class="error-message text-danger"></span>
                      </div>
                    </div>
                  </div>

                  <!-- Shipping Address -->
                  <h4>Shipping Address</h4>
                  <div class="text-end mt-4">
                    <button type="button" id="copyBillingAddress" class="btn btn-primary">
                      Copy billing address
                    </button>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Name:</label>
                        <input
                          type="text"
                          name="shipping_name"
                          id="shipping_name"
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
                          placeholder="Enter Address"></textarea>
                        <span class="error-message text-danger"></span>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Country:</label>
                        <select name="shipping_country" id="shipping_country" class="select">
                          <option value="">Select Country</option>
                          <option value="United States" selected>United States</option>
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
                          class="form-control" />
                        <span class="error-message text-danger"></span>
                      </div>
                      <div class="form-group">
                        <label>Phone:</label>
                        <input
                          type="text"
                          name="shipping_phone"
                          id="shipping_phone"
                          class="form-control" />
                        <span class="error-message text-danger"></span>
                      </div>
                      <div class="form-group">
                        <label>Zip Code:</label>
                        <input
                          type="text"
                          name="shipping_zip"
                          id="shipping_zip"
                          class="form-control" />
                        <span class="error-message text-danger"></span>
                      </div>
                    </div>
                  </div>

                  <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary">
                      Add Customer
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('copyBillingAddress').addEventListener('click', function() {
      // Affiche les valeurs avant de les copier
      console.log('Copy button clicked');
      console.log('Billing Name:', document.querySelector('[name="billing_name"]').value);
      console.log('Billing Address:', document.querySelector('[name="billing_address"]').value);

      // Copier les valeurs de facturation dans les champs de livraison
      document.getElementById('shipping_name').value = document.querySelector('[name="billing_name"]').value;
      document.getElementById('shipping_address').value = document.querySelector('[name="billing_address"]').value;
      document.getElementById('shipping_country').value = document.querySelector('[name="billing_country"]').value;
      document.getElementById('shipping_city').value = document.querySelector('[name="billing_city"]').value;
      document.getElementById('shipping_phone').value = document.querySelector('[name="billing_phone"]').value;
      document.getElementById('shipping_zip').value = document.querySelector('[name="billing_zip"]').value;

      // Affiche les valeurs après copie
      console.log('Shipping Name:', document.getElementById('shipping_name').value);
      console.log('Shipping Address:', document.getElementById('shipping_address').value);
    });
  </script>


  <script>
    document.getElementById('customerForm').addEventListener('submit', function(event) {
      event.preventDefault(); // Empêche la soumission initialement
      let isValid = true;

      // Réinitialiser les messages d'erreur et les classes
      const errorMessages = document.querySelectorAll('.error-message');
      errorMessages.forEach(error => error.textContent = '');
      const inputs = document.querySelectorAll('input, select, textarea');
      inputs.forEach(input => input.classList.remove('error'));

      // Validation des champs
      const basicName = document.querySelector('[name="basic_name"]');
      const basicEmail = document.querySelector('[name="basic_email"]');
      const basicPhone = document.querySelector('[name="basic_phone"]');
      const billingName = document.querySelector('[name="billing_name"]');
      const billingAddress = document.querySelector('[name="billing_address"]');
      const billingCountry = document.querySelector('[name="billing_country"]');
      const billingCity = document.querySelector('[name="billing_city"]');
      const billingPhone = document.querySelector('[name="billing_phone"]');
      const billingZip = document.querySelector('[name="billing_zip"]');
      const shippingName = document.querySelector('[name="shipping_name"]');
      const shippingAddress = document.querySelector('[name="shipping_address"]');
      const shippingCountry = document.querySelector('[name="shipping_country"]');
      const shippingCity = document.querySelector('[name="shipping_city"]');
      const shippingPhone = document.querySelector('[name="shipping_phone"]');
      const shippingZip = document.querySelector('[name="shipping_zip"]');

      // Fonction pour afficher une erreur
      const showError = (field, message) => {
        const errorElement = field.parentElement.querySelector('.error-message');
        errorElement.textContent = message;
        field.classList.add('error'); // Ajouter la classe 'error'
        isValid = false;
      };

      // Validation des champs requis
      const requiredFields = [{
          field: basicName,
          message: "Name is required."
        },
        {
          field: basicEmail,
          message: "Email is required."
        },
        {
          field: basicPhone,
          message: "Phone is required."
        },
        {
          field: billingName,
          message: "Billing Name is required."
        },
        {
          field: billingAddress,
          message: "Billing Address is required."
        },
        {
          field: billingCountry,
          message: "Billing Country is required."
        },
        {
          field: billingCity,
          message: "Billing City is required."
        },
        {
          field: billingPhone,
          message: "Billing Phone is required."
        },
        {
          field: billingZip,
          message: "Billing Zip Code is required."
        },
        {
          field: shippingName,
          message: "Shipping Name is required."
        },
        {
          field: shippingAddress,
          message: "Shipping Address is required."
        },
        {
          field: shippingCountry,
          message: "Shipping Country is required."
        },
        {
          field: shippingCity,
          message: "Shipping City is required."
        },
        {
          field: shippingPhone,
          message: "Shipping Phone is required."
        },
        {
          field: shippingZip,
          message: "Shipping Zip Code is required."
        }
      ];

      requiredFields.forEach(({
        field,
        message
      }) => {
        if (field.value.trim() === '') {
          showError(field, message);
        }
      });

      // Validation de l'email
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (basicEmail.value.trim() !== '' && !emailRegex.test(basicEmail.value)) {
        showError(basicEmail, "Invalid email format.");
      }

      // Validation du téléphone
      const phoneRegex = /^[0-9]{9,}$/;
      [basicPhone, billingPhone, shippingPhone].forEach(field => {
        if (field.value.trim() !== '' && !phoneRegex.test(field.value)) {
          showError(field, "Phone numbers must be at least 10 digits and contain only numbers.");
        }
      });

      // Validation du code postal
      const zipRegex = /^[0-9]+$/;
      [billingZip, shippingZip].forEach(field => {
        if (field.value.trim() !== '' && !zipRegex.test(field.value)) {
          showError(field, "Zip codes must contain only numbers.");
        }
      });

      // Si tout est valide, soumettre le formulaire
      if (isValid) {
        this.submit();
      }
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

  <script src="assets/js/script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.js"></script>
</body>

</html>