<?php require './includes/header.php'; ?>
<?php require './includes/functions.php'; ?>

<?php
$connection_logs = [];
try {
    $stmt = $conn->prepare("SELECT `string`, `timestamp` FROM `logs`");
    $stmt->execute();
    $stmt->bind_result($string, $timestamp);

    // fetch rows and store them in the $logs array
    while ($stmt->fetch()) {
        $connection_logs[] = [
            'string' => $string,
            'timestamp' => $timestamp,
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
    <div class="container-fluid d-flex flex-column align-items-center">
        <h2 class="my-5">Logs:</h2>
        <div class="accordion my-5 w-75" id="accordion-1">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Connection logs:
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordion-1">
                    <div class="accordion-body">
                        <?php foreach ($connection_logs as $connection_log): ?>
                            <code class="text-danger">
                                <?php echo htmlspecialchars('[' . $connection_log['timestamp'] . ']' . ' - ' . $connection_log['string']); ?></br>
                            </code>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion my-5 w-75" id="accordion-2">
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





    <?php require './includes/footer.php'; ?>