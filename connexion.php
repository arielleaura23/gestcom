<?php
    $conn = new mysqli("localhost", "root", "", "gestcom");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>