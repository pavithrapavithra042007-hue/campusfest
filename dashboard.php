<?php
$pageTitle = "Student Dashboard | CampusFest 2026";
$activePage = "dashboard";
require_once __DIR__ . '/db.php';

if (!isLoggedIn()) {
    setFlash('warning', "Please sign in to access your student dashboard.");
    header("Location: login.php");
    exit;
}

$user = getCurrentUser();
$registrations = [];

if ($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM registrations WHERE email = ? OR user_id = ? ORDER BY id DESC");
        $stmt->execute([$user['email'], $user['id']]);
        $registrations = $stmt->fetchAll();
    } catch (PDOException $e) {
        // Fallback
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<!-- Banner -->
<section class="page-banner">
  <div class="container">
    <h1 class="page-banner-title">Welcome, <span><?php echo htmlspecialchars($user['name']); ?></span></h1>
    <p class="page-banner-desc">Student Dashboard: Track your event registrations, fees, passes, and schedule.</p>
    <div class="breadcrumb">
      <a href="index.php">Home</a> / <span>Dashboard</span>
    </div>
  </div>
</section>

<!-- Dashboard Section -->
<section class="section">
  <div class="container">
    
    <!-- User Info Card -->
    <div style="background: var(--white); border-radius: var(--radius-lg); padding: 2rem; border: 1px solid var(--gray-200); box-shadow: var(--shadow-sm); margin-bottom: 2.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem;">
      <div style="display: flex; align-items: center; gap: 1.5rem;">
        <div style="width: 68px; height: 68px; border-radius: 50%; background: var(--gold-gradient); color: var(--primary-navy); display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 800; box-shadow: var(--shadow-gold);">
          <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
        </div>
        <div>
          <h2 style="font-size: 1.5rem; color: var(--primary-navy); margin-bottom: 4px;"><?php echo htmlspecialchars($user['name']); ?></h2>
          <p style="color: var(--gray-600); font-size: 0.95rem;">
            🏫 <?php echo htmlspecialchars($user['college']); ?> | ✉️ <?php echo htmlspecialchars($user['email']); ?>
          </p>
        </div>
      </div>
      <div>
        <a href="register.php" class="btn btn-gold">+ Register for Another Event</a>
      </div>
    </div>

    <!-- Registered Events Table -->
    <div style="background: var(--white); border-radius: var(--radius-lg); border: 1px solid var(--gray-200); box-shadow: var(--shadow-md); overflow: hidden;">
      <div style="background: var(--royal-blue); color: var(--white); padding: 1.2rem 2rem; border-bottom: 2px solid var(--gold-primary); display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-family: var(--font-brand); font-size: 1.25rem; color: var(--white); margin: 0;">My Registered Competitions</h3>
        <span class="badge badge-gold"><?php echo count($registrations); ?> Events Enrolled</span>
      </div>

      <div style="padding: 1.5rem; overflow-x: auto;">
        <?php if (!empty($registrations)): ?>
          <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.95rem;">
            <thead>
              <tr style="border-bottom: 2px solid var(--gray-200); color: var(--gray-600); text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px;">
                <th style="padding: 12px 16px;">Reg ID</th>
                <th style="padding: 12px 16px;">Event Title</th>
                <th style="padding: 12px 16px;">Type</th>
                <th style="padding: 12px 16px;">Amount</th>
                <th style="padding: 12px 16px;">Payment</th>
                <th style="padding: 12px 16px; text-align: right;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($registrations as $reg): ?>
                <tr style="border-bottom: 1px solid var(--gray-200);">
                  <td style="padding: 14px 16px; font-weight: 700; color: var(--royal-blue); font-family: monospace; font-size: 1rem;">
                    <?php echo htmlspecialchars($reg['registration_number']); ?>
                  </td>
                  <td style="padding: 14px 16px; font-weight: 600; color: var(--primary-navy);">
                    <?php echo htmlspecialchars($reg['event_title']); ?>
                  </td>
                  <td style="padding: 14px 16px;">
                    <span class="badge badge-tech"><?php echo htmlspecialchars($reg['team_type']); ?></span>
                  </td>
                  <td style="padding: 14px 16px; font-weight: 700;">
                    ₹<?php echo number_format($reg['amount'], 2); ?>
                  </td>
                  <td style="padding: 14px 16px;">
                    <?php if ($reg['payment_status'] === 'Completed'): ?>
                      <span class="badge badge-sports" style="background: #ecfdf5; color: #065f46; border-color: #a7f3d0;">✓ Completed</span>
                    <?php else: ?>
                      <span class="badge badge-cultural" style="background: #fffbeb; color: #b45309; border-color: #fde68a;">⏳ Pending</span>
                    <?php endif; ?>
                  </td>
                  <td style="padding: 14px 16px; text-align: right;">
                    <?php if ($reg['payment_status'] === 'Completed'): ?>
                      <a href="payment.php?reg_id=<?php echo urlencode($reg['registration_number']); ?>&view_receipt=1" class="btn btn-sm btn-outline-royal">
                        📄 Receipt
                      </a>
                    <?php else: ?>
                      <a href="payment.php?reg_id=<?php echo urlencode($reg['registration_number']); ?>" class="btn btn-sm btn-gold">
                        💳 Pay Now
                      </a>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php else: ?>
          <div style="text-align: center; padding: 3rem 1rem;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">🎪</div>
            <h4 style="font-size: 1.2rem; color: var(--primary-navy); margin-bottom: 0.5rem;">No Event Registrations Found Yet</h4>
            <p style="color: var(--gray-600); margin-bottom: 1.5rem; max-width: 480px; margin-left: auto; margin-right: auto;">
              Explore our Technical, Cultural, and Sports competitions, secure your slot, and battle for the grand championship trophy!
            </p>
            <a href="events.php" class="btn btn-gold">Browse & Register for Events</a>
          </div>
        <?php endif; ?>
      </div>
    </div>

  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
