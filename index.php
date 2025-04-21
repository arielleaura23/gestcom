<!DOCTYPE html>
<html lang="en">

<?php
include('head.php');
session_start();
?>

<body>


  <?php if (isset($_GET['status']) && $_GET['status'] === 'success_delete') : ?>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var notyf = new Notyf();
        notyf.success('Account deleted.');
      });
    </script>

  <?php endif; ?>


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
        <!-- <img
          class="img-fluid logo-dark mb-2"
          src="assets/img/logo.png"
          alt="Logo" /> -->
        <div class="loginbox">
          <div class="login-right">
            <div class="login-right-wrap">
              <h1>Login</h1>
              <p class="account-subtitle">Access to our dashboard</p>

              <?php
              include("connexion.php");

              $message = "";

              if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
                $username = trim($_POST["username"]);
                $password = trim($_POST["password"]);

                // Préparer la requête SQL sécurisée
                $query_verify = $conn->prepare("SELECT password FROM users WHERE username = ?");
                $query_verify->bind_param("s", $username);
                $query_verify->execute();
                $query_verify->store_result();

                if ($query_verify->num_rows == 1) {
                  $query_verify->bind_result($hashed_password);
                  $query_verify->fetch();

                  // Vérifier le mot de passe hashé
                  if (password_verify($password, $hashed_password)) {
                    session_start();
                    $_SESSION['username'] = $username;
                    header("Location: home.php"); // Redirection après connexion
                    exit();
                  } else {
                    $message = "⚠️ Identifiants incorrects.";
                  }
                } else {
                  $message = "⚠️ Identifiants incorrects.";
                }
              }
              ?>

              <form action="" method="post">

                <?php if (!empty($message)): ?>
                  <p style="color: red;"><?php echo $message; ?></p>
                <?php endif; ?>

                <div class="form-group">
                  <label class="form-control-label">Username</label>
                  <input type="text" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                  <label class="form-control-label">Password</label>
                  <div class="pass-group">
                    <input type="password" name="password" class="form-control pass-input" required>
                    <span class="fas fa-eye toggle-password"></span>
                  </div>
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-6">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="cb1">
                        <label class="custom-control-label" for="cb1">Remember me</label>
                      </div>
                    </div>
                    <div class="col-6 text-end">
                      <a class="forgot-link" href="forgot-password.php">Forgot Password ?</a>
                    </div>
                  </div>
                </div>
                <button class="btn btn-lg btn-block btn-primary w-100" name="login" type="submit">Login</button>
                <div class="login-or">
                  <span class="or-line"></span>
                  <span class="span-or">or</span>
                </div>

                <div class="social-login mb-3">
                  <span>Login with</span>
                  <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a><a href="#" class="google"><i class="fab fa-google"></i></a>
                </div>

                <div class="text-center dont-have">Don't have an account yet? <a href="register.php">Register</a></div>
              </form>






            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="assets/js/jquery-3.6.0.min.js"></script>

  <script src="assets/js/bootstrap.bundle.min.js"></script>

  <script src="assets/js/feather.min.js"></script>

  <script src="assets/js/script.js"></script>
</body>

</html>