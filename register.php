<!DOCTYPE html>
<html lang="en">

<?php
include('head.php');
session_start();
?>

<body>

    <div class="main-wrapper login-body">
        <div class="login-wrapper">
            <div class="container">
                <a href="#" class="logo">

                    <?php
                    include('connexion.php');

                    $sql = "SELECT app_name FROM preferences";
                    $stmt = $conn->query($sql);
                    $logo = $stmt->fetch_assoc();
                    ?>


                    <h1 style="    color: #42cdff;margin: 10px 0;    text-align: center;">
                        <?php
                        if (isset($preference['app_name'])) {
                            echo $preference['app_name'];
                        } else {
                            echo 'GESTCOM';
                        }

                        ?>
                    </h1>
                    <!-- <img src="assets/img/logo.png" alt="Logo" /> -->
                </a>
                <!-- <img class="img-fluid logo-dark mb-2" src="assets/img/logo.png" alt="Logo"> -->
                <div class="loginbox">
                    <div class="login-right">
                        <div class="login-right-wrap">
                            <h1>Register</h1>
                            <p class="account-subtitle">Access to our dashboard</p>

                            <?php

                            include("connexion.php");

                            $message = '';
                            $username_error = '';
                            $email_error = '';
                            $password_error = '';
                            $confirm_password_error = '';

                            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                // Récupérer les données du formulaire
                                $username = trim($_POST['username']);
                                $email = trim($_POST['email']);
                                $password = trim($_POST['password']);
                                $confirm_password = trim($_POST['confirm_password']);

                                // Validation des champs
                                if (empty($username)) {
                                    $username_error = 'Le nom d\'utilisateur est requis.';
                                }

                                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                    $email_error = 'L\'adresse email est invalide.';
                                }

                                if ($password !== $confirm_password) {
                                    $confirm_password_error = 'Les mots de passe ne correspondent pas.';
                                }

                                // Si tous les champs sont valides
                                if (empty($username_error) && empty($email_error) && empty($confirm_password_error)) {
                                    // Hash du mot de passe
                                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                                    // Insertion dans la base de données
                                    $sql = "INSERT INTO users (email, username, password) VALUES (?, ?, ?)";
                                    $stmt = $conn->prepare($sql);

                                    if ($stmt) {
                                        // Lier les paramètres et exécuter la requête
                                        $stmt->bind_param("sss", $email, $username, $hashed_password);

                                        try {
                                            $result = $stmt->execute();

                                            if ($result) {
                                                $message = 'Inscription réussie ! ';
                                                $_SESSION['username'] = $username;
                                                header('Location: home.php');
                                                exit();
                                            } else {
                                                $message = 'Erreur lors de l\'inscription. Veuillez réessayer.';
                                            }
                                        } catch (mysqli_sql_exception $e) {
                                            $message = 'Erreur : ' . $e->getMessage();
                                        }
                                    } else {
                                        $message = 'Erreur dans la préparation de la requête.';
                                    }
                                }
                            }
                            ?>


                            <form action="" method="POST" onsubmit="return validateForm()">
                                <?php if (!empty($message)): ?>
                                    <p style="color: red;"><?php echo $message; ?></p>
                                <?php endif; ?>

                                <!-- Name -->
                                <div class="form-group">
                                    <label class="form-control-label">Name</label>
                                    <input class="form-control" type="text" name="username" id="username" required>
                                    <small id="username_error" class="text-danger"></small>
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label class="form-control-label">Email Address</label>
                                    <input class="form-control" type="email" name="email" id="email" required>
                                    <small id="email_error" class="text-danger"></small>
                                </div>

                                <!-- Password -->
                                <div class="form-group">
                                    <label class="form-control-label">Password</label>
                                    <input class="form-control" type="password" name="password" id="password" required onkeyup="validatePassword()">
                                    <div class="progress progress-md mt-2">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="progressBar"></div>
                                    </div>
                                    <small id="password_error" class="text-danger"></small>
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-group">
                                    <label class="form-control-label">Confirm Password</label>
                                    <input class="form-control" type="password" name="confirm_password" id="confirm_password" required>
                                    <small id="confirm_password_error" class="text-danger"></small>
                                </div>

                                <!-- Password Requirements -->
                                <h5>Password requirements:</h5>
                                <p class="mb-2">Ensure that these requirements are met:</p>
                                <ul class="list-unstyled small">
                                    <li id="lengthRequirement" class="text-danger">Minimum 8 characters long - the more, the better</li>
                                    <li id="lowercaseRequirement" class="text-danger">At least one lowercase character</li>
                                    <li id="uppercaseRequirement" class="text-danger">At least one uppercase character</li>
                                    <li id="numberRequirement" class="text-danger">At least one number</li>
                                    <li id="symbolRequirement" class="text-danger">At least one symbol</li>
                                </ul>

                                <!-- Submit Button -->
                                <div class="form-group mb-0">
                                    <button class="btn btn-lg btn-block btn-primary w-100" type="submit">Register</button>
                                </div>
                            </form>



                            <div class="login-or">
                                <span class="or-line"></span>
                                <span class="span-or">or</span>
                            </div>

                            <div class="social-login">
                                <span>Register with</span>
                                <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a><a href="#" class="google"><i class="fab fa-google"></i></a>
                            </div>

                            <div class="text-center dont-have">Already have an account? <a href="index.php">Login</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fonction de validation du mot de passe avec la barre de progression
        function validatePassword() {
            var password = document.getElementById("password").value;
            var progressBar = document.getElementById("progressBar");
            var passwordError = document.getElementById("password_error");
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

        // Fonction de validation du formulaire
        function validateForm() {
            var isValid = true;

            // Validation du nom
            var username = document.getElementById("username").value;
            if (username.trim() === "") {
                document.getElementById("username_error").textContent = "⚠️ Nom d'utilisateur requis.";
                isValid = false;
            } else {
                document.getElementById("username_error").textContent = "";
            }

            // Validation de l'email
            var email = document.getElementById("email").value;
            var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailPattern.test(email)) {
                document.getElementById("email_error").textContent = "⚠️ Adresse email invalide.";
                isValid = false;
            } else {
                document.getElementById("email_error").textContent = "";
            }

            // Validation du mot de passe
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            if (password !== confirmPassword) {
                document.getElementById("confirm_password_error").textContent = "⚠️ Les mots de passe ne correspondent pas.";
                isValid = false;
            } else {
                document.getElementById("confirm_password_error").textContent = "";
            }

            // Validation de la progression du mot de passe
            var progress = document.getElementById("progressBar").style.width.replace("%", "");
            if (progress < 100) {
                document.getElementById("password_error").textContent = "⚠️ Votre mot de passe ne répond pas à toutes les exigences.";
                isValid = false;
            }

            return isValid;
        }
    </script>



    <script src="assets/js/jquery-3.6.0.min.js"></script>

    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/feather.min.js"></script>

    <script src="assets/js/script.js"></script>
</body>

</html>