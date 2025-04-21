<?php

include('connexion.php');

if (isset($_POST['save_item'])) {
  // Récupérer les données du formulaire
  $id = $_POST['id'];  // L'ID de l'article à éditer, passé par l'URL
  $item_name = $_POST['item_name'];
  $category = $_POST['item_category'];
  $price_per_unit = $_POST['price_per_unit'];
  $quantity = $_POST['quantity'];
  $price_of_sale = $_POST['price_of_sale'];
    // Description
    $description = !empty($_POST['description']) ? $_POST['description'] : '';

    // Récupérer l'image actuelle depuis le formulaire
    $image_path = $_POST['existing_image'];  // Garder l'image actuelle par défaut

    // Gestion de l'image (si une nouvelle image est téléchargée)
    if (!empty($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $allowed_exts = ['jpeg', 'jpg', 'png'];

        if (in_array($image_ext, $allowed_exts)) {
            // Définir le chemin de l'image dans le dossier assets/photos
            $image_path = 'assets/photos/' . $image_name;

            // Déplacer l'image vers le répertoire
            move_uploaded_file($image_tmp_name, $image_path);
        } else {
            die("Format d'image non supporté. Formats autorisés : jpeg, jpg, png.");
        }
    }


  // Préparer la requête de mise à jour dans la base de données
  $sql = "UPDATE items SET item_name = ?, item_category = ?, price_per_unit = ?, quantity_buyed = ?, price_of_sale = ?, description = ?, item_image = ? WHERE id = ?";
  $stmt = $conn->prepare($sql);

  // Exécuter la requête avec les paramètres fournis

  if ($stmt->execute([$item_name, $category, $price_per_unit, $quantity, $price_of_sale, $description, $image_path, $id])) {

    header("Location: invoice-items.php?status=success");
    exit();
  } else {
    header("Location: invoice-items.php?status=error");
    exit();
?>

<?php
  }
}
