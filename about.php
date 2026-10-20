<?php
$pageTitle = "About Us | CampusFest 2026";
$activePage = "about";
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/includes/header.php';
?>

<!-- Banner -->
<section class="page-banner">
  <div class="container">
    <h1 class="page-banner-title">About <span>CampusFest 2026</span></h1>
    <p class="page-banner-desc">Celebrating excellence, creative expression, technological disruption, and sportsmanship.</p>
    <div class="breadcrumb">
      <a href="index.php">Home</a> / <span>About</span>
    </div>
  </div>
</section>

<!-- About Fest Story Section -->
<section class="section">
  <div class="container">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: center;">
      <div>
        <span class="section-pill">Our Heritage & Legacy</span>
        <h2 class="section-title">Where Ambition Meets <span>Artistry & Innovation</span></h2>
        <p style="margin-bottom: 1.2rem; color: var(--gray-600); font-size: 1.05rem;">
          Conceived as a collaborative melting pot of student talent in 2015, <strong>CampusFest</strong> has blossomed into one of the country's most celebrated inter-collegiate youth festivals. Every spring, over 3,000 passionate collegians converge on our sprawling campus to push their boundaries.
        </p>
        <p style="margin-bottom: 1.5rem; color: var(--gray-600); font-size: 1.05rem;">
          Whether it is coding until dawn in high-stakes hackathons, shaking the amphitheatre in battle of the bands, or fighting for athletic supremacy under floodlit stadiums, CampusFest is where legends are born.
        </p>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
          <div style="background: var(--royal-blue-subtle); padding: 1.2rem; border-radius: var(--radius-md); border-left: 4px solid var(--gold-primary);">
            <h4 style="color: var(--primary-navy); font-size: 1.1rem; margin-bottom: 4px;">Our Mission</h4>
            <p style="color: var(--gray-600); font-size: 0.88rem;">To cultivate leadership, spark creative ingenuity, and foster national collegiate camaraderie.</p>
          </div>
          <div style="background: var(--royal-blue-subtle); padding: 1.2rem; border-radius: var(--radius-md); border-left: 4px solid var(--royal-blue);">
            <h4 style="color: var(--primary-navy); font-size: 1.1rem; margin-bottom: 4px;">Our Vision</h4>
            <p style="color: var(--gray-600); font-size: 0.88rem;">To become Asia’s most forward-thinking, inclusive, and competitive student confluence.</p>
          </div>
        </div>
      </div>

      <div style="position: relative;">
        <div style="border-radius: var(--radius-xl); overflow: hidden; border: 3px solid var(--gold-primary); box-shadow: var(--shadow-xl);">
          <img src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?auto=format&fit=crop&w=800&q=80" alt="Students celebrating at CampusFest" style="width: 100%; height: 420px; object-fit: cover;">
        </div>
        <div style="position: absolute; bottom: -20px; left: -20px; background: var(--royal-blue); color: var(--gold-light); padding: 1.2rem 1.8rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-gold); border: 2px solid var(--gold-primary);">
          <span style="font-size: 1.8rem; font-weight: 800; display: block; line-height: 1;">11th</span>
          <span style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Annual Edition</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Organizing Committee -->
<section class="section" style="background-color: var(--white); border-top: 1px solid var(--gray-200); border-bottom: 1px solid var(--gray-200);">
  <div class="container">
    <div class="section-title-wrap">
      <span class="section-pill">Leadership</span>
      <h2 class="section-title">Organizing <span>Committee</span></h2>
      <p class="section-desc">Guided by distinguished mentors and powered by dynamic student leaders.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 2rem;">
      
      <!-- Leader 1 -->
      <div style="background: var(--off-white); border-radius: var(--radius-lg); padding: 2rem; text-align: center; border: 1px solid var(--gray-200); transition: var(--transition);" onmouseover="this.style.borderColor='var(--gold-primary)'" onmouseout="this.style.borderColor='var(--gray-200)'">
        <div style="width: 100px; height: 100px; border-radius: 50%; margin: 0 auto 1.2rem; overflow: hidden; border: 3px solid var(--gold-primary);">
          <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&q=80" alt="Dr. Aris Thorne" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <h4 style="font-size: 1.2rem; color: var(--primary-navy); margin-bottom: 4px;">Dr. Evelyn Vance</h4>
        <div style="color: var(--royal-blue); font-weight: 600; font-size: 0.85rem; margin-bottom: 8px;">Faculty Chief Patron</div>
        <p style="color: var(--gray-600); font-size: 0.88rem;">Dean of Student Welfare & Professor of Computer Engineering.</p>
      </div>

      <!-- Leader 2 -->
      <div style="background: var(--off-white); border-radius: var(--radius-lg); padding: 2rem; text-align: center; border: 1px solid var(--gray-200); transition: var(--transition);" onmouseover="this.style.borderColor='var(--gold-primary)'" onmouseout="this.style.borderColor='var(--gray-200)'">
        <div style="width: 100px; height: 100px; border-radius: 50%; margin: 0 auto 1.2rem; overflow: hidden; border: 3px solid var(--gold-primary);">
          <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80" alt="Rohan Verma" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <h4 style="font-size: 1.2rem; color: var(--primary-navy); margin-bottom: 4px;">Rohan Verma</h4>
        <div style="color: var(--royal-blue); font-weight: 600; font-size: 0.85rem; margin-bottom: 8px;">Fest General Secretary</div>
        <p style="color: var(--gray-600); font-size: 0.88rem;">Final Year B.Tech CSE, coordinating festival operations and sponsors.</p>
      </div>

      <!-- Leader 3 -->
      <div style="background: var(--off-white); border-radius: var(--radius-lg); padding: 2rem; text-align: center; border: 1px solid var(--gray-200); transition: var(--transition);" onmouseover="this.style.borderColor='var(--gold-primary)'" onmouseout="this.style.borderColor='var(--gray-200)'">
        <div style="width: 100px; height: 100px; border-radius: 50%; margin: 0 auto 1.2rem; overflow: hidden; border: 3px solid var(--gold-primary);">
          <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=400&q=80" alt="Priya Nair" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <h4 style="font-size: 1.2rem; color: var(--primary-navy); margin-bottom: 4px;">Priya Nair</h4>
        <div style="color: var(--royal-blue); font-weight: 600; font-size: 0.85rem; margin-bottom: 8px;">Cultural & Arts Head</div>
        <p style="color: var(--gray-600); font-size: 0.88rem;">Performing Arts lead managing Stage, Bands, Dramatics & Fashion.</p>
      </div>

      <!-- Leader 4 -->
      <div style="background: var(--off-white); border-radius: var(--radius-lg); padding: 2rem; text-align: center; border: 1px solid var(--gray-200); transition: var(--transition);" onmouseover="this.style.borderColor='var(--gold-primary)'" onmouseout="this.style.borderColor='var(--gray-200)'">
        <div style="width: 100px; height: 100px; border-radius: 50%; margin: 0 auto 1.2rem; overflow: hidden; border: 3px solid var(--gold-primary);">
          <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=400&q=80" alt="Arjun Mehta" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <h4 style="font-size: 1.2rem; color: var(--primary-navy); margin-bottom: 4px;">Arjun Mehta</h4>
        <div style="color: var(--royal-blue); font-weight: 600; font-size: 0.85rem; margin-bottom: 8px;">Technical & Esports Lead</div>
        <p style="color: var(--gray-600); font-size: 0.88rem;">Overseeing hackathon judging, RoboWars safety, and CTF infrastructure.</p>
      </div>

    </div>
  </div>
</section>

<!-- Fest Guidelines & Code of Conduct -->
<section class="section">
  <div class="container" style="max-width: 900px;">
    <div class="section-title-wrap">
      <span class="section-pill">Important Instructions</span>
      <h2 class="section-title">General <span>Rules & Guidelines</span></h2>
      <p class="section-desc">Please review these essential regulations before arriving on campus.</p>
    </div>

    <div class="accordion-item">
      <button class="accordion-btn">
        <span>1. Valid College Identification (Mandatory)</span>
        <span>+</span>
      </button>
      <div class="accordion-body">
        All participants and visiting students must present a government ID and a valid college/university student identification card at the entry security check gate. Entry without physical/digital ID card will not be permitted.
      </div>
    </div>

    <div class="accordion-item">
      <button class="accordion-btn">
        <span>2. Event Check-in & Desk Timings</span>
        <span>+</span>
      </button>
      <div class="accordion-body">
        Participants must report to their respective event venue registration desk at least 45 minutes prior to the scheduled event start time. Spot adjustments are subject to jury discretion.
      </div>
    </div>

    <div class="accordion-item">
      <button class="accordion-btn">
        <span>3. Fair Play, Code of Conduct & Anti-Ragging</span>
        <span>+</span>
      </button>
      <div class="accordion-body">
        CampusFest maintains a strict zero-tolerance policy towards any form of misconduct, vandalism, or indiscipline. Disqualification of the entire contingent will be enforced immediately upon violation.
      </div>
    </div>

    <div class="accordion-item">
      <button class="accordion-btn">
        <span>4. Equipment & Hardware Policy</span>
        <span>+</span>
      </button>
      <div class="accordion-body">
        For technical events like CodeSprint and Cyber CTF, participants must bring their own laptops with chargers. For RoboWars, bots must adhere to weight and pneumatic limits verified during pre-match safety inspection.
      </div>
    </div>

    <div class="accordion-item">
      <button class="accordion-btn">
        <span>5. Cash Prizes & Certificate Issuance</span>
        <span>+</span>
      </button>
      <div class="accordion-body">
        All certified participants will receive verifiable e-certificates post event. Cash prize cheques and trophies will be formally conferred on stage during the Grand Valedictory Ceremony on March 20, 2026.
      </div>
    </div>

  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
