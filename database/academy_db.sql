CREATE DATABASE IF NOT EXISTS academy_db;
USE academy_db;

-- Players table with registration system
CREATE TABLE players (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    date_of_birth DATE,
    position VARCHAR(50),
    age_group VARCHAR(20),
    address TEXT,
    emergency_contact_name VARCHAR(100),
    emergency_contact_phone VARCHAR(20),
    medical_conditions TEXT,
    previous_clubs TEXT,
    height DECIMAL(4,2),
    weight DECIMAL(4,2),
    image_path VARCHAR(255),
    goals INT DEFAULT 0,
    assists INT DEFAULT 0,
    clean_sheets INT DEFAULT 0,
    bio TEXT,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    approved_at TIMESTAMP NULL,
    approved_by INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Staff table
CREATE TABLE staff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    role VARCHAR(100),
    bio TEXT,
    image_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Matches table
CREATE TABLE matches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    match_type ENUM('league', 'friendly', 'tournament'),
    opponent VARCHAR(100) NOT NULL,
    match_date DATE,
    match_time TIME,
    venue VARCHAR(100),
    our_score INT,
    opponent_score INT,
    status ENUM('upcoming', 'completed', 'cancelled'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Programs table
CREATE TABLE programs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    age_group VARCHAR(50),
    image_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Admin users table
CREATE TABLE admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin user (password: password)
INSERT INTO admin_users (username, password_hash, email) 
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@academy.com');

-- Insert sample staff
INSERT INTO staff (name, role, bio) VALUES
('John Smith', 'Head Coach', 'UEFA A Licensed coach with 20+ years experience.'),
('Sarah Johnson', 'Senior Coach', 'Former professional player with expertise in technical development.'),
('Mike Brown', 'Goalkeeping Coach', 'Specialized goalkeeper trainer with professional experience.');

-- Insert sample programs
INSERT INTO programs (title, description, age_group) VALUES
('Junior Development', 'Foundation program focusing on fundamental skills for ages 5-10.', '5-10 years'),
('Elite Training', 'Advanced technical and tactical training for committed players ages 11-16.', '11-16 years'),
('Goalkeeper Academy', 'Specialized training for goalkeepers of all age groups.', 'All ages');

-- Insert sample matches
INSERT INTO matches (match_type, opponent, match_date, match_time, venue, status) VALUES
('league', 'City FC', '2023-11-20', '15:00:00', 'Home Pitch', 'upcoming'),
('friendly', 'United FA', '2023-11-25', '18:30:00', 'Away', 'upcoming');