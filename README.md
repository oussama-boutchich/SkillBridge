# SkillBridge

> A student-career networking platform connecting students with companies through internships, job offers, and challenges.

---

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [Getting Started](#getting-started)
- [Database Setup](#database-setup)
- [API Documentation](#api-documentation)
- [User Roles](#user-roles)
- [Documentation](#documentation)
- [Development Phases](#development-phases)
- [License](#license)

---

## Overview

SkillBridge is a web-based professional networking platform designed specifically for **students**, **companies / HR recruiters**, and **platform administrators**. Inspired by LinkedIn, it focuses on the academic-to-career transition, enabling students to build professional profiles, showcase certificates, and apply to opportunities published by companies.

The platform features three role-based dashboards, a REST API backend built in PHP, a MySQL relational database, and a vanilla HTML/CSS/JavaScript frontend.

This project is developed as a **final-year IT academic project** with emphasis on clean architecture, thorough documentation, and professional-quality code.

---

## Features

### 👨‍🎓 Student
| Feature | Description |
|---------|-------------|
| Authentication | Sign up, login, logout with session management |
| Profile Management | Create, edit, and view personal profile with avatar and resume |
| Certificates | Add professional certificates that generate feed activity |
| Opportunity Browsing | Browse internships, job offers, and challenges |
| Applications | Apply to opportunities and track application status |
| Notifications | Receive real-time notifications for application decisions |
| Activity Feed | View personal and platform-wide activity timeline |

### 🏢 Company / HR
| Feature | Description |
|---------|-------------|
| Authentication | Sign up, login, logout with session management |
| Company Profile | Create and edit company profile with logo and details |
| Post Management | Create internship, job, and challenge posts |
| Application Review | View, accept, or reject student applications |
| Notifications | Receive alerts for new applications |

### 🛡️ Admin
| Feature | Description |
|---------|-------------|
| Authentication | Login, logout (no public registration) |
| User Management | View all users, ban/unban accounts |
| Content Moderation | View and manage all posts |
| Analytics Dashboard | Platform statistics and usage metrics |
| System Logs | Track admin actions and platform events |

---

## Tech Stack

| Layer | Technology | Purpose |
|-------|-----------|---------|
| Frontend | HTML5, CSS3, JavaScript (ES6+) | User interface and client-side logic |
| Backend | PHP 8.x | RESTful API server |
| Database | MySQL 8.x | Relational data storage |
| Server | Apache (XAMPP/WAMP/Laragon) | Local development server |
| Version Control | Git | Source code management |

---

## Project Structure

```
SkillBridge/
├── README.md                      # Project overview (this file)
├── context.md                     # Full project context
├── memory.md                      # Long-term decisions log
├── status.md                      # Current progress tracker
│
├── docs/                          # Technical documentation
│   ├── architecture.md            # System architecture design
│   ├── database.md                # Database schema & ERD
│   ├── api.md                     # REST API endpoint reference
│   ├── frontend.md                # Frontend structure & components
│   ├── backend.md                 # Backend architecture & logic
│   ├── sitemap.md                 # Page inventory & navigation
│   └── security.md                # Authentication & security
│
├── phases/                        # Development phase plans
│   ├── phase-1-foundation.md      # Project setup & infrastructure
│   ├── phase-2-authentication.md  # Auth system implementation
│   ├── phase-3-student-features.md # Student dashboard & features
│   ├── phase-4-company-features.md # Company dashboard & features
│   ├── phase-5-admin.md           # Admin dashboard & moderation
│   └── phase-6-polish.md          # Testing, optimization & delivery
│
├── frontend/                      # Client-side application
│   ├── assets/                    # Static resources
│   │   ├── css/                   # Stylesheets
│   │   ├── js/                    # JavaScript modules
│   │   ├── images/                # Image assets
│   │   └── icons/                 # Icon assets
│   ├── pages/                     # HTML pages by role
│   │   ├── auth/                  # Login, signup, forgot password
│   │   ├── public/                # Landing, about, public profiles
│   │   ├── student/               # Student dashboard pages
│   │   ├── company/               # Company dashboard pages
│   │   └── admin/                 # Admin dashboard pages
│   ├── components/                # Reusable HTML partials
│   └── index.html                 # Entry point / landing page
│
├── backend/                       # Server-side API
│   ├── config/                    # Database connection & settings
│   ├── middleware/                 # Auth & role-checking middleware
│   ├── models/                    # Data access layer
│   ├── controllers/               # Request handling logic
│   ├── services/                  # Business logic layer
│   ├── helpers/                   # Utility functions
│   ├── routes/                    # API route definitions
│   └── index.php                  # API entry point
│
├── database/                      # Database files
│   ├── schema.sql                 # Full database creation script
│   ├── seed.sql                   # Sample data for development
│   └── migrations/                # Incremental schema changes
│
├── prompts/                       # AI assistant prompts
└── presentation/                  # Final defense materials
    ├── screenshots/               # Application screenshots
    └── report/                    # Academic report documents
```

---

## Getting Started

### Prerequisites

- **PHP** 8.0 or higher
- **MySQL** 8.0 or higher
- **Apache** web server (via XAMPP, WAMP, or Laragon)
- **Git** for version control
- A modern web browser (Chrome, Firefox, Edge)

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/SkillBridge.git
   cd SkillBridge
   ```

2. **Start your local server** (XAMPP/WAMP/Laragon)
   - Ensure Apache and MySQL services are running

3. **Create the database**
   ```bash
   mysql -u root -p < database/schema.sql
   mysql -u root -p skillbridge < database/seed.sql
   ```

4. **Configure the backend**
   - Copy `backend/config/database.example.php` to `backend/config/database.php`
   - Update database credentials

5. **Access the application**
   - Frontend: `http://localhost/SkillBridge/frontend/`
   - API: `http://localhost/SkillBridge/backend/`

---

## Database Setup

The database uses MySQL with 9 core tables. See [docs/database.md](docs/database.md) for the complete schema documentation including:
- Entity-Relationship Diagram
- Table definitions with field types
- Foreign key relationships
- Index strategy
- Normalization notes

---

## API Documentation

The backend exposes a REST API with JSON request/response format. See [docs/api.md](docs/api.md) for the complete endpoint reference covering:
- Authentication endpoints
- Profile management endpoints
- Post/opportunity endpoints
- Application workflow endpoints
- Notification endpoints
- Admin endpoints

---

## User Roles

| Role | Registration | Dashboard | Key Capabilities |
|------|-------------|-----------|-----------------|
| Student | Public signup | Student Dashboard | Profile, certificates, apply to posts |
| Company/HR | Public signup | Company Dashboard | Post opportunities, manage applications |
| Admin | Seeded account | Admin Dashboard | Moderation, analytics, system logs |

---

## Documentation

| Document | Description |
|----------|-------------|
| [context.md](context.md) | Full project context and scope |
| [memory.md](memory.md) | Stable decisions and design choices |
| [status.md](status.md) | Current progress and task tracking |
| [docs/architecture.md](docs/architecture.md) | System architecture overview |
| [docs/database.md](docs/database.md) | Database schema documentation |
| [docs/api.md](docs/api.md) | API endpoint reference |
| [docs/frontend.md](docs/frontend.md) | Frontend structure guide |
| [docs/backend.md](docs/backend.md) | Backend architecture guide |
| [docs/sitemap.md](docs/sitemap.md) | Page and navigation map |
| [docs/security.md](docs/security.md) | Security and authentication |

---

## Development Phases

| Phase | Focus | Status |
|-------|-------|--------|
| [Phase 1](phases/phase-1-foundation.md) | Project setup, database, folder structure | 🔲 Not started |
| [Phase 2](phases/phase-2-authentication.md) | Sign up, login, logout, sessions, RBAC | 🔲 Not started |
| [Phase 3](phases/phase-3-student-features.md) | Student profile, certificates, feed, applications | 🔲 Not started |
| [Phase 4](phases/phase-4-company-features.md) | Company profile, posts, application management | 🔲 Not started |
| [Phase 5](phases/phase-5-admin.md) | Admin dashboard, moderation, analytics | 🔲 Not started |
| [Phase 6](phases/phase-6-polish.md) | Testing, bug fixes, presentation prep | 🔲 Not started |

---

## License

This project is licensed under the MIT License. See [LICENSE](LICENSE) for details.
