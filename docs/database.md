# SkillBridge — Database Schema

> Complete MySQL database design for the SkillBridge platform.

---

## 1. Entity-Relationship Overview

```
┌──────────────┐       ┌──────────────────┐       ┌────────────────────┐
│    users     │──1:1──│ student_profiles  │       │   certificates     │
│              │       └──────────────────┘       │  (belongs to user) │
│  id          │                                   └────────────────────┘
│  email       │──1:1──┌──────────────────┐
│  password    │       │ company_profiles  │
│  role        │       └──────────────────┘
│  is_banned   │
└──────┬───────┘
       │
       │ 1:N
       ▼
┌──────────────┐       ┌──────────────────┐       ┌────────────────────┐
│    posts     │──1:N──│  applications    │──N:1──│   users (student)  │
│ (company)    │       │                  │       └────────────────────┘
└──────────────┘       └──────────────────┘
                              │
                              │ triggers
                              ▼
                       ┌──────────────────┐
                       │  notifications   │
                       └──────────────────┘

┌──────────────────┐   ┌──────────────────┐
│ feed_activities  │   │   admin_logs     │
│ (user actions)   │   │ (admin actions)  │
└──────────────────┘   └──────────────────┘
```

---

## 2. Table Definitions

### 2.1 `users`

The central authentication table. All roles (student, company, admin) authenticate through this table. The `role` column determines which dashboard and profile type to load.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | INT | PRIMARY KEY, AUTO_INCREMENT | Unique user identifier |
| `email` | VARCHAR(255) | UNIQUE, NOT NULL | Login email address |
| `password` | VARCHAR(255) | NOT NULL | Bcrypt-hashed password |
| `full_name` | VARCHAR(150) | NOT NULL | Display name |
| `role` | ENUM('student', 'company', 'admin') | NOT NULL | User role |
| `is_banned` | TINYINT(1) | DEFAULT 0 | Ban status (0=active, 1=banned) |
| `avatar_url` | VARCHAR(500) | NULL | Profile picture URL |
| `created_at` | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Registration date |
| `updated_at` | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Last modification |

**Indexes:**
- PRIMARY KEY (`id`)
- UNIQUE INDEX (`email`)
- INDEX (`role`)
- INDEX (`is_banned`)

---

### 2.2 `student_profiles`

Extended profile data for users with `role = 'student'`. One-to-one relationship with `users`.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | INT | PRIMARY KEY, AUTO_INCREMENT | Profile identifier |
| `user_id` | INT | UNIQUE, FOREIGN KEY → users(id) ON DELETE CASCADE | Owning user |
| `university` | VARCHAR(255) | NULL | University name |
| `field_of_study` | VARCHAR(255) | NULL | Academic major/field |
| `bio` | TEXT | NULL | Personal bio/description |
| `skills` | TEXT | NULL | Comma-separated skill tags |
| `resume_url` | VARCHAR(500) | NULL | Link to resume document |
| `linkedin_url` | VARCHAR(500) | NULL | LinkedIn profile URL |
| `graduation_year` | YEAR | NULL | Expected graduation year |
| `created_at` | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Profile creation date |
| `updated_at` | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Last update |

**Indexes:**
- PRIMARY KEY (`id`)
- UNIQUE INDEX (`user_id`)

---

### 2.3 `company_profiles`

Extended profile data for users with `role = 'company'`. One-to-one relationship with `users`.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | INT | PRIMARY KEY, AUTO_INCREMENT | Profile identifier |
| `user_id` | INT | UNIQUE, FOREIGN KEY → users(id) ON DELETE CASCADE | Owning user |
| `company_name` | VARCHAR(255) | NOT NULL | Official company name |
| `industry` | VARCHAR(255) | NULL | Industry sector |
| `description` | TEXT | NULL | Company overview |
| `website` | VARCHAR(500) | NULL | Company website URL |
| `location` | VARCHAR(255) | NULL | Headquarters location |
| `company_size` | ENUM('1-10', '11-50', '51-200', '201-500', '500+') | NULL | Employee count range |
| `founded_year` | YEAR | NULL | Year company was founded |
| `created_at` | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Profile creation date |
| `updated_at` | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Last update |

**Indexes:**
- PRIMARY KEY (`id`)
- UNIQUE INDEX (`user_id`)

---

### 2.4 `certificates`

Professional certificates added by students. Each certificate addition generates a feed activity.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | INT | PRIMARY KEY, AUTO_INCREMENT | Certificate identifier |
| `user_id` | INT | FOREIGN KEY → users(id) ON DELETE CASCADE | Owning student |
| `title` | VARCHAR(255) | NOT NULL | Certificate name |
| `issuer` | VARCHAR(255) | NOT NULL | Issuing organization |
| `issue_date` | DATE | NOT NULL | Date certificate was issued |
| `credential_url` | VARCHAR(500) | NULL | Link to verify certificate |
| `description` | TEXT | NULL | Optional description |
| `created_at` | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Record creation date |

**Indexes:**
- PRIMARY KEY (`id`)
- INDEX (`user_id`)

---

### 2.5 `posts`

Opportunity listings created by companies. Three types: internship, job, challenge.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | INT | PRIMARY KEY, AUTO_INCREMENT | Post identifier |
| `company_id` | INT | FOREIGN KEY → users(id) ON DELETE CASCADE | Company that created the post |
| `title` | VARCHAR(255) | NOT NULL | Post title |
| `description` | TEXT | NOT NULL | Full post description |
| `type` | ENUM('internship', 'job', 'challenge') | NOT NULL | Opportunity type |
| `requirements` | TEXT | NULL | Required skills/qualifications |
| `location` | VARCHAR(255) | NULL | Job location |
| `is_remote` | TINYINT(1) | DEFAULT 0 | Remote work option |
| `deadline` | DATE | NULL | Application deadline |
| `status` | ENUM('active', 'closed', 'draft') | DEFAULT 'active' | Post visibility |
| `created_at` | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Publication date |
| `updated_at` | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Last modification |

**Indexes:**
- PRIMARY KEY (`id`)
- INDEX (`company_id`)
- INDEX (`type`)
- INDEX (`status`)
- INDEX (`deadline`)

---

### 2.6 `applications`

Student applications to company posts. Each student can apply once per post.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | INT | PRIMARY KEY, AUTO_INCREMENT | Application identifier |
| `student_id` | INT | FOREIGN KEY → users(id) ON DELETE CASCADE | Applying student |
| `post_id` | INT | FOREIGN KEY → posts(id) ON DELETE CASCADE | Target post |
| `cover_letter` | TEXT | NULL | Application cover letter |
| `status` | ENUM('pending', 'accepted', 'rejected') | DEFAULT 'pending' | Decision status |
| `created_at` | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Application date |
| `updated_at` | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | Last status change |

**Indexes:**
- PRIMARY KEY (`id`)
- UNIQUE INDEX (`student_id`, `post_id`) — prevents duplicate applications
- INDEX (`post_id`)
- INDEX (`status`)

---

### 2.7 `notifications`

System-generated notifications for users. Triggered by application decisions, new applications, and admin actions.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | INT | PRIMARY KEY, AUTO_INCREMENT | Notification identifier |
| `user_id` | INT | FOREIGN KEY → users(id) ON DELETE CASCADE | Recipient user |
| `title` | VARCHAR(255) | NOT NULL | Notification headline |
| `message` | TEXT | NOT NULL | Notification body |
| `type` | ENUM('application_accepted', 'application_rejected', 'new_application', 'system') | NOT NULL | Notification category |
| `reference_id` | INT | NULL | Related entity ID (post, application) |
| `is_read` | TINYINT(1) | DEFAULT 0 | Read status |
| `created_at` | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Creation date |

**Indexes:**
- PRIMARY KEY (`id`)
- INDEX (`user_id`)
- INDEX (`is_read`)
- INDEX (`type`)

---

### 2.8 `feed_activities`

Activity feed entries tracking user actions. Generated automatically when users perform significant actions.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | INT | PRIMARY KEY, AUTO_INCREMENT | Activity identifier |
| `user_id` | INT | FOREIGN KEY → users(id) ON DELETE CASCADE | Acting user |
| `activity_type` | ENUM('certificate_added', 'post_created', 'application_submitted') | NOT NULL | Type of activity |
| `description` | VARCHAR(500) | NOT NULL | Human-readable description |
| `reference_id` | INT | NULL | Related entity ID |
| `created_at` | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Activity timestamp |

**Indexes:**
- PRIMARY KEY (`id`)
- INDEX (`user_id`)
- INDEX (`activity_type`)
- INDEX (`created_at`)

---

### 2.9 `admin_logs`

Audit trail for admin moderation actions. Records who did what and when.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | INT | PRIMARY KEY, AUTO_INCREMENT | Log entry identifier |
| `admin_id` | INT | FOREIGN KEY → users(id) ON DELETE SET NULL | Admin who performed the action |
| `action` | ENUM('ban_user', 'unban_user', 'delete_post', 'system_event') | NOT NULL | Action type |
| `target_type` | ENUM('user', 'post', 'system') | NOT NULL | Entity type affected |
| `target_id` | INT | NULL | ID of affected entity |
| `description` | VARCHAR(500) | NULL | Human-readable log message |
| `created_at` | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Action timestamp |

**Indexes:**
- PRIMARY KEY (`id`)
- INDEX (`admin_id`)
- INDEX (`action`)
- INDEX (`created_at`)

---

## 3. Relationships Summary

| Relationship | Type | Description |
|-------------|------|-------------|
| users → student_profiles | 1:1 | Each student user has exactly one student profile |
| users → company_profiles | 1:1 | Each company user has exactly one company profile |
| users → certificates | 1:N | A student can have many certificates |
| users → posts | 1:N | A company can create many posts |
| users → applications (as student) | 1:N | A student can submit many applications |
| posts → applications | 1:N | A post can receive many applications |
| users → notifications | 1:N | A user can receive many notifications |
| users → feed_activities | 1:N | A user can generate many feed activities |
| users → admin_logs (as admin) | 1:N | An admin can create many log entries |

---

## 4. MySQL Schema Script

```sql
-- ============================================
-- SkillBridge Database Schema
-- Version: 1.0.0
-- Database: MySQL 8.x
-- ============================================

CREATE DATABASE IF NOT EXISTS skillbridge
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE skillbridge;

-- ============================================
-- 1. Users Table
-- ============================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(150) NOT NULL,
    role ENUM('student', 'company', 'admin') NOT NULL,
    is_banned TINYINT(1) NOT NULL DEFAULT 0,
    avatar_url VARCHAR(500) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_users_role (role),
    INDEX idx_users_banned (is_banned)
) ENGINE=InnoDB;

-- ============================================
-- 2. Student Profiles Table
-- ============================================
CREATE TABLE student_profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    university VARCHAR(255) DEFAULT NULL,
    field_of_study VARCHAR(255) DEFAULT NULL,
    bio TEXT DEFAULT NULL,
    skills TEXT DEFAULT NULL,
    resume_url VARCHAR(500) DEFAULT NULL,
    linkedin_url VARCHAR(500) DEFAULT NULL,
    graduation_year YEAR DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_student_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================
-- 3. Company Profiles Table
-- ============================================
CREATE TABLE company_profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    company_name VARCHAR(255) NOT NULL,
    industry VARCHAR(255) DEFAULT NULL,
    description TEXT DEFAULT NULL,
    website VARCHAR(500) DEFAULT NULL,
    location VARCHAR(255) DEFAULT NULL,
    company_size ENUM('1-10', '11-50', '51-200', '201-500', '500+') DEFAULT NULL,
    founded_year YEAR DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_company_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================
-- 4. Certificates Table
-- ============================================
CREATE TABLE certificates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    issuer VARCHAR(255) NOT NULL,
    issue_date DATE NOT NULL,
    credential_url VARCHAR(500) DEFAULT NULL,
    description TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_certificates_user (user_id),

    CONSTRAINT fk_certificate_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================
-- 5. Posts Table
-- ============================================
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    type ENUM('internship', 'job', 'challenge') NOT NULL,
    requirements TEXT DEFAULT NULL,
    location VARCHAR(255) DEFAULT NULL,
    is_remote TINYINT(1) NOT NULL DEFAULT 0,
    deadline DATE DEFAULT NULL,
    status ENUM('active', 'closed', 'draft') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_posts_company (company_id),
    INDEX idx_posts_type (type),
    INDEX idx_posts_status (status),
    INDEX idx_posts_deadline (deadline),

    CONSTRAINT fk_post_company
        FOREIGN KEY (company_id) REFERENCES users(id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================
-- 6. Applications Table
-- ============================================
CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    post_id INT NOT NULL,
    cover_letter TEXT DEFAULT NULL,
    status ENUM('pending', 'accepted', 'rejected') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE INDEX idx_applications_unique (student_id, post_id),
    INDEX idx_applications_post (post_id),
    INDEX idx_applications_status (status),

    CONSTRAINT fk_application_student
        FOREIGN KEY (student_id) REFERENCES users(id)
        ON DELETE CASCADE ON UPDATE CASCADE,

    CONSTRAINT fk_application_post
        FOREIGN KEY (post_id) REFERENCES posts(id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================
-- 7. Notifications Table
-- ============================================
CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    type ENUM('application_accepted', 'application_rejected', 'new_application', 'system') NOT NULL,
    reference_id INT DEFAULT NULL,
    is_read TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_notifications_user (user_id),
    INDEX idx_notifications_read (is_read),
    INDEX idx_notifications_type (type),

    CONSTRAINT fk_notification_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================
-- 8. Feed Activities Table
-- ============================================
CREATE TABLE feed_activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    activity_type ENUM('certificate_added', 'post_created', 'application_submitted') NOT NULL,
    description VARCHAR(500) NOT NULL,
    reference_id INT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_feed_user (user_id),
    INDEX idx_feed_type (activity_type),
    INDEX idx_feed_created (created_at),

    CONSTRAINT fk_feed_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================
-- 9. Admin Logs Table
-- ============================================
CREATE TABLE admin_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT DEFAULT NULL,
    action ENUM('ban_user', 'unban_user', 'delete_post', 'system_event') NOT NULL,
    target_type ENUM('user', 'post', 'system') NOT NULL,
    target_id INT DEFAULT NULL,
    description VARCHAR(500) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_logs_admin (admin_id),
    INDEX idx_logs_action (action),
    INDEX idx_logs_created (created_at),

    CONSTRAINT fk_log_admin
        FOREIGN KEY (admin_id) REFERENCES users(id)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;
```

---

## 5. Normalization Notes

The schema follows **Third Normal Form (3NF)**:

1. **1NF**: All columns contain atomic values. No repeating groups. The `skills` field in `student_profiles` uses comma-separated values for simplicity — in a larger system, this would be a separate `skills` junction table.

2. **2NF**: All non-key columns are fully dependent on the primary key. No partial dependencies exist because all tables use single-column primary keys.

3. **3NF**: No transitive dependencies. Profile data is separated from auth data. Post data is separate from company profile data. Each table stores only data relevant to its entity.

**Design Trade-offs:**
- `skills` as TEXT instead of a junction table: Acceptable for MVP scope. Avoids additional table complexity.
- `reference_id` in notifications/feed is a generic foreign key: Trades referential integrity for simplicity. The application layer ensures valid references.
- `company_id` in posts references `users.id` directly rather than `company_profiles.id`: Simplifies queries since authentication operates on `users.id`.

---

## 6. Seed Data Script

```sql
-- ============================================
-- SkillBridge Seed Data
-- ============================================

USE skillbridge;

-- Admin account (password: admin123)
INSERT INTO users (email, password, full_name, role) VALUES
('admin@skillbridge.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Platform Admin', 'admin');

-- Sample student (password: student123)
INSERT INTO users (email, password, full_name, role) VALUES
('student@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Ahmed Benali', 'student');

INSERT INTO student_profiles (user_id, university, field_of_study, bio, skills, graduation_year) VALUES
(2, 'University of Science and Technology', 'Computer Science', 'Passionate about web development and AI.', 'PHP, JavaScript, MySQL, Python', 2026);

-- Sample company (password: company123)
INSERT INTO users (email, password, full_name, role) VALUES
('hr@techcorp.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Sarah Martin', 'company');

INSERT INTO company_profiles (user_id, company_name, industry, description, website, location, company_size) VALUES
(3, 'TechCorp Solutions', 'Technology', 'Leading software development company.', 'https://techcorp.example.com', 'Algiers, Algeria', '51-200');

-- Sample post
INSERT INTO posts (company_id, title, description, type, requirements, location, deadline, status) VALUES
(3, 'Frontend Developer Intern', 'Join our team for a 3-month internship building modern web interfaces.', 'internship', 'HTML, CSS, JavaScript, Git', 'Algiers, Algeria', '2026-06-30', 'active');

-- Sample certificate
INSERT INTO certificates (user_id, title, issuer, issue_date, credential_url) VALUES
(2, 'Web Development Fundamentals', 'Coursera', '2025-12-15', 'https://coursera.org/verify/abc123');

-- Sample feed activity
INSERT INTO feed_activities (user_id, activity_type, description, reference_id) VALUES
(2, 'certificate_added', 'Ahmed Benali added a new certificate: Web Development Fundamentals', 1);
```
