-- CampusFest 2026 Database Schema
-- Compatible with MySQL / MariaDB (XAMPP)

CREATE DATABASE IF NOT EXISTS `campusfest_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `campusfest_db`;

-- 1. Users Table (for Student & Participant Accounts)
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `full_name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(120) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `college` VARCHAR(150) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Events Table
CREATE TABLE IF NOT EXISTS `events` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(150) NOT NULL,
    `category` ENUM('Technical', 'Cultural', 'Sports') NOT NULL,
    `description` TEXT NOT NULL,
    `date` VARCHAR(50) NOT NULL,
    `time` VARCHAR(50) NOT NULL,
    `venue` VARCHAR(120) NOT NULL,
    `team_size` VARCHAR(50) NOT NULL,
    `fee` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `prize` VARCHAR(100) NOT NULL,
    `image` VARCHAR(255) NOT NULL,
    `status` ENUM('Open', 'Closing Soon', 'Closed') DEFAULT 'Open',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Registrations Table
CREATE TABLE IF NOT EXISTS `registrations` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NULL,
    `registration_number` VARCHAR(30) NOT NULL UNIQUE,
    `student_name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(120) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `college` VARCHAR(150) NOT NULL,
    `department` VARCHAR(100) NOT NULL,
    `year_of_study` VARCHAR(20) NOT NULL,
    `event_id` INT NOT NULL,
    `event_title` VARCHAR(150) NOT NULL,
    `team_type` ENUM('Solo', 'Team') DEFAULT 'Solo',
    `team_members` TEXT NULL,
    `amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `payment_status` ENUM('Pending', 'Completed', 'Failed') DEFAULT 'Pending',
    `transaction_id` VARCHAR(100) NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_reg_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Payments Table (Demo Payment Records)
CREATE TABLE IF NOT EXISTS `payments` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `registration_id` INT NOT NULL,
    `registration_number` VARCHAR(30) NOT NULL,
    `transaction_id` VARCHAR(100) NOT NULL UNIQUE,
    `amount` DECIMAL(10,2) NOT NULL,
    `payment_method` VARCHAR(50) NOT NULL,
    `status` ENUM('Success', 'Pending', 'Failed') DEFAULT 'Success',
    `payment_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_pay_registration` FOREIGN KEY (`registration_id`) REFERENCES `registrations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Contact Messages Table
CREATE TABLE IF NOT EXISTS `contact_messages` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(120) NOT NULL,
    `subject` VARCHAR(150) NOT NULL,
    `message` TEXT NOT NULL,
    `status` ENUM('Unread', 'Read', 'Replied') DEFAULT 'Unread',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed Default Events (Technical, Cultural, Sports)
DELETE FROM `events`;

INSERT INTO `events` (`id`, `title`, `category`, `description`, `date`, `time`, `venue`, `team_size`, `fee`, `prize`, `image`, `status`) VALUES
-- Technical Events
(1, 'CodeSprint 24-Hour Hackathon', 'Technical', 'Collaborate, build innovative software/hardware solutions overnight and pitch to top industry tech leaders.', 'March 18, 2026', '10:00 AM - 10:00 AM', 'Turing Innovation Lab, Block B', '2 - 4 Members', 500.00, 'INR 50,000 + Internship Offer', 'https://images.unsplash.com/photo-1515879218367-8466d910aaa4?auto=format&fit=crop&w=800&q=80', 'Open'),
(2, 'RoboWars: Clash of Titans', 'Technical', 'Build your high-torque combat bot within weight limits and fight inside a bulletproof arena to conquer the title.', 'March 18, 2026', '02:00 PM', 'Mechanical Arena, Ground 2', '2 - 5 Members', 600.00, 'INR 35,000 + Trophy', 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&w=800&q=80', 'Open'),
(3, 'WebCraft UI/UX & Web Sprint', 'Technical', 'Showcase your frontend mastery and responsive design genius in an intensive 3-hour live web architecture showdown.', 'March 19, 2026', '11:00 AM', 'Design Studio, 3rd Floor', 'Solo or Duo', 250.00, 'INR 20,000', 'https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?auto=format&fit=crop&w=800&q=80', 'Open'),
(4, 'CyberShield Capture The Flag (CTF)', 'Technical', 'Crack cryptographic puzzles, exploit network vulnerabilities, and solve real-world cybersecurity challenges.', 'March 19, 2026', '01:30 PM', 'Cyber Security Center, Block A', 'Solo or Duo', 300.00, 'INR 25,000', 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&w=800&q=80', 'Open'),

-- Cultural Events
(5, 'Symphony: Battle of the Bands', 'Cultural', 'Rock the open amphitheater! Acoustic, metal, fusion or western bands battle live under stadium concert lights.', 'March 19, 2026', '05:30 PM', 'Main Open Air Amphitheatre', '4 - 8 Members', 800.00, 'INR 45,000 + Audio Gear', 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=800&q=80', 'Open'),
(6, 'Rhythm Royale: Western & Fusion Dance', 'Cultural', 'Electrifying group choreography battle featuring hip-hop, contemporary, Bollywood fusion, and high-energy synchronization.', 'March 20, 2026', '06:00 PM', 'Grand Convocation Auditorium', '6 - 15 Members', 750.00, 'INR 40,000 + Winner Cup', 'https://images.unsplash.com/photo-1547153760-18fc86324498?auto=format&fit=crop&w=800&q=80', 'Open'),
(7, 'Vogue: The Grand Fashion Show', 'Cultural', 'Elegance meets glamour. Walk the ramp with creative theme-based haute couture and designer costumes.', 'March 20, 2026', '07:30 PM', 'Central Quadrangle Ramp', '10 - 18 Members', 1000.00, 'INR 50,000 + Modeling Contract', 'https://images.unsplash.com/photo-1509631179647-0177331693ae?auto=format&fit=crop&w=800&q=80', 'Closing Soon'),
(8, 'Natya Manch: Street Play (Nukkad Natak)', 'Cultural', 'Raise your voice on poignant social issues with powerful theatrical acts, acoustic drums, and soul-stirring dialogues.', 'March 18, 2026', '03:00 PM', 'Student Activity Center Lawn', '8 - 20 Members', 400.00, 'INR 25,000', 'https://images.unsplash.com/photo-1460723237483-7a6dc9d0b212?auto=format&fit=crop&w=800&q=80', 'Open'),

-- Sports Events
(9, 'Campus Champions Cup: 7-a-side Football', 'Sports', 'High-intensity knockout football tournament on FIFA standard turf under floodlights.', 'March 18, 2026', '08:00 AM', 'Campus Football Stadium Turf', '7 + 3 Substitutes', 900.00, 'INR 40,000 + Gold Medals', 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?auto=format&fit=crop&w=800&q=80', 'Open'),
(10, 'Gully to Glory: Box Cricket League', 'Sports', 'Fast-paced tennis-ball indoor and box cricket league with thrilling over-by-over high-stakes cricket action.', 'March 18, 2026', '09:00 AM', 'Multi-Purpose Sports Complex', '6 + 2 Substitutes', 700.00, 'INR 30,000 + Championship Trophy', 'https://images.unsplash.com/photo-1540747913346-19e32dc3e97e?auto=format&fit=crop&w=800&q=80', 'Open'),
(11, 'Smash Masters: Badminton Championship', 'Sports', 'Singles and Doubles rapid tournament on synthetic indoor wooden courts with international scoring.', 'March 19, 2026', '10:00 AM', 'Indoor Sports Complex, Court 1 & 2', 'Solo or Duo', 300.00, 'INR 20,000 + Gold Medals', 'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?auto=format&fit=crop&w=800&q=80', 'Open'),
(12, 'Checkmate: Rapid Chess Masters', 'Sports', 'FIDE-rules compliant Swiss League rapid chess tournament for tactical and strategic minds.', 'March 19, 2026', '11:00 AM', 'Auditorium Seminar Hall C', 'Solo', 200.00, 'INR 15,000 + Trophy', 'https://images.unsplash.com/photo-1529699211952-734e80c4d42b?auto=format&fit=crop&w=800&q=80', 'Open');
