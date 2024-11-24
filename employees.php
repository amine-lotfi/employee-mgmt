<?php require './includes/header.php'; ?>
<?php require './includes/functions.php'; ?>

<?php
// check for delete request first
if (isset($_POST['delete']) && !empty($_POST['item-id'])) {
    $delete_stmt = $conn->prepare("DELETE FROM employees WHERE id = ?");
    $delete_stmt->bind_param('i', $_POST['item-id']);
    $delete_stmt->execute();

    if ($delete_stmt->affected_rows > 0) {
        echo "<script>alert('Employee deleted!');</script>";
    } else {
        echo "<script>alert('No employee has been found with such ID.');</script>";
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
        e.role, 
        e.salary, 
        e.status 
    FROM 
        employees e
    JOIN 
        departments d ON e.department_id = d.id");

$stmt->execute();
$stmt->bind_result($id, $name, $SSN, $birthdate, $email, $phone, $department_id, $department_name, $hire_date, $role, $salary, $status);
?>

<div class="col-md-10">
    <div class="container-fluid flex-column d-flex align-items-center">
        <h2 class="my-5">Our employees:</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">SSN</th>
                    <th scope="col">Birthdate</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Role</th>
                    <th scope="col">Hire Date</th>
                    <th scope="col">Department</th>
                    <th scope="col">Salary ($)</th>
                    <th scope="col">Status</th>
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
                        <td><?php echo htmlspecialchars($salary); ?></td>
                        <td><?php echo htmlspecialchars($status); ?></td>

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

<?php

// close the statement and connection
$stmt->close();
$conn->close();
?>

<?php include './includes/footer.php'; ?>