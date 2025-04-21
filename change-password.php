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

        <?php if (isset($_GET['status']) && $_GET['status'] === 'success') : ?>
            <script src="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var notyf = new Notyf();
                    notyf.success('Password changed successfully.');
                });
            </script>
        <?php elseif (isset($_GET['status']) && $_GET['status'] === 'error') : ?>
            <script src="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var notyf = new Notyf();
                    notyf.error('There was an issue changing password.');
                });
            </script>
        <?php endif; ?>


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
                                <li class="breadcrumb-item active">Change Password</li>
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
                                    <a href="change-password.php" class="nav-link active">
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
                                <h5 class="card-title">Change Password</h5>
                            </div>
                            <div class="card-body">

                                <?php
                                // Inclure la connexion à la base de données
                                include('connexion.php');

                                if (!isset($_SESSION['username'])) {
                                    die("Vous devez être connecté.");
                                }

                                $message = "";
                                $username = $_SESSION['username'];

                                // Récupérer l'ID et le mot de passe hashé de l'utilisateur
                                $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
                                $stmt->bind_param("s", $username);
                                $stmt->execute();
                                $stmt->store_result();

                                if ($stmt->num_rows == 1) {
                                    $stmt->bind_result($user_id, $hashed_password);
                                    $stmt->fetch();
                                } else {
                                    die("Utilisateur introuvable.");
                                }
                                $stmt->close();

                                // Vérifications des champs de formulaire
                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    $current_password = trim($_POST['current_password']);
                                    $new_password = trim($_POST['new_password']);
                                    $confirm_password = trim($_POST['confirm_password']);

                                    // Variables d'erreur par champ
                                    $current_password_error = $new_password_error = $confirm_password_error = '';

                                    // Vérification du mot de passe actuel
                                    if (!password_verify($current_password, $hashed_password)) {
                                        $current_password_error = "⚠️ Mot de passe actuel incorrect.";
                                    }

                                    // Vérification des mots de passe
                                    if ($new_password != $confirm_password) {
                                        $new_password_error = "⚠️ Les mots de passe ne correspondent pas.";
                                    }

                                    if (empty($new_password)) {
                                        $new_password_error = "⚠️ Le mot de passe est requis.";
                                    }

                                    // Si tous les champs sont valides, on effectue la mise à jour
                                    if (empty($current_password_error) && empty($new_password_error) && empty($confirm_password_error)) {
                                        // Hasher le nouveau mot de passe
                                        $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                                        // Mise à jour du mot de passe en base de données
                                        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                                        $stmt->bind_param("si", $new_hashed_password, $user_id);

                                        if ($stmt->execute()) {
                                            $message = "✅ Mot de passe changé avec succès.";
                                        } else {
                                            $message = "⚠️ Erreur lors de la mise à jour.";
                                        }
                                        $stmt->close();
                                    }
                                }

                                $conn->close();
                                ?>


                                <form id="changePasswordForm" onsubmit="return validateForm()" method="POST" action="">
                                    <?php if (!empty($message)): ?>
                                        <p style="color: <?php echo strpos($message, '⚠️') !== false ? 'red' : 'green'; ?>;"><?php echo $message; ?></p>
                                    <?php endif; ?>


                                    <div class="row form-group">
                                        <label for="current_password" class="col-sm-3 col-form-label input-label">Current Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Enter current password">
                                            <?php if (!empty($current_password_error)): ?>
                                                <small class="text-danger" style=""><?php echo $current_password_error; ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label for="new_password" class="col-sm-3 col-form-label input-label">New Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" id="new_password" onkeyup="validatePassword()" name="new_password" placeholder="Enter new password">
                                            <div class="progress progress-md mt-2">
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="progressBar"></div>
                                            </div>
                                            <?php if (!empty($new_password_error)): ?>
                                                <small class="text-danger" style=""><?php echo $new_password_error; ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label for="confirm_password" class="col-sm-3 col-form-label input-label">Confirm new password</label>
                                        <div class="col-sm-9">
                                            <div class="mb-3">
                                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your new password">
                                            </div>
                                            <?php if (!empty($confirm_password_error)): ?>
                                                <small class="text-danger" style=""><?php echo $confirm_password_error; ?></small>
                                            <?php endif; ?>

                                            <h5>Password requirements:</h5>
                                            <p class="mb-2">Ensure that these requirements are met:</p>
                                            <ul class="list-unstyled small">
                                                <ul class="list-unstyled small">
                                                    <li id="lengthRequirement" class="text-danger">Minimum 8 characters long - the more, the better</li>
                                                    <li id="lowercaseRequirement" class="text-danger">At least one lowercase character</li>
                                                    <li id="uppercaseRequirement" class="text-danger">At least one uppercase character</li>
                                                    <li id="numberRequirement" class="text-danger">At least one number</li>
                                                    <li id="symbolRequirement" class="text-danger">At least one symbol</li>
                                                </ul>
                                            </ul>
                                        </div>
                                    </div>

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

    <script>
        function validatePassword() {
            var password = document.getElementById("new_password").value;
            var progressBar = document.getElementById("progressBar");
            var passwordError = document.getElementById("new_password_error");
            var lengthRequirement = document.getElementById("lengthRequirement");
            var lowercaseRequirement = document.getElementById("lowercaseRequirement");
            var uppercaseRequirement = document.getElementById("uppercaseRequirement");
            var numberRequirement = document.getElementById("numberRequirement");
            var symbolRequirement = document.getElementById("symbolRequirement");

            var conditionsMet = 0;

            // Conditions de validation
            var minLength = /.{8,}/; // Minimum 8 caractères
            var lowercase = /[a-z]/; // Au moins une lettre minuscule
            var uppercase = /[A-Z]/; // Au moins une lettre majuscule
            var digit = /\d/; // Au moins un chiffre
            var symbol = /[\W_]/; // Au moins un symbole (caractère spécial)

            // Vérification des conditions
            if (minLength.test(password)) {
                lengthRequirement.classList.remove('text-danger');
                lengthRequirement.classList.add('text-success');
                conditionsMet++;
            } else {
                lengthRequirement.classList.remove('text-success');
                lengthRequirement.classList.add('text-danger');
            }

            if (lowercase.test(password)) {
                lowercaseRequirement.classList.remove('text-danger');
                lowercaseRequirement.classList.add('text-success');
                conditionsMet++;
            } else {
                lowercaseRequirement.classList.remove('text-success');
                lowercaseRequirement.classList.add('text-danger');
            }

            if (uppercase.test(password)) {
                uppercaseRequirement.classList.remove('text-danger');
                uppercaseRequirement.classList.add('text-success');
                conditionsMet++;
            } else {
                uppercaseRequirement.classList.remove('text-success');
                uppercaseRequirement.classList.add('text-danger');
            }

            if (digit.test(password)) {
                numberRequirement.classList.remove('text-danger');
                numberRequirement.classList.add('text-success');
                conditionsMet++;
            } else {
                numberRequirement.classList.remove('text-success');
                numberRequirement.classList.add('text-danger');
            }

            if (symbol.test(password)) {
                symbolRequirement.classList.remove('text-danger');
                symbolRequirement.classList.add('text-success');
                conditionsMet++;
            } else {
                symbolRequirement.classList.remove('text-success');
                symbolRequirement.classList.add('text-danger');
            }

            // Calculer la progression de la barre
            var progress = (conditionsMet / 5) * 100; // 5 conditions
            progressBar.style.width = progress + "%";
            progressBar.setAttribute("aria-valuenow", progress);

            // Message d'erreur si les conditions ne sont pas remplies
            if (conditionsMet === 5) {
                passwordError.textContent = ""; // Effacer l'erreur
            } else {
                passwordError.textContent = "⚠️ Le mot de passe ne respecte pas toutes les conditions.";
            }
        }
    </script>

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