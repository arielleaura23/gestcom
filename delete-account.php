<!DOCTYPE html>
<html lang="en">

<?php
include('head.php');
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
                                <li class="breadcrumb-item"><a href="home.php">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Delete Account</li>
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
                                    <a href="preferences.php" class="nav-link ">
                                        <i class="fas fa-cog"></i> <span>Preferences</span>
                                    </a>
                                </li>
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
                                    <a href="delete-account.php" class="nav-link active">
                                        <i class="fas fa-ban"></i> <span>Delete Account</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-9 col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Delete your account</h5>
                            </div>
                            <div class="card-body">

                                <?php
                                include('connexion.php');
                                session_start(); // Assurez-vous que la session est démarrée

                                if (isset($_SESSION['username'])) {

                                    $username = ($_SESSION['username']);
                                    $sql = "SELECT * FROM users WHERE username = '$username' ";
                                    $result = $conn->query($sql);
                                    $user = $result->fetch_assoc();

                                    $user_id = $user['id'];

                                    if (isset($_POST['delete_btn'])) {
                                        // Check if the checkbox is checked
                                        if (isset($_POST['delete_account'])) {
                                            // Delete user from the database
                                            $sql = "DELETE FROM users WHERE id = ?";
                                            if ($stmt = $conn->prepare($sql)) {
                                                $stmt->bind_param("i", $user_id);
                                                if ($stmt->execute()) {
                                                    // Logout the user and destroy session
                                                    session_destroy();
                                                    // Ensure the user is logged out and no further database interaction occurs
                                                    header("Location: index.php?status=success_delete");
                                                    exit;
                                                } else {
                                                    echo "<script>alert('Error: Could not delete the account.'); window.history.back();</script>";
                                                }
                                            } else {
                                                echo "<script>alert('Error: Could not prepare the statement.'); window.history.back();</script>";
                                            }
                                        } else {
                                            echo "<script>alert('Error: You must confirm account deletion.'); window.history.back();</script>";
                                        }
                                    }
                                } else {
                                    echo "<script>alert('Error: You must be logged in to delete your account.'); window.history.back();</script>";
                                }

                                $conn->close();
                                ?>


                                <form method="POST" action="">
                                    <p class="card-text">When you delete your account, you lose access to Kanakku account services, and we permanently delete your personal data.</p>
                                    <p class="card-text">Are you sure you want to close your account?</p>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="delete_account" name="delete_account" required>
                                            <label class="custom-control-label text-danger" for="delete_account">Confirm that I want to delete my account.</label>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-danger" name="delete_btn">Delete Account</button>
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
    <script src="assets/js/script.js"></script>
</body>

</html>