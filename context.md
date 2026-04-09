# SkillBridge — Project Context

## 1. Project Identity

| Attribute | Value |
|-----------|-------|
| **Project Name** | SkillBridge |
| **Project Type** | Student-Career Networking Platform |
| **Academic Context** | Final-Year IT Project |
| **Development Team** | 4 members |
| **Target Audience** | University students, companies/HR recruiters, platform administrators |

---

## 2. Product Vision

SkillBridge bridges the gap between students and the professional world. Unlike general-purpose networking platforms such as LinkedIn, SkillBridge is laser-focused on the **student-to-career transition**:

- **Students** build profiles showcasing their skills, certificates, and academic achievements. They discover and apply to opportunities posted by companies.
- **Companies / HR recruiters** publish internship, job, and challenge opportunities. They review student applications and make hiring decisions.
- **Administrators** maintain platform quality through moderation, analytics, and system oversight.

The platform provides a **dedicated dashboard** for each role, ensuring that every user type has an experience tailored to their specific needs and workflows.

---

## 3. Core User Roles

### 3.1 Student

Students are the primary users of the platform. Their experience centers around building a professional identity and discovering career opportunities.

**Capabilities:**
- Sign up with email and password (role: `student`)
- Log in, log out, manage session
- Create and edit a personal profile (name, bio, university, skills, avatar, resume link)
- Add professional certificates (with title, issuer, date, optional URL)
- View a personal activity feed (generated from actions like adding certificates)
- Browse company posts: internships, job offers, and challenges
- View detailed post pages and apply to opportunities
- Track application statuses (pending, accepted, rejected)
- Receive notifications when applications are accepted or rejected
- View other users' public profiles

### 3.2 Company / HR

Company users represent organizations looking to recruit students. Their experience centers around publishing opportunities and managing incoming applications.

**Capabilities:**
- Sign up with email and password (role: `company`)
- Log in, log out, manage session
- Create and edit a company profile (company name, industry, description, logo, website, location)
- Create opportunity posts with type (`internship`, `job`, `challenge`), title, description, requirements, and deadline
- Edit or delete their own posts
- View a list of applications received for each post
- Accept or reject individual applications (triggers student notification)
- Receive notifications when students apply to their posts

### 3.3 Admin

Admins are platform operators who maintain quality and monitor platform health. Admin accounts are **not publicly registerable** — they are seeded directly in the database.

**Capabilities:**
- Log in and log out (no sign up)
- View platform-wide analytics (user counts, post counts, application statistics)
- View all posts across the platform
- View all users with ability to filter by role and status
- Ban and unban user accounts (banned users cannot log in)
- View system logs (admin actions, moderation events)
- Access an admin dashboard with summary cards and charts

---

## 4. Core Functional Modules

### 4.1 Authentication Module
- **Registration**: Students and companies register with email, password, full name, and role selection
- **Login**: Email + password authentication with server-side session management
- **Logout**: Session destruction and redirect to login page
- **Role-Based Access Control (RBAC)**: Middleware checks user role before granting access to protected routes
- **Password Security**: Passwords hashed with `password_hash()` (bcrypt) before storage
- **Ban Enforcement**: Login denied for users with `is_banned = 1`

### 4.2 Profile Module
- **Student Profiles**: Separate `student_profiles` table linked to `users` via `user_id`
- **Company Profiles**: Separate `company_profiles` table linked to `users` via `user_id`
- **Profile Viewing**: Users can view their own profile and other users' public profiles
- **Profile Editing**: Role-specific forms for updating profile data
- **File Handling**: Avatar/logo uploads stored as file paths in the database

### 4.3 Certificate Module
- Students add certificates with: title, issuing organization, issue date, credential URL
- Certificates are stored in a dedicated `certificates` table linked to `user_id`
- Adding a certificate automatically creates an entry in the `feed_activities` table
- Certificates are displayed on the student's profile page

### 4.4 Posts / Opportunities Module
- Companies create posts with: title, description, type, requirements, location, deadline
- Post types: `internship`, `job`, `challenge`
- Posts have a status: `active`, `closed`, `draft`
- Students browse active posts in a listing page with optional filtering by type
- Each post has a detail page showing full information and an "Apply" button

### 4.5 Application Module
- Students submit applications to active posts (one application per student per post)
- Applications are stored with: `student_id`, `post_id`, `cover_letter`, `status`, `created_at`
- Application statuses: `pending` → `accepted` or `rejected`
- Company users view applications per post and update their status
- Status changes trigger notification creation for the student

### 4.6 Notification Module
- Notifications are stored in the `notifications` table with: `user_id`, `title`, `message`, `type`, `is_read`, `created_at`
- Notification types: `application_accepted`, `application_rejected`, `new_application`, `system`
- Students receive notifications when their applications are accepted or rejected
- Companies receive notifications when students apply to their posts
- Notification badge shows count of unread notifications in the dashboard header

### 4.7 Activity Feed Module
- Feed entries are stored in `feed_activities` with: `user_id`, `activity_type`, `description`, `reference_id`, `created_at`
- Activity types: `certificate_added`, `post_created`, `application_submitted`
- Student dashboard shows personal feed of recent activities
- Feed entries link back to the relevant resource (certificate, post, application)

### 4.8 Admin Module
- **User Management**: List all users, filter by role, ban/unban accounts
- **Post Management**: View all platform posts, optionally remove inappropriate content
- **Analytics Dashboard**: Aggregate counts (total users, students, companies, posts, applications, acceptance rate)
- **System Logs**: Track admin actions in `admin_logs` table (action type, target user/entity, timestamp, description)
- **Dashboard Overview**: Summary cards with key metrics and recent activity

---

## 5. Technical Architecture

### 5.1 Frontend
- **Technology**: HTML5, CSS3, JavaScript (ES6+)
- **Architecture**: Multi-page application (MPA) with AJAX calls to the backend API
- **Styling**: Custom CSS with CSS variables for theming, no frameworks
- **JavaScript**: Vanilla JS with `fetch()` for API communication
- **Responsive**: Desktop-first design with responsive breakpoints for tablets

### 5.2 Backend API
- **Technology**: PHP 8.x
- **Architecture**: RESTful API returning JSON responses
- **Structure**: MVC-inspired with controllers, models, and services
- **Entry Point**: Single `index.php` front controller with URL routing
- **Authentication**: Server-side sessions with `$_SESSION`
- **Error Handling**: Consistent JSON error responses with HTTP status codes

### 5.3 Database
- **Technology**: MySQL 8.x
- **Design**: Normalized relational schema (3NF)
- **Connection**: PDO with prepared statements (SQL injection protection)
- **Tables**: 9 core tables (see [docs/database.md](docs/database.md))

### 5.4 Development Environment
- **Server Stack**: XAMPP, WAMP, or Laragon
- **PHP Server**: Apache with `mod_rewrite` for clean URLs
- **Database Admin**: phpMyAdmin for database inspection
- **Version Control**: Git with feature branches

---

## 6. Key Design Decisions

| Decision | Rationale |
|----------|-----------|
| Separate profile tables per role | Students and companies have fundamentally different profile data; separate tables enforce clear boundaries and simplify queries |
| Single `users` table with `role` column | Simplifies authentication logic; role determines which profile and dashboard to load |
| Feed as a separate entity | Decouples activity tracking from the entities that generate activities, making the feed extensible |
| Notification as a generic table | Supports multiple notification types without per-type tables; `type` enum provides categorization |
| PHP sessions over JWT | Simpler to implement for an academic project; sessions are well-supported in PHP |
| No frontend framework | Keeps the stack simple and evaluator-friendly; demonstrates raw HTML/CSS/JS competency |
| MVC-inspired backend | Provides structure without the overhead of a full framework; demonstrates architectural understanding |

---

## 7. Quality Standards

- **Code**: Well-commented, consistently formatted, following PSR-12 for PHP
- **Documentation**: Professional Markdown files covering every architectural decision
- **Security**: Input validation, prepared statements, password hashing, session security
- **Testing**: Manual test plans for all workflows, functional testing per phase
- **Presentation**: Clean project organization suitable for academic defense

---

## 8. Project Constraints

- Must be implementable by a 4-person team within a semester
- Must use only PHP, MySQL, HTML, CSS, and JavaScript (no external frameworks)
- Must be deployable on a standard XAMPP/WAMP environment
- Must include comprehensive documentation for academic evaluation
- Must demonstrate understanding of software engineering principles
