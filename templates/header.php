<?php include 'config/connect_db.php'; ?>

<?php
session_start();

if (isset($_POST['login-btn'])) {
    header('location: login.php');
    exit();
}

if (isset($_POST['logout-btn'])) {
    // unsett all session variables
    $_SESSION = [];

    // destroy the session
    session_destroy();

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/styles.css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <title>Employee Management</title>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="wrapper col-md-2 d-flex flex-column justify-content-between">
                <div class="container text-center mt-3">
                    <img src="res/logo.png" alt="LOGO" class=" w-50">

                    <h5 class="username-list mt-2">Welcome, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?></h5>
                </div>
                <div class="container d-flex flex-column align-items-center">
                    <a href="dashboard.php" class="menu-list btn"><i class="bi bi-speedometer2"></i> Dashboard</a>
                    <a href="employees.php" class="menu-list btn"><i class="bi bi-file-earmark-person"></i> Employees</a>
                    <a href="#" class="menu-list btn"><i class="bi bi-building"></i> Departments</a>
                    <a href="#" class="menu-list btn"><i class="bi bi-calendar-check"></i> Absences</a>
                    <a href="#" class="menu-list btn"><i class="bi bi-exclamation-circle"></i> Warnings</a>
                </div>
                <div class="container text-center">
                    <form action="" method="POST">
                        <?php if (isset($_SESSION['username'])): ?>
                            <button type="submit" name="logout-btn" class="menu-list btn">Logout</button>
                        <?php else: ?>
                            <button type="submit" name="login-btn" class="menu-list btn">Login</button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>