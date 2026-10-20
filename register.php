<?php
$pageTitle = "Event Registration | CampusFest 2026";
$activePage = "register";
require_once __DIR__ . '/db.php';

$errors = [];
$success = "";
$preSelectedEventId = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;

// Fetch events list for dropdown
$eventList = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT id, title, category, fee, team_size FROM events ORDER BY category, title ASC");
        $eventList = $stmt->fetchAll();
    } catch (Exception $e) {
        // Fallback
    }
}

// Fallback if DB empty or offline
if (empty($eventList)) {
    $eventList = [
        ['id' => 1, 'title' => 'CodeSprint 24-Hour Hackathon', 'category' => 'Technical', 'fee' => 500.00, 'team_size' => '2 - 4 Members'],
        ['id' => 2, 'title' => 'RoboWars: Clash of Titans', 'category' => 'Technical', 'fee' => 600.00, 'team_size' => '2 - 5 Members'],
        ['id' => 3, 'title' => 'WebCraft UI/UX & Web Sprint', 'category' => 'Technical', 'fee' => 250.00, 'team_size' => 'Solo or Duo'],
        ['id' => 4, 'title' => 'CyberShield Capture The Flag (CTF)', 'category' => 'Technical', 'fee' => 300.00, 'team_size' => 'Solo or Duo'],
        ['id' => 5, 'title' => 'Symphony: Battle of the Bands', 'category' => 'Cultural', 'fee' => 800.00, 'team_size' => '4 - 8 Members'],
        ['id' => 6, 'title' => 'Rhythm Royale: Western & Fusion Dance', 'category' => 'Cultural', 'fee' => 750.00, 'team_size' => '6 - 15 Members'],
        ['id' => 7, 'title' => 'Vogue: The Grand Fashion Show', 'category' => 'Cultural', 'fee' => 1000.00, 'team_size' => '10 - 18 Members'],
        ['id' => 8, 'title' => 'Natya Manch: Street Play (Nukkad Natak)', 'category' => 'Cultural', 'fee' => 400.00, 'team_size' => '8 - 20 Members'],
        ['id' => 9, 'title' => 'Campus Champions Cup: 7-a-side Football', 'category' => 'Sports', 'fee' => 900.00, 'team_size' => '7 + 3 Substitutes'],
        ['id' => 10, 'title' => 'Gully to Glory: Box Cricket League', 'category' => 'Sports', 'fee' => 700.00, 'team_size' => '6 + 2 Substitutes'],
        ['id' => 11, 'title' => 'Smash Masters: Badminton Championship', 'category' => 'Sports', 'fee' => 300.00, 'team_size' => 'Solo or Duo'],
        ['id' => 12, 'title' => 'Checkmate: Rapid Chess Masters', 'category' => 'Sports', 'fee' => 200.00, 'team_size' => 'Solo']
    ];
}

// Prefill from session if logged in
$user = getCurrentUser();
$student_name = $user['name'] ?? ($_POST['student_name'] ?? '');
$email = $user['email'] ?? ($_POST['email'] ?? '');
$phone = $user['phone'] ?? ($_POST['phone'] ?? '');
$college = $user['college'] ?? ($_POST['college'] ?? '');
$department = $_POST['department'] ?? '';
$year_of_study = $_POST['year_of_study'] ?? '3rd Year';
$event_id = $_POST['event_id'] ?? $preSelectedEventId;
$team_type = $_POST['team_type'] ?? 'Solo';
$team_members = $_POST['team_members'] ?? '';

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_name = sanitize($_POST['student_name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $college = sanitize($_POST['college'] ?? '');
    $department = sanitize($_POST['department'] ?? '');
    $year_of_study = sanitize($_POST['year_of_study'] ?? '');
    $event_id = intval($_POST['event_id'] ?? 0);
    $team_type = sanitize($_POST['team_type'] ?? 'Solo');
    $team_members = sanitize($_POST['team_members'] ?? '');
    $amount = floatval($_POST['amount'] ?? 0.00);

    // Validation
    if (empty($student_name)) $errors[] = "Full Name is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "A valid Email Address is required.";
    if (empty($phone) || strlen($phone) < 8) $errors[] = "A valid Phone number is required.";
    if (empty($college)) $errors[] = "College / Institution name is required.";
    if (empty($department)) $errors[] = "Department / Major is required.";
    if ($event_id <= 0) $errors[] = "Please select an event to register for.";

    // Find event title & fee
    $selectedEventTitle = "Selected Event";
    foreach ($eventList as $e) {
        if ($e['id'] == $event_id) {
            $selectedEventTitle = $e['title'];
            $amount = floatval($e['fee']);
            break;
        }
    }

    if (empty($errors)) {
        $registration_number = "CF26-" . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
        $userId = $user['id'] ?? null;

        if ($pdo) {
            try {
                // Prepared statement insertion
                $sql = "INSERT INTO registrations 
                    (user_id, registration_number, student_name, email, phone, college, department, year_of_study, event_id, event_title, team_type, team_members, amount, payment_status) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending')";
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $userId,
                    $registration_number,
                    $student_name,
                    $email,
                    $phone,
                    $college,
                    $department,
                    $year_of_study,
                    $event_id,
                    $selectedEventTitle,
                    $team_type,
                    $team_members,
                    $amount
                ]);

                $regDbId = $pdo->lastInsertId();

                setFlash('success', "Registration received! Please proceed to the payment gateway to finalize your slot.");
                header("Location: payment.php?reg_id=" . urlencode($registration_number));
                exit;

            } catch (PDOException $ex) {
                // If tables missing, display informative instruction
                $errors[] = "Registration could not be stored in database: " . $ex->getMessage() . ". (Please ensure MySQL is running in XAMPP and tables are imported).";
            }
        } else {
            // Simulated flow when MySQL not yet started
            setFlash('info', "Simulation: Database is not connected, but your mock registration was prepared! Forwarding to demo payment.");
            header("Location: payment.php?reg_id=" . urlencode($registration_number) . "&demo=1&fee=" . urlencode($amount) . "&event=" . urlencode($selectedEventTitle) . "&name=" . urlencode($student_name));
            exit;
        }
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<!-- Banner -->
<section class="page-banner">
  <div class="container">
    <h1 class="page-banner-title">Event <span>Registration</span></h1>
    <p class="page-banner-desc">Reserve your competition slot for CampusFest 2026. Secure your entry pass and cash prize bid.</p>
    <div class="breadcrumb">
      <a href="index.php">Home</a> / <span>Registration</span>
    </div>
  </div>
</section>

<!-- Registration Form Section -->
<section class="section">
  <div class="container">
    <div class="form-card">
      <div class="form-card-header">
        <h2>CAMPUSFEST <span>2026 ENTRY</span></h2>
        <p>Complete the student credentials and event details below</p>
      </div>

      <div class="form-card-body">
        
        <?php if (!empty($errors)): ?>
          <div class="alert alert-danger" role="alert">
            <ul style="margin: 0; padding-left: 1.2rem;">
              <?php foreach ($errors as $err): ?>
                <li><?php echo htmlspecialchars($err); ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <form action="register.php" method="POST" id="registrationForm" novalidate>
          
          <div class="form-grid">
            
            <!-- Student Full Name -->
            <div class="form-group">
              <label class="form-label" for="student_name">
                Full Name <span class="req">*</span>
              </label>
              <input type="text" id="student_name" name="student_name" class="form-control" placeholder="e.g. Alex Johnson" value="<?php echo htmlspecialchars($student_name); ?>" required>
            </div>

            <!-- Email Address -->
            <div class="form-group">
              <label class="form-label" for="email">
                College / Personal Email <span class="req">*</span>
              </label>
              <input type="email" id="email" name="email" class="form-control" placeholder="alex@university.edu" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>

            <!-- Contact Number -->
            <div class="form-group">
              <label class="form-label" for="phone">
                Mobile Number (WhatsApp) <span class="req">*</span>
              </label>
              <input type="tel" id="phone" name="phone" class="form-control" placeholder="e.g. 9876543210" value="<?php echo htmlspecialchars($phone); ?>" required>
            </div>

            <!-- College Name -->
            <div class="form-group">
              <label class="form-label" for="college">
                College / University Name <span class="req">*</span>
              </label>
              <input type="text" id="college" name="college" class="form-control" placeholder="e.g. National Institute of Tech" value="<?php echo htmlspecialchars($college); ?>" required>
            </div>

            <!-- Department -->
            <div class="form-group">
              <label class="form-label" for="department">
                Department / Branch <span class="req">*</span>
              </label>
              <input type="text" id="department" name="department" class="form-control" placeholder="e.g. Computer Science & Engg" value="<?php echo htmlspecialchars($department); ?>" required>
            </div>

            <!-- Year of Study -->
            <div class="form-group">
              <label class="form-label" for="year_of_study">
                Year of Study <span class="req">*</span>
              </label>
              <select id="year_of_study" name="year_of_study" class="form-control" required>
                <option value="1st Year" <?php echo ($year_of_study === '1st Year') ? 'selected' : ''; ?>>1st Year (Freshman)</option>
                <option value="2nd Year" <?php echo ($year_of_study === '2nd Year') ? 'selected' : ''; ?>>2nd Year (Sophomore)</option>
                <option value="3rd Year" <?php echo ($year_of_study === '3rd Year') ? 'selected' : ''; ?>>3rd Year (Junior)</option>
                <option value="4th Year" <?php echo ($year_of_study === '4th Year') ? 'selected' : ''; ?>>4th Year (Senior)</option>
                <option value="Postgraduate" <?php echo ($year_of_study === 'Postgraduate') ? 'selected' : ''; ?>>Postgraduate / Ph.D.</option>
              </select>
            </div>

            <!-- Event Selection Dropdown -->
            <div class="form-group full-width">
              <label class="form-label" for="eventSelect">
                Select Competition / Event <span class="req">*</span>
              </label>
              <select id="eventSelect" name="event_id" class="form-control" required>
                <option value="">-- Choose an Event --</option>
                
                <?php 
                $currentGroup = '';
                $initialFee = 0.00;
                foreach ($eventList as $ev): 
                  if ($currentGroup !== $ev['category']) {
                    if ($currentGroup !== '') echo '</optgroup>';
                    $currentGroup = $ev['category'];
                    echo '<optgroup label="' . htmlspecialchars($currentGroup) . ' Events">';
                  }
                  $isTeamVal = (stripos($ev['team_size'], 'member') !== false || stripos($ev['team_size'], 'duo') !== false) ? 'true' : 'false';
                  $selectedAttr = ($ev['id'] == $event_id) ? 'selected' : '';
                  if ($ev['id'] == $event_id) {
                    $initialFee = $ev['fee'];
                  }
                ?>
                  <option value="<?php echo $ev['id']; ?>" data-fee="<?php echo $ev['fee']; ?>" data-team="<?php echo $isTeamVal; ?>" <?php echo $selectedAttr; ?>>
                    <?php echo htmlspecialchars($ev['title']); ?> (₹<?php echo number_format($ev['fee'], 2); ?> - <?php echo htmlspecialchars($ev['team_size']); ?>)
                  </option>
                <?php endforeach; 
                if ($currentGroup !== '') echo '</optgroup>';
                ?>
              </select>
            </div>

            <!-- Participation Format -->
            <div class="form-group full-width">
              <label class="form-label">Participation Type</label>
              <div style="display: flex; gap: 2rem; margin-top: 6px;">
                <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer;">
                  <input type="radio" name="team_type" value="Solo" <?php echo ($team_type === 'Solo') ? 'checked' : ''; ?>> Solo Participant
                </label>
                <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer;">
                  <input type="radio" name="team_type" value="Team" <?php echo ($team_type === 'Team') ? 'checked' : ''; ?>> Team Representation
                </label>
              </div>
            </div>

            <!-- Team Members (Conditional) -->
            <div class="form-group full-width" id="teamDetailsSection" style="<?php echo ($team_type === 'Team') ? 'display: block;' : 'display: none;'; ?>">
              <label class="form-label" for="team_members">
                Additional Team Member Names & College IDs
              </label>
              <textarea id="team_members" name="team_members" class="form-control" placeholder="1. John Doe (ID: CS202301)&#10;2. Sarah Khan (ID: CS202345)&#10;3. Liam Patel (ID: ME202319)"><?php echo htmlspecialchars($team_members); ?></textarea>
              <small style="color: var(--gray-600); font-size: 0.8rem;">Enter team members as applicable for team competitions.</small>
            </div>

            <!-- Dynamic Fee Summary Card -->
            <div class="form-group full-width" style="background: var(--royal-blue-subtle); padding: 1.2rem 1.6rem; border-radius: var(--radius-md); border: 1px solid var(--royal-blue-border); display: flex; justify-content: space-between; align-items: center;">
              <div>
                <span style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase; color: var(--gray-600);">Registration Amount Payable</span>
                <div style="font-size: 0.85rem; color: var(--gray-600);">Includes event kit, entry pass & participation certification</div>
              </div>
              <div id="feeDisplay" style="font-size: 1.8rem; font-weight: 800; color: var(--royal-blue);">
                ₹<?php echo number_format($initialFee, 2); ?>
              </div>
              <input type="hidden" name="amount" id="feeHiddenInput" value="<?php echo htmlspecialchars($initialFee); ?>">
            </div>

          </div>

          <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-lg btn-gold btn-block">
              Proceed to Demo Payment Gateway &rarr;
            </button>
            <p style="text-align: center; margin-top: 10px; font-size: 0.85rem; color: var(--gray-600);">
              🔒 Safe & Secure Registration. Prepared statements with SQL injection protection.
            </p>
          </div>

        </form>

      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
