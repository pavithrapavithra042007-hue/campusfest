<?php
$pageTitle = "Demo Payment Gateway | CampusFest 2026";
$activePage = "payment";
require_once __DIR__ . '/db.php';

$regId = isset($_GET['reg_id']) ? sanitize($_GET['reg_id']) : '';
$viewReceipt = isset($_GET['view_receipt']) && $_GET['view_receipt'] == '1';
$regRecord = null;
$paymentSuccess = false;
$txnId = '';

// Check database for registration details
if (!empty($regId) && $pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM registrations WHERE registration_number = ? LIMIT 1");
        $stmt->execute([$regId]);
        $regRecord = $stmt->fetch();
        if ($regRecord && $regRecord['payment_status'] === 'Completed') {
            $viewReceipt = true;
            $txnId = $regRecord['transaction_id'] ?? ('TXN-CF26-' . rand(100000, 999999));
        }
    } catch (PDOException $e) {
        // Fallback
    }
}

// Handle simulated payment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'process_demo_payment') {
    $submittedRegId = sanitize($_POST['registration_number'] ?? '');
    $paymentMethod = sanitize($_POST['payment_method'] ?? 'UPI / QR Code');
    $amount = floatval($_POST['amount'] ?? 500.00);
    $txnId = "TXN-CF26-" . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 10));

    if (!empty($submittedRegId) && $pdo) {
        try {
            // Find registration
            $fStmt = $pdo->prepare("SELECT * FROM registrations WHERE registration_number = ? LIMIT 1");
            $fStmt->execute([$submittedRegId]);
            $currentReg = $fStmt->fetch();

            if ($currentReg) {
                // Update registration table using prepared statement
                $uStmt = $pdo->prepare("UPDATE registrations SET payment_status = 'Completed', transaction_id = ? WHERE id = ?");
                $uStmt->execute([$txnId, $currentReg['id']]);

                // Insert into payments table using prepared statement
                $pStmt = $pdo->prepare("INSERT INTO payments (registration_id, registration_number, transaction_id, amount, payment_method, status) VALUES (?, ?, ?, ?, ?, 'Success')");
                $pStmt->execute([$currentReg['id'], $submittedRegId, $txnId, $amount, $paymentMethod]);

                $regRecord = $currentReg;
                $regRecord['payment_status'] = 'Completed';
                $regRecord['transaction_id'] = $txnId;
                $viewReceipt = true;
                $paymentSuccess = true;
            }
        } catch (PDOException $e) {
            $db_error = "Payment record update error: " . $e->getMessage();
        }
    } else {
        // Simulation when DB offline
        $viewReceipt = true;
        $paymentSuccess = true;
        $regRecord = [
            'registration_number' => $submittedRegId ?: ('CF26-DEMO' . rand(100, 999)),
            'student_name' => sanitize($_POST['student_name'] ?? 'Alex Johnson'),
            'email' => 'alex@university.edu',
            'college' => 'Apex Institute of Technology',
            'event_title' => sanitize($_POST['event_title'] ?? 'CodeSprint 24-Hour Hackathon'),
            'amount' => $amount,
            'payment_status' => 'Completed',
            'transaction_id' => $txnId,
            'team_type' => 'Solo',
            'created_at' => date('Y-m-d H:i:s')
        ];
    }
}

// Fallback demo values if accessed directly without parameter
if (!$regRecord) {
    if (!empty($_GET['demo'])) {
        $regRecord = [
            'registration_number' => $regId ?: 'CF26-DEMO884',
            'student_name' => isset($_GET['name']) ? sanitize($_GET['name']) : 'Demo Participant',
            'email' => 'student@college.edu',
            'college' => 'Apex Institute of Technology',
            'event_title' => isset($_GET['event']) ? sanitize($_GET['event']) : 'CodeSprint 24-Hour Hackathon',
            'amount' => isset($_GET['fee']) ? floatval($_GET['fee']) : 500.00,
            'payment_status' => 'Pending',
            'team_type' => 'Solo',
            'created_at' => date('Y-m-d H:i:s')
        ];
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<!-- Banner -->
<section class="page-banner">
  <div class="container">
    <h1 class="page-banner-title">Demo Payment <span>Gateway</span></h1>
    <p class="page-banner-desc">Simulated payment sandbox for testing and slot confirmation. No actual funds are charged.</p>
    <div class="breadcrumb">
      <a href="index.php">Home</a> / <span>Payment Gateway</span>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">

    <!-- Case 1: Display Completed Payment Receipt / Pass -->
    <?php if ($viewReceipt && $regRecord): ?>
      
      <div class="receipt-card" id="printableReceipt">
        <div class="receipt-icon">✓</div>
        <span class="badge badge-gold" style="margin-bottom: 0.8rem;">Official Fest Entry Pass</span>
        
        <h2 style="font-family: var(--font-brand); font-size: 1.8rem; color: var(--primary-navy); margin-bottom: 0.4rem;">
          Payment Confirmed!
        </h2>
        <p style="color: var(--gray-600); font-size: 0.95rem; margin-bottom: 2rem;">
          Your competition slot is locked in for CampusFest 2026. Please retain this receipt or take a screenshot.
        </p>

        <div style="background: var(--royal-blue-subtle); border: 2px solid var(--royal-blue-border); border-radius: var(--radius-lg); padding: 1.8rem; text-align: left; margin-bottom: 2rem;">
          
          <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--gray-200); padding-bottom: 0.8rem; margin-bottom: 0.8rem;">
            <span style="color: var(--gray-600);">Registration ID:</span>
            <strong style="color: var(--royal-blue); font-family: monospace; font-size: 1.1rem;"><?php echo htmlspecialchars($regRecord['registration_number']); ?></strong>
          </div>

          <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--gray-200); padding-bottom: 0.8rem; margin-bottom: 0.8rem;">
            <span style="color: var(--gray-600);">Transaction Ref:</span>
            <strong style="font-family: monospace; font-size: 0.95rem; color: var(--primary-navy);"><?php echo htmlspecialchars($regRecord['transaction_id'] ?? $txnId); ?></strong>
          </div>

          <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--gray-200); padding-bottom: 0.8rem; margin-bottom: 0.8rem;">
            <span style="color: var(--gray-600);">Student Name:</span>
            <strong><?php echo htmlspecialchars($regRecord['student_name']); ?></strong>
          </div>

          <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--gray-200); padding-bottom: 0.8rem; margin-bottom: 0.8rem;">
            <span style="color: var(--gray-600);">Competition / Event:</span>
            <strong style="color: var(--primary-navy);"><?php echo htmlspecialchars($regRecord['event_title']); ?></strong>
          </div>

          <div style="display: flex; justify-content: space-between; border-bottom: 1px solid var(--gray-200); padding-bottom: 0.8rem; margin-bottom: 0.8rem;">
            <span style="color: var(--gray-600);">Institution:</span>
            <strong><?php echo htmlspecialchars($regRecord['college'] ?? 'Participating University'); ?></strong>
          </div>

          <div style="display: flex; justify-content: space-between; padding-top: 0.4rem;">
            <span style="color: var(--gray-600); font-size: 1.05rem; font-weight: 700;">Amount Paid:</span>
            <strong style="color: var(--gold-dark); font-size: 1.3rem;">₹<?php echo number_format($regRecord['amount'], 2); ?> (PAID)</strong>
          </div>

        </div>

        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
          <button type="button" onclick="window.print()" class="btn btn-royal">
            🖨️ Print / Save Pass
          </button>
          <a href="dashboard.php" class="btn btn-outline-royal">
            Go to Student Dashboard
          </a>
          <a href="events.php" class="btn btn-gold">
            Browse More Events
          </a>
        </div>
      </div>

    <!-- Case 2: Active Demo Payment Checkout -->
    <?php elseif ($regRecord): ?>
      
      <div class="payment-layout">
        
        <!-- Summary Column -->
        <div class="summary-card">
          <div class="summary-header">
            <span class="badge badge-gold" style="margin-bottom: 6px;">CampusFest 2026 Invoice</span>
            <h3 class="summary-title">Registration Summary</h3>
          </div>

          <div class="summary-list">
            <div class="summary-row">
              <span>Registration ID</span>
              <strong style="font-family: monospace; color: var(--royal-blue);"><?php echo htmlspecialchars($regRecord['registration_number']); ?></strong>
            </div>
            <div class="summary-row">
              <span>Candidate Name</span>
              <strong><?php echo htmlspecialchars($regRecord['student_name']); ?></strong>
            </div>
            <div class="summary-row">
              <span>College</span>
              <strong><?php echo htmlspecialchars($regRecord['college'] ?? 'Registered Institution'); ?></strong>
            </div>
            <div class="summary-row">
              <span>Selected Event</span>
              <strong style="color: var(--primary-navy);"><?php echo htmlspecialchars($regRecord['event_title']); ?></strong>
            </div>
            <div class="summary-row">
              <span>Category Pass</span>
              <strong>All-Access Entry + Certificate</strong>
            </div>
            <div class="summary-row">
              <span>Base Event Fee</span>
              <span>₹<?php echo number_format($regRecord['amount'], 2); ?></span>
            </div>
            <div class="summary-row">
              <span>Convenience Fee / GST</span>
              <span style="color: var(--success); font-weight: 700;">₹0.00 (Waived)</span>
            </div>

            <div class="summary-total">
              <span>Total Payable</span>
              <strong>₹<?php echo number_format($regRecord['amount'], 2); ?></strong>
            </div>
          </div>

          <div style="margin-top: 1.8rem; padding: 1rem; background: var(--royal-blue-subtle); border-radius: var(--radius-md); font-size: 0.85rem; color: var(--gray-600);">
            💡 <strong>Sandbox Environment:</strong> This is a demo gateway interface. No actual bank charge will occur. Click any payment tab and trigger the mock authorization.
          </div>
        </div>

        <!-- Simulated Gateway Card -->
        <div class="gateway-card">
          <div class="gateway-card-header">
            <div>
              <div style="font-weight: 800; font-size: 1.1rem; color: var(--gold-light);">CAMPUSFEST SECUREPAY</div>
              <small style="color: rgba(255,255,255,0.7);">256-Bit SSL Demo Sandbox</small>
            </div>
            <span class="badge badge-tech" style="background: rgba(255,255,255,0.2); color: var(--white); border: 1px solid rgba(255,255,255,0.4);">TEST MODE</span>
          </div>

          <!-- Payment Tabs -->
          <div class="gateway-tabs">
            <button type="button" class="gateway-tab active" data-target="payTabUpi">
              📱 UPI / QR Code
            </button>
            <button type="button" class="gateway-tab" data-target="payTabCard">
              💳 Card (Debit/Credit)
            </button>
            <button type="button" class="gateway-tab" data-target="payTabNetbank">
              🏦 Net Banking
            </button>
          </div>

          <div class="gateway-tab-content">
            
            <!-- Tab 1: UPI & QR Code -->
            <div id="payTabUpi" class="payment-tab-content">
              <div class="qr-container">
                <div class="qr-box">
                  <!-- Clean SVG QR Code Representation -->
                  <svg viewBox="0 0 100 100" width="180" height="180" xmlns="http://www.w3.org/2000/svg">
                    <rect width="100" height="100" fill="#ffffff" />
                    <!-- Corner 1 -->
                    <rect x="10" y="10" width="28" height="28" fill="#0c2b64" rx="3"/>
                    <rect x="16" y="16" width="16" height="16" fill="#ffffff" />
                    <rect x="20" y="20" width="8" height="8" fill="#d4af37" />
                    <!-- Corner 2 -->
                    <rect x="62" y="10" width="28" height="28" fill="#0c2b64" rx="3"/>
                    <rect x="68" y="16" width="16" height="16" fill="#ffffff" />
                    <rect x="72" y="20" width="8" height="8" fill="#d4af37" />
                    <!-- Corner 3 -->
                    <rect x="10" y="62" width="28" height="28" fill="#0c2b64" rx="3"/>
                    <rect x="16" y="68" width="16" height="16" fill="#ffffff" />
                    <rect x="20" y="72" width="8" height="8" fill="#d4af37" />
                    <!-- Inner Grid Patterns -->
                    <rect x="44" y="12" width="6" height="12" fill="#0c2b64" />
                    <rect x="44" y="28" width="8" height="6" fill="#d4af37" />
                    <rect x="14" y="44" width="12" height="6" fill="#0c2b64" />
                    <rect x="32" y="44" width="6" height="14" fill="#0c2b64" />
                    <rect x="44" y="44" width="12" height="12" fill="#0c2b64" rx="2"/>
                    <rect x="62" y="44" width="8" height="6" fill="#0c2b64" />
                    <rect x="76" y="44" width="12" height="14" fill="#d4af37" />
                    <rect x="44" y="62" width="8" height="10" fill="#0c2b64" />
                    <rect x="58" y="62" width="14" height="6" fill="#0c2b64" />
                    <rect x="58" y="74" width="12" height="14" fill="#0c2b64" />
                    <rect x="76" y="64" width="12" height="10" fill="#d4af37" />
                    <rect x="76" y="80" width="14" height="8" fill="#0c2b64" />
                  </svg>
                </div>
                <p style="font-weight: 700; color: var(--primary-navy); margin-bottom: 4px;">
                  Scan via GPay / PhonePe / Paytm / Any UPI App
                </p>
                <div style="font-size: 0.85rem; color: var(--gray-600); margin-bottom: 1.5rem;">
                  UPI VPA: <code>campusfest2026@festupi</code>
                </div>

                <form action="payment.php" method="POST">
                  <input type="hidden" name="action" value="process_demo_payment">
                  <input type="hidden" name="registration_number" value="<?php echo htmlspecialchars($regRecord['registration_number']); ?>">
                  <input type="hidden" name="payment_method" value="UPI / QR Code">
                  <input type="hidden" name="amount" value="<?php echo htmlspecialchars($regRecord['amount']); ?>">
                  <input type="hidden" name="student_name" value="<?php echo htmlspecialchars($regRecord['student_name']); ?>">
                  <input type="hidden" name="event_title" value="<?php echo htmlspecialchars($regRecord['event_title']); ?>">

                  <button type="submit" class="btn btn-gold btn-block btn-lg">
                    ⚡ Simulate Successful UPI Payment (₹<?php echo number_format($regRecord['amount'], 2); ?>)
                  </button>
                </form>
              </div>
            </div>

            <!-- Tab 2: Credit / Debit Card -->
            <div id="payTabCard" class="payment-tab-content" style="display: none;">
              <form action="payment.php" method="POST">
                <input type="hidden" name="action" value="process_demo_payment">
                <input type="hidden" name="registration_number" value="<?php echo htmlspecialchars($regRecord['registration_number']); ?>">
                <input type="hidden" name="payment_method" value="Credit/Debit Card">
                <input type="hidden" name="amount" value="<?php echo htmlspecialchars($regRecord['amount']); ?>">
                <input type="hidden" name="student_name" value="<?php echo htmlspecialchars($regRecord['student_name']); ?>">
                <input type="hidden" name="event_title" value="<?php echo htmlspecialchars($regRecord['event_title']); ?>">

                <div class="form-group">
                  <label class="form-label" for="card_number">Card Number</label>
                  <input type="text" id="card_number" class="form-control" placeholder="4111 2222 3333 4444" maxlength="19" value="4532 8920 1123 4821">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                  <div class="form-group">
                    <label class="form-label" for="card_exp">Expiry Date</label>
                    <input type="text" id="card_exp" class="form-control" placeholder="MM/YY" maxlength="5" value="12/28">
                  </div>
                  <div class="form-group">
                    <label class="form-label" for="card_cvv">CVV</label>
                    <input type="password" id="card_cvv" class="form-control" placeholder="•••" maxlength="4" value="789">
                  </div>
                </div>

                <div class="form-group">
                  <label class="form-label" for="card_holder">Cardholder Name</label>
                  <input type="text" id="card_holder" class="form-control" value="<?php echo htmlspecialchars($regRecord['student_name']); ?>">
                </div>

                <div style="margin-top: 1.5rem;">
                  <button type="submit" class="btn btn-gold btn-block btn-lg">
                    🔒 Pay ₹<?php echo number_format($regRecord['amount'], 2); ?> via Card
                  </button>
                </div>
              </form>
            </div>

            <!-- Tab 3: Net Banking -->
            <div id="payTabNetbank" class="payment-tab-content" style="display: none;">
              <form action="payment.php" method="POST">
                <input type="hidden" name="action" value="process_demo_payment">
                <input type="hidden" name="registration_number" value="<?php echo htmlspecialchars($regRecord['registration_number']); ?>">
                <input type="hidden" name="payment_method" value="Net Banking">
                <input type="hidden" name="amount" value="<?php echo htmlspecialchars($regRecord['amount']); ?>">
                <input type="hidden" name="student_name" value="<?php echo htmlspecialchars($regRecord['student_name']); ?>">
                <input type="hidden" name="event_title" value="<?php echo htmlspecialchars($regRecord['event_title']); ?>">

                <p style="font-size: 0.9rem; color: var(--gray-600); margin-bottom: 1rem;">Select your bank to proceed with test authentication:</p>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.8rem; margin-bottom: 1.5rem;">
                  <label style="border: 1px solid var(--gray-300); padding: 10px; border-radius: var(--radius-sm); display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.9rem;">
                    <input type="radio" name="bank" value="SBI" checked> State Bank of India
                  </label>
                  <label style="border: 1px solid var(--gray-300); padding: 10px; border-radius: var(--radius-sm); display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.9rem;">
                    <input type="radio" name="bank" value="HDFC"> HDFC Bank
                  </label>
                  <label style="border: 1px solid var(--gray-300); padding: 10px; border-radius: var(--radius-sm); display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.9rem;">
                    <input type="radio" name="bank" value="ICICI"> ICICI Bank
                  </label>
                  <label style="border: 1px solid var(--gray-300); padding: 10px; border-radius: var(--radius-sm); display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.9rem;">
                    <input type="radio" name="bank" value="Axis"> Axis Bank
                  </label>
                </div>

                <button type="submit" class="btn btn-gold btn-block btn-lg">
                  🏦 Authorize Net Banking Payment
                </button>
              </form>
            </div>

          </div>
        </div>

      </div>

    <!-- Case 3: Registration ID Search Lookup -->
    <?php else: ?>
      
      <div class="form-card" style="max-width: 600px;">
        <div class="form-card-header">
          <h2>FETCH <span>REGISTRATION FEE</span></h2>
          <p>Enter your Registration ID to proceed to the payment sandbox</p>
        </div>

        <div class="form-card-body">
          <form action="payment.php" method="GET">
            <div class="form-group">
              <label class="form-label" for="lookup_reg_id">Registration ID (e.g. CF26-XXXX)</label>
              <input type="text" id="lookup_reg_id" name="reg_id" class="form-control" placeholder="CF26-ABC12345" required>
            </div>

            <div style="margin-top: 1.5rem;">
              <button type="submit" class="btn btn-gold btn-block btn-lg">
                Fetch Registration Bill &rarr;
              </button>
            </div>
          </form>

          <div style="margin-top: 2rem; border-top: 1px solid var(--gray-200); padding-top: 1.5rem; text-align: center;">
            <p style="font-size: 0.9rem; color: var(--gray-600); margin-bottom: 1rem;">
              Haven't registered for any event yet?
            </p>
            <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
              <a href="register.php" class="btn btn-royal">Go to Registration Form</a>
              <a href="payment.php?demo=1" class="btn btn-outline-gold">Test Demo Checkout</a>
            </div>
          </div>
        </div>
      </div>

    <?php endif; ?>

  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
