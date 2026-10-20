<?php
$pageTitle = "Student Portal & Login | CampusFest 2026";
$activePage = "login";
require_once __DIR__ . '/db.php';

// If already logged in, redirect to dashboard
if (isLoggedIn()) {
    header("Location: dashboard.php");
    exit;
}

$loginErrors = [];
$registerErrors = [];
$activeTab = 'login';

// Process Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $activeTab = 'login';
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $loginErrors[] = "A valid registered email address is required.";
    }
    if (empty($password)) {
        $loginErrors[] = "Please enter your password.";
    }

    if (empty($loginErrors)) {
        if ($pdo) {
            try {
                // Prepared statement to find user
                $stmt = $pdo->prepare("SELECT id, full_name, email, password, phone, college FROM users WHERE email = ? LIMIT 1");
                $stmt->execute([$email]);
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['password'])) {
                    // Password verified successfully!
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['full_name'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_phone'] = $user['phone'];
                    $_SESSION['user_college'] = $user['college'];

                    setFlash('success', "Welcome back, " . htmlspecialchars($user['full_name']) . "! You are logged in.");
                    header("Location: dashboard.php");
                    exit;
                } else {
                    $loginErrors[] = "Invalid credentials. Please verify your email and password.";
                }
            } catch (PDOException $e) {
                $loginErrors[] = "Database error: " . $e->getMessage();
            }
        } else {
            // Demo account fallback if MySQL is offline
            if ($email === 'demo@campusfest.org' && $password === 'password123') {
                $_SESSION['user_id'] = 999;
                $_SESSION['user_name'] = "Alex Mercer (Demo)";
                $_SESSION['user_email'] = "demo@campusfest.org";
                $_SESSION['user_phone'] = "9876543210";
                $_SESSION['user_college'] = "Demo Institute of Technology";
                setFlash('info', "Logged into demo account successfully.");
                header("Location: dashboard.php");
                exit;
            } else {
                $loginErrors[] = "Database offline. For testing without MySQL, use demo email: 'demo@campusfest.org' and password: 'password123'. Or start MySQL in XAMPP.";
            }
        }
    }
}

// Process Registration / Sign Up
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'signup') {
    $activeTab = 'signup';
    $name = sanitize($_POST['full_name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $college = sanitize($_POST['college'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($name)) $registerErrors[] = "Full Name is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $registerErrors[] = "A valid Email Address is required.";
    if (empty($phone) || strlen($phone) < 8) $registerErrors[] = "Valid contact number is required.";
    if (empty($college)) $registerErrors[] = "College Name is required.";
    if (strlen($password) < 6) $registerErrors[] = "Password must be at least 6 characters long.";
    if ($password !== $confirm_password) $registerErrors[] = "Passwords do not match.";

    if (empty($registerErrors)) {
        if ($pdo) {
            try {
                // Check if email already registered using prepared statement
                $chk = $pdo->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
                $chk->execute([$email]);
                if ($chk->fetch()) {
                    $registerErrors[] = "An account with this email already exists. Please log in.";
                } else {
                    // Hash password using BCRYPT
                    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                    // Insert using prepared statements
                    $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password, phone, college) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$name, $email, $hashedPassword, $phone, $college]);
                    $newUserId = $pdo->lastInsertId();

                    // Log in immediately
                    $_SESSION['user_id'] = $newUserId;
                    $_SESSION['user_name'] = $name;
                    $_SESSION['user_email'] = $email;
                    $_SESSION['user_phone'] = $phone;
                    $_SESSION['user_college'] = $college;

                    setFlash('success', "Account successfully created! Welcome to CampusFest 2026, " . htmlspecialchars($name) . "!");
                    header("Location: dashboard.php");
                    exit;
                }
            } catch (PDOException $e) {
                $registerErrors[] = "Database insertion error: " . $e->getMessage();
            }
        } else {
            $registerErrors[] = "Database is offline. Please start Apache & MySQL in your XAMPP Control Panel.";
        }
    }
}

require_once __DIR__ . '/includes/header.php';
?>

<!-- Banner -->
<section class="page-banner">
  <div class="container">
    <h1 class="page-banner-title">Student <span>Portal</span></h1>
    <p class="page-banner-desc">Sign in to manage event registrations, payment receipts, and schedule updates.</p>
    <div class="breadcrumb">
      <a href="index.php">Home</a> / <span>Login & Register</span>
    </div>
  </div>
</section>

<!-- Auth Container -->
<section class="section">
  <div class="container" style="max-width: 580px;">
    
    <div class="form-card">
      
      <!-- Tab Controls -->
      <div style="display: flex; border-bottom: 2px solid var(--gold-primary); background: var(--royal-blue);">
        <button type="button" id="tabBtnLogin" onclick="switchAuthTab('login')" style="flex: 1; padding: 1.2rem; background: <?php echo ($activeTab === 'login') ? 'rgba(255,255,255,0.15)' : 'transparent'; ?>; color: var(--white); font-weight: 700; font-size: 1.05rem; border: none; cursor: pointer;">
          🔑 Sign In
        </button>
        <button type="button" id="tabBtnSignup" onclick="switchAuthTab('signup')" style="flex: 1; padding: 1.2rem; background: <?php echo ($activeTab === 'signup') ? 'rgba(255,255,255,0.15)' : 'transparent'; ?>; color: var(--gold-light); font-weight: 700; font-size: 1.05rem; border: none; cursor: pointer;">
          ✨ Create Account
        </button>
      </div>

      <div class="form-card-body">

        <!-- LOGIN FORM -->
        <div id="authLoginSection" style="<?php echo ($activeTab === 'login') ? 'display: block;' : 'display: none;'; ?>">
          
          <?php if (!empty($loginErrors)): ?>
            <div class="alert alert-danger" role="alert">
              <ul style="margin: 0; padding-left: 1.2rem;">
                <?php foreach ($loginErrors as $err): ?>
                  <li><?php echo htmlspecialchars($err); ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <form action="login.php" method="POST" novalidate>
            <input type="hidden" name="action" value="login">

            <div class="form-group">
              <label class="form-label" for="login_email">Registered Email <span class="req">*</span></label>
              <input type="email" id="login_email" name="email" class="form-control" placeholder="name@college.edu" required>
            </div>

            <div class="form-group">
              <label class="form-label" for="login_password">Password <span class="req">*</span></label>
              <input type="password" id="login_password" name="password" class="form-control" placeholder="••••••••" required>
            </div>

            <div style="margin-top: 1.5rem;">
              <button type="submit" class="btn btn-gold btn-block btn-lg">
                Sign In to CampusFest
              </button>
            </div>

            <div style="margin-top: 1.5rem; background: var(--royal-blue-subtle); padding: 1rem; border-radius: var(--radius-md); font-size: 0.85rem; color: var(--gray-600); text-align: center;">
              💡 <strong>Quick Demo Login:</strong><br>
              Email: <code>demo@campusfest.org</code> | Password: <code>password123</code>
            </div>

            <p style="text-align: center; margin-top: 1.2rem; font-size: 0.92rem; color: var(--gray-600);">
              Don't have an account yet? <a href="javascript:void(0)" onclick="switchAuthTab('signup')" style="font-weight: 700; color: var(--royal-blue);">Create one now</a>
            </p>
          </form>
        </div>

        <!-- SIGNUP FORM -->
        <div id="authSignupSection" style="<?php echo ($activeTab === 'signup') ? 'display: block;' : 'display: none;'; ?>">
          
          <?php if (!empty($registerErrors)): ?>
            <div class="alert alert-danger" role="alert">
              <ul style="margin: 0; padding-left: 1.2rem;">
                <?php foreach ($registerErrors as $err): ?>
                  <li><?php echo htmlspecialchars($err); ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <form action="login.php" method="POST" novalidate>
            <input type="hidden" name="action" value="signup">

            <div class="form-group">
              <label class="form-label" for="signup_name">Full Name <span class="req">*</span></label>
              <input type="text" id="signup_name" name="full_name" class="form-control" placeholder="e.g. Alex Johnson" required>
            </div>

            <div class="form-group">
              <label class="form-label" for="signup_email">Email Address <span class="req">*</span></label>
              <input type="email" id="signup_email" name="email" class="form-control" placeholder="alex@university.edu" required>
            </div>

            <div class="form-group">
              <label class="form-label" for="signup_phone">Mobile Number <span class="req">*</span></label>
              <input type="tel" id="signup_phone" name="phone" class="form-control" placeholder="e.g. 9876543210" required>
            </div>

            <div class="form-group">
              <label class="form-label" for="signup_college">College / University Name <span class="req">*</span></label>
              <input type="text" id="signup_college" name="college" class="form-control" placeholder="e.g. Institute of Science" required>
            </div>

            <div class="form-group">
              <label class="form-label" for="signup_password">Password (Min. 6 chars) <span class="req">*</span></label>
              <input type="password" id="signup_password" name="password" class="form-control" placeholder="••••••••" required>
            </div>

            <div class="form-group">
              <label class="form-label" for="signup_confirm_password">Confirm Password <span class="req">*</span></label>
              <input type="password" id="signup_confirm_password" name="confirm_password" class="form-control" placeholder="••••••••" required>
            </div>

            <div style="margin-top: 1.5rem;">
              <button type="submit" class="btn btn-gold btn-block btn-lg">
                Create Student Account &rarr;
              </button>
            </div>

            <p style="text-align: center; margin-top: 1.2rem; font-size: 0.92rem; color: var(--gray-600);">
              Already have an account? <a href="javascript:void(0)" onclick="switchAuthTab('login')" style="font-weight: 700; color: var(--royal-blue);">Sign in here</a>
            </p>
          </form>
        </div>

      </div>
    </div>

  </div>
</section>

<script>
function switchAuthTab(tab) {
  const loginSec = document.getElementById('authLoginSection');
  const signupSec = document.getElementById('authSignupSection');
  const btnLogin = document.getElementById('tabBtnLogin');
  const btnSignup = document.getElementById('tabBtnSignup');

  if (tab === 'signup') {
    loginSec.style.display = 'none';
    signupSec.style.display = 'block';
    btnLogin.style.background = 'transparent';
    btnSignup.style.background = 'rgba(255,255,255,0.15)';
  } else {
    loginSec.style.display = 'block';
    signupSec.style.display = 'none';
    btnLogin.style.background = 'rgba(255,255,255,0.15)';
    btnSignup.style.background = 'transparent';
  }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
