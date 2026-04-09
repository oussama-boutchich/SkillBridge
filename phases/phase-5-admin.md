# Phase 5 — Admin Dashboard

> Build the admin experience: user moderation, post oversight, analytics dashboard, and system logging.

---

## Goals

1. Implement admin user management (list, ban, unban)
2. Implement admin post moderation (list all, delete)
3. Build the analytics dashboard with aggregate metrics
4. Implement system logging for all admin actions
5. Build all admin dashboard frontend pages

---

## Tasks

### 5.1 Backend — Admin Service & Models
- [ ] Create `models/AdminLogModel.php`:
  - `create(int $adminId, string $action, string $targetType, ?int $targetId, ?string $description): int`
  - `getAll(int $page, int $limit, ?string $actionFilter): array`
  - `countAll(?string $actionFilter): int`
- [ ] Create `services/AdminService.php`:
  - `getUsers(int $page, int $limit, ?string $role, ?string $status, ?string $search): array`
  - `banUser(int $userId, int $adminId): void`
  - `unbanUser(int $userId, int $adminId): void`
  - `getAllPosts(int $page, int $limit, ?string $type, ?string $status): array`
  - `deletePost(int $postId, int $adminId): void`
  - `getAnalytics(): array`
  - `getLogs(int $page, int $limit, ?string $action): array`

### 5.2 Backend — User Management
- [ ] Add to `models/UserModel.php`:
  - `getAll(int $page, int $limit, ?string $role, ?string $status, ?string $search): array`
  - `countAll(?string $role, ?string $status, ?string $search): int`
  - `setBanStatus(int $id, bool $isBanned): void`
- [ ] In `AdminService::banUser()`:
  - Set `is_banned = 1` on user
  - Create admin_logs entry: action = `ban_user`, target_type = `user`
  - Create system notification for the banned user
- [ ] In `AdminService::unbanUser()`:
  - Set `is_banned = 0` on user
  - Create admin_logs entry: action = `unban_user`, target_type = `user`
- [ ] Prevent admin from banning other admins

### 5.3 Backend — Post Moderation
- [ ] In `AdminService::getAllPosts()`:
  - Return all posts (including closed/draft) with company name
  - Support filtering by type and status
- [ ] In `AdminService::deletePost()`:
  - Delete the post (cascades to applications)
  - Create admin_logs entry: action = `delete_post`, target_type = `post`
  - Create system notification for the post-owning company

### 5.4 Backend — Analytics
- [ ] In `AdminService::getAnalytics()`:
  - Query aggregate counts:
    ```sql
    -- Total users by role
    SELECT role, COUNT(*) as count FROM users GROUP BY role;
    
    -- Banned users
    SELECT COUNT(*) FROM users WHERE is_banned = 1;
    
    -- Posts by status
    SELECT status, COUNT(*) FROM posts GROUP BY status;
    
    -- Applications by status
    SELECT status, COUNT(*) FROM applications GROUP BY status;
    
    -- Recent signups (last 7 days)
    SELECT COUNT(*) FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY);
    
    -- Recent posts (last 7 days)
    SELECT COUNT(*) FROM posts WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY);
    ```
  - Calculate acceptance rate: `accepted / (accepted + rejected) * 100`
  - Return structured analytics object

### 5.5 Backend — Admin Controller
- [ ] Create `controllers/AdminController.php`:
  - `users()` — list users with filters and pagination
  - `banUser($id)` — ban a user
  - `unbanUser($id)` — unban a user
  - `posts()` — list all posts with filters
  - `deletePost($id)` — delete any post
  - `analytics()` — return analytics summary
  - `logs()` — return admin action logs
- [ ] Register all admin routes with `['auth', 'role:admin']` middleware

### 5.6 Frontend — Admin Dashboard Page
- [ ] Create `pages/admin/dashboard.html`:
  - Summary stat cards:
    - Total Users | Total Students | Total Companies
    - Total Posts | Active Posts
    - Total Applications | Acceptance Rate
    - Banned Users
  - Recent admin actions (last 5 log entries)
  - Quick links to management pages
- [ ] Create `assets/js/admin-dashboard.js`
- [ ] Create `assets/css/admin.css` for admin-specific styles

### 5.7 Frontend — User Management Page
- [ ] Create `pages/admin/users.html`:
  - Filter bar: role dropdown, status dropdown, search input
  - Users table:
    - Columns: ID, Name, Email, Role, Status, Registered Date, Actions
    - Status shown as badge: Active (green), Banned (red)
    - Action buttons: Ban (for active) / Unban (for banned)
  - Confirmation modal before ban/unban
  - Pagination controls
- [ ] Create `assets/js/admin-users.js`

### 5.8 Frontend — Post Management Page
- [ ] Create `pages/admin/posts.html`:
  - Filter bar: type dropdown, status dropdown
  - Posts table:
    - Columns: ID, Title, Type, Company, Status, Applications, Created Date, Actions
    - Type and status shown as badges
    - Action: Delete button with confirmation
  - Pagination controls
- [ ] Create `assets/js/admin-posts.js`

### 5.9 Frontend — Analytics Page
- [ ] Create `pages/admin/analytics.html`:
  - Large stat cards with detailed metrics
  - User breakdown: students vs companies (can use a simple chart or visual bar)
  - Application status breakdown
  - Post type breakdown
  - Recent activity summary (signups and posts in last 7 days)
- [ ] Create `assets/js/admin-analytics.js`
- [ ] Optional: Use a lightweight chart library or CSS-based charts

### 5.10 Frontend — System Logs Page
- [ ] Create `pages/admin/logs.html`:
  - Filter by action type dropdown
  - Log entries table:
    - Columns: ID, Admin Name, Action, Target, Description, Date
    - Action shown as badge with color coding
  - Pagination controls
  - Empty state for no logs
- [ ] Create `assets/js/admin-logs.js`

---

## Deliverables

| Deliverable | Verification |
|-------------|-------------|
| User listing with filters | Admin sees all users, can filter by role/status |
| Ban/unban workflow | Ban user → user can't login; unban → user can login again |
| Post moderation | Admin sees all posts, can delete any post |
| Analytics dashboard | All aggregate metrics display correctly |
| System logs | Admin actions are logged and displayed |
| Admin log audit trail | Every ban/unban/delete is recorded with timestamp |
| 6 frontend pages | All admin pages render and function correctly |

---

## Test Scenarios

| # | Scenario | Expected Result |
|---|----------|-----------------|
| 1 | Admin views user list | All users displayed with role/status |
| 2 | Admin filters users by role | Only matching role users shown |
| 3 | Admin bans active user | User status → banned, log entry created |
| 4 | Banned user tries to login | 403, account suspended |
| 5 | Admin unbans user | User status → active, log entry created |
| 6 | Unbanned user logs in | Success, session created |
| 7 | Admin tries to ban another admin | Error, operation denied |
| 8 | Admin views all posts | All posts shown regardless of status |
| 9 | Admin deletes a post | Post removed, applications cascade deleted, log created |
| 10 | Admin views analytics | All metric counts match database reality |
| 11 | Admin views logs | All previous admin actions listed |
| 12 | Non-admin tries to access admin routes | 403, access denied |

---

## Exit Criteria

- [ ] Admin can view all users with role and status filters
- [ ] Admin can ban and unban non-admin users
- [ ] Banned users cannot log in
- [ ] Admin can view all posts and delete any post
- [ ] Analytics page displays accurate aggregate data
- [ ] All admin actions are logged in `admin_logs`
- [ ] System logs page shows complete audit trail
- [ ] All admin dashboard pages are styled and functional
- [ ] Non-admin users cannot access any admin endpoint or page

---

## Estimated Duration

**5–6 days** for the full team
