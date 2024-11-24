<?php require './includes/header.php'; ?>
<?php require './includes/functions.php'; ?>

<?php
$employees_count = 0;
$departments_count = 0;
$absences_count = 0;
$warnings_count = 0;

// get the count of rows in a table
function getCount($conn, $table)
{
    $count = 0;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM $table");
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return $count;
}

// counts for each table
$employees_count = getCount($conn, 'employees');
$departments_count = getCount($conn, 'departments');
$absences_count = getCount($conn, 'absences');
$warnings_count = getCount($conn, 'warnings');
?>

<div class="col-md-10">
    <div class="container-fluid flex-column d-flex justify-content-center align-items-center vh-100">

        <h1 class="mb-5">Employee Mgmt Web App</h1>
        <div class="col-md-10">
            <div class="row">

                <!-- Card 1 -->
                <div class="col-md-3">
                    <div class="card card-dashboard text-center mb-3">
                        <div class="card-body">
                            <i class="fa-solid fa-users"></i>
                            <h5>Employees</h5>
                            <h3><?php echo htmlspecialchars("{$employees_count}") ?></h3>
                            <a href="employees.php" class="menu-list btn">More</a>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-md-3">
                    <div class="card card-dashboard text-center mb-3">
                        <div class="card-body">
                            <i class="fa-solid fa-building"></i>
                            <h5>Departments</h5>
                            <h3><?php echo htmlspecialchars("{$departments_count}") ?></h3>
                            <a href="#" class="menu-list btn">More</a>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-md-3">
                    <div class="card card-dashboard text-center mb-3">
                        <div class="card-body">
                            <i class="fa-regular fa-calendar-check"></i>
                            <h5>Absences</h5>
                            <h3><?php echo htmlspecialchars("{$absences_count}") ?></h3>
                            <a href="#" class="menu-list btn">More</a>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="col-md-3">
                    <div class="card card-dashboard text-center mb-3">
                        <div class="card-body">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            <h5>Warnings</h5>
                            <h3><?php echo htmlspecialchars("{$warnings_count}") ?></h3>
                            <a href="#" class="menu-list btn">More</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<?php include './includes/footer.php'; ?>