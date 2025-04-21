<?php
if (isset($_POST["edit_cat"])) {
    extract($_POST);

    $conn->query("UPDATE categories SET name = '$cat_name', description = '$description'");
?>
    <script>
        window.location.href = "invoice-category.php";
    </script>
<?php
}
?>