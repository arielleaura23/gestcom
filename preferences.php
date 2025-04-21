<!DOCTYPE html>
<html lang="en">
<?php
include('head.php');

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

        <?php if (isset($_GET['status']) && $_GET['status'] === 'success') : ?>
            <script src="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var notyf = new Notyf();
                    notyf.success('Preferences edited successfully.');
                });
            </script>
        <?php elseif (isset($_GET['status']) && $_GET['status'] === 'error') : ?>
            <script src="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var notyf = new Notyf();
                    notyf.error('There was an issue editing preferences.');
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
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Preferences</li>
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
                                    <a href="preferences.php" class="nav-link active">
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
                                <h5 class="card-title">Preferences</h5>
                            </div>
                            <div class="card-body">

                                <?php
                                include('connexion.php');

                                // Récupérer les préférences actuelles depuis la base de données
                                $sql = "SELECT * FROM preferences";
                                $stmt = $conn->query($sql);
                                $preferences = $stmt->fetch_assoc();
                                ?>

                                <form action="save_preferences.php" method="post">
                                    <div class="row form-group">
                                        <label for="currencyLabel" class="col-sm-3 col-form-label input-label">Currency</label>
                                        <div class="col-sm-9">
                                            <select class="select" id="currencyLabel" name="currency">
                                                <option value="fcfa" <?= ($preferences['currency'] == 'FCFA') ? 'selected' : '' ?>>FCFA</option>
                                                <option value="euro" <?= ($preferences['currency'] == 'EURO') ? 'selected' : '' ?>>EUR</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label for="languageLabel" class="col-sm-3 col-form-label input-label">Language</label>
                                        <div class="col-sm-9">
                                            <select class="select" id="languageLabel" name="language">
                                                <option value="english" <?= ($preferences['language'] == 'english') ? 'selected' : '' ?>>English</option>
                                                <option value="french" <?= ($preferences['language'] == 'french') ? 'selected' : '' ?>>French</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label for="appname" class="col-sm-3 col-form-label input-label">Appname</label>
                                        <div class="col-sm-9">
                                            <input type="text" value="<?= $preferences['app_name']; ?>" class="form-control" name="appname" id="appname">
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label for="financialyear" class="col-sm-3 col-form-label input-label">Financial Year</label>
                                        <div class="col-sm-9">
                                            <select class="select" id="financialyear" name="financialyear">
                                                <?php
                                                $years = [
                                                    "january-december",
                                                    "february-january",
                                                    "march-february",
                                                    "april-march",
                                                    "may-april",
                                                    "june-may",
                                                    "july-june",
                                                    "august-july",
                                                    "september-august",
                                                    "october-september",
                                                    "november-october",
                                                    "december-november"
                                                ];

                                                foreach ($years as $year) {
                                                    $selected = ($preferences['financial_year'] == $year) ? 'selected' : '';
                                                    echo "<option value='$year' $selected>$year</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" name="save_preferences" class="btn btn-primary">Save Changes</button>
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

    <script src="assets/plugins/select2/js/select2.min.js"></script>

    <script src="assets/js/script.js"></script>
</body>

</html>