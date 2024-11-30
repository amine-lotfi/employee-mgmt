<?php require_once __DIR__ . '/../includes/header.php'; ?>
<?php require_once __DIR__ . '/../includes/funcs.php'; ?>

<?php
// call the function to check if the user is logged in
check_if_logged_in();

// check for delete request first
if (isset($_POST['delete']) && !empty($_POST['item-id'])) {
    $delete_stmt = $conn->prepare("DELETE FROM employees WHERE id = ?");
    $delete_stmt->bind_param('i', $_POST['item-id']);
    $delete_stmt->execute();

    if ($delete_stmt->affected_rows > 0) {
        echo "<script>alert('Employee deleted!');</script>";
    } else {
        echo "<script>alert('Oops! Something went wrong.');</script>";
        error_log('Error in ' . $_SERVER['PHP_SELF'] . $delete_stmt->error);
    }
    $delete_stmt->close();
}

// prepare and execute the SQL statement to display employees
$stmt = $conn->prepare("
    SELECT
        e.id, 
        e.name, 
        e.SSN, 
        e.birthdate, 
        e.email, 
        e.phone, 
        e.department_id, 
        d.name AS department_name,
        e.hire_date, 
        e.role
    FROM 
        employees e
    JOIN 
        departments d ON e.department_id = d.id");

$stmt->execute();
$stmt->bind_result($id, $name, $SSN, $birthdate, $email, $phone, $department_id, $department_name, $hire_date, $role);
?>

<div class="col-md-10">
    <div class="container-fluid flex-column d-flex justify-content-center align-items-center vh-100">
        <div class="card bg-dark text-light shadow-lg w-100">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-4">
                        <h1>Employees List</h1>
                    </div>
                    <!-- TODO: Add: add employee, search feature and fix the search design -->
                    <div class="col-md-6 d-flex align-items-center">
                        <input type="text" class="form-control" placeholder="Search by lastname">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table mb-0">
                    <thead class="table-dark fs-5">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">SSN</th>
                            <th scope="col">Birthdate</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Role</th>
                            <th scope="col">Hire Date</th>
                            <th scope="col">Department</th>
                            <th scope="col"> </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // fetching and displaying data
                        while ($stmt->fetch()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($name); ?></td>
                                <td><?php echo htmlspecialchars($SSN); ?></td>
                                <td><?php echo htmlspecialchars($birthdate); ?></td>
                                <td><?php echo htmlspecialchars($email); ?></td>
                                <td><?php echo htmlspecialchars($phone); ?></td>
                                <td><?php echo htmlspecialchars($role); ?></td>
                                <td><?php echo htmlspecialchars($hire_date); ?></td>
                                <td><?php echo htmlspecialchars($department_name); ?></td>

                                <td>
                                    <form action="" method="POST">
                                        <input type="hidden" name="item-id" value="<?php echo $id; ?>">
                                        <button type="submit" name="delete" class="btn btn-danger btn-sm">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>

                                        <button type="submit" name="update" class="btn btn-success btn-sm">
                                            <i class="fa-solid fa-pencil"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php

// close the statement and connection
$stmt->close();
$conn->close();
?>

<?php require __DIR__ . '/../includes/footer.php'; ?>