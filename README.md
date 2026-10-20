# CampusFest 2026 - College Event Registration Website

A modern, responsive, and secure College Event Registration web application built with **HTML5, CSS3, JavaScript (ES6+), PHP, and MySQL (PDO)**.

Designed with an elegant **Royal Blue, Gold, and White** color theme.

---

## 🌟 Key Features

1. **Home (`index.php`)**:
   - Hero banner with festival dates and active live countdown timer.
   - Live festival statistics (50+ Colleges, 30+ Events, ₹2.5L+ Cash Prizes, 3500+ Participants).
   - Event Arenas preview (Technical, Cultural, Sports) with rich imagery.
   - 3-Day festival timeline schedule and call to action.

2. **About (`about.php`)**:
   - History, vision, and mission of CampusFest.
   - Organizing leadership & faculty/student coordinators.
   - Essential guidelines, equipment rules, and anti-ragging code of conduct.

3. **Events (`events.php`)**:
   - Dynamic category filter tabs (**All**, **Technical**, **Cultural**, **Sports**).
   - Event cards with high-resolution images, team sizes, venues, timings, entry fees, and cash prizes.
   - Direct "Register Now" buttons pre-filling the registration form.

4. **Registration (`register.php`)**:
   - Comprehensive registration form with validation.
   - Dynamic fee calculation and team member inputs.
   - Secure database insertion using **PDO prepared statements**.
   - Generates unique Registration ID (e.g., `CF26-XXXXX`) and forwards to payment.

5. **Student Portal / Login (`login.php`, `dashboard.php`, `logout.php`)**:
   - Tabbed Login and Sign Up interface.
   - **Password hashing** with `password_hash($pass, PASSWORD_BCRYPT)`.
   - Verification with `password_verify()`.
   - Student Dashboard displaying registered events, payment statuses, and printable passes.

6. **Campus Location & Map (`location.php`)**:
   - Interactive Google Maps embed.
   - Distance and directions from Airport, Central Railway Station, Metro, and Bus Terminals.
   - Campus arena directory and accommodation assistance guide.

7. **Contact Helpdesk (`contact.php`)**:
   - Direct query form saved to MySQL using prepared statements.
   - Coordinator phone numbers, emails, and office hours.
   - Interactive FAQ accordion.

8. **Demo Payment Gateway (`payment.php`)**:
   - Interactive demo checkout interface.
   - 3 payment options: **UPI / QR Code**, **Credit/Debit Card**, and **Net Banking**.
   - Generates transaction reference and updates registration status to `Completed`.
   - Official printable **CampusFest 2026 Entry Pass & Payment Receipt**.

9. **Photo Gallery (`gallery.php`)**:
   - Responsive masonry-style grid for Technical, Cultural, and Sports moments.
   - Filterable categories.
   - Fullscreen **Lightbox modal** with keyboard support.

---

## 🛠️ Technologies Used

- **Frontend:** HTML5, CSS3 (`style.css`), JavaScript (`script.js`).
- **Backend:** PHP 8.x (`db.php`, PDO extension).
- **Database:** MySQL / MariaDB (`database.sql`).
- **Security:** Password Hashing (`BCRYPT`), PDO Prepared Statements, Input Sanitization.
- **Environment:** XAMPP (Apache & MySQL).

---

## 🚀 How to Run the Website in XAMPP

### Step 1: Start XAMPP
1. Open the **XAMPP Control Panel**.
2. Click **Start** for **Apache**.
3. Click **Start** for **MySQL**.

### Step 2: Database Setup (Two Easy Options)

#### Option A: 1-Click Automated Setup (Recommended)
1. Open your browser and navigate to:
   ```
   http://localhost/campusfest 2026/setup.php
   ```
2. Click the **"⚡ Run Database Setup & Seed Tables"** button.
3. The wizard will automatically create `campusfest_db`, generate the tables, and seed all events!

#### Option B: Via phpMyAdmin
1. Open your browser and go to `http://localhost/phpmyadmin`.
2. Click **New** in the left sidebar and name the database: `campusfest_db`.
3. Select `campusfest_db` and click the **Import** tab.
4. Choose the `database.sql` file located at `c:\xampp\htdocs\campusfest 2026\database.sql`.
5. Click **Import** at the bottom.

### Step 3: Launch the Website
Open your browser and navigate to:
```
http://localhost/campusfest 2026/
```

---

## 🔑 Demo Login Credentials

- **Email:** `demo@campusfest.org`
- **Password:** `password123`
*(Or register a new account on `login.php`)*
