<?php
if (isset($_POST["add_cat"])) {
    extract($_POST);

    $query_verify = $db->prepare("SELECT * FROM categories WHERE name = '$cat_name' ");
    $query_verify->execute();
    $result = $query_verify->rowCount();
    if ($result == 0) {
        $conn->query("INSERT INTO categories(name,description) VALUES('$cat_name','$description')");
?>
        <script>
            window.location.href = "invoice-category.php";
        </script>
<?php
    }
}
?>