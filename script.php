    <!-- jquery ui -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>


    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/feather.min.js"></script>
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="assets/plugins/apexchart/apexcharts.min.js"></script>
    <script src="assets/plugins/apexchart/chart-data.js"></script>
    <script src="assets/my_js/monScript.js"></script>
    <script src="assets/plugins/moment/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="assets/plugins/select2/js/select2.min.js"></script>



    <script
      data-cfasync="false"
      src="../../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>


    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatables/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.js"></script>





    <script src="https://unpkg.com/feather-icons"></script>

    <script>
      document.addEventListener("DOMContentLoaded", function() {
        feather.replace(); // Initialisation des icônes
      });
    </script>



    <!-- script pour afficher les notifications -->
    <script>
      function timeAgo(date) {
        const now = new Date();
        const seconds = Math.floor((now - date) / 1000);

        const intervals = {
          "an": 31536000,
          "mois": 2592000,
          "jour": 86400,
          "heure": 3600,
          "minute": 60,
          "seconde": 1
        };

        for (const [unit, value] of Object.entries(intervals)) {
          const count = Math.floor(seconds / value);
          if (count > 0) {
            return `il y a ${count} ${unit}${count > 1 && unit !== 'mois' ? 's' : ''}`;
          }
        }
        return "à l'instant";
      }



      document.addEventListener('DOMContentLoaded', function() {
        function loadStockNotifications() {
          fetch('check_notif.php')
            .then(response => response.json())
            .then(data => {
              const notificationList = document.querySelector('.notification-list');
              const badge = document.querySelector('.nav-item .badge');

              // 🧹 Supprimer TOUTES les anciennes notifications (statiques ou dynamiques)
              notificationList.innerHTML = '';

              // Si on a des données de stock
              if (data.length > 0) {
                data.forEach(notif => {
                  const li = document.createElement('li');
                  li.classList.add('notification-message');
                  li.innerHTML = `
                <a href="stock.html">
                  <div class="media d-flex">
                    <div class="avatar avatar-sm">
                      <span class="avatar-title rounded-circle bg-danger-light">
                        <i class="fas fa-triangle-exclamation"></i>
                      </span>
                    </div>
                    <div class="media-body">
                      <p class="noti-details">${notif.message}</p>
                      <p class="noti-time"><span class="notification-time">${timeAgo(new Date(notif.time))}</span></p>
                    </div>
                  </div>
                </a>
              `;
                  notificationList.appendChild(li);
                });

                // ✅ Afficher le badge avec le nombre
                badge.textContent = data.length;
                badge.style.display = 'inline-block';
              } else {
                // ❌ Aucune notification → cacher le badge
                badge.style.display = 'none';

                // Tu peux même afficher "Aucune notification" si tu veux :
                const li = document.createElement('li');
                li.classList.add('notification-message');
                li.innerHTML = `
              <div class="media-body text-center text-muted p-2">
                Aucune notification
              </div>
            `;
                notificationList.appendChild(li);
              }
            })
            .catch(error => {
              console.error("Erreur lors du chargement des notifications :", error);
            });
        }

        // Chargement au démarrage
        loadStockNotifications();

        // (Optionnel) Recharger toutes les 30s :
        // setInterval(loadStockNotifications, 30000);
      });

      // Événement pour le bouton "Clear All"
      document.addEventListener('DOMContentLoaded', function() {
        const clearBtn = document.querySelector('.clear-noti');
        const notificationList = document.querySelector('.notification-list');
        const badge = document.querySelector('.nav-item .badge');

        clearBtn.addEventListener('click', function() {
          notificationList.innerHTML = ''; // Supprime toutes les notifications
          badge.style.display = 'none'; // Cache le badge
        });
      });
    </script>