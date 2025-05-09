<div class="header header-one">
  <div class="header-left header-left-one">
    <a href="home.php" class="logo">

      <?php
      include('connexion.php');

      $sql = "SELECT * FROM preferences";
      $stmt = $conn->query($sql);
      $preference = $stmt->fetch_assoc();
      ?>
      <h1 style="    color: #42cdff;margin: 10px 0;">
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
    <a href="home.php" class="white-logo">
      <img src="assets/img/logo-white.png" alt="Logo" />
    </a>
    <a href="home.php" class="logo logo-small">
      <?php
      if (isset($preference['app_name'])) {
        echo $preference['app_name'];
      } else {
        echo 'GESTCOM';
      }
      ?>
    </a>
  </div>
  <a href="javascript:void(0);" id="toggle_btn">
    <i class="fas fa-bars"></i>
  </a>
  <div class="top-nav-search">
    <form>
      <input type="text" class="form-control" placeholder="Search here" />
      <button class="btn" type="submit">
        <i class="fas fa-search"></i>
      </button>
    </form>
  </div>
  <a class="mobile_btn" id="mobile_btn">
    <i class="fas fa-bars"></i>
  </a>
  <ul class="nav nav-tabs user-menu">
    <li class="nav-item dropdown has-arrow flag-nav">
      <a
        class="nav-link dropdown-toggle"
        data-bs-toggle="dropdown"
        href="#"
        role="button">
        <img src="assets/img/flags/us.png" alt="" height="20" />
        <span>English</span>
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <a href="javascript:void(0);" class="dropdown-item">
          <img src="assets/img/flags/us.png" alt="" height="16" /> English
        </a>
        <a href="javascript:void(0);" class="dropdown-item">
          <img src="assets/img/flags/fr.png" alt="" height="16" /> French
        </a>
        <a href="javascript:void(0);" class="dropdown-item">
          <img src="assets/img/flags/es.png" alt="" height="16" /> Spanish
        </a>
        <a href="javascript:void(0);" class="dropdown-item">
          <img src="assets/img/flags/de.png" alt="" height="16" /> German
        </a>
      </div>
    </li>

    <li class="nav-item dropdown">
      <a
        href="#"
        class="dropdown-toggle nav-link"
        data-bs-toggle="dropdown">
        <i data-feather="bell"></i>
        <span class="badge rounded-pill">5</span>
      </a>
      <div class="dropdown-menu notifications">
        <div class="topnav-dropdown-header">
          <span class="notification-title">Notifications</span>
          <a href="javascript:void(0)" class="clear-noti"> Clear All</a>
        </div>
        <div class="noti-content">
          <ul class="notification-list">
            <li class="notification-message">
              <a href="activities.html">
                <div class="media d-flex">
                  <span class="avatar avatar-sm">
                    <img
                      class="avatar-img rounded-circle"
                      alt=""
                      src="assets/img/profiles/avatar-02.jpg" />
                  </span>
                  <div class="media-body">
                    <p class="noti-details">
                      <span class="noti-title">Brian Johnson</span> paid
                      the invoice <span class="noti-title">#DF65485</span>
                    </p>
                    <p class="noti-time">
                      <span class="notification-time">4 mins ago</span>
                    </p>
                  </div>
                </div>
              </a>
            </li>
            <li class="notification-message">
              <a href="activities.html">
                <div class="media d-flex">
                  <span class="avatar avatar-sm">
                    <img
                      class="avatar-img rounded-circle"
                      alt=""
                      src="assets/img/profiles/avatar-03.jpg" />
                  </span>
                  <div class="media-body">
                    <p class="noti-details">
                      <span class="noti-title">Marie Canales</span> has
                      accepted your estimate
                      <span class="noti-title">#GTR458789</span>
                    </p>
                    <p class="noti-time">
                      <span class="notification-time">6 mins ago</span>
                    </p>
                  </div>
                </div>
              </a>
            </li>
            <li class="notification-message">
              <a href="activities.html">
                <div class="media d-flex">
                  <div class="avatar avatar-sm">
                    <span
                      class="avatar-title rounded-circle bg-primary-light"><i class="far fa-user"></i></span>
                  </div>
                  <div class="media-body">
                    <p class="noti-details">
                      <span class="noti-title">New user registered</span>
                    </p>
                    <p class="noti-time">
                      <span class="notification-time">8 mins ago</span>
                    </p>
                  </div>
                </div>
              </a>
            </li>
            <li class="notification-message">
              <a href="activities.html">
                <div class="media d-flex">
                  <span class="avatar avatar-sm">
                    <img
                      class="avatar-img rounded-circle"
                      alt=""
                      src="assets/img/profiles/avatar-04.jpg" />
                  </span>
                  <div class="media-body">
                    <p class="noti-details">
                      <span class="noti-title">Barbara Moore</span>
                      declined the invoice
                      <span class="noti-title">#RDW026896</span>
                    </p>
                    <p class="noti-time">
                      <span class="notification-time">12 mins ago</span>
                    </p>
                  </div>
                </div>
              </a>
            </li>
            <li class="notification-message">
              <a href="activities.html">
                <div class="media d-flex">
                  <div class="avatar avatar-sm">
                    <span
                      class="avatar-title rounded-circle bg-info-light"><i class="far fa-comment"></i></span>
                  </div>
                  <div class="media-body">
                    <p class="noti-details">
                      <span class="noti-title">You have received a new message</span>
                    </p>
                    <p class="noti-time">
                      <span class="notification-time">2 days ago</span>
                    </p>
                  </div>
                </div>
              </a>
            </li>
          </ul>
        </div>
        <div class="topnav-dropdown-footer">
          <a href="activities.html">View all Notifications</a>
        </div>
      </div>
    </li>

    <?php

      if (isset($_SESSION['username'])) {
        $username = ($_SESSION['username']);
        $sql = "SELECT * FROM users WHERE username = '$username' ";
        $result = $conn->query($sql);

        $user = $result->fetch_assoc();
      }else{
        $username='admin';
      }

    ?>



    <li class="nav-item dropdown has-arrow main-drop">
      <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
        <span class="user-img">

          <img id="avatarImg" width="35" height="35" src="<?php echo (!empty($user['image']) ? 'assets/photos/' . $user['image'] : 'assets/img/user.jpeg'); ?>"
            alt="Profile Image">
          <span class="status online"></span>
        </span>
        <span><?php echo $username; ?></span> <!-- Afficher le nom de l'utilisateur ou "Admin" -->
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="profile.php"><i data-feather="user" class="me-1"></i> Profile</a>
        <a class="dropdown-item" href="settings.php"><i data-feather="settings" class="me-1"></i> Settings</a>
        <a class="dropdown-item" href="logout.php"><i data-feather="log-out" class="me-1"></i> Logout</a>
      </div>
    </li>


  </ul>
</div>


