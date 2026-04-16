-- ============================================================
-- SkillBridge — Database Schema
-- Version: 1.0.0  |  Engine: MySQL 8.x  |  Charset: utf8mb4
-- ============================================================

CREATE DATABASE IF NOT EXISTS skillbridge
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE skillbridge;

-- ============================================================
-- TABLE 1: users
-- Central authentication table. role determines dashboard.
-- ============================================================
CREATE TABLE IF NOT EXISTS users (
    id          INT           AUTO_INCREMENT PRIMARY KEY,
    email       VARCHAR(255)  NOT NULL UNIQUE,
    password    VARCHAR(255)  NOT NULL,
    full_name   VARCHAR(150)  NOT NULL,
    role        ENUM('student','company','admin') NOT NULL,
    is_banned   TINYINT(1)    NOT NULL DEFAULT 0,
    avatar_url  VARCHAR(500)  DEFAULT NULL,
    created_at  TIMESTAMP     DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_users_role    (role),
    INDEX idx_users_banned  (is_banned)
) ENGINE=InnoDB;

-- ============================================================
-- TABLE 2: student_profiles
-- 1:1 with users where role='student'
-- ============================================================
CREATE TABLE IF NOT EXISTS student_profiles (
    id              INT          AUTO_INCREMENT PRIMARY KEY,
    user_id         INT          NOT NULL UNIQUE,
    university      VARCHAR(255) DEFAULT NULL,
    field_of_study  VARCHAR(255) DEFAULT NULL,
    bio             TEXT         DEFAULT NULL,
    skills          TEXT         DEFAULT NULL,
    resume_url      VARCHAR(500) DEFAULT NULL,
    linkedin_url    VARCHAR(500) DEFAULT NULL,
    graduation_year YEAR         DEFAULT NULL,
    created_at      TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_sp_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- TABLE 3: company_profiles
-- 1:1 with users where role='company'
-- ============================================================
CREATE TABLE IF NOT EXISTS company_profiles (
    id           INT          AUTO_INCREMENT PRIMARY KEY,
    user_id      INT          NOT NULL UNIQUE,
    company_name VARCHAR(255) NOT NULL,
    industry     VARCHAR(255) DEFAULT NULL,
    description  TEXT         DEFAULT NULL,
    website      VARCHAR(500) DEFAULT NULL,
    location     VARCHAR(255) DEFAULT NULL,
    company_size ENUM('1-10','11-50','51-200','201-500','500+') DEFAULT NULL,
    founded_year YEAR         DEFAULT NULL,
    created_at   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_cp_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- TABLE 4: certificates
-- Owned by students. Adding one auto-creates a feed entry.
-- ============================================================
CREATE TABLE IF NOT EXISTS certificates (
    id             INT          AUTO_INCREMENT PRIMARY KEY,
    user_id        INT          NOT NULL,
    title          VARCHAR(255) NOT NULL,
    issuer         VARCHAR(255) NOT NULL,
    issue_date     DATE         NOT NULL,
    credential_url VARCHAR(500) DEFAULT NULL,
    description    TEXT         DEFAULT NULL,
    created_at     TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_cert_user (user_id),

    CONSTRAINT fk_cert_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- TABLE 5: posts
-- Opportunity listings created by company users.
-- ============================================================
CREATE TABLE IF NOT EXISTS posts (
    id          INT          AUTO_INCREMENT PRIMARY KEY,
    company_id  INT          NOT NULL,
    title       VARCHAR(255) NOT NULL,
    description TEXT         NOT NULL,
    type        ENUM('internship','job','challenge') NOT NULL,
    requirements TEXT        DEFAULT NULL,
    location    VARCHAR(255) DEFAULT NULL,
    is_remote   TINYINT(1)   NOT NULL DEFAULT 0,
    deadline    DATE         DEFAULT NULL,
    status      ENUM('active','closed','draft') NOT NULL DEFAULT 'active',
    created_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_posts_company  (company_id),
    INDEX idx_posts_type     (type),
    INDEX idx_posts_status   (status),
    INDEX idx_posts_deadline (deadline),

    CONSTRAINT fk_post_company
        FOREIGN KEY (company_id) REFERENCES users(id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- TABLE 6: applications
-- One application per student per post (UNIQUE constraint).
-- ============================================================
CREATE TABLE IF NOT EXISTS applications (
    id           INT          AUTO_INCREMENT PRIMARY KEY,
    student_id   INT          NOT NULL,
    post_id      INT          NOT NULL,
    cover_letter TEXT         DEFAULT NULL,
    status       ENUM('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
    created_at   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    updated_at   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE INDEX idx_app_unique  (student_id, post_id),
    INDEX        idx_app_post    (post_id),
    INDEX        idx_app_status  (status),

    CONSTRAINT fk_app_student
        FOREIGN KEY (student_id) REFERENCES users(id)
        ON DELETE CASCADE ON UPDATE CASCADE,

    CONSTRAINT fk_app_post
        FOREIGN KEY (post_id) REFERENCES posts(id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- TABLE 7: notifications
-- System-generated only. is_read tracks badge count.
-- ============================================================
CREATE TABLE IF NOT EXISTS notifications (
    id           INT          AUTO_INCREMENT PRIMARY KEY,
    user_id      INT          NOT NULL,
    title        VARCHAR(255) NOT NULL,
    message      TEXT         NOT NULL,
    type         ENUM('application_accepted','application_rejected','new_application','system') NOT NULL,
    reference_id INT          DEFAULT NULL,
    is_read      TINYINT(1)   NOT NULL DEFAULT 0,
    created_at   TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_notif_user   (user_id),
    INDEX idx_notif_read   (is_read),
    INDEX idx_notif_type   (type),

    CONSTRAINT fk_notif_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- TABLE 8: feed_activities
-- Auto-logged from: certificate_added, post_created, application_submitted
-- ============================================================
CREATE TABLE IF NOT EXISTS feed_activities (
    id            INT          AUTO_INCREMENT PRIMARY KEY,
    user_id       INT          NOT NULL,
    activity_type ENUM('certificate_added','post_created','application_submitted') NOT NULL,
    description   VARCHAR(500) NOT NULL,
    reference_id  INT          DEFAULT NULL,
    created_at    TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_feed_user    (user_id),
    INDEX idx_feed_type    (activity_type),
    INDEX idx_feed_created (created_at),

    CONSTRAINT fk_feed_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ============================================================
-- TABLE 9: admin_logs
-- Audit trail for all admin moderation actions.
-- ============================================================
CREATE TABLE IF NOT EXISTS admin_logs (
    id          INT          AUTO_INCREMENT PRIMARY KEY,
    admin_id    INT          DEFAULT NULL,
    action      ENUM('ban_user','unban_user','delete_post','system_event') NOT NULL,
    target_type ENUM('user','post','system') NOT NULL,
    target_id   INT          DEFAULT NULL,
    description VARCHAR(500) DEFAULT NULL,
    created_at  TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_log_admin   (admin_id),
    INDEX idx_log_action  (action),
    INDEX idx_log_created (created_at),

    CONSTRAINT fk_log_admin
        FOREIGN KEY (admin_id) REFERENCES users(id)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;
