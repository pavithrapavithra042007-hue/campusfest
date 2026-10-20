<?php
/**
 * CampusFest 2026 - Logout Handler
 */
require_once __DIR__ . '/db.php';

// Unset all session variables
$_SESSION = [];

// Destroy session cookie if present
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy session
session_destroy();

// Restart new session to set friendly farewell flash message
session_start();
setFlash('info', 'You have been successfully signed out. See you at CampusFest 2026!');
header("Location: login.php");
exit;
