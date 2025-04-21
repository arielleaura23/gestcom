

<?php
// Connexion à la base de données
include('connexion.php');
// include('head.php');

// Récupération des données du formulaire
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

$register_date = date("Y-m-d H:i:s"); // Date actuelle

// Insérer dans la table customers
$sql_customers = "INSERT INTO customers (name_customer, email_customer, phone_customer, register_on) VALUES ('$basic_name', '$basic_email', '$basic_phone', '$register_date')";
if ($conn->query($sql_customers) === TRUE) {
    $customer_id = $conn->insert_id; // Récupère l'ID du client inséré

    // Insérer dans la table customers_details
    $sql_details = "INSERT INTO customer_details (name_customer, email_customer, phone_customer, register_on, billing_name, billing_address, billing_country, billing_city, billing_phone, billing_zip, shipping_name, shipping_address, shipping_country, shipping_city, shipping_phone, shipping_zip) VALUES ('$basic_name', '$basic_email', '$basic_phone', '$register_date', '$billing_name', '$billing_address', '$billing_country', '$billing_city', '$billing_phone', '$billing_zip', '$shipping_name', '$shipping_address', '$shipping_country', '$shipping_city', '$shipping_phone', '$shipping_zip')";
    
    if ($conn->query($sql_details) === TRUE) {
        // Redirection vers add-customer.php avec un paramètre GET indiquant un succès
        header("Location: add-customer.php?status=success");
        exit();
    } else {
        // Redirection vers add-customer.php avec un paramètre GET indiquant une erreur
        header("Location: add-customer.php?status=error");
        exit();
    }
} else {
    echo "Error: " . $conn->error;
}

$conn->close();


?>




