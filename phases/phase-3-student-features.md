# Phase 3 — Student Features

> Build the complete student experience: profile management, certificates, opportunity browsing, applications, notifications, and activity feed.

---

## Goals

1. Implement student profile creation, viewing, and editing
2. Implement certificate management with feed activity generation
3. Build the opportunity browsing and post detail pages
4. Implement application submission with status tracking
5. Build the notification system for students
6. Implement the activity feed display
7. Build all student dashboard frontend pages

---

## Tasks

### 3.1 Backend — Student Profile
- [ ] Create `models/StudentProfileModel.php`:
  - `getByUserId(int $userId): ?array`
  - `update(int $userId, array $data): void`
- [ ] Create `controllers/StudentProfileController.php`:
  - `show($userId)` — return student profile with certificates
  - `update()` — update current student's profile
- [ ] Validate profile fields (max lengths, URL formats, year range)
- [ ] Register routes:
  - `GET /api/profiles/student/{id}` (auth)
  - `PUT /api/profiles/student` (student only)

### 3.2 Backend — Certificates
- [ ] Create `models/CertificateModel.php`:
  - `getByUserId(int $userId): array`
  - `create(array $data): int`
  - `getById(int $id): ?array`
  - `delete(int $id): void`
- [ ] Create `services/CertificateService.php`:
  - `addCertificate()` — create certificate AND feed activity
  - `deleteCertificate()` — verify ownership, then delete
- [ ] Create `controllers/CertificateController.php`:
  - `index()` — list current student's certificates
  - `store()` — add new certificate (triggers feed entry)
  - `destroy($id)` — delete own certificate
- [ ] Register routes:
  - `GET /api/certificates` (student)
  - `POST /api/certificates` (student)
  - `DELETE /api/certificates/{id}` (student)

### 3.3 Backend — Activity Feed
- [ ] Create `models/FeedModel.php`:
  - `create(int $userId, string $type, string $description, ?int $refId): int`
  - `getByUserId(int $userId, int $page, int $limit): array`
  - `countByUserId(int $userId): int`
- [ ] Create `services/FeedService.php`:
  - `logActivity(int $userId, string $type, ?int $referenceId): void`
  - Generates human-readable description based on type
- [ ] Create `controllers/FeedController.php`:
  - `index()` — return paginated feed for current user
- [ ] Register route: `GET /api/feed` (auth)

### 3.4 Backend — Post Browsing
- [ ] Create `models/PostModel.php`:
  - `getActiveWithPagination(int $page, int $limit, ?string $type, ?string $search): array`
  - `countActive(?string $type, ?string $search): int`
  - `getById(int $id): ?array`
- [ ] Create `controllers/PostController.php`:
  - `index()` — list active posts with filtering and pagination
  - `show($id)` — get single post with company details and `has_applied` flag
- [ ] Register routes:
  - `GET /api/posts` (auth)
  - `GET /api/posts/{id}` (auth)

### 3.5 Backend — Applications
- [ ] Create `models/ApplicationModel.php`:
  - `create(int $studentId, int $postId, ?string $coverLetter): int`
  - `exists(int $studentId, int $postId): bool`
  - `getByStudentId(int $studentId): array`
  - `getById(int $id): ?array`
- [ ] Create `services/ApplicationService.php`:
  - `submitApplication()` — check duplicate, create application, log feed, notify company
- [ ] Create `controllers/ApplicationController.php`:
  - `store()` — submit application
  - `myApps()` — list student's applications with post details
- [ ] Register routes:
  - `POST /api/applications` (student)
  - `GET /api/applications/my` (student)

### 3.6 Backend — Notifications
- [ ] Create `models/NotificationModel.php`:
  - `getByUserId(int $userId, bool $unreadOnly, int $page, int $limit): array`
  - `countUnread(int $userId): int`
  - `create(int $userId, string $title, string $message, string $type, ?int $refId): int`
  - `markAsRead(int $id): void`
  - `markAllAsRead(int $userId): void`
- [ ] Create `controllers/NotificationController.php`:
  - `index()` — list notifications with unread count
  - `markRead($id)` — mark single notification as read
  - `markAllRead()` — mark all as read
- [ ] Register routes:
  - `GET /api/notifications` (auth)
  - `PATCH /api/notifications/{id}/read` (auth)
  - `PATCH /api/notifications/read-all` (auth)

### 3.7 Frontend — Student Dashboard Page
- [ ] Create `pages/student/dashboard.html`:
  - Welcome greeting with user name
  - 3–4 stat cards (certificates count, applications count, pending count, notifications count)
  - Recent feed activity (last 5 entries)
  - Recent/recommended posts (3 cards)
  - Quick links to key pages
- [ ] Create `assets/js/student-dashboard.js`

### 3.8 Frontend — Student Profile Pages
- [ ] Create `pages/student/profile.html`:
  - Avatar, name, university, field of study
  - Bio section
  - Skills tags
  - Resume and LinkedIn links
  - Certificates list
- [ ] Create `pages/student/edit-profile.html`:
  - Form with all profile fields
  - Save button with API call to `PUT /api/profiles/student`
  - Success/error feedback

### 3.9 Frontend — Certificates Page
- [ ] Create `pages/student/certificates.html`:
  - List of certificate cards (title, issuer, date, credential link)
  - "Add Certificate" button/form
  - Delete button per certificate
  - Empty state when no certificates
- [ ] Create `assets/js/certificates.js`

### 3.10 Frontend — Opportunities & Post Detail
- [ ] Create `pages/student/opportunities.html`:
  - Post cards in a grid/list layout
  - Filter bar (type: all/internship/job/challenge)
  - Search input
  - Pagination controls
- [ ] Create `pages/student/post-detail.html`:
  - Full post information
  - Company card (name, logo, industry)
  - Requirements section
  - "Apply" button or "Already Applied" badge
  - Cover letter textarea (shown when applying)
- [ ] Create `assets/js/opportunities.js`

### 3.11 Frontend — Applications Page
- [ ] Create `pages/student/applications.html`:
  - List of application cards
  - Each card shows: post title, company name, status badge, date
  - Status badges: pending (amber), accepted (green), rejected (red)
  - Empty state
- [ ] Create `assets/js/applications.js`

### 3.12 Frontend — Notifications Page
- [ ] Create `pages/student/notifications.html`:
  - List of notification items
  - Unread items visually distinguished
  - "Mark All Read" button
  - Click to mark individual as read
  - Empty state
- [ ] Create `assets/js/notifications.js`
- [ ] Add notification badge to dashboard header (shows unread count)

---

## Deliverables

| Deliverable | Verification |
|-------------|-------------|
| Student profile CRUD | Profile view/edit works in browser |
| Certificate management | Add/view/delete certificates; feed entry created |
| Post browsing | Posts display with filter and pagination |
| Application submission | Apply to post; duplicate prevented |
| Application tracking | All applications with status visible |
| Notifications | Notifications appear after application decisions |
| Activity feed | Feed shows certificate and application activities |
| 8 frontend pages | All pages render correctly and are functional |

---

## Exit Criteria

- [ ] Student can view and edit their profile
- [ ] Student can add, view, and delete certificates
- [ ] Adding a certificate creates a feed activity
- [ ] Student can browse posts with filtering by type
- [ ] Student can view post details and apply
- [ ] Duplicate applications are blocked (409)
- [ ] Student can see all their applications with statuses
- [ ] Student receives notifications (tested via DB insert or company action)
- [ ] Activity feed displays recent activities with pagination
- [ ] All student dashboard pages are styled and functional

---

## Estimated Duration

**7–8 days** for the full team
