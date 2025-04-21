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
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="page-title">Settings</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Notifications</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-md-4">

                        <div class="widget settings-menu">
                            <ul>
                                <li class="nav-item">
                                    <a href="settings.php" class="nav-link">
                                        <i class="far fa-user"></i> <span>Profile Settings</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="preferences.php" class="nav-link">
                                        <i class="fas fa-cog"></i> <span>Preferences</span>
                                    </a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a href="tax-types.html" class="nav-link">
                                        <i class="far fa-check-square"></i> <span>Tax Types</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="expense-category.html" class="nav-link">
                                        <i class="far fa-list-alt"></i> <span>Expense Category</span>
                                    </a>
                                </li> -->
                                <li class="nav-item">
                                    <a href="notifications.php" class="nav-link active">
                                        <i class="far fa-bell"></i> <span>Notifications</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="change-password.php" class="nav-link">
                                        <i class="fas fa-unlock-alt"></i> <span>Change Password</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="delete-account.php" class="nav-link">
                                        <i class="fas fa-ban"></i> <span>Delete Account</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <div class="col-xl-9 col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Notifications</h5>
                                <p>Which email notifications would you like to receive when something changes?</p>
                            </div>
                            <div class="card-body">

                                <form>
                                    <div class="row form-group">
                                        <label for="notificationmail" class="col-sm-3 col-form-label input-label">Send Notifications to</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" id="notificationmail">
                                        </div>
                                    </div>

                                    <!-- <label class="row form-group toggle-switch" for="notification_switch1">
                                        <span class="col-8 col-sm-9 toggle-switch-content ms-0">
                                            <span class="d-block text-dark">Invoice viewed</span>
                                            <span class="d-block text-muted">When your customer views the invoice sent via dashboard.</span>
                                        </span>
                                        <span class="col-4 col-sm-3">
                                            <input type="checkbox" class="toggle-switch-input" id="notification_switch1">
                                            <span class="toggle-switch-label ms-auto">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </span>
                                    </label>


                                    <label class="row form-group toggle-switch" for="notification_switch2">
                                        <span class="col-8 col-sm-9 toggle-switch-content ms-0">
                                            <span class="d-block text-dark">Estimate viewed</span>
                                            <span class="d-block text-muted">When your customer views the estimate sent via dashboard.</span>
                                        </span>
                                        <span class="col-4 col-sm-3">
                                            <input type="checkbox" class="toggle-switch-input" id="notification_switch2">
                                            <span class="toggle-switch-label ms-auto">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </span>
                                    </label> -->

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
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



    <script src="assets/js/jquery-3.6.0.min.js"></script>

    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/feather.min.js"></script>

    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <script src="assets/js/script.js"></script>
</body>

</html>