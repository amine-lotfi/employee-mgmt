<?php require './config/connect_db.php'; ?>

<?php
try {
    // start a session
    session_start();
    // to login
    if (isset($_POST['login-btn'])) {
        header('location: login.php');
        exit();
    }
    // to log out
    if (isset($_POST['logout-btn'])) {
        $log = $_SESSION['username'] . ' has logged out.';
        $stmt = $conn->prepare("INSERT INTO `logs` (`string`) VALUES (?)");
        $stmt->bind_param('s', $log);
        if ($stmt->execute()) {
            error_log('User has successfully logged out.');
        } else {
            error_log('Error: ' . $stmt->error);
        }

        // unsett all session variables
        $_SESSION = [];

        // destroy the session
        session_destroy();

        header("Location: index.php");
        exit();
    }
} catch (Exception $e) {
    error_log('Error in: ' . $_SERVER['PHP_SELF'] . ' ' . $e->getMessage());
} finally {
    if (isset($stmt) && isset($conn)) {
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />

    <link rel="stylesheet" href="./css/styles.css" />

    <title>Employee Management</title>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="wrapper col-md-2 d-flex flex-column justify-content-between">
                <div class="container text-center mt-3">
                <i class="logo-icon fa-solid fa-user-large"></i>

                    <h5 class="username-list mt-2">Welcome, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?></h5>
                </div>
                <div class="container d-flex flex-column align-items-center">
                    <a href="dashboard.php" class="menu-list btn"><i class="fa-solid fa-gauge-high"></i> Dashboard</a>
                    <a href="employees.php" class="menu-list btn"><i class="fa-solid fa-users"></i> Employees</a>
                    <a href="#" class="menu-list btn"><i class="fa-solid fa-building"></i> Departments</a>
                    <a href="#" class="menu-list btn"><i class="fa-regular fa-calendar-check"></i> Absences</a>
                    <a href="#" class="menu-list btn"><i class="fa-solid fa-triangle-exclamation"></i> Warnings</a>
                    <a href="logs.php" class="menu-list btn"><i class="fa-solid fa-file-lines"></i> Logs</a>
                </div>
                <div class="container text-center">
                    <form action="" method="POST">
                        <?php if (isset($_SESSION['username'])): ?>
                            <button type="submit" name="logout-btn" class="menu-list btn"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
                        <?php else: ?>
                            <button type="submit" name="login-btn" class="menu-list btn"><i class="fa-solid fa-right-to-bracket"></i> Login</button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>