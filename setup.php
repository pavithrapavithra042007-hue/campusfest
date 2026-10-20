<?php
/**
 * CampusFest 2026 - One-Click Database Setup & Diagnostics Utility
 */
$pageTitle = "Database Setup & Health Check";
require_once __DIR__ . '/db.php';

$log = [];
$status = 'pending';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'run_setup') {
    try {
        $root_dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";charset=utf8mb4";
        $testPdo = new PDO($root_dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        $log[] = "✅ Connected to MySQL server on " . DB_HOST . ":" . DB_PORT . " as user '" . DB_USER . "'";

        // Create database
        $testPdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
        $log[] = "✅ Database `" . DB_NAME . "` verified / created successfully.";

        // Reconnect to campusfest_db
        $appPdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // Run database.sql
        $sqlPath = __DIR__ . '/database.sql';
        if (file_exists($sqlPath)) {
            $sqlQueries = file_get_contents($sqlPath);
            $appPdo->exec($sqlQueries);
            $log[] = "✅ database.sql executed successfully! Tables created and events seeded.";
        } else {
            $log[] = "⚠️ database.sql file not found in root directory.";
        }

        // Count events
        $count = $appPdo->query("SELECT COUNT(*) FROM events")->fetchColumn();
        $log[] = "✅ Total Events loaded in database: " . $count;

        $status = 'success';
        setFlash('success', "Database setup successfully completed! You are ready to explore CampusFest 2026.");
    } catch (Exception $e) {
        $status = 'error';
        $log[] = "❌ Setup Failed: " . $e->getMessage();
        $log[] = "👉 Please make sure Apache and MySQL services are started in your XAMPP Control Panel.";
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<section class="page-banner">
  <div class="container">
    <h1 class="page-banner-title">Database Setup & <span>Diagnostics</span></h1>
    <p class="page-banner-desc">Initialize the MySQL database and verify XAMPP configurations.</p>
  </div>
</section>

<section class="section">
  <div class="container" style="max-width: 700px;">
    
    <div class="form-card">
      <div class="form-card-header">
        <h2>CAMPUSFEST <span>SETUP WIZARD</span></h2>
        <p>1-Click MySQL Database Creator & Table Seeder</p>
      </div>

      <div class="form-card-body">
        
        <div style="background: var(--royal-blue-subtle); padding: 1.4rem; border-radius: var(--radius-md); border-left: 4px solid var(--gold-primary); margin-bottom: 1.8rem; font-size: 0.92rem; color: var(--primary-navy);">
          <strong>Target Configuration:</strong>
          <ul style="margin-top: 6px; list-style: disc; padding-left: 1.5rem; color: var(--gray-600);">
            <li>Host: <code>localhost:3306</code></li>
            <li>User: <code>root</code></li>
            <li>Password: <code>(empty default)</code></li>
            <li>Database: <code>campusfest_db</code></li>
          </ul>
        </div>

        <?php if (!empty($log)): ?>
          <div style="background: #071329; color: #f1f5f9; padding: 1.2rem; border-radius: var(--radius-md); font-family: monospace; font-size: 0.88rem; margin-bottom: 1.8rem; line-height: 1.8;">
            <?php foreach ($log as $line): ?>
              <div><?php echo htmlspecialchars($line); ?></div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <form action="setup.php" method="POST">
          <input type="hidden" name="action" value="run_setup">
          <button type="submit" class="btn btn-gold btn-block btn-lg">
            ⚡ Run Database Setup & Seed Tables
          </button>
        </form>

        <div style="margin-top: 1.5rem; text-align: center;">
          <a href="index.php" class="btn btn-outline-royal">Return to CampusFest Home &rarr;</a>
        </div>

      </div>
    </div>

  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
