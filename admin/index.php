<?php include 'templates/header.php'; ?>

<?php
// check if form is submitted
if (isset($_POST['add-admin'])) {
    $adminUsername = $_POST['username'];
    $adminPassword = $_POST['password'];

    // check if the username already exists
    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM admins WHERE username = ?");
    $checkStmt->bind_param("s", $adminUsername);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($count > 0) {
        echo "<script>alert('Error: Admin with this username already exists!');</script>";
    } else {
        // hash the password
        $hashedPassword = password_hash($adminPassword, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $adminUsername, $hashedPassword);

        if ($stmt->execute()) {
            echo '<script>alert("Admin has been added! You can login now.");</script>';
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<div class="col-md-10">
    <div class="container flex-column d-flex justify-content-center align-items-center vh-100">
        <h2>Add an admin</h2>
        <form action="" method="POST" class="form-control w-50 p-2">

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username (limit = 12 char)" required maxlength="12">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
            </div>
            <div class="text-center">
                <button type="submit" name="add-admin" class="btn btn-primary">Add</button>
            </div>
        </form>
    </div>
</div>

<?php include 'templates/footer.php'; ?>