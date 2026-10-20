<?php
$pageTitle = "Events Directory | CampusFest 2026";
$activePage = "events";
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/includes/header.php';

// Check if category is passed via GET
$selectedCategory = isset($_GET['cat']) ? sanitize($_GET['cat']) : 'all';

// Fallback events array if database is not yet seeded or disconnected
$fallbackEvents = [
    [
        'id' => 1,
        'title' => 'CodeSprint 24-Hour Hackathon',
        'category' => 'Technical',
        'description' => 'Collaborate, build innovative software/hardware solutions overnight and pitch to top industry tech leaders.',
        'date' => 'March 18, 2026',
        'time' => '10:00 AM - 10:00 AM',
        'venue' => 'Turing Innovation Lab, Block B',
        'team_size' => '2 - 4 Members',
        'fee' => 500.00,
        'prize' => 'INR 50,000 + Internship Offer',
        'image' => 'https://images.unsplash.com/photo-1515879218367-8466d910aaa4?auto=format&fit=crop&w=800&q=80',
        'status' => 'Open'
    ],
    [
        'id' => 2,
        'title' => 'RoboWars: Clash of Titans',
        'category' => 'Technical',
        'description' => 'Build your high-torque combat bot within weight limits and fight inside a bulletproof arena to conquer the title.',
        'date' => 'March 18, 2026',
        'time' => '02:00 PM',
        'venue' => 'Mechanical Arena, Ground 2',
        'team_size' => '2 - 5 Members',
        'fee' => 600.00,
        'prize' => 'INR 35,000 + Trophy',
        'image' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&w=800&q=80',
        'status' => 'Open'
    ],
    [
        'id' => 3,
        'title' => 'WebCraft UI/UX & Web Sprint',
        'category' => 'Technical',
        'description' => 'Showcase your frontend mastery and responsive design genius in an intensive 3-hour live web architecture showdown.',
        'date' => 'March 19, 2026',
        'time' => '11:00 AM',
        'venue' => 'Design Studio, 3rd Floor',
        'team_size' => 'Solo or Duo',
        'fee' => 250.00,
        'prize' => 'INR 20,000',
        'image' => 'https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?auto=format&fit=crop&w=800&q=80',
        'status' => 'Open'
    ],
    [
        'id' => 4,
        'title' => 'CyberShield Capture The Flag (CTF)',
        'category' => 'Technical',
        'description' => 'Crack cryptographic puzzles, exploit network vulnerabilities, and solve real-world cybersecurity challenges.',
        'date' => 'March 19, 2026',
        'time' => '01:30 PM',
        'venue' => 'Cyber Security Center, Block A',
        'team_size' => 'Solo or Duo',
        'fee' => 300.00,
        'prize' => 'INR 25,000',
        'image' => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&w=800&q=80',
        'status' => 'Open'
    ],
    [
        'id' => 5,
        'title' => 'Symphony: Battle of the Bands',
        'category' => 'Cultural',
        'description' => 'Rock the open amphitheater! Acoustic, metal, fusion or western bands battle live under stadium concert lights.',
        'date' => 'March 19, 2026',
        'time' => '05:30 PM',
        'venue' => 'Main Open Air Amphitheatre',
        'team_size' => '4 - 8 Members',
        'fee' => 800.00,
        'prize' => 'INR 45,000 + Audio Gear',
        'image' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=800&q=80',
        'status' => 'Open'
    ],
    [
        'id' => 6,
        'title' => 'Rhythm Royale: Western & Fusion Dance',
        'category' => 'Cultural',
        'description' => 'Electrifying group choreography battle featuring hip-hop, contemporary, Bollywood fusion, and high-energy synchronization.',
        'date' => 'March 20, 2026',
        'time' => '06:00 PM',
        'venue' => 'Grand Convocation Auditorium',
        'team_size' => '6 - 15 Members',
        'fee' => 750.00,
        'prize' => 'INR 40,000 + Winner Cup',
        'image' => 'https://images.unsplash.com/photo-1547153760-18fc86324498?auto=format&fit=crop&w=800&q=80',
        'status' => 'Open'
    ],
    [
        'id' => 7,
        'title' => 'Vogue: The Grand Fashion Show',
        'category' => 'Cultural',
        'description' => 'Elegance meets glamour. Walk the ramp with creative theme-based haute couture and designer costumes.',
        'date' => 'March 20, 2026',
        'time' => '07:30 PM',
        'venue' => 'Central Quadrangle Ramp',
        'team_size' => '10 - 18 Members',
        'fee' => 1000.00,
        'prize' => 'INR 50,000 + Modeling Contract',
        'image' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?auto=format&fit=crop&w=800&q=80',
        'status' => 'Closing Soon'
    ],
    [
        'id' => 8,
        'title' => 'Natya Manch: Street Play (Nukkad Natak)',
        'category' => 'Cultural',
        'description' => 'Raise your voice on poignant social issues with powerful theatrical acts, acoustic drums, and soul-stirring dialogues.',
        'date' => 'March 18, 2026',
        'time' => '03:00 PM',
        'venue' => 'Student Activity Center Lawn',
        'team_size' => '8 - 20 Members',
        'fee' => 400.00,
        'prize' => 'INR 25,000',
        'image' => 'https://images.unsplash.com/photo-1460723237483-7a6dc9d0b212?auto=format&fit=crop&w=800&q=80',
        'status' => 'Open'
    ],
    [
        'id' => 9,
        'title' => 'Campus Champions Cup: 7-a-side Football',
        'category' => 'Sports',
        'description' => 'High-intensity knockout football tournament on FIFA standard turf under floodlights.',
        'date' => 'March 18, 2026',
        'time' => '08:00 AM',
        'venue' => 'Campus Football Stadium Turf',
        'team_size' => '7 + 3 Substitutes',
        'fee' => 900.00,
        'prize' => 'INR 40,000 + Gold Medals',
        'image' => 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?auto=format&fit=crop&w=800&q=80',
        'status' => 'Open'
    ],
    [
        'id' => 10,
        'title' => 'Gully to Glory: Box Cricket League',
        'category' => 'Sports',
        'description' => 'Fast-paced tennis-ball indoor and box cricket league with thrilling over-by-over high-stakes cricket action.',
        'date' => 'March 18, 2026',
        'time' => '09:00 AM',
        'venue' => 'Multi-Purpose Sports Complex',
        'team_size' => '6 + 2 Substitutes',
        'fee' => 700.00,
        'prize' => 'INR 30,000 + Championship Trophy',
        'image' => 'https://images.unsplash.com/photo-1540747913346-19e32dc3e97e?auto=format&fit=crop&w=800&q=80',
        'status' => 'Open'
    ],
    [
        'id' => 11,
        'title' => 'Smash Masters: Badminton Championship',
        'category' => 'Sports',
        'description' => 'Singles and Doubles rapid tournament on synthetic indoor wooden courts with international scoring.',
        'date' => 'March 19, 2026',
        'time' => '10:00 AM',
        'venue' => 'Indoor Sports Complex, Court 1 & 2',
        'team_size' => 'Solo or Duo',
        'fee' => 300.00,
        'prize' => 'INR 20,000 + Gold Medals',
        'image' => 'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?auto=format&fit=crop&w=800&q=80',
        'status' => 'Open'
    ],
    [
        'id' => 12,
        'title' => 'Checkmate: Rapid Chess Masters',
        'category' => 'Sports',
        'description' => 'FIDE-rules compliant Swiss League rapid chess tournament for tactical and strategic minds.',
        'date' => 'March 19, 2026',
        'time' => '11:00 AM',
        'venue' => 'Auditorium Seminar Hall C',
        'team_size' => 'Solo',
        'fee' => 200.00,
        'prize' => 'INR 15,000 + Trophy',
        'image' => 'https://images.unsplash.com/photo-1529699211952-734e80c4d42b?auto=format&fit=crop&w=800&q=80',
        'status' => 'Open'
    ]
];

$allEvents = $fallbackEvents;

if ($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM events ORDER BY category DESC, id ASC");
        $stmt->execute();
        $dbEvents = $stmt->fetchAll();
        if (!empty($dbEvents)) {
            $allEvents = $dbEvents;
        }
    } catch (Exception $e) {
        // Fall back gracefully
    }
}
?>

<!-- Banner -->
<section class="page-banner">
  <div class="container">
    <h1 class="page-banner-title">Competitions & <span>Events</span></h1>
    <p class="page-banner-desc">Explore 30+ high-energy technical hackathons, cultural spectacles, and sports leagues.</p>
    <div class="breadcrumb">
      <a href="index.php">Home</a> / <span>Events</span>
    </div>
  </div>
</section>

<!-- Filter Tabs & Grid -->
<section class="section">
  <div class="container">
    
    <!-- Filter Bar -->
    <div class="event-filter-bar">
      <button class="filter-btn <?php echo ($selectedCategory === 'all' || empty($selectedCategory)) ? 'active' : ''; ?>" data-filter="all">
        All Competitions (<?php echo count($allEvents); ?>)
      </button>
      <button class="filter-btn <?php echo (strtolower($selectedCategory) === 'technical') ? 'active' : ''; ?>" data-filter="Technical">
        💻 Technical Events
      </button>
      <button class="filter-btn <?php echo (strtolower($selectedCategory) === 'cultural') ? 'active' : ''; ?>" data-filter="Cultural">
        🎭 Cultural Events
      </button>
      <button class="filter-btn <?php echo (strtolower($selectedCategory) === 'sports') ? 'active' : ''; ?>" data-filter="Sports">
        ⚽ Sports Arena
      </button>
    </div>

    <!-- Events Grid -->
    <div class="events-grid">
      <?php foreach ($allEvents as $event): 
        $catClass = strtolower($event['category']) === 'technical' ? 'badge-tech' : (strtolower($event['category']) === 'cultural' ? 'badge-cultural' : 'badge-sports');
        $displayStyle = ($selectedCategory !== 'all' && strtolower($selectedCategory) !== strtolower($event['category'])) ? 'display: none;' : '';
      ?>
        <article class="event-card filterable-item" data-category="<?php echo htmlspecialchars($event['category']); ?>" style="<?php echo $displayStyle; ?>">
          
          <div class="event-img-wrap">
            <img src="<?php echo htmlspecialchars($event['image']); ?>" alt="<?php echo htmlspecialchars($event['title']); ?>" loading="lazy">
            <div style="position: absolute; top: 14px; left: 14px;">
              <span class="badge <?php echo $catClass; ?>"><?php echo htmlspecialchars($event['category']); ?></span>
            </div>
            <div class="event-status-pill">
              <?php echo htmlspecialchars($event['status'] ?? 'Open'); ?>
            </div>
          </div>

          <div class="event-content">
            <h3 class="event-title"><?php echo htmlspecialchars($event['title']); ?></h3>
            <p class="event-desc"><?php echo htmlspecialchars($event['description']); ?></p>

            <div class="event-details-list">
              <div class="detail-row">
                <span class="detail-label">📅 Date & Time</span>
                <span class="detail-value"><?php echo htmlspecialchars($event['date']); ?> | <?php echo htmlspecialchars($event['time']); ?></span>
              </div>
              <div class="detail-row">
                <span class="detail-label">📍 Campus Venue</span>
                <span class="detail-value"><?php echo htmlspecialchars($event['venue']); ?></span>
              </div>
              <div class="detail-row">
                <span class="detail-label">👥 Team Size</span>
                <span class="detail-value"><?php echo htmlspecialchars($event['team_size']); ?></span>
              </div>
              <div class="detail-row">
                <span class="detail-label">🎟️ Entry Fee</span>
                <span class="detail-value" style="color: var(--royal-blue);">₹<?php echo number_format($event['fee'], 2); ?></span>
              </div>
            </div>

            <div class="event-card-footer">
              <div class="event-prize-tag">
                <span>Prize Pool</span>
                <strong>🏆 <?php echo htmlspecialchars($event['prize']); ?></strong>
              </div>
              <a href="register.php?event_id=<?php echo urlencode($event['id']); ?>" class="btn btn-sm btn-gold">
                Register Now &rarr;
              </a>
            </div>

          </div>
        </article>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
