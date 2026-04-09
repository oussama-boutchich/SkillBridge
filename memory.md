# SkillBridge — Memory

> This file records stable, long-term decisions that should persist across all development sessions. Updated only when a decision is confirmed and unlikely to change.

---

## Project Identity

| Key | Value |
|-----|-------|
| Project Name | SkillBridge |
| Product Type | Student-career networking platform |
| Academic Context | Final-year IT project |
| Team Size | 4 developers |
| Semester | 2025–2026 |

---

## Locked Technology Stack

| Layer | Technology | Version | Notes |
|-------|-----------|---------|-------|
| Frontend | HTML5, CSS3, JavaScript (ES6+) | — | No frameworks; vanilla implementation |
| Backend | PHP | 8.x | RESTful API architecture |
| Database | MySQL | 8.x | Relational schema, PDO for access |
| Server | Apache | via XAMPP/Laragon | Local development environment |

**Rationale**: This stack was chosen to align with academic curriculum requirements. It demonstrates fundamental web development skills without framework abstraction, which is valued for evaluation.

---

## Architecture Decisions

### AD-001: Separate Profile Tables
- **Decision**: Use `student_profiles` and `company_profiles` as separate tables linked to `users`
- **Rationale**: Students and companies have fundamentally different data shapes. A single profile table would have too many nullable columns. Separate tables enforce data integrity per role.
- **Date**: 2026-04-09

### AD-002: Single Users Table with Role Column
- **Decision**: All authenticated users share a single `users` table with a `role` ENUM field
- **Rationale**: Simplifies authentication — one login endpoint, one session model. The `role` field determines which dashboard and profile type to load.
- **Date**: 2026-04-09

### AD-003: PHP Sessions for Authentication
- **Decision**: Use `$_SESSION` server-side sessions, not JWT tokens
- **Rationale**: PHP sessions are simpler to implement, well-documented, and appropriate for a server-rendered MPA. JWT would add unnecessary complexity for this project scope.
- **Date**: 2026-04-09

### AD-004: Feed Activity as Separate Table
- **Decision**: Use a `feed_activities` table to log user actions instead of computing the feed from other tables
- **Rationale**: Decouples feed display from source entities. Makes the feed extensible — new activity types can be added without modifying existing tables.
- **Date**: 2026-04-09

### AD-005: Generic Notifications Table
- **Decision**: Single `notifications` table with a `type` ENUM column
- **Rationale**: Avoids creating per-type notification tables. All notifications follow the same structure (user_id, title, message, type, is_read). Type-specific rendering is handled in the frontend.
- **Date**: 2026-04-09

### AD-006: MVC-Inspired Backend Without Framework
- **Decision**: Organize backend into controllers, models, services, and middleware without using Laravel or any framework
- **Rationale**: Demonstrates understanding of MVC architecture while keeping the codebase evaluator-friendly. No external dependencies to install or configure.
- **Date**: 2026-04-09

### AD-007: One Application Per Student Per Post
- **Decision**: Enforce a unique constraint on `(student_id, post_id)` in the applications table
- **Rationale**: Prevents duplicate applications, simplifies the application workflow, and aligns with real-world job application behavior.
- **Date**: 2026-04-09

### AD-008: Admin Accounts Are Seeded
- **Decision**: Admin accounts are created directly in the database via seed scripts, not through public registration
- **Rationale**: Prevents unauthorized admin registration. In production, admin creation would be handled through a secure internal process.
- **Date**: 2026-04-09

---

## Naming Conventions

| Context | Convention | Example |
|---------|-----------|---------|
| Database tables | snake_case, plural | `student_profiles`, `feed_activities` |
| Database columns | snake_case | `user_id`, `created_at`, `is_banned` |
| API routes | kebab-case, prefixed with `/api` | `/api/auth/login`, `/api/posts` |
| PHP files | kebab-case | `auth-controller.php`, `db-config.php` |
| PHP classes | PascalCase | `UserModel`, `AuthController` |
| PHP methods | camelCase | `getById()`, `createPost()` |
| CSS classes | kebab-case (BEM) | `card__title`, `btn--primary` |
| JavaScript functions | camelCase | `fetchPosts()`, `handleSubmit()` |
| HTML pages | kebab-case | `student-dashboard.html`, `login.html` |
| Documentation files | kebab-case | `database.md`, `api.md` |

---

## Core Business Rules

1. **Registration**: Only students and companies can register publicly. Admins are seeded.
2. **Authentication**: Banned users cannot log in. Login returns user role for dashboard routing.
3. **Profiles**: Users must complete their profile before performing role-specific actions.
4. **Certificates**: Only students can add certificates. Each certificate addition creates a feed activity.
5. **Posts**: Only companies can create posts. Posts can be of type: `internship`, `job`, `challenge`.
6. **Applications**: Only students can apply to posts. One application per student per post. Applications start as `pending`.
7. **Application Decisions**: Only the post-owning company can accept/reject applications. Each decision creates a student notification.
8. **Notifications**: System-generated. Users cannot create notifications manually. Unread count shown in header.
9. **Admin Actions**: All admin moderation actions (ban, unban, post removal) are logged in `admin_logs`.
10. **Feed**: Entries are system-generated from user actions. Users cannot manually create feed entries.

---

## Scope Boundaries

### In Scope (MVP)
- User authentication (register, login, logout)
- Student and company profile CRUD
- Certificate management for students
- Post creation and browsing
- Application submission and decision workflow
- Notification system
- Activity feed
- Admin user management (ban/unban)
- Admin analytics dashboard
- Admin system logs

### Out of Scope (Future Iterations)
- Real-time messaging between users
- Email verification for registration
- Password reset via email
- File upload (PDFs, images) — use URL links instead for MVP
- Full-text search across posts
- Mobile application
- Payment integration
- Social features (likes, comments, endorsements)
- Multi-language support

---

## Risk Register

| Risk | Impact | Mitigation |
|------|--------|------------|
| Scope creep beyond MVP | High | Strict adherence to feature list above |
| Inconsistent documentation | Medium | Update docs with every phase completion |
| Database schema changes mid-development | High | Finalize schema before Phase 2 begins |
| Role permission bugs | High | Implement middleware-based RBAC early; test per role |
| Team coordination gaps | Medium | Use status.md for progress tracking; weekly sync |
