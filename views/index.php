<?php require __DIR__ . '/../includes/header.php'; ?>
<?php require __DIR__ . '/../includes/funcs.php'; ?>

<?php

$alertMessage = isset($_SESSION['alertMessage']) ? $_SESSION['alertMessage'] : '';
// clear the message after displaying it
unset($_SESSION['alertMessage']);

try {
    if (isset($_POST['login-btn'])) {
        // getting the data
        $inputUsername = $_POST['username'];
        $inputPassword = $_POST['password'];

        // prepare and bind
        $stmt = $conn->prepare("SELECT `password` FROM `admins` WHERE `username` = ?");
        $stmt->bind_param("s", $inputUsername);
        $stmt->execute();
        $stmt->store_result();

        // checking if the user exists
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashedPassword);
            $stmt->fetch();

            // verifying the password
            if (password_verify($inputPassword, $hashedPassword)) {
                // password is correct, insert the log and set session
                $log = $inputUsername . ' has successfully logged in.';
                $insertStmt = $conn->prepare("INSERT INTO `logs` (`string`) VALUES (?)");
                $insertStmt->bind_param('s', $log);
                if ($insertStmt->execute()) {
                    error_log('Inserted!');
                } else {
                    error_log('Error: ' . $insertStmt->error);
                }

                // closing the second statement
                $insertStmt->close();

                session_start();
                $_SESSION['username'] = $inputUsername;
                header('Location: ' . REDIRECT_URL . 'dashboard.php');
                exit();
            } else {
                echo '<script>alert("Invalid password.")</script>';
            }
        } else {
            echo '<script>alert("User does not exist.")</script>';
        }
    }
} catch (Exception $e) {
    error_log('Error: ' . $e->getMessage());
} finally {
    if (isset($stmt) && isset($conn)) {
        $stmt->close();
        $conn->close();
    }
}
?>

<div class="col-md-10">
    <div class="container flex-column d-flex justify-content-center align-items-center vh-100">

        <!-- bootsrap alert -->
        <div class="col-md-7 mt-5">
            <?php if (!empty($alertMessage)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $alertMessage; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        </div>

        <div class="card col-md-7 bg-dark text-light shadow-lg">
            <div class="card-header text-center">
                <h1 class="font-weight-bold">Login</h1>
            </div>
            <div class="card-body">
                <form action="" method="POST" class="p-5">

                    <div class="mb-3">
                        <span class="text-danger fs-4">*</span><label for="username" class="form-label fs-5">Username</label>
                        <input type="text" name="username" id="username" class="form-control p-3 fs-5" placeholder="Enter your username" required>
                    </div>
                    <div class="mb-3">
                        <span class="text-danger fs-4">*</span><label for="password" class="form-label fs-5">Password</label>
                        <input type="password" name="password" id="password" class="form-control p-3 fs-5" placeholder="Enter your password" required>
                    </div>
                    <span class="text-danger fs-4">*</span><span class="fs-6"> Required field.</span>

                    <button type="submit" name="login-btn" class="btn btn-primary fs-4 mt-5 w-100">Login</button>

                </form>

            </div>
        </div>
    </div>

    <?php require __DIR__ . '/../includes/footer.php'; ?>