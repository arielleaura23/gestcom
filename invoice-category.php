<!DOCTYPE html>
<html lang="en">

<?php
include('head.php');
include('connexion.php');
include('db.php');
if (isset($_GET["delete"])) {
    extract($_GET);

    $conn->query("DELETE FROM categories WHERE id = '$delete'");
?>
    <script>
        window.location.href = "invoice-category.php";
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
                            <h3 class="page-title">Items </h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
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
                                            <li><a href="invoice-items.php">All Items</a></li>
                                            <li><a href="invoice-category.php" class="active">Category</a></li>
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
                                    <div class="invoices-settings-btn invoices-settings-btn-one">
                                        <a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#add_items">
                                            <i data-feather="plus-circle"></i> Add New Category
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
                                    <table class="table table-stripped table-hover datatable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Date Added</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = $conn->query("SELECT * FROM categories");
                                            while ($row = $sql->fetch_assoc()) {
                                            ?>
                                                <div class="modal custom-modal fade bank-details" id="edit_items<?= $row['id'] ?>" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <div class="form-header text-start mb-0">
                                                                    <h4 class="mb-0">Create New Category</h4>
                                                                </div>
                                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="" method="post">
                                                                <div class="modal-body">
                                                                    <div class="bank-inner-details">
                                                                        <div class="row">
                                                                            <div class="col-lg-12 col-md-12">
                                                                                <div class="form-group">
                                                                                    <label>Category Name</label>
                                                                                    <input type="text" value="<?= $row['name'] ?>" class="form-control" name="cat_name" placeholder="Add New Item">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-12 col-md-12">
                                                                                <div class="form-group">
                                                                                    <label>Category Description</label>
                                                                                    <textarea name="description" class="form-control"><?= $row['description'] ?></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <div class="bank-details-btn">
                                                                        <a href="javascript:void(0);" data-bs-dismiss="modal" class="btn bank-cancel-btn me-2">Cancel</a>
                                                                        <button type="submit" name="edit_cat" class="btn bank-save-btn">Save Item</button>
                                                                    </div>
                                                                </div>
                                                                <?php include "edit_category.php" ?>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <tr>
                                                    <td>
                                                        <a href="#" class="invoice-link"><?= $row["name"] ?></a>
                                                    </td>
                                                    <td class="items-text"><?= $row["description"] ?></td>
                                                    <td><?= $row["cate_added"] ?></td>
                                                    <td class="text-end">
                                                        <a href="" data-bs-toggle="modal" data-bs-target="#edit_items<?= $row['id'] ?>" class="btn btn-sm btn-white text-success me-2"><i class="far fa-edit me-1"></i> Edit</a>
                                                        <a class="btn btn-sm btn-white text-danger" href="?delete=<?= $row["id"] ?>"><i class="far fa-trash-alt me-1"></i>Delete</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal custom-modal fade bank-details" id="add_items" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="form-header text-start mb-0">
                            <h4 class="mb-0">Create New Category</h4>
                        </div>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="post">
                        <div class="modal-body">
                            <div class="bank-inner-details">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label>Category Name</label>
                                            <input type="text" class="form-control" name="cat_name" placeholder="Add New Item">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label>Category Description</label>
                                            <textarea name="description" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="bank-details-btn">
                                <a href="javascript:void(0);" data-bs-dismiss="modal" class="btn bank-cancel-btn me-2">Cancel</a>
                                <button type="submit" name="add_cat" class="btn bank-save-btn">Save Item</button>
                            </div>
                        </div>
                        <?php include "add_category.php" ?>
                    </form>
                </div>
            </div>
        </div>


        <!-- <div class="modal custom-modal fade" id="delete_paid" role="dialog">
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
                                    <a href="javascript:void(0);" class="btn btn-primary paid-continue-btn">Delete</a>
                                </div>
                                <div class="col-6">
                                    <a href="javascript:void(0);" data-bs-dismiss="modal" class="btn btn-primary paid-cancel-btn">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

    </div>

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