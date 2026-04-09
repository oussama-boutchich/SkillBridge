# Phase 1 — Foundation & Project Setup

> Build the project infrastructure: folder structure, database, base layout, and development environment.

---

## Goals

1. Establish the complete project folder structure for frontend, backend, and database
2. Create and populate the MySQL database with all 9 tables
3. Configure the PHP backend entry point with routing and CORS
4. Build the base HTML/CSS layout shell (sidebar + header + content area)
5. Create the CSS design system (variables, typography, base styles)
6. Verify the development environment works end-to-end

---

## Tasks

### 1.1 Development Environment Setup
- [ ] Install and configure XAMPP/WAMP/Laragon
- [ ] Verify Apache, MySQL, and PHP are running
- [ ] Create the project directory under the web server root
- [ ] Initialize Git repository with `.gitignore`

### 1.2 Project Folder Structure
- [ ] Create `frontend/` directory with subdirectories:
  - `assets/css/`, `assets/js/`, `assets/images/`, `assets/icons/`
  - `pages/auth/`, `pages/public/`, `pages/student/`, `pages/company/`, `pages/admin/`
  - `components/`
- [ ] Create `backend/` directory with subdirectories:
  - `config/`, `routes/`, `middleware/`, `controllers/`, `services/`, `models/`, `helpers/`
- [ ] Create `database/` directory with `migrations/`

### 1.3 Database Creation
- [ ] Write `database/schema.sql` with all 9 tables (from docs/database.md)
- [ ] Write `database/seed.sql` with sample data (1 admin, 2 students, 2 companies, sample posts)
- [ ] Execute schema in MySQL: `mysql -u root -p < database/schema.sql`
- [ ] Execute seed data: `mysql -u root -p skillbridge < database/seed.sql`
- [ ] Verify all tables and relationships in phpMyAdmin

### 1.4 Backend Foundation
- [ ] Create `backend/index.php` (front controller)
- [ ] Create `backend/.htaccess` (URL rewriting)
- [ ] Create `backend/config/database.php` (PDO singleton)
- [ ] Create `backend/config/cors.php` (CORS headers)
- [ ] Create `backend/config/constants.php` (roles, statuses)
- [ ] Create `backend/helpers/Response.php` (JSON response helper)
- [ ] Create `backend/helpers/Validator.php` (input validation)
- [ ] Create `backend/helpers/Sanitizer.php` (input sanitization)
- [ ] Create basic Router class in `backend/routes/api.php`
- [ ] Test: `GET /api/health` returns `{"success": true, "data": "API is running"}`

### 1.5 Frontend Foundation
- [ ] Create `frontend/assets/css/variables.css` (color palette, typography, spacing)
- [ ] Create `frontend/assets/css/base.css` (reset, global styles)
- [ ] Create `frontend/assets/css/layout.css` (sidebar, header, content grid)
- [ ] Create `frontend/assets/css/components.css` (buttons, cards, forms, badges, tables)
- [ ] Create `frontend/assets/js/api.js` (fetch wrapper)
- [ ] Create `frontend/assets/js/auth.js` (auth state management)
- [ ] Create `frontend/assets/js/utils.js` (date formatting, DOM helpers)
- [ ] Create `frontend/index.html` (landing page placeholder)
- [ ] Verify CSS design system renders correctly in browser

### 1.6 Integration Test
- [ ] Verify frontend can make a fetch request to backend API
- [ ] Verify backend can connect to MySQL and return data
- [ ] Verify the full stack works: Browser → JS → PHP → MySQL → JSON → DOM

---

## Deliverables

| Deliverable | File(s) | Verification |
|-------------|---------|-------------|
| Running MySQL database | `database/schema.sql`, `database/seed.sql` | All 9 tables visible in phpMyAdmin |
| Backend API responds | `backend/index.php`, `backend/config/` | `GET /api/health` returns 200 |
| CSS design system | `frontend/assets/css/*.css` | Visual review in browser |
| JS API client | `frontend/assets/js/api.js` | Console test with fetch |
| Folder structure complete | All directories created | Visual inspection |

---

## Exit Criteria

- [ ] All directories exist in the file system
- [ ] MySQL database `skillbridge` has all 9 tables with correct columns
- [ ] Seed data is loaded (at least 1 user of each role)
- [ ] `GET /api/health` returns a valid JSON response
- [ ] The base dashboard layout renders correctly in Chrome/Firefox
- [ ] Git repository has initial commit with all foundation files

---

## Estimated Duration

**3–4 days** for the full team
