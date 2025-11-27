CREATE DATABASE IF NOT EXISTS db_anahita_hospitals
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;
USE db_anahita_hospitals;

-- tabel login
CREATE TABLE auth_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- tabel profil user (register)
CREATE TABLE user_profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    full_name VARCHAR(150) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES auth_users(id) ON DELETE CASCADE
);

-- rumah sakit
CREATE TABLE hospitals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    address TEXT
);

-- dokter
CREATE TABLE doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    specialization VARCHAR(100)
);

-- dokter praktek di mana
CREATE TABLE doctor_practices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    doctor_id INT NOT NULL,
    hospital_id INT NOT NULL,
    UNIQUE (doctor_id, hospital_id),
    FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE CASCADE,
    FOREIGN KEY (hospital_id) REFERENCES hospitals(id) ON DELETE CASCADE
);

-- jadwal dokter
CREATE TABLE doctor_schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    practice_id INT NOT NULL,
    day_of_week TINYINT NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    FOREIGN KEY (practice_id) REFERENCES doctor_practices(id) ON DELETE CASCADE
);

-- --------------------------------------------------------
-- SEED DATA AWAL
-- --------------------------------------------------------

-- user biasa (username: user01, password: password123)
INSERT INTO auth_users (username, password_hash)
VALUES (
    'user01',
    '$2y$10$LZ5S1KXGcRT51r6z2qwOuO7wJNnND9uGzA3SGYKoGs66E1Q1iG9ru'
);

INSERT INTO user_profiles (user_id, full_name)
VALUES (
    1,
    'Budi Santoso'
);

-- admin (username: admin, password: admin123)
INSERT INTO auth_users (username, password_hash)
VALUES (
    'admin',
    '$2y$10$igxUZ7h0mN61.JcB5.pWPu5Sl4BLAvlx2SvXkgiMi3tEe3qoxSuJe'
);

INSERT INTO user_profiles (user_id, full_name)
VALUES (
    2,
    'Admin Utama'
);