<?php require __DIR__ . '/../config/connect_db.php'; ?>
<?php require_once __DIR__ . '/../config/paths.php'; ?>
<?php require_once __DIR__ . '/funcs.php'; ?>

<?php
try {
    // start a session
    session_start();

    // login
    if (isset($_POST['menu-login-btn'])) {
        header('location: ' . REDIRECT_URL);
        exit();
    }

    // log out
    if (isset($_POST['logout-btn'])) {
        !empty(get_ip()) ? $ip = get_ip() : 'IP_ERROR';
        $operation = 'logout';
        $log = $inputUsername . ' has logged out';

        $log_stmt = $conn->prepare("INSERT INTO `logs` (`ip`, `operation`, `log`) VALUES (?, ?, ?)");
        $log_stmt->bind_param('sss', $ip, $operation, $log);
        if ($log_stmt->execute()) {
            error_log('Log inserted!');

            // unsett all session variables
            $_SESSION = [];

            // destroy the session
            session_destroy();

            header('Location: ' . REDIRECT_URL);
            exit();
        } else {
            error_log('Error in ' . $_SERVER['PHP_SELF'] . ' - ' . $log_stmt->error);
        }
        // closing the second statement
        $log_stmt->close();
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

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/styles.css" />

    <title>Employee Management System</title>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="side-menu-wrapper col-lg-2 d-flex align-items-center">
                <div class="card bg-dark shadow-lg w-100">
                    <div class="card-header text-center text-light">
                        <div class="container text-center">
                            <i class="logo-icon fa-solid fa-user-large m-2"></i>

                            <p class="text-light lead mb-0"><?php echo isset($_SESSION['username']) ? 'Welcome back, ' . $_SESSION['username'] : 'Welcome back!'; ?></p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="container d-flex flex-column align-items-center">
                            <a href="<?php echo BASE_URL . '/views/dashboard.php'; ?>" class="menu-list btn shadow-lg"><i class="fa-solid fa-gauge-high me-2"></i>Dashboard</a>
                            <a href="<?php echo BASE_URL . '/views/employees.php'; ?>" class="menu-list btn"><i class="fa-solid fa-users me-2"></i>Employees</a>
                            <a href="#" class="menu-list btn"><i class="fa-solid fa-building me-2"></i>Departments</a>
                            <a href="#" class="menu-list btn"><i class="fa-regular fa-calendar-check me-2"></i>Absences</a>
                            <a href="#" class="menu-list btn"><i class="fa-solid fa-triangle-exclamation me-2"></i>Warnings</a>
                            <a href="<?php echo BASE_URL . '/views/logs.php'; ?>" class="menu-list btn"><i class="fa-solid fa-file-lines me-2"></i>Logs</a>
                        </div>
                        <div class="container text-center mt-5">
                            <form action="" method="POST">
                                <?php if (isset($_SESSION['username'])): ?>
                                    <button type="submit" name="logout-btn" class="menu-list btn"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</button>
                                <?php else: ?>
                                    <button type="submit" name="menu-login-btn" class="menu-list btn"><i class="fa-solid fa-right-to-bracket me-2"></i>Login</button>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>