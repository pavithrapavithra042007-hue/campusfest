<?php
$pageTitle = "Contact Us & Helpdesk | CampusFest 2026";
$activePage = "contact";
require_once __DIR__ . '/db.php';

$errors = [];
$successMessage = "";

// Form Submission handling
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $subject = sanitize($_POST['subject'] ?? '');
    $message = sanitize($_POST['message'] ?? '');

    if (empty($name)) $errors[] = "Please provide your Full Name.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Please provide a valid Email Address.";
    if (empty($subject)) $errors[] = "Please select or type a Subject.";
    if (empty($message) || strlen($message) < 10) $errors[] = "Please enter a detailed message (minimum 10 characters).";

    if (empty($errors)) {
        if ($pdo) {
            try {
                // Prepared statement insertion
                $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
                $stmt->execute([$name, $email, $subject, $message]);
                $successMessage = "Thank you, " . htmlspecialchars($name) . "! Your query has been logged. Our festival coordinators will reply within 24 hours.";
            } catch (PDOException $e) {
                $errors[] = "Message could not be saved to database: " . $e->getMessage();
            }
        } else {
            $successMessage = "Thank you, " . htmlspecialchars($name) . "! (Demo mode: message received successfully). We will respond to " . htmlspecialchars($email) . ".";
        }
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<!-- Banner -->
<section class="page-banner">
  <div class="container">
    <h1 class="page-banner-title">Contact <span>Helpdesk</span></h1>
    <p class="page-banner-desc">Have questions regarding rules, registrations, accommodation, or sponsorship? Reach out to our committee.</p>
    <div class="breadcrumb">
      <a href="index.php">Home</a> / <span>Contact</span>
    </div>
  </div>
</section>

<!-- Contact Form & Info Cards -->
<section class="section">
  <div class="container">
    
    <div class="contact-layout">
      
      <!-- Contact Form -->
      <div class="form-card" style="margin: 0; max-width: 100%;">
        <div class="form-card-header" style="text-align: left; padding: 1.8rem 2rem;">
          <h2 style="font-size: 1.5rem;">SEND A <span>MESSAGE</span></h2>
          <p style="margin: 0;">Our student support team is active 24/7 during fest preparations</p>
        </div>

        <div class="form-card-body" style="padding: 2rem;">
          
          <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success" role="alert">
              <div>
                <strong>Message Dispatched!</strong><br>
                <?php echo $successMessage; ?>
              </div>
            </div>
          <?php endif; ?>

          <?php if (!empty($errors)): ?>
            <div class="alert alert-danger" role="alert">
              <ul style="margin: 0; padding-left: 1.2rem;">
                <?php foreach ($errors as $err): ?>
                  <li><?php echo htmlspecialchars($err); ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <form action="contact.php" method="POST" novalidate>
            <div class="form-group">
              <label class="form-label" for="contact_name">Your Name <span class="req">*</span></label>
              <input type="text" id="contact_name" name="name" class="form-control" placeholder="e.g. Alex Johnson" required>
            </div>

            <div class="form-group">
              <label class="form-label" for="contact_email">Email Address <span class="req">*</span></label>
              <input type="email" id="contact_email" name="email" class="form-control" placeholder="alex@university.edu" required>
            </div>

            <div class="form-group">
              <label class="form-label" for="contact_subject">Subject Category <span class="req">*</span></label>
              <select id="contact_subject" name="subject" class="form-control" required>
                <option value="Event Registration Inquiry">Event Registration Inquiry</option>
                <option value="Technical Events Rules Clarification">Technical Events Rules Clarification</option>
                <option value="Cultural Band & Stage Equipment">Cultural Band & Stage Equipment</option>
                <option value="Sports Tournament Fixtures">Sports Tournament Fixtures</option>
                <option value="Hostel & Accommodation Assistance">Hostel & Accommodation Assistance</option>
                <option value="Corporate Sponsorship / Partnerships">Corporate Sponsorship / Partnerships</option>
                <option value="Other / General Query">Other / General Query</option>
              </select>
            </div>

            <div class="form-group">
              <label class="form-label" for="contact_message">Your Message / Query <span class="req">*</span></label>
              <textarea id="contact_message" name="message" class="form-control" rows="5" placeholder="Please elaborate on your query so we can direct it to the right coordinator..." required></textarea>
            </div>

            <div style="margin-top: 1.5rem;">
              <button type="submit" class="btn btn-gold btn-block btn-lg">
                Send Query to Helpdesk &rarr;
              </button>
            </div>
          </form>

        </div>
      </div>

      <!-- Coordinators Info Deck -->
      <div class="info-cards-stack">
        
        <div class="info-card">
          <div class="info-icon">📞</div>
          <div class="info-details">
            <h4>Student General Secretary</h4>
            <p><strong>Rohan Verma</strong>: +91 98765 43210</p>
            <p style="font-size: 0.85rem; color: var(--gray-600);">Chief student coordinator for university delegations & general queries.</p>
          </div>
        </div>

        <div class="info-card">
          <div class="info-icon">💻</div>
          <div class="info-details">
            <h4>Technical Events Convenor</h4>
            <p><strong>Arjun Mehta</strong>: +91 98111 22334</p>
            <p style="font-size: 0.85rem; color: var(--gray-600);">Hackathon, RoboWars arena specifications & CTF rules.</p>
          </div>
        </div>

        <div class="info-card">
          <div class="info-icon">🎭</div>
          <div class="info-details">
            <h4>Cultural Fest Head</h4>
            <p><strong>Priya Nair</strong>: +91 98222 33445</p>
            <p style="font-size: 0.85rem; color: var(--gray-600);">Band equipment rider, dance time-slots & fashion theme checks.</p>
          </div>
        </div>

        <div class="info-card">
          <div class="info-icon">🛏️</div>
          <div class="info-details">
            <h4>Hospitality & Outstation Lodging</h4>
            <p><strong>Kavya Sharma</strong>: +91 98333 44556</p>
            <p style="font-size: 0.85rem; color: var(--gray-600);">Campus hostel bed reservation, food passes & bus pickup desk.</p>
          </div>
        </div>

        <div class="info-card">
          <div class="info-icon">✉️</div>
          <div class="info-details">
            <h4>Official Fest Email</h4>
            <p><strong>General:</strong> helpdesk@campusfest2026.org</p>
            <p><strong>Sponsors:</strong> partners@campusfest2026.org</p>
          </div>
        </div>

      </div>

    </div>

    <!-- FAQ Accordion -->
    <div class="faq-wrap">
      <div class="section-title-wrap" style="margin-bottom: 2rem;">
        <span class="section-pill">Got Questions?</span>
        <h2 class="section-title">Frequently <span>Asked Questions</span></h2>
      </div>

      <div class="accordion-item">
        <button class="accordion-btn">
          <span>Can one student participate in multiple events?</span>
          <span>+</span>
        </button>
        <div class="accordion-body">
          Yes! You can register for multiple events as long as their schedule does not clash. Make sure to check the 3-day timeline on the Home page before registering.
        </div>
      </div>

      <div class="accordion-item">
        <button class="accordion-btn">
          <span>Are spot registrations available at the campus venue?</span>
          <span>+</span>
        </button>
        <div class="accordion-body">
          Spot registrations are available only for select solo events if slots remain open. For flagship events like CodeSprint Hackathon, RoboWars, and Battle of the Bands, online pre-registration is mandatory due to limited slots.
        </div>
      </div>

      <div class="accordion-item">
        <button class="accordion-btn">
          <span>Is the registration fee refundable?</span>
          <span>+</span>
        </button>
        <div class="accordion-body">
          Registration fees are strictly non-refundable once your slot is confirmed. However, team member name replacements are permitted up to 24 hours prior to the event commencement upon contacting the desk.
        </div>
      </div>

      <div class="accordion-item">
        <button class="accordion-btn">
          <span>What documents are required during entry?</span>
          <span>+</span>
        </button>
        <div class="accordion-body">
          Every participant must produce their physical College Student ID card and the CampusFest Registration Confirmation Pass (available on the Dashboard / Payment Receipt).
        </div>
      </div>

    </div>

  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
