<?php include './includes/header.php'; ?>

<?php
$alertMessage = isset($_SESSION['alertMessage']) ? $_SESSION['alertMessage'] : '';
// clear the message after displaying it
unset($_SESSION['alertMessage']);

try {
    if (isset($_POST['connect-btn'])) {
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
                header("Location: dashboard.php");
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
        <div class="container mt-5 w-50">
            <?php if (!empty($alertMessage)): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?php echo $alertMessage; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        </div>

        <h2>Login</h2>
        <form action="" method="POST" class="form-control w-50 p-2">

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
            </div>
            <div class="text-center">
                <button type="submit" name="connect-btn" class="btn btn-primary">Connect</button>
            </div>
        </form>
    </div>

    <?php include './includes/footer.php'; ?>