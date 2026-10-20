<?php
/**
 * CampusFest 2026 - Vercel Serverless Entry Router
 * Routes incoming Vercel requests to corresponding PHP pages
 */

// Determine requested path
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($requestUri, PHP_URL_PATH);
$path = trim($path, '/');

// Base directory (project root)
$rootDir = dirname(__DIR__);

// Route mapping table
$routes = [
    ''              => 'index.php',
    'index'         => 'index.php',
    'index.php'     => 'index.php',
    'about'         => 'about.php',
    'about.php'     => 'about.php',
    'events'        => 'events.php',
    'events.php'    => 'events.php',
    'register'      => 'register.php',
    'register.php'  => 'register.php',
    'login'         => 'login.php',
    'login.php'     => 'login.php',
    'logout'        => 'logout.php',
    'logout.php'    => 'logout.php',
    'dashboard'     => 'dashboard.php',
    'dashboard.php' => 'dashboard.php',
    'location'      => 'location.php',
    'location.php'  => 'location.php',
    'contact'       => 'contact.php',
    'contact.php'   => 'contact.php',
    'payment'       => 'payment.php',
    'payment.php'   => 'payment.php',
    'gallery'       => 'gallery.php',
    'gallery.php'   => 'gallery.php',
    'setup'         => 'setup.php',
    'setup.php'     => 'setup.php',
];

// Serve static assets if requested through router
$staticFile = $rootDir . '/' . $path;
if (!empty($path) && file_exists($staticFile) && !is_dir($staticFile)) {
    $ext = strtolower(pathinfo($staticFile, PATHINFO_EXTENSION));
    $mimes = [
        'css'  => 'text/css',
        'js'   => 'application/javascript',
        'json' => 'application/json',
        'png'  => 'image/png',
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'svg'  => 'image/svg+xml',
        'ico'  => 'image/x-icon',
        'sql'  => 'text/plain',
        'txt'  => 'text/plain',
    ];

    if (isset($mimes[$ext])) {
        header("Content-Type: " . $mimes[$ext]);
        header("Cache-Control: public, max-age=86400");
        readfile($staticFile);
        exit;
    }
}

// Route to corresponding PHP page
if (isset($routes[$path])) {
    $targetFile = $rootDir . '/' . $routes[$path];
    if (file_exists($targetFile)) {
        chdir($rootDir);
        require $targetFile;
        exit;
    }
}

// 404 Fallback
http_response_code(404);
chdir($rootDir);
$pageTitle = "Page Not Found";
require_once $rootDir . '/includes/header.php';
?>
<section class="page-banner">
  <div class="container">
    <h1 class="page-banner-title">404 - Page <span>Not Found</span></h1>
    <p class="page-banner-desc">The requested URL was not found on CampusFest 2026.</p>
  </div>
</section>
<section class="section" style="text-align: center; padding: 4rem 1rem;">
  <div class="container" style="max-width: 600px;">
    <div style="font-size: 4rem; margin-bottom: 1rem;">🔍</div>
    <h3 style="font-family: var(--font-brand); color: var(--primary-navy); margin-bottom: 1rem;">Lost Your Way to the Arena?</h3>
    <p style="color: var(--gray-600); margin-bottom: 2rem;">
      We couldn't locate the page you were searching for. Check the URL or navigate back to the festival homepage.
    </p>
    <a href="index.php" class="btn btn-gold btn-lg">Back to CampusFest Home &rarr;</a>
  </div>
</section>
<?php
require_once $rootDir . '/includes/footer.php';
