<?php

include('connexion.php');


// Vérifier si le formulaire est soumis
if (isset($_POST['save_item'])) {
    $item_name = $_POST['item_name'];
    $category = $_POST['item_category'];
    $price_per_unit = $_POST['price_per_unit'];
    $quantity_buyed = $_POST['quantity'];
    $price_of_sale = $_POST['price_of_sale'];
    $description = !empty($_POST['description']) ? $_POST['description'] : '';
    $quantity_rest=0;

    $quantity_selled=$quantity_buyed-$quantity_rest;

    // Gestion de l'image
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

    // Insérer les données dans la base
    $sql = "INSERT INTO items (item_name, item_image, item_category, price_per_unit, quantity_buyed,qunntity_selled,quantity_rest, price_of_sale, description)
            VALUES (?, ?, ?, ?,?, ?,?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssdiiids",
        $item_name,
        $image_path,
        $category,
        $price_per_unit,
        $quantity_buyed,
        $quantity_selled,
        $quantity_rest,
        $price_of_sale,
        $description
    );

    if ($stmt->execute()) {
        header("Location: invoice-items.php?status=addedItem");
        exit();
    } else {
        // Alerte d'erreur
    }
}
?>
