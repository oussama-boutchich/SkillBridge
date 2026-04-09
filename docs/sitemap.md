# SkillBridge — Sitemap & Navigation

> Complete page inventory and navigation structure for all user roles.

---

## 1. Page Inventory

### 1.1 Public Pages (No Authentication Required)

| # | Page | URL Path | Purpose |
|---|------|----------|---------|
| P1 | Landing Page | `/index.html` | Project introduction, value proposition, CTA to register/login |
| P2 | About Page | `/pages/public/about.html` | Platform description, team info, contact |
| P3 | Login | `/pages/auth/login.html` | Email + password authentication |
| P4 | Register | `/pages/auth/register.html` | Account creation with role selection |
| P5 | Public Profile | `/pages/public/profile.html?id={user_id}` | View any user's public profile |

### 1.2 Student Dashboard Pages

| # | Page | URL Path | Purpose |
|---|------|----------|---------|
| S1 | Dashboard Home | `/pages/student/dashboard.html` | Overview with stats, feed preview, notifications |
| S2 | My Profile | `/pages/student/profile.html` | View own profile with certificates |
| S3 | Edit Profile | `/pages/student/edit-profile.html` | Update personal and academic info |
| S4 | Certificates | `/pages/student/certificates.html` | Manage certificates (add, view, delete) |
| S5 | Opportunities | `/pages/student/opportunities.html` | Browse and filter available posts |
| S6 | Post Detail | `/pages/student/post-detail.html?id={post_id}` | View full post details, apply |
| S7 | My Applications | `/pages/student/applications.html` | Track application statuses |
| S8 | Notifications | `/pages/student/notifications.html` | View all notifications |
| S9 | Settings | `/pages/student/settings.html` | Account settings, password change |

### 1.3 Company Dashboard Pages

| # | Page | URL Path | Purpose |
|---|------|----------|---------|
| C1 | Dashboard Home | `/pages/company/dashboard.html` | Overview with stats, recent applications |
| C2 | Company Profile | `/pages/company/profile.html` | View own company profile |
| C3 | Edit Profile | `/pages/company/edit-profile.html` | Update company information |
| C4 | Create Post | `/pages/company/create-post.html` | Publish a new opportunity |
| C5 | Edit Post | `/pages/company/edit-post.html?id={post_id}` | Modify an existing post |
| C6 | My Posts | `/pages/company/my-posts.html` | List all published posts with stats |
| C7 | Applications Inbox | `/pages/company/applications.html?post_id={id}` | Review applications for a post |
| C8 | Notifications | `/pages/company/notifications.html` | View all notifications |
| C9 | Settings | `/pages/company/settings.html` | Account settings |

### 1.4 Admin Dashboard Pages

| # | Page | URL Path | Purpose |
|---|------|----------|---------|
| A1 | Dashboard Home | `/pages/admin/dashboard.html` | Analytics overview, key metrics |
| A2 | User Management | `/pages/admin/users.html` | List, search, ban/unban users |
| A3 | Post Management | `/pages/admin/posts.html` | View, filter, delete posts |
| A4 | Analytics | `/pages/admin/analytics.html` | Detailed platform statistics |
| A5 | System Logs | `/pages/admin/logs.html` | View admin action history |
| A6 | Settings | `/pages/admin/settings.html` | Admin account settings |

---

## 2. Navigation Structure

### 2.1 Student Sidebar Navigation

```
📊  Dashboard          → /pages/student/dashboard.html
👤  My Profile         → /pages/student/profile.html
🏆  Certificates       → /pages/student/certificates.html
💼  Opportunities      → /pages/student/opportunities.html
📄  My Applications    → /pages/student/applications.html
🔔  Notifications      → /pages/student/notifications.html
⚙️  Settings           → /pages/student/settings.html
🚪  Logout             → POST /api/auth/logout
```

### 2.2 Company Sidebar Navigation

```
📊  Dashboard          → /pages/company/dashboard.html
🏢  Company Profile    → /pages/company/profile.html
📝  Create Post        → /pages/company/create-post.html
📋  My Posts           → /pages/company/my-posts.html
📥  Applications       → /pages/company/applications.html
🔔  Notifications      → /pages/company/notifications.html
⚙️  Settings           → /pages/company/settings.html
🚪  Logout             → POST /api/auth/logout
```

### 2.3 Admin Sidebar Navigation

```
📊  Dashboard          → /pages/admin/dashboard.html
👥  Users              → /pages/admin/users.html
📋  Posts              → /pages/admin/posts.html
📈  Analytics          → /pages/admin/analytics.html
📜  System Logs        → /pages/admin/logs.html
⚙️  Settings           → /pages/admin/settings.html
🚪  Logout             → POST /api/auth/logout
```

### 2.4 Header Bar (All Dashboards)

```
┌─────────────────────────────────────────────────────────────┐
│  [Logo]  SkillBridge          [Search]   🔔(3)   [Avatar ▼]│
└─────────────────────────────────────────────────────────────┘
                                              │
                                              ├── View Profile
                                              ├── Settings
                                              └── Logout
```

---

## 3. Access Control Matrix

| Page | Student | Company | Admin | Public |
|------|---------|---------|-------|--------|
| Landing Page | ✅ | ✅ | ✅ | ✅ |
| About | ✅ | ✅ | ✅ | ✅ |
| Login | ✅ | ✅ | ✅ | ✅ |
| Register | ✅ | ✅ | ❌ | ✅ |
| Public Profile | ✅ | ✅ | ✅ | ❌ |
| Student Dashboard | ✅ | ❌ | ❌ | ❌ |
| Student Profile Pages | ✅ | ❌ | ❌ | ❌ |
| Certificates | ✅ | ❌ | ❌ | ❌ |
| Opportunities | ✅ | ❌ | ❌ | ❌ |
| Post Detail | ✅ | ✅ | ✅ | ❌ |
| Student Applications | ✅ | ❌ | ❌ | ❌ |
| Company Dashboard | ❌ | ✅ | ❌ | ❌ |
| Company Profile Pages | ❌ | ✅ | ❌ | ❌ |
| Post Management | ❌ | ✅ | ❌ | ❌ |
| Application Inbox | ❌ | ✅ | ❌ | ❌ |
| Admin Dashboard | ❌ | ❌ | ✅ | ❌ |
| User Management | ❌ | ❌ | ✅ | ❌ |
| Post Moderation | ❌ | ❌ | ✅ | ❌ |
| Analytics | ❌ | ❌ | ✅ | ❌ |
| System Logs | ❌ | ❌ | ✅ | ❌ |

---

## 4. Redirect Rules

| Condition | Redirect To |
|-----------|-------------|
| Unauthenticated user visits protected page | `/pages/auth/login.html` |
| Authenticated student visits company page | `/pages/student/dashboard.html` |
| Authenticated company visits student page | `/pages/company/dashboard.html` |
| Authenticated admin visits student/company page | `/pages/admin/dashboard.html` |
| Successful login (student) | `/pages/student/dashboard.html` |
| Successful login (company) | `/pages/company/dashboard.html` |
| Successful login (admin) | `/pages/admin/dashboard.html` |
| Successful registration | `/pages/auth/login.html` with success message |
| Logout | `/pages/auth/login.html` |
| Banned user tries to login | `/pages/auth/login.html` with error message |

---

## 5. Page Priority for Implementation

| Priority | Pages | Phase |
|----------|-------|-------|
| 🔴 Critical | Login, Register, Dashboard (all 3) | Phase 1–2 |
| 🟠 High | Student Profile, Edit Profile, Certificates | Phase 3 |
| 🟠 High | Company Profile, Create Post, My Posts | Phase 4 |
| 🟡 Medium | Opportunities, Post Detail, Applications | Phase 3–4 |
| 🟡 Medium | Application Inbox, Accept/Reject | Phase 4 |
| 🟡 Medium | Admin Users, Posts, Analytics | Phase 5 |
| 🟢 Low | Settings, System Logs, About | Phase 6 |
| 🟢 Low | Landing Page polish | Phase 6 |

---

## 6. Total Page Count

| Category | Count |
|----------|-------|
| Public pages | 5 |
| Student pages | 9 |
| Company pages | 9 |
| Admin pages | 6 |
| **Total** | **29 pages** |
