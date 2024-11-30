<?php
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'admin');
define('DB_PASSWORD', 'admin24');
define('DB_NAME', 'employee_db');

$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

// check if the connection fails
if ($conn->connect_error) {
  error_log('Connection failed: ' . $conn->connect_error);
}
