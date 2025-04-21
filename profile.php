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

        <?php if (isset($_GET['status']) && $_GET['status'] === 'success') : ?>
            <script src="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var notyf = new Notyf();
                    notyf.success('Profile edited successfully.');
                });
            </script>
        <?php elseif (isset($_GET['status']) && $_GET['status'] === 'error') : ?>
            <script src="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var notyf = new Notyf();
                    notyf.error('There was an issue editing profile.');
                });
            </script>
        <?php endif; ?>


        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="row justify-content-lg-center">
                    <div class="col-lg-10">

                        <div class="page-header">
                            <div class="row">
                                <div class="col">
                                    <h3 class="page-title">Profile</h3>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="home.php">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Profile</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="profile-cover">
                            <div class="profile-cover-wrap">

                                <img id="avatarImg" class="profile-cover-img" src="<?php echo (!empty($user['image']) ? 'assets/photos/' . $user['image'] : 'assets/img/user.jpeg'); ?>"
                                    alt="Profile Image">


                                <!-- <div class="cover-content">
                                    <div class="custom-file-btn">
                                        <input type="file" class="custom-file-btn-input" id="cover_upload">
                                        <label class="custom-file-btn-label btn btn-sm btn-white" for="cover_upload">
                                            <i class="fas fa-camera"></i>
                                            <span class="d-none d-sm-inline-block ms-1">Update Cover</span>
                                        </label>
                                    </div>
                                </div> -->

                            </div>
                        </div>

                        <?php


                        // // Définir le nom à afficher
                        // $displayName = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['name']) : "admin";
                        // // $displayEmail = isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : "admin@gmail.com";
                        // 
                        ?>

                        <div class="text-center mb-5">
                            <label class="avatar avatar-xxl profile-cover-avatar" for="avatar_upload">
                                <img id="avatar_upload" class="avatar-img" src="<?php echo (!empty($user['image']) ? 'assets/photos/' . $user['image'] : 'assets/img/user.jpeg'); ?>"
                                    alt="Profile Image">
                                <input type="file" id="avatar_upload">

                                <!-- <span class="avatar-edit">
                                    <i data-feather="edit-2" class="avatar-uploader-icon shadow-soft"></i>
                                </span> -->
                            </label>
                            <h2>

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
                                echo $username;

                                ?>
                                <i class="fas fa-certificate text-primary small" data-toggle="tooltip" data-placement="top" title="" data-original-title="Verified"></i>
                            </h2>
                            <!-- <ul class="list-inline">
                                <li class="list-inline-item">
                                    <i class="far fa-building"></i> <span>Hafner Pvt Ltd.</span>
                                </li>
                                <li class="list-inline-item">
                                    <i class="fas fa-map-marker-alt"></i> West Virginia, US
                                </li>
                                <li class="list-inline-item">
                                    <i class="far fa-calendar-alt"></i> <span>Joined November 2017</span>
                                </li>
                            </ul> -->
                        </div>
                        <div class="row">

                            <?php
                            // Vérification des champs remplis
                            $fields = ['username', 'email', 'phone', 'address', 'image'];
                            $total_fields = count($fields);
                            $filled_fields = 0;

                            foreach ($fields as $field) {
                                if (!empty($user[$field])) {
                                    $filled_fields++;
                                }
                            }

                            // Calcul du pourcentage de complétion
                            $completion_percentage = ($filled_fields / $total_fields) * 100;
                            $completion_percentage = round($completion_percentage); // Arrondi à l'entier
                            ?>


                            <div class="col-lg-4" style="width: 100%;">
                                <div class="card card-body">
                                    <h5>Complete your profile</h5>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="progress progress-md flex-grow-1">
                                            <div class="progress-bar bg-primary" role="progressbar"
                                                style="width: <?php echo $completion_percentage; ?>%"
                                                aria-valuenow="<?php echo $completion_percentage; ?>"
                                                aria-valuemin="0"
                                                aria-valuemax="100">
                                            </div>
                                        </div>
                                        <span class="ms-4"><?php echo $completion_percentage; ?>%</span>
                                    </div>
                                </div>


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


                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title d-flex justify-content-between">
                                            <span>Profile</span>

                                            <a class="btn btn-sm btn-white <?php echo isset($_SESSION['username']) ? 'no' : 'disabled'; ?>"
                                                href="settings.php">Edit</a>
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-unstyled mb-0">
                                            <li class="py-0">
                                                <h6>About</h6>
                                            </li>
                                            <li>
                                                <?php
                                                if (isset($_SESSION['username'])) {
                                                    echo ($_SESSION['username']);
                                                } else {
                                                    echo 'Charles Hafner';
                                                }
                                                ?>
                                            </li>
                                            <!-- <li>
                                                Hafner Pvt Ltd.
                                            </li> -->
                                            <li class="pt-2 pb-0">
                                                <h6>Contacts</h6>
                                            </li>
                                            <li>
                                                <?php
                                                if (isset($_SESSION['username'])) {
                                                    echo ($user['email']);
                                                } else {
                                                    echo 'Charles@gmail.com';
                                                }
                                                ?>
                                            </li>
                                            <li>
                                                <?php
                                                if (isset($user['phone'])) {
                                                    echo ($user['phone']);
                                                } else {
                                                    echo '690116784';
                                                }
                                                ?>
                                            </li>
                                            <li class="pt-2 pb-0">
                                                <h6>Address</h6>
                                            </li>
                                            <li>
                                                <?php
                                                if (isset($user['address'])) {
                                                    echo ($user['address']);
                                                } else {
                                                    echo 'Charles de gaule';
                                                }
                                                ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Activity</h5>
                                    </div>
                                    <div class="card-body card-body-height">
                                        <ul class="activity-feed">
                                            <li class="feed-item">
                                                <div class="feed-date">Nov 16</div>
                                                <span class="feed-text"><a href="profile.html">Brian Johnson</a> has paid the invoice <a href="view-invoice.html">"#DF65485"</a></span>
                                            </li>
                                            <li class="feed-item">
                                                <div class="feed-date">Nov 7</div>
                                                <span class="feed-text"><a href="profile.html">Marie Canales</a> has accepted your estimate <a href="view-estimate.html">#GTR458789</a></span>
                                            </li>
                                            <li class="feed-item">
                                                <div class="feed-date">Oct 24</div>
                                                <span class="feed-text">New expenses added <a href="expenses.html">"#TR018756</a></span>
                                            </li>
                                            <li class="feed-item">
                                                <div class="feed-date">Oct 24</div>
                                                <span class="feed-text">New expenses added <a href="expenses.html">"#TR018756</a></span>
                                            </li>
                                            <li class="feed-item">
                                                <div class="feed-date">Oct 24</div>
                                                <span class="feed-text">New expenses added <a href="expenses.html">"#TR018756</a></span>
                                            </li>
                                            <li class="feed-item">
                                                <div class="feed-date">Oct 24</div>
                                                <span class="feed-text">New expenses added <a href="expenses.html">"#TR018756</a></span>
                                            </li>
                                            <li class="feed-item">
                                                <div class="feed-date">Oct 24</div>
                                                <span class="feed-text">New expenses added <a href="expenses.html">"#TR018756</a></span>
                                            </li>
                                            <li class="feed-item">
                                                <div class="feed-date">Jan 27</div>
                                                <span class="feed-text"><a href="profile.html">Robert Martin</a> gave a review for <a href="product-details.html">"Dell Laptop"</a></span>
                                            </li>
                                            <li class="feed-item">
                                                <div class="feed-date">Jan 14</div>
                                                <span class="feed-text">New customer registered <a href="profile.html">"Tori Carter"</a></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php
    include('script.php');
    ?>


    <script data-cfasync="false" src="../../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="assets/js/jquery-3.6.0.min.js"></script>

    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/feather.min.js"></script>

    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <script src="assets/js/script.js"></script>
</body>

</html>