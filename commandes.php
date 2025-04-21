<!DOCTYPE html>
<html lang="en">
  <?php
      include('head.php');
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
                <h3 class="page-title">Orders</h3>
                <ul class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a href="home.php">Dashboard</a>
                  </li>
                  <li class="breadcrumb-item active">Orders</li>
                </ul>
              </div>
              <div class="col-auto">
                <a href="add_order.php" class="btn btn-primary me-1">
                  <i class="fas fa-plus"></i>
                </a>
                <a
                  class="btn btn-primary filter-btn"
                  href="javascript:void(0);"
                  id="filter_search"
                >
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

        <div class="row" style="width: 100%">
          <div class="col-md-6 col-sm-6" style="width: 100%">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col">
                    <h5 class="card-title">Recent Orders</h5>
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
        </div>
        </div>
      </div>
    </div>

<?php
    include('script.php');
?>
  </body>
</html>
