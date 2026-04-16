-- ============================================================
-- SkillBridge — Seed Data
-- Run AFTER schema.sql
-- Passwords use bcrypt hash of 'password' (password_hash('password', PASSWORD_BCRYPT))
-- ============================================================

USE skillbridge;

-- ============================================================
-- USERS
-- admin123 / student123 / company123  all map to same hash
-- (bcrypt of literal string 'password' for demo; change in prod)
-- ============================================================

INSERT INTO users (email, password, full_name, role) VALUES
(
    'admin@skillbridge.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'Platform Admin',
    'admin'
),
(
    'ahmed@example.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'Ahmed Benali',
    'student'
),
(
    'sara@example.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'Sara Khelif',
    'student'
),
(
    'hr@techcorp.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'Sarah Martin',
    'company'
),
(
    'jobs@innovasoft.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'Karim Boudjema',
    'company'
);

-- ============================================================
-- STUDENT PROFILES  (user_id 2 = Ahmed, 3 = Sara)
-- ============================================================

INSERT INTO student_profiles (user_id, university, field_of_study, bio, skills, graduation_year, linkedin_url) VALUES
(
    2,
    'University of Science and Technology Houari Boumediene',
    'Computer Science',
    'Passionate about web development and artificial intelligence. Seeking meaningful internship opportunities.',
    'PHP, JavaScript, MySQL, Python, HTML, CSS',
    2026,
    'https://linkedin.com/in/ahmed-benali'
),
(
    3,
    'École Nationale Supérieure d''Informatique',
    'Software Engineering',
    'Full-stack developer in training. Interested in mobile applications and cloud computing.',
    'Flutter, Dart, Java, Firebase, REST APIs',
    2025,
    'https://linkedin.com/in/sara-khelif'
);

-- ============================================================
-- COMPANY PROFILES  (user_id 4 = TechCorp, 5 = InnovaSoft)
-- ============================================================

INSERT INTO company_profiles (user_id, company_name, industry, description, website, location, company_size, founded_year) VALUES
(
    4,
    'TechCorp Solutions',
    'Technology',
    'Leading software development company specialising in enterprise solutions and cloud infrastructure.',
    'https://techcorp.example.com',
    'Algiers, Algeria',
    '51-200',
    2010
),
(
    5,
    'InnovaSoft',
    'Software & AI',
    'Startup focused on AI-powered business automation tools and data analytics platforms.',
    'https://innovasoft.example.com',
    'Oran, Algeria',
    '11-50',
    2019
);

-- ============================================================
-- POSTS  (company_id 4 = TechCorp, 5 = InnovaSoft)
-- ============================================================

INSERT INTO posts (company_id, title, description, type, requirements, location, is_remote, deadline, status) VALUES
(
    4,
    'Frontend Developer Internship',
    'Join our engineering team for a 3-month internship building modern, responsive web interfaces for our enterprise clients. You will work directly with senior engineers, participate in code reviews, and ship production-quality code from day one.',
    'internship',
    'HTML, CSS, JavaScript, Git, Basic React knowledge',
    'Algiers, Algeria',
    0,
    '2026-06-30',
    'active'
),
(
    4,
    'Backend PHP Developer',
    'We are looking for a PHP developer with solid experience in RESTful APIs and MySQL databases. You will join a cross-functional team building scalable backend systems. This is a full-time position with opportunity for growth.',
    'job',
    'PHP 8+, MySQL, REST APIs, Git, Docker basics',
    'Algiers, Algeria',
    1,
    '2026-07-15',
    'active'
),
(
    5,
    'AI Challenge: Smart CV Screening',
    'Build a proof-of-concept AI system that can analyse a student CV and score its relevance to a given job description. Winners receive cash prizes and a fast-track interview at InnovaSoft.',
    'challenge',
    'Python, NLP, Machine Learning basics, REST API',
    NULL,
    1,
    '2026-05-31',
    'active'
),
(
    5,
    'Mobile App Developer',
    'We need a Flutter developer to join our small but growing mobile team. You will build features across iOS and Android for our flagship product used by over 50,000 users.',
    'job',
    'Flutter, Dart, REST APIs, Firebase',
    'Oran, Algeria',
    0,
    '2026-08-01',
    'active'
);

-- ============================================================
-- CERTIFICATES  (user_id 2 = Ahmed, 3 = Sara)
-- ============================================================

INSERT INTO certificates (user_id, title, issuer, issue_date, credential_url, description) VALUES
(
    2,
    'Web Development Fundamentals',
    'Coursera',
    '2025-12-15',
    'https://coursera.org/verify/abc123',
    'Comprehensive course covering HTML5, CSS3, JavaScript ES6+, and basic web security.'
),
(
    2,
    'PHP & MySQL for Beginners',
    'Udemy',
    '2025-09-01',
    'https://udemy.com/certificate/xyz456',
    'Introduction to server-side programming with PHP and database management with MySQL.'
),
(
    3,
    'Flutter & Dart — The Complete Guide',
    'Udemy',
    '2025-11-20',
    'https://udemy.com/certificate/flutter789',
    'Build iOS and Android apps from scratch using Flutter framework and Dart language.'
);

-- ============================================================
-- FEED ACTIVITIES
-- ============================================================

INSERT INTO feed_activities (user_id, activity_type, description, reference_id) VALUES
(2, 'certificate_added', 'Ahmed Benali added a new certificate: Web Development Fundamentals', 1),
(2, 'certificate_added', 'Ahmed Benali added a new certificate: PHP & MySQL for Beginners', 2),
(3, 'certificate_added', 'Sara Khelif added a new certificate: Flutter & Dart — The Complete Guide', 3),
(4, 'post_created', 'TechCorp Solutions published a new internship: Frontend Developer Internship', 1),
(4, 'post_created', 'TechCorp Solutions published a new job: Backend PHP Developer', 2),
(5, 'post_created', 'InnovaSoft published a new challenge: AI Challenge: Smart CV Screening', 3);

-- ============================================================
-- SAMPLE APPLICATION
-- ============================================================

INSERT INTO applications (student_id, post_id, cover_letter, status) VALUES
(
    2,
    1,
    'I am very excited to apply for the Frontend Developer Internship at TechCorp Solutions. My background in HTML, CSS, JavaScript, and PHP makes me a strong candidate. I am eager to learn and contribute to your team.',
    'pending'
);

-- Feed entry for the application
INSERT INTO feed_activities (user_id, activity_type, description, reference_id) VALUES
(2, 'application_submitted', 'Ahmed Benali applied to Frontend Developer Internship at TechCorp Solutions', 1);

-- Notification for the company
INSERT INTO notifications (user_id, title, message, type, reference_id) VALUES
(
    4,
    'New Application Received',
    'Ahmed Benali has applied to your post: Frontend Developer Internship.',
    'new_application',
    1
);
