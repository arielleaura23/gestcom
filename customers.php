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
    include('header.php')
    ?>

    <?php
    include('sidebar.php');
    ?>

    <div class="page-wrapper">
      <div class="content container-fluid">
        <div class="page-header">
          <div class="row align-items-center">
            <div class="col">
              <h3 class="page-title">Customers</h3>
              <ul class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="home.php">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Customers</li>
              </ul>
            </div>
            <div class="col-auto">
              <a href="add-customer.php" class="btn btn-primary me-1">
                <i class="fas fa-plus"></i>
              </a>
              <a
                class="btn btn-primary filter-btn"
                href="javascript:void(0);"
                id="filter_search">
                <i class="fas fa-filter"></i>
              </a>
            </div>
          </div>
        </div>

        <div id="filter_inputs" class="card filter-card">
          <div class="card-body pb-0">
            <div class="row">
              <div class="col-sm-6 col-md-3">
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" class="form-control" />
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="form-group">
                  <label>Email</label>
                  <input type="text" class="form-control" />
                </div>
              </div>
              <div class="col-sm-6 col-md-3">
                <div class="form-group">
                  <label>Phone</label>
                  <input type="text" class="form-control" />
                </div>
              </div>
            </div>
          </div>
        </div>

        <?php
        include('connexion.php');
        $sql = "SELECT * FROM customers";
        $result = $conn->query($sql);
        ?>


        <?php if (isset($_GET['status']) && $_GET['status'] === 'success') : ?>
          <script src="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.js"></script>
          <script>
            document.addEventListener('DOMContentLoaded', function() {
              var notyf = new Notyf();
              notyf.success('Customer has been modified successfully.');
            });
          </script>

        <?php endif; ?>
        
        <?php if (isset($_GET['status']) && $_GET['status'] === 'deleted') : ?>
          <script src="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.js"></script>
          <script>
            document.addEventListener('DOMContentLoaded', function() {
              var notyf = new Notyf();
              notyf.success('Customer has been successfully deleted.');
            });
          </script>

        <?php endif; ?>

        <div class="row" style="width: 100%">
          <div class="col-md-6 col-sm-6" style="width: 100%">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col">
                    <h5 class="card-title">Recent Customers</h5>
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
                        <th class="text-center">Action</th>
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
                            <td class="text-end">
                              <!-- <a data-bs-toggle="modal" data-bs-target="#"
                                href="#"
                                class="btn btn-sm btn-white text-success me-2"><i class="far fa-eye me-2"></i>View
                              </a> -->

                              <a href="edit_customer.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-white text-success me-2"><i class="far fa-edit me-1"></i> Edit</a>


                              <a class="btn btn-sm btn-white text-danger" href="delete_customer.php?id=<?= $row['id']; ?>"><i class="far fa-trash-alt me-1"></i>Delete</a>


                              <?php
                              include('connexion.php');

                              if (isset($_GET['id'])) {
                                $id = $_GET['id'];

                                // Récupérer les données de l'article depuis la base de données
                                $sql = "SELECT * FROM items WHERE id = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute([$id]);
                                $article = $stmt->fetch();

                                if (!$article) {
                                  die("Article non trouvé");
                                }
                              }
                              include "update_item.php";
                              include "add_item.php";
                              ?>

                              <!-- Modale de modification d'article -->
                              <div class="modal custom-modal fade bank-details" id="add_items" role="dialog">
                                <form id="itemForm" method="POST" action="" enctype="multipart/form-data">
                                  <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h4 class="mb-0">Edit Item</h4>
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
                                              <img src="<?= htmlspecialchars($article['item_image']) ?>" class="card p-3 border-1 border-primary w-50 justify-content-start align-self-start" style="height: 50%;" alt="Current Image" />
                                            </div>
                                          </div>
                                          <div class="col-lg-6">
                                            <div class="form-group group">
                                              <label>Category</label>
                                              <select name="item_category" class="form-select form-control" required>
                                                <option value="GoMechanic Neutron 600" <?= $article['item_category'] == 'GoMechanic Neutron 600' ? 'selected' : '' ?>>GoMechanic Neutron 600</option>
                                                <option value="Car Wash Shampoo 250ml" <?= $article['item_category'] == 'Car Wash Shampoo 250ml' ? 'selected' : '' ?>>Car Wash Shampoo 250ml</option>
                                                <option value="Bosch 1300W High Pressure" <?= $article['item_category'] == 'Bosch 1300W High Pressure' ? 'selected' : '' ?>>Bosch 1300W High Pressure</option>
                                              </select>
                                            </div>
                                          </div>
                                          <div class="col-lg-6">
                                            <div class="form-group group">
                                              <label>Price Per Unit</label>
                                              <input type="number" name="price_per_unit" class="form-control" value="<?= htmlspecialchars($article['price_per_unit']) ?>" step="0.01" required />
                                            </div>
                                          </div>
                                          <div class="col-lg-6">
                                            <div class="form-group group">
                                              <label>Quantity</label>
                                              <input type="number" name="quantity" class="form-control" value="<?= htmlspecialchars($article['quantity']) ?>" required />
                                            </div>
                                          </div>
                                          <div class="col-lg-6">
                                            <div class="form-group group">
                                              <label>Price of Sale</label>
                                              <input type="number" name="price_of_sale" class="form-control" value="<?= htmlspecialchars($article['price_of_sale']) ?>" step="0.01" required />
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
                            <!-- <td class="text-right">
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
                            </td> -->
                          </tr>
                      <?php
                        }
                      } else {
                        echo "<tr><td class='text-center'  colspan='5'>No customers found.</td></tr>";
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