<?php
/**
 * CampusFest 2026 - Database Connection & Configuration
 * Compatible with XAMPP (Apache & MySQL / MariaDB)
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database Credentials (Default XAMPP Configuration with Cloud/Vercel ENV Support)
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');
define('DB_NAME', getenv('DB_NAME') ?: 'campusfest_db');
define('DB_PORT', getenv('DB_PORT') ? intval(getenv('DB_PORT')) : 3306);

$pdo = null;
$db_error = null;
$isVercel = (bool) getenv('VERCEL');

try {
    // Attempt connecting to the specific database
    $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    if ($isVercel) {
        // On Vercel cloud without remote MySQL configured, run in graceful simulated demo mode
        $db_error = null;
    } else {
        // If the database does not exist yet (Error code 1049), attempt auto-creation
        if ($e->getCode() == 1049) {
            try {
                $root_dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";charset=utf8mb4";
                $root_pdo = new PDO($root_dsn, DB_USER, DB_PASS, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]);
                $root_pdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
                
                // Reconnect to newly created database
                $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
                
                // Auto-load database.sql if available
                $sqlFile = __DIR__ . '/database.sql';
                if (file_exists($sqlFile)) {
                    $sqlCommands = file_get_contents($sqlFile);
                    $pdo->exec($sqlCommands);
                }
            } catch (Exception $autoEx) {
                $db_error = "Database created but initialization failed: " . $autoEx->getMessage();
            }
        } else {
            // MySQL server might not be started or wrong credentials
            $db_error = "Database Connection Warning: Unable to connect to MySQL. " . 
                        "Please ensure the MySQL service is started in your XAMPP Control Panel. " . 
                        "(" . $e->getMessage() . ")";
        }
    }
}

/**
 * Helper: Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Helper: Get current logged-in user
 */
function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    return [
        'id' => $_SESSION['user_id'] ?? null,
        'name' => $_SESSION['user_name'] ?? 'Guest Student',
        'email' => $_SESSION['user_email'] ?? '',
        'college' => $_SESSION['user_college'] ?? '',
        'phone' => $_SESSION['user_phone'] ?? ''
    ];
}

/**
 * Helper: Sanitize string input
 */
function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Helper: Flash messages
 */
function setFlash($type, $message) {
    $_SESSION['flash_type'] = $type;
    $_SESSION['flash_message'] = $message;
}

function getFlash() {
    if (isset($_SESSION['flash_message'])) {
        $msg = [
            'type' => $_SESSION['flash_type'] ?? 'info',
            'message' => $_SESSION['flash_message']
        ];
        unset($_SESSION['flash_type'], $_SESSION['flash_message']);
        return $msg;
    }
    return null;
}
