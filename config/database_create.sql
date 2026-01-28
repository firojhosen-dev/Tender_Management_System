--* 1. Create Database
CREATE DATABASE tender_management_system;
USE tender_management_system;
--* 2. Users & Roles
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) NOT NULL UNIQUE
);
--* Users Table
CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL, -- Required for login
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    -- * Profile & Personal
    profile_picture VARCHAR(255) DEFAULT 'default_avatar.png',
    gender ENUM('Male', 'Female', 'Other') DEFAULT NULL,
    dob DATE DEFAULT NULL,
    employee_id VARCHAR(50) DEFAULT NULL,
    -- * Contact
    mobile VARCHAR(20) DEFAULT NULL,
    office_phone VARCHAR(20) DEFAULT NULL,
    address TEXT DEFAULT NULL,
    country_city_zip VARCHAR(100) DEFAULT NULL,
    -- * Organization
    department VARCHAR(100) DEFAULT NULL,
    designation VARCHAR(100) DEFAULT NULL,
    supervisor VARCHAR(100) DEFAULT NULL,
    company_name VARCHAR(100) DEFAULT NULL,
    company_id VARCHAR(50) DEFAULT NULL,
    -- * Account & Security
    `2fa_status` ENUM('Enabled', 'Disabled') DEFAULT 'Disabled', -- Note the backticks
    security_questions TEXT DEFAULT NULL,
    -- * Preferences
    preferred_language VARCHAR(50) DEFAULT 'English',
    timezone VARCHAR(50) DEFAULT 'Asia/Dhaka',
    theme_preference ENUM('Light', 'Dark') DEFAULT 'Light',
    notification_preferences VARCHAR(100) DEFAULT 'Email, SMS',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_login DATETIME DEFAULT NULL,
    last_logout DATETIME DEFAULT NULL,
    total_duration_minutes INT DEFAULT 0;
    bio TEXT, 
    fb_url VARCHAR(255), 
    ln_url VARCHAR(255), 
    gh_url VARCHAR(255), 
    tw_url VARCHAR(255), 
    supervisor VARCHAR(100),
    emergency_contact_name VARCHAR(100),
    emergency_contact_phone VARCHAR(20),
    blood_group VARCHAR(5),
    core_skills TEXT,
    years_of_exp INT;
    status TINYINT(1) DEFAULT 1;
    PRIMARY KEY (id),
    UNIQUE KEY (username),
    UNIQUE KEY (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- Assign Roles to Users
UPDATE users SET role_name = 'Admin' WHERE username = 'firojdev';
-- * 3. Tender Companies (Your Company Categories)
CREATE TABLE tender_companies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
ALTER TABLE tender_companies
ADD UNIQUE KEY unique_company_name (company_name); 

-- * 4. Tenders Table (Main Tender Data)
CREATE TABLE tenders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tender_company_id INT NOT NULL,
    tender_participate_company VARCHAR(100),
    tender_name VARCHAR(200),
    tender_ref_no VARCHAR(100),
    published_date DATE,
    submitted_date DATE,
    tender_status ENUM('Submitted','Not Submitted'),
    quoted_price DECIMAL(15,2),
    tender_result VARCHAR(100),
    brand VARCHAR(100),
    remarks TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tender_company_id) REFERENCES tender_companies(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);
-- * 5. Tender Documents (Future Use)
CREATE TABLE tender_documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tender_id INT,
    file_name VARCHAR(255),
    file_path VARCHAR(255),
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tender_id) REFERENCES tenders(id)
);
-- * 6. Search Logs (Optional – for analytics)
CREATE TABLE search_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    search_query TEXT,
    searched_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- * 7. Activity Logs (Audit)
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `role` VARCHAR(50) NOT NULL,
  `duration_minutes` INT(11) DEFAULT 0,
  `last_activity` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` DATE NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- * 8. Default Role Insert
INSERT INTO roles (role_name) VALUES
('Admin'),
('Tender Creator'),
('Reviewer'),
('Vendor'),
('Auditor');
-- * 9. Permission
CREATE TABLE permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_id INT NOT NULL,
    page_name VARCHAR(255) NOT NULL,
    can_access TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);
-- * 10. Search History
CREATE TABLE search_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    search_query TEXT NOT NULL,
    search_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
-- * System Settings
CREATE TABLE system_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value LONGTEXT NULL,
    setting_group VARCHAR(50) NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- * Default Settings Insert
INSERT INTO system_settings (setting_key, setting_value) VALUES
('system_name', 'Tender Management System'),
('system_version', '1.0.0'),
('company_name', 'Your Company Name'),
('timezone', 'Asia/Dhaka'),
('maintenance_mode', 'off');

-- * Vendors Table
CREATE TABLE vendors (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    vendor_name VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255),
    phone VARCHAR(50),
    address TEXT,
    company_registration_no VARCHAR(100),
    status ENUM('Active','Inactive','Blacklisted') DEFAULT 'Active',
    created_by INT UNSIGNED,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
-- * Support Tickets Table
CREATE TABLE `support_tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `priority` enum('Low','Medium','High','Urgent') DEFAULT 'Low',
  `category` varchar(50) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('Open','In Progress','Resolved','Closed') DEFAULT 'Open',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ticket_id` (`ticket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- * User Requests Table
CREATE TABLE user_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    description TEXT,
    status ENUM('pending', 'approved') DEFAULT 'pending',
    request_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- * End of Database Creation Script