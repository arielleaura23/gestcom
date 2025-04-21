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

        <?php if (isset($_GET['status']) && $_GET['status'] === 'upload_error') : ?>
            <script src="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var notyf = new Notyf();
                    notyf.error('upload image error');
                });
            </script>
        <?php elseif (isset($_GET['status']) && $_GET['status'] === 'invalid_file') : ?>
            <script src="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var notyf = new Notyf();
                    notyf.error('invalid file');
                });
            </script>
        <?php endif; ?>


        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="page-title">Settings</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Profile Settings</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-md-4">

                        <div class="widget settings-menu">
                            <ul>
                                <li class="nav-item">
                                    <a href="settings.php" class="nav-link active">
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
                                    <a href="notifications.php" class="nav-link">
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
                                <h5 class="card-title">Basic information</h5>
                            </div>
                            <div class="card-body">

                                <?php
                                include('connexion.php');
                                if (isset($_SESSION['username'])) {
                                    $username = ($_SESSION['username']);
                                    $sql = "SELECT * FROM users WHERE username = '$username' ";
                                    $result = $conn->query($sql);

                                    $user = $result->fetch_assoc();
                                } else {
                                    $username = 'Charles Hafner';
                                }

                                ?>
                                <form method="post" enctype="multipart/form-data" action="save_profile.php">
                                    <div class="row form-group">
                                        <label for="name" class="col-sm-3 col-form-label input-label">image</label>
                                        <div class="col-sm-9">
                                            <div class="d-flex align-items-center">
                                                <label class="avatar avatar-xxl profile-cover-avatar m-0" for="edit_img">
                                                    <img id="avatarImg" class="avatar-img"
                                                        src="<?php echo (!empty($user['image']) ? 'assets/photos/' . $user['image'] : 'assets/img/user.jpeg'); ?>"
                                                        alt="Profile Image">
                                                    <input type="file" name="image" id="edit_img" accept="image/*">
                                                    <span class="avatar-edit">
                                                        <i data-feather="edit-2" class="avatar-uploader-icon shadow-soft"></i>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label for="name" class="col-sm-3 col-form-label input-label">Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Your Name"
                                                value="<?php
                                                        if (isset($_SESSION['username'])) {
                                                            echo ($_SESSION['username']);
                                                        } else {
                                                            echo 'Charles Hafner';
                                                        }
                                                        ?>">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label for="email" class="col-sm-3 col-form-label input-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" name="email" id="email" placeholder="Email"
                                                value="<?php
                                                        if (isset($_SESSION['username'])) {
                                                            echo ($user['email']);
                                                        } else {
                                                            echo 'Charles@gmail.com';
                                                        }
                                                        ?>">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label for="phone" class="col-sm-3 col-form-label input-label">Phone <span class="text-muted"></span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="phone" id="phone" placeholder="690116784"
                                                value="<?php
                                                        if (isset($user['phone'])) {
                                                            echo ($user['phone']);
                                                        } else {
                                                            echo '690116784';
                                                        }
                                                        ?>">
                                        </div>
                                    </div>
                                    <!-- <div class="row form-group">
                                        <label for="location" class="col-sm-3 col-form-label input-label">Location</label>
                                        <div class="col-sm-9">
                                            <div class="mb-3">
                                                <input type="text" class="form-control" id="location" placeholder="Country" value="United States">
                                            </div>
                                            <div class="mb-3">
                                                <input type="text" class="form-control" placeholder="City" value="Charleston">
                                            </div>
                                            <input type="text" class="form-control" placeholder="State" value="West Virginia">
                                        </div>
                                    </div> -->
                                    <div class="row form-group">
                                        <label for="addressline1" class="col-sm-3 col-form-label input-label">Address</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="address" id="addressline1" placeholder="Your address"
                                                value="<?php
                                                        if (isset($user['address'])) {
                                                            echo ($user['address']);
                                                        } else {
                                                            echo 'Charles de gaule';
                                                        }
                                                        ?>">
                                        </div>
                                    </div>
                                    <!-- <div class="row form-group">
                                        <label for="addressline2" class="col-sm-3 col-form-label input-label">Address line 2 <span class="text-muted">(Optional)</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="addressline2" placeholder="Your address">
                                        </div>
                                    </div> -->

                                    <div class="text-end">
                                        <button type="submit" name="save_profile" class="btn btn-primary">Save Changes</button>
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