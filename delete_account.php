<?php
session_start();
include('connexion.php');


if (isset($_SESSION['username'])) {

    $username = ($_SESSION['username']);
    $sql = "SELECT * FROM users WHERE username = '$username' ";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();

    $user_id = $user['id'];


    if (isset($_POST['delete_btn'])) {
        // Check if the checkbox is checked
        if (isset($_POST['delete_account'])) {
            // Delete user from the database
            $sql = "DELETE FROM users WHERE id = ?";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("i", $user_id);
                if ($stmt->execute()) {
                    // Logout the user and destroy session
                    session_destroy();
                    if ($conn->query($sql) == TRUE) {
                        header("Location: index.php?status=success_delete");
                        exit;
                    } else {
                        echo "<script >
                    alert ('Error: Could not delete the account.');
                    window.redirect.back();
                </script>";
                    }
                } else {

                    echo "<script >
                alert ('Error: Could not prepare the statement.');
                window.redirect.back();
            </script>";
                }
            } else {


                echo "<script >
                alert ('Error: You must confirm account deletion.');
                window.redirect.back();
            </script>";
            }
        }
    } else {
        echo "<script >
        alert ('Error: You must be logged in to delete your account.');
        window.redirect.back();
    </script>";
    }
}

$conn->close();
