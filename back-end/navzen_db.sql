-- 🛠️ Création de la base
CREATE DATABASE IF NOT EXISTS navzen_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE navzen_db;

-- 👤 Utilisateurs
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    username VARCHAR(100) UNIQUE, 
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    auth_provider VARCHAR(50),
    phone_number VARCHAR(20),
    profile_picture_url LONGTEXT,
    address VARCHAR(255),
    last_login DATETIME,
    is_active BOOLEAN DEFAULT TRUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 🎭 Rôles
CREATE TABLE roles (
    role_id INT PRIMARY KEY AUTO_INCREMENT,
    role_name VARCHAR(50) UNIQUE,
    role_description TEXT
);

-- 🔗 Association roles ⇄ users
CREATE TABLE roles_user (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    role_id INT,
    assigned_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(role_id) ON DELETE CASCADE,
    UNIQUE (user_id, role_id)
);

-- 🏢 Lieux
CREATE TABLE locations (
    location_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    address VARCHAR(255),
    city VARCHAR(50),
    country VARCHAR(50),
    latitude FLOAT,
    longitude FLOAT,
    description TEXT
);

-- 🧱 Étages
CREATE TABLE floors (
    floor_id INT PRIMARY KEY AUTO_INCREMENT,
    location_id INT,
    floor_label VARCHAR(50),
    floor_number INT,
    FOREIGN KEY (location_id) REFERENCES locations(location_id) ON DELETE CASCADE
);

-- 📡 Balises
CREATE TABLE beacons (
    beacon_id INT PRIMARY KEY AUTO_INCREMENT,
    location_id INT,
    beacon_uuid VARCHAR(100),
    identifier VARCHAR(50),
    description TEXT,
    latitude FLOAT,
    longitude FLOAT,
    FOREIGN KEY (location_id) REFERENCES locations(location_id) ON DELETE CASCADE
);

-- 📍 Points d'intérêt
CREATE TABLE pois (
    poi_id INT PRIMARY KEY AUTO_INCREMENT,
    location_id INT,
    floor_id INT,
    beacon_id INT,
    name VARCHAR(100),
    description TEXT,
    type VARCHAR(50),
    category VARCHAR(50),
    latitude FLOAT,
    longitude FLOAT,
    is_accessible BOOLEAN DEFAULT FALSE,
    opening_hours VARCHAR(100),
    closing_soon BOOLEAN DEFAULT FALSE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (location_id) REFERENCES locations(location_id) ON DELETE CASCADE,
    FOREIGN KEY (floor_id) REFERENCES floors(floor_id) ON DELETE SET NULL,
    FOREIGN KEY (beacon_id) REFERENCES beacons(beacon_id) ON DELETE SET NULL
);

-- 🧭 Itinéraires
CREATE TABLE routes (
    route_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    start_beacon_id INT,
    end_beacon_id INT,
    steps JSON,
    distance FLOAT,
    estimated_time INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (start_beacon_id) REFERENCES beacons(beacon_id) ON DELETE SET NULL,
    FOREIGN KEY (end_beacon_id) REFERENCES beacons(beacon_id) ON DELETE SET NULL
);

-- 🔔 Notifications
CREATE TABLE notifications (
    notification_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    message TEXT,
    trigger_type VARCHAR(50),
    trigger_id INT,
    is_read BOOLEAN DEFAULT FALSE,
    sent_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- ⭐ Favoris POIs
CREATE TABLE favorites_pois (
    favorite_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    poi_id INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (poi_id) REFERENCES pois(poi_id) ON DELETE CASCADE,
    UNIQUE (user_id, poi_id)
);

-- ⭐ Favoris Lieux
CREATE TABLE IF NOT EXISTS favorites_locations (
    favorite_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    location_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (location_id) REFERENCES locations(location_id) ON DELETE CASCADE,
    UNIQUE (user_id, location_id)
);

-- ♿ Accessibilité
CREATE TABLE accessibility_options (
    option_id INT PRIMARY KEY AUTO_INCREMENT,
    location_id INT,
    option_type VARCHAR(50),
    description TEXT,
    FOREIGN KEY (location_id) REFERENCES locations(location_id) ON DELETE CASCADE
);

-- 🧑‍💼 Niveaux utilisateur
CREATE TABLE levels_user (
    user_id INT PRIMARY KEY,
    level INT DEFAULT 1,
    xp INT DEFAULT 0,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- 🔓 Rôles par défaut
INSERT INTO roles (role_name, role_description) VALUES
('ROLE_GUEST', 'Utilisateur non inscrit'),
('ROLE_USER', 'Utilisateur connecté'),
('ROLE_ADMIN', 'Administrateur');