# Phase 2 — Authentication System

> Implement complete authentication: registration, login, logout, session management, and role-based access control.

---

## Goals

1. Build the registration system for students and companies
2. Build the login system with password verification and ban checking
3. Implement session-based authentication with role storage
4. Create authentication and role middleware for route protection
5. Build the login and registration frontend pages
6. Implement client-side auth state management and redirects

---

## Tasks

### 2.1 Backend — Auth Models & Service
- [ ] Create `models/UserModel.php` with methods:
  - `getByEmail(string $email): ?array`
  - `getById(int $id): ?array`
  - `create(string $email, string $password, string $fullName, string $role): int`
  - `emailExists(string $email): bool`
- [ ] Create `services/AuthService.php` with methods:
  - `register(string $email, string $password, string $fullName, string $role): array`
  - `login(string $email, string $password): array`
  - `logout(): void`
  - `getCurrentUser(): ?array`
- [ ] Hash passwords with `password_hash($password, PASSWORD_BCRYPT)`
- [ ] Verify passwords with `password_verify()`
- [ ] Check `is_banned` status on login attempt
- [ ] Regenerate session ID after successful login: `session_regenerate_id(true)`

### 2.2 Backend — Auth Controller
- [ ] Create `controllers/AuthController.php` with methods:
  - `register()` — validate input, call service, return 201
  - `login()` — validate input, call service, set session, return 200
  - `logout()` — destroy session, return 200
  - `me()` — return current session user data, return 200
- [ ] Validate registration: email format, unique email, password min 8 chars, role in [student, company]
- [ ] Validate login: email format, password non-empty
- [ ] Return appropriate error codes (400, 401, 403, 409)

### 2.3 Backend — Profile Auto-Creation
- [ ] After student registration, auto-create empty `student_profiles` row
- [ ] After company registration, auto-create empty `company_profiles` row with company_name from full_name
- [ ] This ensures profile endpoints always have a row to update

### 2.4 Backend — Middleware
- [ ] Create `middleware/AuthMiddleware.php`:
  - Check `$_SESSION['user_id']` exists
  - Return 401 if not authenticated
- [ ] Create `middleware/RoleMiddleware.php`:
  - Check `$_SESSION['role']` matches required role
  - Return 403 if wrong role
- [ ] Wire middleware into the Router class dispatch logic

### 2.5 Backend — Route Registration
- [ ] Register routes in `routes/api.php`:
  - `POST /api/auth/register` (public)
  - `POST /api/auth/login` (public)
  - `POST /api/auth/logout` (auth required)
  - `GET /api/auth/me` (auth required)

### 2.6 Frontend — Login Page
- [ ] Create `pages/auth/login.html` with:
  - Email input field
  - Password input field
  - Login button
  - Link to registration page
  - Error message display area
- [ ] Create `assets/css/auth.css` for auth page styling
- [ ] Create `assets/js/login.js`:
  - Form submission handler
  - Call `POST /api/auth/login`
  - On success: store user in sessionStorage, redirect to role-based dashboard
  - On error: display error message

### 2.7 Frontend — Registration Page
- [ ] Create `pages/auth/register.html` with:
  - Full name input field
  - Email input field
  - Password input field
  - Confirm password field
  - Role selector (Student / Company radio buttons)
  - Register button
  - Link to login page
- [ ] Create `assets/js/register.js`:
  - Client-side validation (password match, email format)
  - Call `POST /api/auth/register`
  - On success: redirect to login with success message
  - On error: display validation errors

### 2.8 Frontend — Auth Guards
- [ ] Update `assets/js/auth.js`:
  - `auth.check()` — verify session via `GET /api/auth/me`
  - `auth.requireRole(role)` — redirect if wrong role
  - `auth.logout()` — call logout API, clear sessionStorage, redirect
- [ ] Add auth check to the beginning of every dashboard page
- [ ] Implement role-based redirect logic (student → student dashboard, etc.)

---

## Deliverables

| Deliverable | Files | Verification |
|-------------|-------|-------------|
| Registration API | AuthController, AuthService, UserModel | Register via Postman/curl, verify user in DB |
| Login API | AuthController, AuthService | Login returns user data with session cookie |
| Logout API | AuthController | Session destroyed, subsequent /me returns 401 |
| Auth Middleware | AuthMiddleware, RoleMiddleware | Protected routes return 401/403 for unauthorized users |
| Login Page | pages/auth/login.html, login.js | Visual: form renders; functional: login works |
| Register Page | pages/auth/register.html, register.js | Visual: form renders; functional: registration works |
| Role Redirects | auth.js | Student → student dashboard; company → company dashboard |

---

## Test Scenarios

| # | Scenario | Expected Result |
|---|----------|-----------------|
| 1 | Register student with valid data | 201, user created in DB, student_profiles row created |
| 2 | Register with existing email | 409, error message |
| 3 | Register with invalid email | 400, validation error |
| 4 | Register with short password | 400, validation error |
| 5 | Register as admin | 400, role not allowed |
| 6 | Login with valid credentials | 200, session created, user data returned |
| 7 | Login with wrong password | 401, error message |
| 8 | Login with non-existent email | 401, error message |
| 9 | Login when banned | 403, account suspended message |
| 10 | Access /api/auth/me when logged in | 200, user data |
| 11 | Access /api/auth/me when not logged in | 401, not authenticated |
| 12 | Access student route as company | 403, access denied |
| 13 | Logout when logged in | 200, session destroyed |

---

## Exit Criteria

- [ ] Student and company users can register through the API and frontend
- [ ] Users can log in and receive a session cookie
- [ ] Users can log out and the session is destroyed
- [ ] Auth middleware blocks unauthenticated requests with 401
- [ ] Role middleware blocks wrong-role requests with 403
- [ ] Banned users cannot log in (403)
- [ ] Frontend redirects users to their role-specific dashboard after login
- [ ] All 13 test scenarios pass

---

## Estimated Duration

**4–5 days** for the full team
