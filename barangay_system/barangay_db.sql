CREATE DATABASE IF NOT EXISTS barangay_db;
USE barangay_db;

CREATE TABLE users (
    user_id  INT AUTO_INCREMENT PRIMARY KEY,
    name     VARCHAR(100) NOT NULL,
    email    VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE households (
    household_id   INT AUTO_INCREMENT PRIMARY KEY,
    household_head VARCHAR(150) NOT NULL,
    member_count   INT DEFAULT 1,
    contact        VARCHAR(30),
    region         VARCHAR(100),
    province       VARCHAR(100),
    citymun        VARCHAR(100),
    barangay       VARCHAR(100)
);

CREATE TABLE residents (
    resident_id  INT AUTO_INCREMENT PRIMARY KEY,
    full_name    VARCHAR(150) NOT NULL,
    age          INT NOT NULL,
    gender       ENUM('Male','Female','Other') NOT NULL,
    contact      VARCHAR(30),
    civil_status ENUM('Single','Married','Widowed','Separated') DEFAULT 'Single',
    household_id INT,
    region       VARCHAR(100),
    province     VARCHAR(100),
    citymun      VARCHAR(100),
    barangay     VARCHAR(100),
    FOREIGN KEY (household_id) REFERENCES households(household_id) ON DELETE SET NULL
);

CREATE TABLE clearances (
    clearance_id INT AUTO_INCREMENT PRIMARY KEY,
    resident_id  INT NOT NULL,
    purpose      VARCHAR(255),
    date_issued  DATE NOT NULL,
    status       ENUM('Pending','Issued','Rejected') DEFAULT 'Pending',
    FOREIGN KEY (resident_id) REFERENCES residents(resident_id) ON DELETE CASCADE
);

CREATE TABLE officials (
    official_id   INT AUTO_INCREMENT PRIMARY KEY,
    official_name VARCHAR(150) NOT NULL,
    position      VARCHAR(100) NOT NULL,
    contact       VARCHAR(30)
);

INSERT INTO users (name, email, password) VALUES
('Admin','admin@barangay.com',
 '$2y$10$3r37sQ6/xJMQh1KBQ/U7WQ5gBwGE2EKQXSF9KbspRMlcV5aaQw.f');

INSERT INTO households (household_head, member_count, contact, region, province, citymun, barangay)
VALUES ('Dela Cruz, Juan', 4, '0917-111-2222', 'National Capital Region', 'Metro Manila', 'Quezon City', 'Payatas');

INSERT INTO residents (full_name, age, gender, contact, civil_status, household_id,
                       region, province, citymun, barangay) VALUES
('Juan Dela Cruz',   45, 'Male',  '0917-111-2222', 'Married', 1, 'National Capital Region','Metro Manila','Quezon City','Payatas'),
('Maria Dela Cruz',  42, 'Female','0917-111-3333', 'Married', 1, 'National Capital Region','Metro Manila','Quezon City','Payatas');

INSERT INTO clearances (resident_id, purpose, date_issued, status) VALUES
(1, 'Employment requirement', '2025-10-01', 'Issued'),
(2, 'Scholarship application','2025-10-05', 'Pending');

INSERT INTO officials (official_name, position, contact) VALUES
('Pedro Santos',  'Barangay Captain',   '0917-555-0001'),
('Ana Lopez',     'Barangay Secretary', '0917-555-0002'),
('Mark Rivera',   'Barangay Treasurer', '0917-555-0003');