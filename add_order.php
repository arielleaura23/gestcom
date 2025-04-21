<!DOCTYPE html>
<html lang="en">

<?php
include('head.php');
?>

<?php
session_start();
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
              <h3 class="page-title">Orders</h3>
              <ul class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="index.html">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="commandes.php">Orders</a>
                </li>
                <li class="breadcrumb-item active">Add Orders</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form id="orderForm" method="POST" action="save_order.php">
                  <!-- Informations du client -->
                  <h4>Client Information</h4>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Client Name<span style="color:red;"> *</span></label>
                        <input type="text" name="client_name" class="form-control" id="client_name" required />
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Phone<span style="color:red;"> *</span></label>
                        <input type="text" name="client_phone" class="form-control" id="client_phone" required />
                      </div>
                    </div>
                  </div>


                  <!-- Informations de commande -->
                  <h4>Order Information</h4>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Product<span style="color:red;"> *</span></label>
                        <input type="text" class="form-control" name="item_name"
                          id="item_name" required>

                      </div>
                      <div class="form-group">
                        <label>Quantity<span style="color:red;"> *</span></label>
                        <input type="number" name="quantity" id="quantity" class="form-control" min="1"
                          required />
                      </div>
                      <div class="form-group">
                        <label>Price Per Unit</label>
                        <input type="text" id="price_per_unit" name="price_per_unit"
                          class="form-control" readonly />
                      </div>
                      <div class="form-group">
                        <label>Total</label>
                        <input type="text" name="total" id="total" class="form-control" readonly />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Payment Method<span style="color:red;"> *</span></label>
                        <select name="payment_method" class="select" required>
                          <option value="">Select Payment Method</option>
                          <option value="mobile_money">Mobile Money</option>
                          <option value="orange_money">Orange Money</option>
                          <option value="cash">cash</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <!-- Adresse de livraison -->
                  <h4>Delivery Information</h4>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Do you want delivery?</label>
                        <select id="delivery_option" class="form-control">
                          <option value="no">No</option>
                          <option value="yes">Yes</option>
                        </select>
                      </div>

                    </div>

                    <div class="delivery_details" id="delivery_details" style="display: none;">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Delivery Address<span style="color:red;"> *</span></label>
                          <textarea name="delivery_address" id="delivery_address" readonly rows="5" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                          <label>Delivery Fee (FCFA)<span style="color:red;"> *</span></label>
                          <input type="number" name="delivery_fee" class="form-control" />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Special Instructions</label>
                          <textarea name="special_instructions" rows="5" class="form-control" placeholder="Enter Special Instructions"></textarea>
                        </div>
                      </div>
                    </div>

                  </div>


                  <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary">
                      Save Order
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

  <script src="assets/js/jquery-3.6.0.min.js"></script>

  <script src="assets/js/bootstrap.bundle.min.js"></script>

  <script src="assets/js/feather.min.js"></script>

  <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

  <script src="assets/plugins/select2/js/select2.min.js"></script>

  <script src="assets/js/script.js"></script>

  <?php
  include('script.php');
  ?>

  <script>
    // chercher les articles selon la saisie
    $(document).ready(function() {
      $("#item_name").autocomplete({
        source: function(request, response) {
          console.log("Term tapé : ", request.term); // Affiche le terme tapé
          $.ajax({
            url: "fetch_items.php",
            data: {
              term: request.term
            },
            success: function(data) {
              console.log("Réponse du serveur : ",
                data); // Affiche la réponse JSON
              response(JSON.parse(data));
            },
            error: function(err) {
              console.log("Erreur AJAX : ", err);
            }
          });
        },
        minLength: 2,
        select: function(event, ui) {
          console.log("Produit sélectionné : ", ui.item);
          $("#item_name").val(ui.item.value);
          $("#price_per_unit").val(ui.item.price);
          return false;
        }
      });


      // calculer le total en fonction de la quantite entree
      // Écouter les changements de quantité
      $("input[name='quantity']").on("input", function() {
        calculateTotal();
      });

      // Fonction pour calculer le total
      function calculateTotal() {
        const price = parseFloat($("#price_per_unit").val()) || 0; // Récupère le prix ou 0 par défaut
        const quantity = parseFloat($("input[name='quantity']").val()) || 0; // Récupère la quantité ou 0 par défaut
        const total = price * quantity; // Calcule le total
        $("input[name='total']").val(total.toFixed(2)); // Met à jour le champ Total avec 2 décimales
      }

      $(document).ready(function() {
        // Auto-complétion pour le champ Client Name
        $("#client_name").autocomplete({
          source: function(request, response) {
            $.ajax({
              url: "fetch_customers.php", // Fichier PHP qui récupère les clients depuis la base de données
              data: {
                term: request.term
              },
              success: function(data) {
                response(JSON.parse(data)); // Retourne les résultats sous forme de JSON
              },
              error: function(err) {
                console.log("Erreur AJAX : ", err);
              }
            });
          },
          minLength: 2, // L'utilisateur doit taper au moins 2 caractères avant de déclencher la recherche
          select: function(event, ui) {
            // Remplir les champs client avec les données sélectionnées
            $("#client_name").val(ui.item.value); // Nom du client
            $("#delivery_address").val(ui.item.address); // Adresse du client
            $("#client_phone").val(ui.item.phone); // Numéro de téléphone du client
            return false; // Empêche le comportement par défaut du champ
          }
        });
      });


      $(document).ready(function() {

        // Afficher ou cacher les détails de livraison
        $("#delivery_option").on("change", function() {
          if ($(this).val() === "yes") {
            $("#delivery_details").css("display", "flex"); // Appliquer display: flex
            $("#delivery_details").css("gap", "10px");
          } else {
            $("#delivery_details").css("display", "none"); // Cacher la div
            $("input[name='delivery_fee']").val(""); // Réinitialiser le champ des frais
          }
        });


      });






    });
  </script>
</body>

</html>