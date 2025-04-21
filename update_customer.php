<?php
// Connexion à la base de données
include('connexion.php');

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $basic_name = $_POST['basic_name'];
    $basic_email = $_POST['basic_email'];
    // $basic_currency = $_POST['basic_currency'];
    $basic_phone = $_POST['basic_phone'];
    
    $billing_name = $_POST['billing_name'];
    $billing_address = $_POST['billing_address'];
    $billing_country = $_POST['billing_country'];
    $billing_city = $_POST['billing_city'];
    $billing_phone = $_POST['billing_phone'];
    $billing_zip = $_POST['billing_zip'];
    
    $shipping_name = $_POST['shipping_name'];
    $shipping_address = $_POST['shipping_address'];
    $shipping_country = $_POST['shipping_country'];
    $shipping_city = $_POST['shipping_city'];
    $shipping_phone = $_POST['shipping_phone'];
    $shipping_zip = $_POST['shipping_zip'];

    // Mettre à jour la table `customers`
    $queryCustomer = "UPDATE customers SET name_customer = ?, email_customer = ?, phone_customer = ?  WHERE id = ?";
    $stmt = $conn->prepare($queryCustomer);
    $stmt->bind_param('sssi', $basic_name, $basic_email,$basic_phone, $id);
    $stmt->execute();

    // Mettre à jour la table `customer_details`
    $queryDetails = "UPDATE customer_details SET name_customer=?, email_customer=?, phone_customer=?, billing_name=?, billing_address=?, billing_country=?, billing_city=?, billing_phone=?, billing_zip=?, shipping_name=?, shipping_address=?, shipping_country=?, shipping_city=?, shipping_phone=?, shipping_zip=? WHERE id = ?";
    $stmtDetails = $conn->prepare($queryDetails);
    $shipping_address = $_POST['shipping_address'];
    $stmtDetails->bind_param('ssssssssisssssii', $basic_name, $basic_email,$basic_phone, $billing_name,$billing_address,$billing_country,$billing_city,$billing_phone,$billing_zip,$shipping_name,$shipping_address,$shipping_country,$shipping_city,$shipping_phone,$shipping_zip, $id);
    $stmtDetails->execute();

    // Redirection avec message de succès
    header("Location: customers.php?status=success");
    exit;
}
?>
