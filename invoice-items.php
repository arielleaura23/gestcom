<!DOCTYPE html>
<html lang="en">

<?php
session_start();
?>

<?php
include('head.php');
include('connexion.php');

if (isset($_GET["delete"])) {
  extract($_GET);

  $confirmDelet = $conn->query("DELETE FROM items WHERE id = '$delete'");

  if (isset($confirmDelet)) {
    echo '<script src="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.js"></script>';
    echo "<script>
      document.addEventListener('DOMContentLoaded', function() {
        var notyf = new Notyf();
        notyf.success('Item has been successfully deleted.');
      });
    </script>";
  }
}

?>

<?php
include('connexion.php');
if (isset($_GET["edit"])) {
  extract($_GET);

  $conn->query("DELETE FROM items WHERE id = '$delete'");
?>
  <script>
    window.location.href = "invoice-items.php";
  </script>
<?php

}
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
              <h3 class="page-title">Items</h3>
              <ul class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="home.php">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Items List</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="card invoices-tabs-card">
          <div class="card-body card-body pt-0 pb-0">
            <div class="invoices-items-main-tabs">
              <div class="row align-items-center">
                <div class="col-lg-12 col-md-12">
                  <div class="invoices-items-tabs">
                    <ul>
                      <li>
                        <a href="invoice-items.php" class="active">All Items</a>
                      </li>
                      <li><a href="invoice-category.php">Category</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card invoices-tabs-card">
          <div class="card-body card-body pt-0 pb-0">
            <div class="invoices-main-tabs border-0 pb-0">
              <div class="row align-items-center">
                <div class="col-lg-12 col-md-12">
                  <div
                    class="invoices-settings-btn invoices-settings-btn-one">
                    <a
                      href="#"
                      class="btn"
                      data-bs-toggle="modal"
                      data-bs-target="#add_items">
                      <i data-feather="plus-circle"></i> Add New Item
                    </a>
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

                  // Récupérer les articles depuis la base de données
                  $sql = "SELECT * FROM items ORDER BY created_at DESC";
                  $stmt = $conn->query($sql);

                  // Récupérer tous les articles sous forme de tableau associatif
                  $articles = [];
                  if ($stmt) {
                    while ($article = $stmt->fetch_assoc()) {
                      $articles[] = $article;
                    }
                  }
                  ?>



                  <table class="table table-stripped table-hover datatable">
                    <thead class="thead-light">
                      <tr>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Price Per Unit</th>
                        <th>Quantity</th>
                        <th>Description</th>
                        <th>Price of sale</th>
                        <th>Date Added</th>
                        <th class="text-end">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (!empty($articles)): ?>
                        <?php foreach ($articles as $article): ?>
                          <tr>
                            <td>
                              </label>
                              <a href="#" class="items-links"><?= htmlspecialchars($article['item_name']) ?></a>
                            </td>
                            <input type="hidden" name="existing_image" id="existing_image" value="<?= htmlspecialchars($article['item_image']) ?>" />
                            <td>
                              <?php if (!empty($article['item_image'])): ?>
                                <img src="<?= htmlspecialchars($article['item_image']) ?>" alt="Image" width="50" height="50">
                              <?php else: ?>
                                No Image
                              <?php endif; ?>
                            </td>

                            <?php
                            include('connexion.php');

                            $sql = "SELECT * FROM preferences";
                            $stmt = $conn->query($sql);
                            $preference = $stmt->fetch_assoc();

                            $exchange_rate = isset($preference['exchange_rate']) ? (float) $preference['exchange_rate'] : 655.957; // Valeur par défaut

                            ?>

                            <?php
                            if (!function_exists('convertCurrency')) {
                              function convertCurrency($amount, $currency, $rate)
                              {
                                $amount = (float) str_replace(',', '.', $amount); // Convertit en float et gère les virgules
                                if ($currency === 'euro') {
                                  return number_format($amount / $rate, 2, '.', '') . ' €';
                                } else {
                                  return number_format($amount, 0, '.', ' ') . ' FCFA';
                                }
                              }
                            }


                            ?>




                            <td><?= htmlspecialchars($article['item_category']) ?></td>
                            <td class="text-primary"><?= convertCurrency($article['price_per_unit'], $preference['currency'], $exchange_rate) ?> </td>
                            <td><?= (int)$article['quantity_buyed'] ?></td>
                            <td class="items-text">
                              <?= htmlspecialchars($article['description'] ?: 'No description') ?>
                            </td>
                            <td class="text-primary"><?= convertCurrency($article['price_of_sale'], $preference['currency'], $exchange_rate) ?> </td>
                            <td><?= date('d M Y', strtotime($article['created_at'])) ?></td>
                            <td class="text-end">


                              <a href="#" class="btn btn-sm btn-white text-success me-2 edit-item-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#edit_items"
                                data-id="<?= $article['id'] ?>"
                                data-name="<?= htmlspecialchars($article['item_name']) ?>"
                                data-image="<?= htmlspecialchars($article['item_image']) ?>"
                                data-category="<?= htmlspecialchars($article['item_category']) ?>"
                                data-price="<?= htmlspecialchars($article['price_per_unit']) ?>"
                                data-quantity="<?= htmlspecialchars($article['quantity_buyed']) ?>"
                                data-sale-price="<?= htmlspecialchars($article['price_of_sale']) ?>"
                                data-currency="<?= $currency; ?>"
                                data-description="<?= htmlspecialchars($article['description']) ?>">

                                <i class="far fa-edit me-1"></i> Edit
                              </a>

                              <a
                                class="btn btn-sm btn-white text-danger"
                                href="?delete=<?= $article['id'] ?>"><i class="far fa-trash-alt me-1"></i>Delete</a>

                              <?php
                              include('connexion.php');

                              if (isset($_GET['id'])) {
                                $id = $_GET['id'];


                                // Récupérer les données de l'article depuis la base de données
                                $sql = "SELECT * FROM items WHERE id = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute([$id]);
                                $article = $stmt->fetch(PDO::FETCH_ASSOC);

                                if (!$article) {
                                  die("Article non trouvé");
                                }
                              }
                              include "update_item.php";
                              include "add_item.php";
                              ?>

                              <?php if (isset($_GET['status']) && $_GET['status'] === 'success') : ?>
                                <script src="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.js"></script>
                                <script>
                                  document.addEventListener('DOMContentLoaded', function() {
                                    var notyf = new Notyf();
                                    notyf.success('Item has been modified successfully.');
                                  });
                                </script>
                              <?php endif; ?>

                              <?php if (isset($_GET['status']) && $_GET['status'] === 'addedItem') : ?>
                                <script src="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.js"></script>
                                <script>
                                  document.addEventListener('DOMContentLoaded', function() {
                                    var notyf = new Notyf();
                                    notyf.success('Item has been registered successfully.');
                                  });
                                </script>
                              <?php endif; ?>

                              <?php if (isset($_GET['status']) && $_GET['status'] === 'error') : ?>
                                <script src="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.js"></script>
                                <script>
                                  document.addEventListener('DOMContentLoaded', function() {
                                    var notyf = new Notyf();
                                    notyf.error('Item has not been modified.');
                                  });
                                </script>
                              <?php endif; ?>

                              <!-- Modale de modification d'article -->
                              <div class="modal custom-modal fade bank-details" id="edit_items" role="dialog">
                                <form id="itemForm" method="POST" action="update_item.php" enctype="multipart/form-data">
                                  <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h4 class="mb-0">Edit Item</h4>


                                        <?php
                                        include('connexion.php');
                                        $sql_categories = "SELECT * FROM categories";
                                        $result_categories = $conn->query($sql_categories);
                                        ?>



                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <div class="row align-items-center">
                                          <!-- Champ caché pour l'ID de l'article -->
                                          <input type="hidden" name="id" value="<?= htmlspecialchars($article['id']) ?>" />
                                          <div class="col-lg-6">

                                            <div class="col-lg-12">
                                              <div class="form-group group">
                                                <label>Item Name</label>
                                                <input type="text" name="item_name" class="form-control" value="<?= htmlspecialchars($article['item_name']) ?>" required />
                                              </div>
                                            </div>
                                            <div class="col-lg-12">
                                              <div class="form-group group">
                                                <label>Image</label>
                                                <input type="file" name="image" class="form-control" accept="image/*" />

                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-lg-6">
                                            <div class="">
                                              <input type="hidden" name="existing_image" value="<?= htmlspecialchars($article['item_image']) ?>" />
                                              <img src="<?= htmlspecialchars($article['item_image']) ?>" class="card p-3 border-1 border-primary w-50 justify-content-start align-self-start" style="height: 50%;" alt="Current Image" />
                                            </div>
                                          </div>
                                          <div class="col-lg-6">
                                            <div class="form-group group">
                                              <label>Category</label>
                                              <select name="item_category" class="form-select form-control" required>
                                                <?php
                                                include('connexion.php');
                                                $sql_categories = "SELECT * FROM categories";
                                                $result_categories = $conn->query($sql_categories);
                                                ?>

                                                <?php
                                                // Vérifier si des catégories existent et les afficher dans le select
                                                if ($result_categories->num_rows > 0) {
                                                  while ($row = $result_categories->fetch_assoc()) {
                                                    echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                                                  }
                                                } else {
                                                  echo "<option value=''>Aucune catégorie disponible</option>";
                                                }
                                                ?>


                                              </select>
                                            </div>
                                          </div>
                                          <div class="col-lg-6">
                                            <div class="form-group group">
                                              <label>Price Per Unit</label>
                                              <input type="number" name="price_per_unit" class="form-control" value="<?= convertCurrency($article['price_per_unit'], $currency, $conversionRate) ?>" step="0.01" required />
                                            </div>
                                          </div>
                                          <div class="col-lg-6">
                                            <div class="form-group group">
                                              <label>Quantity</label>
                                              <input type="number" name="quantity" class="form-control" value="<?= htmlspecialchars($article['quantity_buyed']) ?>" required />
                                            </div>
                                          </div>
                                          <div class="col-lg-6">
                                            <div class="form-group group">
                                              <label>Price of Sale</label>
                                              <input type="number" name="price_of_sale" class="form-control" value="<?= convertCurrency($article['price_of_sale'], $preference['currency'], $exchange_rate) ?>" step="0.01" required />
                                            </div>
                                          </div>
                                          <div class="col-lg-12">
                                            <div class="form-group group">
                                              <label>Description (Optional)</label>
                                              <textarea name="description" class="form-control"><?= htmlspecialchars($article['description']) ?></textarea>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="modal-footer modal-btn">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" name="save_item" class="btn btn-primary">Save Item</button>
                                      </div>
                                    </div>
                                  </div>
                                </form>

                              </div>

                            </td>
                          </tr>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <tr>
                          <td colspan="9" class="text-center">No articles found</td>
                        </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div
      class="modal custom-modal fade bank-details"
      id="add_items"
      role="dialog">
      <form id="itemForm" method="POST" action="add_item.php" enctype="multipart/form-data">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="mb-0">Create New Item</h4>
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Item Name</label>
                    <input type="text" name="item_name" class="form-control" placeholder="Add New Item" required />
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*" />
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">

                    <?php
                    include('connexion.php');
                    $sql_categories = "SELECT * FROM categories";
                    $result_categories = $conn->query($sql_categories);
                    ?>


                    <label>Category</label>
                    <select name="item_category" class="form-select form-control" required>
                      <option value="">Select category</option>
                      <?php
                      // Vérifier si des catégories existent et les afficher dans le select
                      if ($result_categories->num_rows > 0) {
                        while ($row = $result_categories->fetch_assoc()) {
                          echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                        }
                      } else {
                        echo "<option value=''>Aucune catégorie disponible</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Price Per Unit</label>
                    <input type="number" name="price_per_unit" class="form-control" step="0.01" required />
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" name="quantity" class="form-control" required />
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Price of Sale</label>
                    <input type="number" name="price_of_sale" class="form-control" step="0.01" required />
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group">
                    <label>Description (Optional)</label>
                    <textarea name="description" class="form-control" placeholder="Add item description"></textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" name="save_item" class="btn btn-primary">Save Item</button>
            </div>
          </div>
        </div>
      </form>
    </div>

    <div class="modal custom-modal fade" id="delete_paid" role="dialog">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body">
            <div class="form-header">
              <h3>Delete Invoice Iems</h3>
              <p>Are you sure want to delete?</p>
            </div>
            <div class="modal-btn delete-action">
              <div class="row">
                <div class="col-6">
                  <a
                    href="javascript:void(0);"
                    class="btn btn-primary paid-continue-btn">Delete</a>
                </div>
                <div class="col-6">
                  <a
                    href="javascript:void(0);"
                    data-bs-dismiss="modal"
                    class="btn btn-primary paid-cancel-btn">Cancel</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <script>
    document.addEventListener("DOMContentLoaded", function() {
      document.querySelectorAll(".edit-item-btn").forEach(button => {
        button.addEventListener("click", function() {
          let modal = document.querySelector("#edit_items");

          // Récupération des données
          let id = this.getAttribute("data-id");
          let name = this.getAttribute("data-name");
          let image = this.getAttribute("data-image");
          let category = this.getAttribute("data-category");
          let price = this.getAttribute("data-price");
          let quantity = this.getAttribute("data-quantity");
          let salePrice = this.getAttribute("data-sale-price");
          let description = this.getAttribute("data-description");

          // Mise à jour des champs
          modal.querySelector("input[name='id']").value = id;
          modal.querySelector("input[name='item_name']").value = name;
          modal.querySelector("input[name='price_per_unit']").value = price;
          modal.querySelector("input[name='quantity']").value = quantity;
          modal.querySelector("input[name='price_of_sale']").value = salePrice;
          modal.querySelector("textarea[name='description']").value = description;

          // Mettre à jour l'image et le champ caché
          let imgPreview = modal.querySelector("img");
          let hiddenImageInput = modal.querySelector("input[name='existing_image']");

          if (image) {
            imgPreview.src = image;
            hiddenImageInput.value = image; // Mise à jour du champ caché
          } else {
            imgPreview.src = "default-image.jpg"; // Image par défaut si pas d'image
            hiddenImageInput.value = "default-image.jpg";
          }

          // Sélectionner la bonne catégorie
          let selectCategory = modal.querySelector("select[name='item_category']");
          for (let option of selectCategory.options) {
            if (option.value === category) {
              option.selected = true;
              break;
            }
          }
        });
      });
    });
  </script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      let modals = document.querySelectorAll(".edit-modal");

      modals.forEach((modal) => {
        modal.addEventListener("show.bs.modal", function(event) {
          let button = event.relatedTarget; // Bouton qui a déclenché la modale
          let price = button.getAttribute("data-raw-price"); // Prix brut en FCFA
          let currency = button.getAttribute("data-currency"); // Devise préférée (euro ou fcfa)

          let priceField = modal.querySelector("input[name='price_of_sale']");

          // Fonction de conversion
          function convertCurrency(amount, currency) {
            let conversionRate = 655.957;
            let convertedAmount;

            if (currency === "euro") {
              convertedAmount = (amount / conversionRate).toFixed(2);
              return convertedAmount + " €";
            } else {
              convertedAmount = parseInt(amount).toLocaleString("fr-FR");
              return convertedAmount + " FCFA";
            }
          }

          // Appliquer la conversion
          if (priceField) {
            priceField.value = convertCurrency(price, currency);
          }
        });
      });
    });
  </script>


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