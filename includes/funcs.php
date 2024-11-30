<?php require __DIR__ . '/../config/paths.php'; ?>

<?php
/*
define functions here that you'll need to use across the app
to avoid code repetition
*/


// to check if the user is not logged in and redirect to the login page
function checkIfLoggedIn()
{
    if (empty($_SESSION['username'])) {
        $_SESSION['alertMessage'] = "You need to log in to have access.";
        header('location: ' . REDIRECT_URL);
        exit();
    }
}

// to get the client IP address
function get_ip()
{
    $ip = '';

    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED'];
    } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_FORWARDED'])) {
        $ip = $_SERVER['HTTP_FORWARDED'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    // handle the localhost IPv6 loopback address (it normally returns ::1)
    if ($ip === '::1') {
        $ip = '127.0.0.1';
    }

    // fallback - sending a request to ipify which will return an ip address
    if (empty($ip) || $ip == '0.0.0.0') {
        $ip = file_get_contents('https://api.ipify.org/');
    }

    return $ip;
}
