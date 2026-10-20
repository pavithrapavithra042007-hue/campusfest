<?php
$pageTitle = "Home | National College Fest 2026";
$activePage = "home";
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/includes/header.php';

// Fetch top 3 featured events if database is connected
$featuredEvents = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM events ORDER BY id ASC LIMIT 3");
        $featuredEvents = $stmt->fetchAll();
    } catch (Exception $e) {
        // Fallback to static data if tables not yet populated
    }
}
?>

<!-- Hero Section -->
<section class="hero">
  <div class="container hero-inner">
    <div class="hero-tag">
      <span>👑 National Level Inter-Collegiate Fest 2026</span>
    </div>
    
    <h1 class="hero-title">
      UNLEASH YOUR TALENT AT <br>
      <span>CAMPUSFEST 2026</span>
    </h1>

    <p class="hero-subtitle">
      Join 3,000+ student innovators, artists, and athletes from across 50+ prestigious universities for three electrifying days of innovation, culture, and sportsmanship.
    </p>

    <div class="hero-buttons">
      <a href="register.php" class="btn btn-lg btn-gold">
        <span>⚡ Register for Events</span>
      </a>
      <a href="events.php" class="btn btn-lg btn-outline-white">
        <span>Explore All Events</span>
      </a>
    </div>

    <!-- Live Fest Countdown Timer -->
    <div class="countdown-wrapper">
      <div class="countdown-title">Fest Starts In</div>
      <div class="countdown-grid">
        <div class="countdown-card">
          <span class="countdown-number" id="cdDays">00</span>
          <span class="countdown-label">Days</span>
        </div>
        <div class="countdown-card">
          <span class="countdown-number" id="cdHours">00</span>
          <span class="countdown-label">Hours</span>
        </div>
        <div class="countdown-card">
          <span class="countdown-number" id="cdMins">00</span>
          <span class="countdown-label">Minutes</span>
        </div>
        <div class="countdown-card">
          <span class="countdown-number" id="cdSecs">00</span>
          <span class="countdown-label">Seconds</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Stats Bar -->
<div class="container">
  <section class="stats-section">
    <div class="stats-grid">
      <div class="stat-item">
        <div class="stat-number">50<span>+</span></div>
        <div class="stat-label">Colleges Participating</div>
      </div>
      <div class="stat-item">
        <div class="stat-number">30<span>+</span></div>
        <div class="stat-label">Competitions & Events</div>
      </div>
      <div class="stat-item">
        <div class="stat-number">₹2.5<span>L+</span></div>
        <div class="stat-label">Total Cash Prizes</div>
      </div>
      <div class="stat-item">
        <div class="stat-number">3,500<span>+</span></div>
        <div class="stat-label">Expected Footfall</div>
      </div>
    </div>
  </section>
</div>

<!-- Three Pillar Categories Section (Technical, Cultural, Sports) -->
<section class="section">
  <div class="container">
    <div class="section-title-wrap">
      <span class="section-pill">Competitions Showcase</span>
      <h2 class="section-title">Explore <span>Event Arenas</span></h2>
      <p class="section-desc">
        Compete with the sharpest minds, most creative performers, and toughest athletes in three vibrant arenas.
      </p>
    </div>

    <div class="category-grid">
      
      <!-- Technical Arena -->
      <article class="category-card">
        <div class="category-card-img">
          <img src="https://images.unsplash.com/photo-1515879218367-8466d910aaa4?auto=format&fit=crop&w=800&q=80" alt="Technical Events - CodeSprint & Robotics" loading="lazy">
          <div class="category-badge-overlay">
            <span class="badge badge-tech">Technical Arena</span>
          </div>
        </div>
        <div class="category-card-body">
          <h3 class="category-card-title">Technical Events</h3>
          <p class="category-card-desc">
            Push boundaries with 24-hour hackathons, combat bot battles, cyber CTF defense, and rapid frontend design challenges.
          </p>
          <div class="category-card-meta">
            <span>Key Events: <strong>Hackathon, RoboWars, CTF</strong></span>
            <span>Prize: <strong>₹1,00,000+</strong></span>
          </div>
          <a href="events.php?cat=Technical" class="btn btn-royal btn-block">Explore Technical</a>
        </div>
      </article>

      <!-- Cultural Arena -->
      <article class="category-card">
        <div class="category-card-img">
          <img src="https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=800&q=80" alt="Cultural Events - Band Battle & Dance" loading="lazy">
          <div class="category-badge-overlay">
            <span class="badge badge-cultural">Cultural Arena</span>
          </div>
        </div>
        <div class="category-card-body">
          <h3 class="category-card-title">Cultural Events</h3>
          <p class="category-card-desc">
            Amplify your passion on stage with live Battle of the Bands, high-octane group dance, theatrical street plays, and haute couture fashion ramp walks.
          </p>
          <div class="category-card-meta">
            <span>Key Events: <strong>Band Battle, Dance, Fashion</strong></span>
            <span>Prize: <strong>₹90,000+</strong></span>
          </div>
          <a href="events.php?cat=Cultural" class="btn btn-royal btn-block">Explore Cultural</a>
        </div>
      </article>

      <!-- Sports Arena -->
      <article class="category-card">
        <div class="category-card-img">
          <img src="https://images.unsplash.com/photo-1508098682722-e99c43a406b2?auto=format&fit=crop&w=800&q=80" alt="Sports Events - Football & Cricket" loading="lazy">
          <div class="category-badge-overlay">
            <span class="badge badge-sports">Sports Arena</span>
          </div>
        </div>
        <div class="category-card-body">
          <h3 class="category-card-title">Sports Arena</h3>
          <p class="category-card-desc">
            Bring true grit to the turf and courts with 7-a-side floodlight football, indoor box cricket, badminton smashes, and master-level rapid chess.
          </p>
          <div class="category-card-meta">
            <span>Key Events: <strong>Football, Cricket, Badminton</strong></span>
            <span>Prize: <strong>₹60,000+</strong></span>
          </div>
          <a href="events.php?cat=Sports" class="btn btn-royal btn-block">Explore Sports</a>
        </div>
      </article>

    </div>
  </div>
</section>

<!-- 3-Day Schedule Snapshot -->
<section class="section" style="background-color: var(--white); border-top: 1px solid var(--gray-200); border-bottom: 1px solid var(--gray-200);">
  <div class="container">
    <div class="section-title-wrap">
      <span class="section-pill">Event Timeline</span>
      <h2 class="section-title">Festival <span>Schedule</span></h2>
      <p class="section-desc">Mark your calendars for three non-stop action-packed festival days.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
      
      <div style="background: var(--royal-blue-subtle); border: 2px solid var(--royal-blue-border); border-radius: var(--radius-lg); padding: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
          <span class="badge badge-gold">Day 01</span>
          <span style="font-weight: 700; color: var(--royal-blue);">March 18, 2026</span>
        </div>
        <h3 style="font-size: 1.25rem; color: var(--primary-navy); margin-bottom: 0.8rem;">Inauguration & Tech Kickoff</h3>
        <ul style="color: var(--gray-600); font-size: 0.95rem; line-height: 1.8;">
          <li>✨ 09:00 AM - Grand Lamp Lighting & Welcome</li>
          <li>💻 10:00 AM - CodeSprint Hackathon Commencement</li>
          <li>🤖 02:00 PM - RoboWars Qualifier Matches</li>
          <li>⚽ 04:00 PM - 7-a-side Football League Heats</li>
          <li>🎭 06:30 PM - Street Play (Nukkad Natak) Finals</li>
        </ul>
      </div>

      <div style="background: var(--royal-blue-subtle); border: 2px solid var(--royal-blue-border); border-radius: var(--radius-lg); padding: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
          <span class="badge badge-gold">Day 02</span>
          <span style="font-weight: 700; color: var(--royal-blue);">March 19, 2026</span>
        </div>
        <h3 style="font-size: 1.25rem; color: var(--primary-navy); margin-bottom: 0.8rem;">Sports Clashes & Music Night</h3>
        <ul style="color: var(--gray-600); font-size: 0.95rem; line-height: 1.8;">
          <li>🏸 09:30 AM - Badminton & Box Cricket Semis</li>
          <li>🌐 11:00 AM - WebCraft UI/UX Sprint Showdown</li>
          <li>🛡️ 01:30 PM - Cyber CTF Flag Submissions</li>
          <li>🎸 05:30 PM - Battle of the Bands Live Stage</li>
          <li>🌟 08:30 PM - EDM Star Night & DJ Showcase</li>
        </ul>
      </div>

      <div style="background: var(--royal-blue-subtle); border: 2px solid var(--royal-blue-border); border-radius: var(--radius-lg); padding: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
          <span class="badge badge-gold">Day 03</span>
          <span style="font-weight: 700; color: var(--royal-blue);">March 20, 2026</span>
        </div>
        <h3 style="font-size: 1.25rem; color: var(--primary-navy); margin-bottom: 0.8rem;">Grand Finale & Award Gala</h3>
        <ul style="color: var(--gray-600); font-size: 0.95rem; line-height: 1.8;">
          <li>🏆 10:00 AM - Sports Grand Finals & Trophy Round</li>
          <li>💃 04:00 PM - Rhythm Royale Mega Dance Off</li>
          <li>👗 07:00 PM - Vogue Haute Couture Fashion Show</li>
          <li>🎖️ 09:00 PM - Valedictory & Cash Prize Distribution</li>
          <li>🎆 10:00 PM - Grand Campus Fireworks Display</li>
        </ul>
      </div>

    </div>
  </div>
</section>

<!-- Call to Action Section -->
<section class="section" style="background: var(--blue-gradient); color: var(--white); text-align: center; border-bottom: 4px solid var(--gold-primary);">
  <div class="container" style="max-width: 800px;">
    <span class="badge badge-gold" style="margin-bottom: 1rem;">Seats Filling Fast</span>
    <h2 style="font-family: var(--font-brand); font-size: clamp(2rem, 3.8vw, 2.8rem); margin-bottom: 1rem; color: var(--white);">
      Ready to etch your name in CampusFest history?
    </h2>
    <p style="color: #cbd5e1; font-size: 1.1rem; margin-bottom: 2rem;">
      Register solo or rally your college contingent. Certificates with national accreditation, trophies, and cash rewards await the winners!
    </p>
    <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
      <a href="register.php" class="btn btn-lg btn-gold">Register Now</a>
      <a href="contact.php" class="btn btn-lg btn-outline-white">Contact Helpdesk</a>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
