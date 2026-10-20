<?php
$pageTitle = "Venue & Location Guide | CampusFest 2026";
$activePage = "location";
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/includes/header.php';
?>

<!-- Banner -->
<section class="page-banner">
  <div class="container">
    <h1 class="page-banner-title">Campus Venue & <span>Location</span></h1>
    <p class="page-banner-desc">Find your route to the grand festival arenas, auditoriums, and sports complexes.</p>
    <div class="breadcrumb">
      <a href="index.php">Home</a> / <span>Location</span>
    </div>
  </div>
</section>

<!-- Location Section -->
<section class="section">
  <div class="container">
    
    <div class="location-grid">
      
      <!-- Interactive Map Frame -->
      <div>
        <div class="map-card">
          <!-- Embed Google Map -->
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3888.001696420556!2d77.5945627!3d12.9715987!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bae1670c9b44e6d%3A0xf8dfc3e8517e4fe0!2sBengaluru%2C%20Karnataka!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade"
            title="CampusFest 2026 Main Campus Map">
          </iframe>
        </div>
        <div style="margin-top: 1rem; display: flex; justify-content: space-between; align-items: center; background: var(--white); padding: 1rem 1.4rem; border-radius: var(--radius-md); border: 1px solid var(--gray-200);">
          <span style="font-size: 0.9rem; color: var(--gray-600);">📍 GPS Coordinates: 12.9716° N, 77.5946° E</span>
          <a href="https://maps.google.com" target="_blank" rel="noopener" class="btn btn-sm btn-outline-royal">Open in Google Maps &nearr;</a>
        </div>
      </div>

      <!-- Directions & Connectivity Details -->
      <div class="info-cards-stack">
        
        <div class="info-card">
          <div class="info-icon">🏛️</div>
          <div class="info-details">
            <h4>Main Campus Address</h4>
            <p>
              <strong>CampusFest 2026 Secretariat</strong><br>
              Apex Institute of Technology & Sciences Campus<br>
              Golden Quadrilateral Tech Boulevard, Sector 4<br>
              Bengaluru, Karnataka - 560001
            </p>
          </div>
        </div>

        <div class="info-card">
          <div class="info-icon">✈️</div>
          <div class="info-details">
            <h4>From Airport (Kempegowda Int'l)</h4>
            <p>
              Distance: ~34 km (Approx. 45-60 mins drive). Airport Vayu Vajra AC feeder buses and pre-paid cab stands are available 24/7 directly to the campus main gate.
            </p>
          </div>
        </div>

        <div class="info-card">
          <div class="info-icon">🚆</div>
          <div class="info-details">
            <h4>From Central Railway Station & Metro</h4>
            <p>
              Distance: ~7 km. The Purple Line Metro brings you directly to "Tech Park Station", just 400 meters away from our East Gate security pavilion.
            </p>
          </div>
        </div>

        <div class="info-card">
          <div class="info-icon">🚌</div>
          <div class="info-details">
            <h4>Inter-State Bus Terminal (KSRTC / BMTC)</h4>
            <p>
              Distance: ~6.5 km. Dedicated CampusFest volunteer shuttle vans operate every 30 minutes from Majestic Terminal starting 07:00 AM.
            </p>
          </div>
        </div>

      </div>

    </div>

  </div>
</section>

<!-- Campus Zones Overview -->
<section class="section" style="background: var(--white); border-top: 1px solid var(--gray-200); border-bottom: 1px solid var(--gray-200);">
  <div class="container">
    <div class="section-title-wrap">
      <span class="section-pill">Campus Layout</span>
      <h2 class="section-title">Festival <span>Arenas & Facilities</span></h2>
      <p class="section-desc">Key campus destinations hosting your favorite events.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
      
      <div style="background: var(--royal-blue-subtle); border-radius: var(--radius-lg); padding: 1.8rem; border: 1px solid var(--royal-blue-border);">
        <div style="font-size: 2rem; margin-bottom: 0.6rem;">🎭</div>
        <h4 style="font-size: 1.2rem; color: var(--primary-navy); margin-bottom: 6px;">Main Amphitheatre</h4>
        <p style="color: var(--gray-600); font-size: 0.92rem;">
          Capacity 4,500. Features stage acoustics, LED walls, and lighting for Battle of Bands and Star Night DJ concerts.
        </p>
      </div>

      <div style="background: var(--royal-blue-subtle); border-radius: var(--radius-lg); padding: 1.8rem; border: 1px solid var(--royal-blue-border);">
        <div style="font-size: 2rem; margin-bottom: 0.6rem;">💻</div>
        <h4 style="font-size: 1.2rem; color: var(--primary-navy); margin-bottom: 6px;">Turing Computing Complex</h4>
        <p style="color: var(--gray-600); font-size: 0.92rem;">
          High-speed gigabit fiber internet, backup power grid, and server clusters hosting CodeSprint & Cyber CTF.
        </p>
      </div>

      <div style="background: var(--royal-blue-subtle); border-radius: var(--radius-lg); padding: 1.8rem; border: 1px solid var(--royal-blue-border);">
        <div style="font-size: 2rem; margin-bottom: 0.6rem;">⚽</div>
        <h4 style="font-size: 1.2rem; color: var(--primary-navy); margin-bottom: 6px;">Floodlit Sports Arena</h4>
        <p style="color: var(--gray-600); font-size: 0.92rem;">
          FIFA-grade artificial turf football pitch, indoor wooden badminton courts, and box cricket enclosures.
        </p>
      </div>

      <div style="background: var(--royal-blue-subtle); border-radius: var(--radius-lg); padding: 1.8rem; border: 1px solid var(--royal-blue-border);">
        <div style="font-size: 2rem; margin-bottom: 0.6rem;">🍕</div>
        <h4 style="font-size: 1.2rem; color: var(--primary-navy); margin-bottom: 6px;">Food Carnival & Stalls</h4>
        <p style="color: var(--gray-600); font-size: 0.92rem;">
          25+ gourmet food trucks, artisan cafeterias, and hydration points providing hygienic cuisines round the clock.
        </p>
      </div>

    </div>

    <!-- Accommodation Notice -->
    <div style="margin-top: 3rem; background: var(--blue-gradient); border-radius: var(--radius-lg); border: 2px solid var(--gold-primary); color: var(--white); padding: 2.2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem;">
      <div>
        <h3 style="font-family: var(--font-brand); color: var(--gold-light); font-size: 1.4rem; margin-bottom: 6px;">Outstation Contingent Accommodation</h3>
        <p style="color: #cbd5e1; max-width: 650px; font-size: 0.95rem; margin: 0;">
          Separate secure hostel dormitories and guest houses are reserved for visiting college teams at nominal tariff (includes breakfast and WiFi).
        </p>
      </div>
      <a href="contact.php" class="btn btn-gold">Inquire for Lodging</a>
    </div>

  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
