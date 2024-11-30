<?php require __DIR__ . '/../includes/header.php'; ?>
<?php require_once __DIR__ . '/../includes/funcs.php'; ?>

<?php
// call the function to check if the user is logged in
check_if_logged_in();

$connection_logs = [];
try {
    $stmt = $conn->prepare("SELECT `timestamp`, `ip`, `operation`, `log` FROM `logs` WHERE `operation` = ? OR `operation` = ?");
    $op1 = 'login';
    $op2 = 'logout';
    $stmt->bind_param('ss', $op1, $op2);
    $stmt->execute();
    $stmt->bind_result($timestamp, $ip, $operation, $log);

    // fetch rows and store them in the $logs array
    while ($stmt->fetch()) {
        $connection_logs[] = [
            'timestamp' => $timestamp,
            'ip' => $ip,
            'operation' => $operation,
            'log' => $log
        ];
    }
} catch (Exception $e) {
    error_log('Error: ' . $e->getMessage());
} finally {
    if (isset($stmt) && $stmt != null) {
        $stmt->close();
    }
    if (isset($conn) && $conn->ping()) {
        $conn->close();
    }
}
?>

<div class="col-md-10">
    <div class="container-fluid flex-column d-flex justify-content-center align-items-center vh-100">
        <div class="card bg-dark text-light shadow-lg w-100 mt-5">
            <div class="card-header">
                <h1>Logs</h1>
            </div>
            <div class="card-body">
                <div class="accordion my-5 w-100" id="accordion-1">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Connection logs:
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordion-1">
                            <div class="accordion-body">
                                <?php $line_counter = 1; ?>
                                <?php foreach ($connection_logs as $connection_log): ?>
                                    <code class="text-danger">
                                        <?php echo htmlspecialchars('Line: ' . $line_counter . ' - ' . '[' . $connection_log['timestamp'] . ']' . ' - ' . 'IP ' .  $connection_log['ip'] . ' - ' . $connection_log['operation'] . ' - ' . $connection_log['log']); ?></br>
                                    </code>
                                    <?php $line_counter++; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion my-5 w-100" id="accordion-2">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                Operation logs:
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordion-2">
                            <div class="accordion-body">
                                <code class="text-danger">
                                    <!-- TODO: operation logs to be added here! -->
                                </code>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>