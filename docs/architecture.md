# SkillBridge — System Architecture

> High-level system design and architectural decisions.

---

## 1. Architecture Overview

SkillBridge follows a **three-tier architecture** separating presentation, business logic, and data storage:

```
┌─────────────────────────────────────────────────────────┐
│                    CLIENT (Browser)                      │
│                                                         │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐    │
│  │   Student    │  │   Company   │  │    Admin     │    │
│  │  Dashboard   │  │  Dashboard  │  │  Dashboard   │    │
│  └──────┬──────┘  └──────┬──────┘  └──────┬──────┘    │
│         │                │                │             │
│         └────────────────┼────────────────┘             │
│                          │                              │
│              ┌───────────┴───────────┐                  │
│              │   JavaScript (ES6+)   │                  │
│              │   fetch() API calls   │                  │
│              └───────────┬───────────┘                  │
└──────────────────────────┼──────────────────────────────┘
                           │ HTTP (JSON)
                           ▼
┌──────────────────────────────────────────────────────────┐
│                   BACKEND (PHP 8.x)                      │
│                                                          │
│  ┌──────────┐    ┌──────────────┐    ┌──────────────┐   │
│  │  index   │───▶│    Router    │───▶│ Middleware    │   │
│  │  .php    │    │              │    │ (Auth, RBAC)  │   │
│  └──────────┘    └──────────────┘    └──────┬───────┘   │
│                                             │            │
│                                             ▼            │
│                  ┌──────────────┐    ┌──────────────┐   │
│                  │   Services   │◀───│ Controllers  │   │
│                  │ (Business    │    │ (Request     │   │
│                  │  Logic)      │    │  Handling)   │   │
│                  └──────┬───────┘    └──────────────┘   │
│                         │                                │
│                         ▼                                │
│                  ┌──────────────┐                        │
│                  │    Models    │                        │
│                  │ (Data Access │                        │
│                  │  Layer)      │                        │
│                  └──────┬───────┘                        │
└─────────────────────────┼────────────────────────────────┘
                          │ PDO (Prepared Statements)
                          ▼
┌──────────────────────────────────────────────────────────┐
│                   DATABASE (MySQL 8.x)                    │
│                                                          │
│    users │ student_profiles │ company_profiles            │
│    certificates │ posts │ applications                    │
│    notifications │ feed_activities │ admin_logs           │
└──────────────────────────────────────────────────────────┘
```

---

## 2. Layer Responsibilities

### 2.1 Presentation Layer (Frontend)

| Aspect | Details |
|--------|---------|
| Technology | HTML5, CSS3, JavaScript (ES6+) |
| Pattern | Multi-Page Application (MPA) |
| API Communication | `fetch()` with JSON |
| State Management | `sessionStorage` for auth state |
| Routing | File-based (each page is an HTML file) |

**Key Responsibilities:**
- Render role-specific dashboard pages
- Handle user input and form validation (client-side)
- Make AJAX requests to the backend API
- Update the DOM based on API responses
- Display notifications and activity feed

### 2.2 Business Logic Layer (Backend)

| Aspect | Details |
|--------|---------|
| Technology | PHP 8.x |
| Pattern | MVC-inspired (Controllers, Services, Models) |
| API Style | RESTful with JSON responses |
| Authentication | Server-side PHP sessions |

**Request Flow:**
```
HTTP Request
  → index.php (front controller)
    → Router (maps URL to controller method)
      → Middleware (authentication, role checking)
        → Controller (validates input, calls service)
          → Service (business logic, orchestrates models)
            → Model (database queries via PDO)
              → JSON Response
```

### 2.3 Data Layer (Database)

| Aspect | Details |
|--------|---------|
| Technology | MySQL 8.x |
| Connection | PDO with prepared statements |
| Schema | 9 tables, Third Normal Form (3NF) |
| Character Set | utf8mb4 with unicode_ci collation |

---

## 3. Backend Architecture Detail

### 3.1 Directory Structure

```
backend/
├── index.php                  # Front controller & entry point
├── .htaccess                  # Apache URL rewriting rules
│
├── config/
│   ├── database.php           # Database connection (PDO singleton)
│   ├── cors.php               # CORS headers configuration
│   └── constants.php          # Application constants
│
├── routes/
│   └── api.php                # Route definitions (URL → controller mapping)
│
├── middleware/
│   ├── AuthMiddleware.php     # Verifies session exists
│   └── RoleMiddleware.php     # Verifies user role matches requirement
│
├── controllers/
│   ├── AuthController.php     # Login, register, logout, me
│   ├── ProfileController.php  # Student and company profile CRUD
│   ├── CertificateController.php  # Certificate CRUD
│   ├── PostController.php     # Post CRUD and listing
│   ├── ApplicationController.php  # Application submission and management
│   ├── NotificationController.php # Notification listing and read status
│   ├── FeedController.php     # Activity feed listing
│   └── AdminController.php    # User management, analytics, logs
│
├── services/
│   ├── AuthService.php        # Authentication business logic
│   ├── ProfileService.php     # Profile business logic
│   ├── CertificateService.php # Certificate + feed activity logic
│   ├── PostService.php        # Post business logic
│   ├── ApplicationService.php # Application + notification logic
│   ├── NotificationService.php # Notification business logic
│   ├── FeedService.php        # Feed activity business logic
│   └── AdminService.php       # Admin operations + logging
│
├── models/
│   ├── UserModel.php          # Users table queries
│   ├── StudentProfileModel.php # Student profiles queries
│   ├── CompanyProfileModel.php # Company profiles queries
│   ├── CertificateModel.php   # Certificates table queries
│   ├── PostModel.php          # Posts table queries
│   ├── ApplicationModel.php   # Applications table queries
│   ├── NotificationModel.php  # Notifications table queries
│   ├── FeedModel.php          # Feed activities table queries
│   └── AdminLogModel.php      # Admin logs table queries
│
└── helpers/
    ├── Response.php           # JSON response helper
    ├── Validator.php          # Input validation utilities
    └── Sanitizer.php          # Input sanitization utilities
```

### 3.2 Routing Mechanism

The backend uses a simple custom router. All requests are directed to `index.php` via `.htaccess`:

```apache
# .htaccess
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

The router in `index.php` parses the URL and HTTP method to dispatch to the correct controller:

```php
// Simplified routing logic
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace('/api/', '', $uri);

// Route matching
$routes = require 'routes/api.php';
```

### 3.3 Authentication Flow

```
┌──────────┐    POST /api/auth/login    ┌──────────────┐
│  Client  │ ────────────────────────▶  │ AuthController│
│          │                            └──────┬───────┘
│          │                                   │
│          │                            ┌──────▼───────┐
│          │                            │ AuthService   │
│          │                            │ 1. Validate   │
│          │                            │ 2. Check ban  │
│          │                            │ 3. Verify pwd │
│          │                            │ 4. Create     │
│          │                            │    session    │
│          │                            └──────┬───────┘
│          │    Set-Cookie: PHPSESSID    ┌──────▼───────┐
│          │ ◀──────────────────────────│  Response     │
└──────────┘                            └──────────────┘
```

### 3.4 Middleware Chain

Every protected request passes through middleware before reaching the controller:

```
Request → AuthMiddleware → RoleMiddleware → Controller
              │                  │
              │ No session?      │ Wrong role?
              ▼                  ▼
          401 Response       403 Response
```

---

## 4. Frontend Architecture Detail

### 4.1 Directory Structure

```
frontend/
├── index.html                     # Landing page
│
├── assets/
│   ├── css/
│   │   ├── variables.css          # CSS custom properties (colors, spacing)
│   │   ├── base.css               # Reset, typography, global styles
│   │   ├── layout.css             # Dashboard layout (sidebar, header, content)
│   │   ├── components.css         # Reusable component styles
│   │   ├── auth.css               # Login/register page styles
│   │   ├── student.css            # Student-specific styles
│   │   ├── company.css            # Company-specific styles
│   │   └── admin.css              # Admin-specific styles
│   │
│   ├── js/
│   │   ├── api.js                 # Centralized API client (fetch wrapper)
│   │   ├── auth.js                # Auth state management
│   │   ├── router.js              # Client-side navigation helpers
│   │   ├── utils.js               # Utility functions (date formatting, etc.)
│   │   ├── student-dashboard.js   # Student dashboard logic
│   │   ├── company-dashboard.js   # Company dashboard logic
│   │   ├── admin-dashboard.js     # Admin dashboard logic
│   │   └── notifications.js       # Notification polling and display
│   │
│   ├── images/                    # Static images
│   └── icons/                     # Icon assets
│
├── pages/
│   ├── auth/
│   │   ├── login.html
│   │   └── register.html
│   │
│   ├── public/
│   │   ├── about.html
│   │   └── profile.html           # Public profile view
│   │
│   ├── student/
│   │   ├── dashboard.html
│   │   ├── profile.html
│   │   ├── edit-profile.html
│   │   ├── certificates.html
│   │   ├── opportunities.html
│   │   ├── post-detail.html
│   │   ├── applications.html
│   │   ├── notifications.html
│   │   └── settings.html
│   │
│   ├── company/
│   │   ├── dashboard.html
│   │   ├── profile.html
│   │   ├── edit-profile.html
│   │   ├── create-post.html
│   │   ├── edit-post.html
│   │   ├── my-posts.html
│   │   ├── applications.html
│   │   ├── notifications.html
│   │   └── settings.html
│   │
│   └── admin/
│       ├── dashboard.html
│       ├── users.html
│       ├── posts.html
│       ├── analytics.html
│       ├── logs.html
│       └── settings.html
│
└── components/                    # Reusable HTML snippets (loaded via JS)
    ├── sidebar.html
    ├── header.html
    ├── notification-badge.html
    └── footer.html
```

### 4.2 Dashboard Layout Model

All three dashboards share a common layout structure:

```
┌────────────────────────────────────────────────────┐
│  Header (Logo, Search, Notifications, Avatar)      │
├──────────┬─────────────────────────────────────────┤
│          │                                         │
│  Sidebar │         Main Content Area               │
│  (Nav)   │                                         │
│          │   ┌─────────────────────────────────┐   │
│  - Home  │   │  Page-specific content          │   │
│  - Profile│   │  (loaded per page)              │   │
│  - Posts │   │                                 │   │
│  - ...   │   └─────────────────────────────────┘   │
│          │                                         │
└──────────┴─────────────────────────────────────────┘
```

---

## 5. Data Flow Diagrams

### 5.1 Student Application Flow

```
Student                  Backend                    Company
  │                        │                          │
  │ POST /api/applications │                          │
  ├───────────────────────▶│                          │
  │                        │ 1. Validate input        │
  │                        │ 2. Check duplicate        │
  │                        │ 3. Insert application     │
  │                        │ 4. Create feed entry      │
  │                        │ 5. Create notification ──▶│
  │     201 Created        │                          │
  │◀───────────────────────┤                          │
  │                        │                          │
  │                        │ GET /api/applications/    │
  │                        │     post/{id}             │
  │                        │◀─────────────────────────┤
  │                        │                          │
  │                        │ PATCH /api/applications/  │
  │                        │     {id}/status           │
  │                        │◀─────────────────────────┤
  │                        │ 1. Update status          │
  │                        │ 2. Create notification    │
  │  Notification received │    for student            │
  │◀───────────────────────┤                          │
```

### 5.2 Admin Moderation Flow

```
Admin                    Backend                    Target User
  │                        │                          │
  │ PATCH /api/admin/      │                          │
  │   users/{id}/ban       │                          │
  ├───────────────────────▶│                          │
  │                        │ 1. Set is_banned = 1 ───▶│
  │                        │ 2. Create admin_log      │
  │     200 OK             │ 3. Invalidate session    │
  │◀───────────────────────┤                          │
  │                        │                          │
  │                        │   Next login attempt     │
  │                        │◀─────────────────────────┤
  │                        │   403 Forbidden          │
  │                        │──────────────────────────▶│
```

---

## 6. Security Architecture

| Layer | Mechanism | Purpose |
|-------|-----------|---------|
| Transport | HTTPS (production) | Encrypt data in transit |
| Authentication | PHP sessions, bcrypt | Verify identity |
| Authorization | Role middleware | Enforce access control |
| Input | Server-side validation, sanitization | Prevent injection |
| Database | PDO prepared statements | Prevent SQL injection |
| Output | `htmlspecialchars()` | Prevent XSS |
| Session | `httponly`, `secure` flags | Prevent session hijacking |
| CSRF | Token validation on forms | Prevent cross-site request forgery |

---

## 7. Technology Justification

| Choice | Alternative Considered | Reason for Choice |
|--------|----------------------|-------------------|
| Vanilla PHP | Laravel, Symfony | Academic requirement — demonstrate raw PHP skills; no framework dependency overhead |
| MySQL | PostgreSQL, SQLite | Most commonly taught in curriculum; excellent tooling support via phpMyAdmin |
| Vanilla JS | React, Vue | No build step needed; demonstrates core JavaScript competency |
| Vanilla CSS | Bootstrap, Tailwind | Full control over design; demonstrates CSS proficiency |
| PHP Sessions | JWT | Simpler for server-rendered pages; native PHP support; appropriate for academic scope |
| MPA | SPA | Simpler routing; no client-side router needed; each page is self-contained |
