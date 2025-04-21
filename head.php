<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=0" />
  <title>Gestcom</title>

  <!-- <link rel="shortcut icon" href="assets/img/favicon.png" /> -->

  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />

  <link
    rel="stylesheet"
    href="assets/plugins/fontawesome/css/fontawesome.min.css" />
  <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css" />

  <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css" />

  <link
    rel="stylesheet"
    href="assets/plugins/datatables/datatables.min.css" />

  <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css" />

  <link rel="stylesheet" href="assets/css/style.css" />
  <link rel="stylesheet" href="assets/css/mystyle.css" />
  <link href="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.css" rel="stylesheet">

  <!-- jquery ui -->
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

  <script src="https://cdn.jsdelivr.net/npm/notyf@3.10.0/notyf.min.js"></script>





  <style>
    input.error,
    select.error,
    textarea.error {
      border: 1px solid red !important;
    }

    .facture_summary {
      display: flex !important;
      justify-content: end !important;
    }

    .facture_date {
      padding: 26px;
    }

    .customer-item {
      font-weight: 600;
      color: #1b2559;
      margin: 10px 0 10px 10px;
      cursor: pointer;
    }

    .call_to_actions {
      display: flex;
      align-items: start;
      justify-content: center;
    }

    .call_to_actions .dropdown-item {
      margin-bottom: 0 !important;
    }

    /* Style de la liste des suggestions */
    #item-suggestions {
      position: absolute;
      /* Pour s'assurer que la liste s'adapte à la largeur du champ de saisie */
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      margin-top: 2px;
      z-index: 999;
      background-color: white;
      width: 120px;
    }

    /* Style des éléments de la liste */
    .suggestion-item {
      padding: 8px;
      cursor: pointer;
      font-size: 14px;
      color: #333;
    }

    /* Effet au survol d'un élément */
    .suggestion-item:hover {
      background-color: #f1f1f1;
      color: #007bff;
      /* Change la couleur du texte au survol */
    }

    /* Optionnel : Effet au clic */
    .suggestion-item:active {
      background-color: #e1e1e1;
      color: #0056b3;
    }
  </style>
</head>