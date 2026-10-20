<?php
$pageTitle = "Photo & Moments Gallery | CampusFest 2026";
$activePage = "gallery";
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/includes/header.php';

$galleryPhotos = [
    // Technical Events
    [
        'title' => 'CodeSprint 24h Hackathon Midnight Grind',
        'category' => 'Technical',
        'tag' => 'Technical',
        'url' => 'https://images.unsplash.com/photo-1515879218367-8466d910aaa4?auto=format&fit=crop&w=1200&q=80'
    ],
    [
        'title' => 'RoboWars Combat Arena Titanium Clash',
        'category' => 'Technical',
        'tag' => 'Robotics',
        'url' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&w=1200&q=80'
    ],
    [
        'title' => 'CyberShield CTF Ethical Hacking Arena',
        'category' => 'Technical',
        'tag' => 'Cybersecurity',
        'url' => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&w=1200&q=80'
    ],
    [
        'title' => 'WebCraft UI/UX Prototype Showdown',
        'category' => 'Technical',
        'tag' => 'UI/UX Design',
        'url' => 'https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?auto=format&fit=crop&w=1200&q=80'
    ],

    // Cultural Events
    [
        'title' => 'Symphony: Battle of the Bands Live Stage',
        'category' => 'Cultural',
        'tag' => 'Live Music',
        'url' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=1200&q=80'
    ],
    [
        'title' => 'Rhythm Royale Western & Fusion Hip-Hop Crew',
        'category' => 'Cultural',
        'tag' => 'Dance',
        'url' => 'https://images.unsplash.com/photo-1547153760-18fc86324498?auto=format&fit=crop&w=1200&q=80'
    ],
    [
        'title' => 'Vogue: Haute Couture Designer Ramp Walk',
        'category' => 'Cultural',
        'tag' => 'Fashion',
        'url' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?auto=format&fit=crop&w=1200&q=80'
    ],
    [
        'title' => 'Natya Manch: Street Play Social Awakening',
        'category' => 'Cultural',
        'tag' => 'Theatre',
        'url' => 'https://images.unsplash.com/photo-1460723237483-7a6dc9d0b212?auto=format&fit=crop&w=1200&q=80'
    ],

    // Sports Events
    [
        'title' => 'Floodlit 7-a-side Football Championship Finals',
        'category' => 'Sports',
        'tag' => 'Football',
        'url' => 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?auto=format&fit=crop&w=1200&q=80'
    ],
    [
        'title' => 'Gully to Glory Box Cricket Tournament Final Over',
        'category' => 'Sports',
        'tag' => 'Cricket',
        'url' => 'https://images.unsplash.com/photo-1540747913346-19e32dc3e97e?auto=format&fit=crop&w=1200&q=80'
    ],
    [
        'title' => 'Smash Masters Badminton Indoor Tournament',
        'category' => 'Sports',
        'tag' => 'Badminton',
        'url' => 'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?auto=format&fit=crop&w=1200&q=80'
    ],
    [
        'title' => 'Grandmaster Chess Championship High-Stakes Move',
        'category' => 'Sports',
        'tag' => 'Chess',
        'url' => 'https://images.unsplash.com/photo-1529699211952-734e80c4d42b?auto=format&fit=crop&w=1200&q=80'
    ],

    // Campus Celebrations
    [
        'title' => 'EDM Star Night & Festival Amphitheatre Glow',
        'category' => 'Cultural',
        'tag' => 'Concert Night',
        'url' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&w=1200&q=80'
    ],
    [
        'title' => 'Grand Valedictory Ceremony & Trophies Conferment',
        'category' => 'Cultural',
        'tag' => 'Awards',
        'url' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&w=1200&q=80'
    ],
    [
        'title' => 'Robotics Team Preparing Autonomous Drones',
        'category' => 'Technical',
        'tag' => 'Innovation',
        'url' => 'https://images.unsplash.com/photo-1508614589041-895b88991e3e?auto=format&fit=crop&w=1200&q=80'
    ],
    [
        'title' => 'Festival Crowd & College Contingent Cheering',
        'category' => 'Sports',
        'tag' => 'Campus Spirit',
        'url' => 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=1200&q=80'
    ]
];
?>

<!-- Banner -->
<section class="page-banner">
  <div class="container">
    <h1 class="page-banner-title">Festival <span>Gallery</span></h1>
    <p class="page-banner-desc">Relive the unforgettable moments, electrifying concerts, adrenaline rushes, and victories.</p>
    <div class="breadcrumb">
      <a href="index.php">Home</a> / <span>Gallery</span>
    </div>
  </div>
</section>

<!-- Filter Tabs & Photo Grid -->
<section class="section">
  <div class="container">
    
    <!-- Filter Tabs -->
    <div class="event-filter-bar">
      <button class="filter-btn active" data-filter="all">All Captures (<?php echo count($galleryPhotos); ?>)</button>
      <button class="filter-btn" data-filter="Technical">💻 Technical Arena</button>
      <button class="filter-btn" data-filter="Cultural">🎭 Cultural & Concerts</button>
      <button class="filter-btn" data-filter="Sports">⚽ Sports Tournaments</button>
    </div>

    <!-- Gallery Grid -->
    <div class="gallery-grid">
      <?php foreach ($galleryPhotos as $photo): ?>
        <div class="gallery-item filterable-item" data-category="<?php echo htmlspecialchars($photo['category']); ?>">
          <img src="<?php echo htmlspecialchars($photo['url']); ?>" alt="<?php echo htmlspecialchars($photo['title']); ?>" loading="lazy">
          <div class="gallery-item-overlay">
            <span class="gallery-tag"><?php echo htmlspecialchars($photo['tag']); ?></span>
            <div class="gallery-caption"><?php echo htmlspecialchars($photo['title']); ?></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Lightbox Modal -->
    <div class="lightbox-modal" id="lightboxModal" role="dialog" aria-modal="true">
      <div class="lightbox-content">
        <button type="button" class="lightbox-close" id="lightboxClose" aria-label="Close Lightbox">&times;</button>
        <img id="lightboxImg" src="" alt="Enlarged gallery photo">
        <div id="lightboxCaption" style="color: var(--gold-light); font-weight: 700; margin-top: 12px; font-size: 1.15rem; text-align: center;"></div>
      </div>
    </div>

    <!-- CTA Box -->
    <div style="margin-top: 4rem; text-align: center; background: var(--royal-blue-subtle); border-radius: var(--radius-xl); padding: 3rem 2rem; border: 2px solid var(--royal-blue-border);">
      <h3 style="font-family: var(--font-brand); font-size: 1.6rem; color: var(--primary-navy); margin-bottom: 0.6rem;">
        Be Part of CampusFest 2026 Photos!
      </h3>
      <p style="color: var(--gray-600); max-width: 580px; margin: 0 auto 1.5rem;">
        Claim your spotlight on stage or in the arena. Register today to compete for the national champion title!
      </p>
      <a href="register.php" class="btn btn-gold btn-lg">Register for Events &rarr;</a>
    </div>

  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
