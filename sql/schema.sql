-- /job-portal/sql/schema.sql
-- Job Portal database schema (MySQL)
CREATE DATABASE IF NOT EXISTS job_portal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE job_portal;

-- Roles table (small lookup)
CREATE TABLE roles (
  id TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(32) NOT NULL UNIQUE, -- e.g. 'admin', 'employer', 'user'
  description VARCHAR(255)
) ENGINE=InnoDB;

-- Users table (covers job seekers and employers as users; employer-specific details in employers table)
CREATE TABLE users (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  role_id TINYINT UNSIGNED NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  first_name VARCHAR(100),
  last_name VARCHAR(100),
  phone VARCHAR(32),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  is_active TINYINT(1) DEFAULT 1,
  INDEX idx_role (role_id),
  FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Employers table (one-to-one with users when role = employer)
CREATE TABLE employers (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  user_id BIGINT UNSIGNED NOT NULL,
  company_name VARCHAR(255) NOT NULL,
  company_description TEXT,
  website VARCHAR(255),
  logo_path VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_user (user_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Categories (job categories)
CREATE TABLE categories (
  id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL UNIQUE,
  slug VARCHAR(120) NOT NULL UNIQUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Jobs table
CREATE TABLE jobs (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  employer_id BIGINT UNSIGNED NOT NULL,
  category_id INT UNSIGNED,
  title VARCHAR(255) NOT NULL,
  slug VARCHAR(255) NOT NULL,
  description MEDIUMTEXT NOT NULL,
  requirements TEXT,
  location VARCHAR(255),
  salary_from INT NULL,
  salary_to INT NULL,
  is_remote TINYINT(1) DEFAULT 0,
  status ENUM('draft','published','closed') DEFAULT 'draft',
  views INT UNSIGNED DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_employer (employer_id),
  INDEX idx_category (category_id),
  FULLTEXT KEY ft_title_desc (title, description),
  FOREIGN KEY (employer_id) REFERENCES employers(id) ON DELETE CASCADE,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Applications (job applications)
CREATE TABLE applications (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  job_id BIGINT UNSIGNED NOT NULL,
  user_id BIGINT UNSIGNED NOT NULL, -- candidate
  resume_path VARCHAR(255),
  cover_letter TEXT,
  status ENUM('applied','reviewed','interview','rejected','hired') DEFAULT 'applied',
  submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY unique_app (job_id, user_id),
  INDEX idx_job (job_id),
  INDEX idx_user (user_id),
  FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Saved jobs (favorites) — many-to-many: user <-> job
CREATE TABLE saved_jobs (
  user_id BIGINT UNSIGNED NOT NULL,
  job_id BIGINT UNSIGNED NOT NULL,
  saved_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (user_id, job_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Messages (optional: employer <-> candidate messaging)
CREATE TABLE messages (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  sender_id BIGINT UNSIGNED NOT NULL,
  receiver_id BIGINT UNSIGNED NOT NULL,
  job_id BIGINT UNSIGNED NULL,
  subject VARCHAR(255),
  body TEXT NOT NULL,
  is_read TINYINT(1) DEFAULT 0,
  sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_sender (sender_id),
  INDEX idx_receiver (receiver_id),
  FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Simple audit/logs
CREATE TABLE activity_logs (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  user_id BIGINT UNSIGNED NULL,
  action VARCHAR(255) NOT NULL,
  meta JSON NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_user (user_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Insert default roles
INSERT INTO roles (name, description) VALUES
('admin','Site administrator'),
('employer','Company / employer account'),
('user','Job seeker / candidate');
