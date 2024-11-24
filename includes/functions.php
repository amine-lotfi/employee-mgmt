<?php
// this will redirect to login page if not logged in
if (empty($_SESSION['username'])) {
    $_SESSION['alertMessage'] = "You need to log in to have access.";
    header("Location: login.php");
    exit();
}
