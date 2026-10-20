<?php
/**
 * CampusFest 2026 - Header Include
 */
if (!isset($pdo)) {
    require_once __DIR__ . '/../db.php';
}

$currentUser = getCurrentUser();
$flash = getFlash();
$activePage = $activePage ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) . ' | CampusFest 2026' : 'CampusFest 2026 | National Level Inter-Collegiate Mega Fest'; ?></title>
  <meta name="description" content="CampusFest 2026 - The premier inter-collegiate national fest featuring Technical, Cultural, and Sports events with thrilling competitions and grand cash prizes.">
  <link rel="stylesheet" href="style.css">
  <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='20' fill='%230c2b64'/><text x='50%' y='68%' font-size='55' font-family='Georgia,serif' font-weight='bold' fill='%23ffd700' text-anchor='middle'>CF</text></svg>">
</head>
<body>

  <!-- Top Announcement Banner -->
  <aside class="top-announcement" style="background: #071329; color: #ffd700; font-size: 0.8rem; text-align: center; padding: 7px 10px; border-bottom: 1px solid rgba(212, 175, 55, 0.4); font-weight: 600; letter-spacing: 0.5px;">
    <span>⚡ CAMPUSFEST 2026 DATES ANNOUNCED: MARCH 18-20, 2026 | ₹2,50,000+ CASH PRIZES | REGISTRATIONS CLOSING SOON!</span>
  </aside>

  <!-- Main Navigation Header -->
  <header class="site-header">
    <div class="container header-inner">
      <a href="index.php" class="brand-logo" aria-label="CampusFest 2026 Home">
        <div class="logo-badge">CF</div>
        <div class="brand-text">
          <div class="brand-title">CAMPUS<span>FEST</span></div>
          <div class="brand-subtitle">National College Fest 2026</div>
        </div>
      </a>

      <nav class="nav-links" id="navLinks" aria-label="Primary Navigation">
        <a href="index.php" class="<?php echo ($activePage === 'home') ? 'active' : ''; ?>">Home</a>
        <a href="about.php" class="<?php echo ($activePage === 'about') ? 'active' : ''; ?>">About</a>
        <a href="events.php" class="<?php echo ($activePage === 'events') ? 'active' : ''; ?>">Events</a>
        <a href="register.php" class="<?php echo ($activePage === 'register') ? 'active' : ''; ?>">Registration</a>
        <a href="gallery.php" class="<?php echo ($activePage === 'gallery') ? 'active' : ''; ?>">Gallery</a>
        <a href="location.php" class="<?php echo ($activePage === 'location') ? 'active' : ''; ?>">Location</a>
        <a href="contact.php" class="<?php echo ($activePage === 'contact') ? 'active' : ''; ?>">Contact</a>
        <a href="payment.php" class="<?php echo ($activePage === 'payment') ? 'active' : ''; ?>">Payment</a>
      </nav>

      <div class="header-actions">
        <?php if ($currentUser): ?>
          <a href="dashboard.php" class="user-menu-pill" title="Student Dashboard">
            <span class="avatar"><?php echo strtoupper(substr($currentUser['name'], 0, 1)); ?></span>
            <span><?php echo htmlspecialchars(explode(' ', $currentUser['name'])[0]); ?></span>
          </a>
          <a href="logout.php" class="btn btn-sm btn-outline-white" style="padding: 6px 12px; font-size: 0.8rem;">Logout</a>
        <?php else: ?>
          <a href="login.php" class="btn btn-sm btn-outline-white">Login</a>
          <a href="register.php" class="btn btn-sm btn-gold">Register</a>
        <?php endif; ?>
        
        <button type="button" class="nav-toggle-btn" id="navToggleBtn" aria-label="Toggle navigation">&#9776;</button>
      </div>
    </div>
  </header>

  <!-- Global Flash Messages -->
  <div class="container" style="margin-top: 1.5rem;">
    <?php if ($flash): ?>
      <div class="alert alert-<?php echo htmlspecialchars($flash['type']); ?> alert-dismissible" role="alert">
        <strong>Notice:</strong> <?php echo htmlspecialchars($flash['message']); ?>
      </div>
    <?php endif; ?>

    <?php if (isset($db_error) && !empty($db_error)): ?>
      <div class="alert alert-warning" style="border-left: 5px solid #d4af37;" role="alert">
        <div>
          <strong>Database Notice:</strong> <?php echo htmlspecialchars($db_error); ?><br>
          <small>Tip: Start <strong>Apache</strong> and <strong>MySQL</strong> in your <strong>XAMPP Control Panel</strong>, then import <code>database.sql</code> via phpMyAdmin if not automatically created.</small>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <main>
