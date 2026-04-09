# SkillBridge — Frontend Architecture

> UI structure, component system, design system, and implementation guidelines.

---

## 1. Technology & Principles

| Aspect | Decision |
|--------|----------|
| Languages | HTML5, CSS3, JavaScript (ES6+) |
| CSS Strategy | Custom CSS with CSS Variables (no frameworks) |
| JS Strategy | Vanilla JS with `fetch()` API |
| Architecture | Multi-Page Application (MPA) |
| Methodology | BEM naming for CSS, module pattern for JS |
| Responsive | Desktop-first, responsive down to 768px |

---

## 2. Design System

### 2.1 Color Palette

```css
:root {
    /* Primary Brand Colors */
    --color-primary: #2563EB;         /* Blue — main CTA, links */
    --color-primary-dark: #1D4ED8;    /* Darker blue — hover states */
    --color-primary-light: #DBEAFE;   /* Light blue — backgrounds */

    /* Secondary Colors */
    --color-secondary: #7C3AED;       /* Purple — accents */

    /* Semantic Colors */
    --color-success: #16A34A;         /* Green — accepted, success */
    --color-warning: #F59E0B;         /* Amber — pending, warnings */
    --color-danger: #DC2626;          /* Red — rejected, errors, ban */
    --color-info: #0EA5E9;            /* Sky blue — information */

    /* Neutral Colors */
    --color-bg: #F8FAFC;             /* Page background */
    --color-surface: #FFFFFF;         /* Card/panel background */
    --color-border: #E2E8F0;         /* Borders */
    --color-text-primary: #1E293B;   /* Main text */
    --color-text-secondary: #64748B; /* Secondary text */
    --color-text-muted: #94A3B8;     /* Muted/disabled text */
}
```

### 2.2 Typography

```css
:root {
    --font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    --font-size-xs: 0.75rem;    /* 12px — captions */
    --font-size-sm: 0.875rem;   /* 14px — secondary text */
    --font-size-base: 1rem;     /* 16px — body text */
    --font-size-lg: 1.125rem;   /* 18px — subtitles */
    --font-size-xl: 1.25rem;    /* 20px — section headings */
    --font-size-2xl: 1.5rem;    /* 24px — page headings */
    --font-size-3xl: 1.875rem;  /* 30px — dashboard titles */
}
```

### 2.3 Spacing Scale

```css
:root {
    --space-xs: 0.25rem;   /* 4px */
    --space-sm: 0.5rem;    /* 8px */
    --space-md: 1rem;      /* 16px */
    --space-lg: 1.5rem;    /* 24px */
    --space-xl: 2rem;      /* 32px */
    --space-2xl: 3rem;     /* 48px */
}
```

### 2.4 Border Radius & Shadows

```css
:root {
    --radius-sm: 4px;
    --radius-md: 8px;
    --radius-lg: 12px;
    --radius-full: 9999px;

    --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.07);
    --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.1);
}
```

---

## 3. Reusable UI Components

### 3.1 Cards

Used throughout dashboards for posts, applications, certificates, and stats.

```html
<div class="card">
    <div class="card__header">
        <h3 class="card__title">Frontend Developer Intern</h3>
        <span class="badge badge--internship">Internship</span>
    </div>
    <div class="card__body">
        <p class="card__text">Join our team for a 3-month internship...</p>
    </div>
    <div class="card__footer">
        <span class="card__meta">TechCorp Solutions</span>
        <span class="card__meta">Deadline: Jun 30, 2026</span>
    </div>
</div>
```

### 3.2 Stat Cards (Dashboard)

```html
<div class="stat-card">
    <div class="stat-card__icon stat-card__icon--primary">
        <i class="icon-users"></i>
    </div>
    <div class="stat-card__content">
        <span class="stat-card__value">150</span>
        <span class="stat-card__label">Total Users</span>
    </div>
</div>
```

### 3.3 Buttons

```html
<button class="btn btn--primary">Apply Now</button>
<button class="btn btn--secondary">View Profile</button>
<button class="btn btn--success">Accept</button>
<button class="btn btn--danger">Reject</button>
<button class="btn btn--outline">Cancel</button>
```

### 3.4 Forms

```html
<div class="form-group">
    <label class="form-label" for="email">Email Address</label>
    <input class="form-input" type="email" id="email" placeholder="you@example.com" required>
    <span class="form-error" id="email-error"></span>
</div>
```

### 3.5 Badges (Status Indicators)

```html
<span class="badge badge--pending">Pending</span>
<span class="badge badge--accepted">Accepted</span>
<span class="badge badge--rejected">Rejected</span>
<span class="badge badge--internship">Internship</span>
<span class="badge badge--job">Job</span>
<span class="badge badge--challenge">Challenge</span>
```

### 3.6 Tables

```html
<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Ahmed Benali</td>
                <td><span class="badge badge--student">Student</span></td>
                <td><span class="badge badge--active">Active</span></td>
                <td>
                    <button class="btn btn--sm btn--danger">Ban</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
```

### 3.7 Notification Items

```html
<div class="notification-item notification-item--unread">
    <div class="notification-item__icon notification-item__icon--success">
        ✓
    </div>
    <div class="notification-item__content">
        <p class="notification-item__title">Application Accepted</p>
        <p class="notification-item__message">Your application for "Frontend Developer Intern" has been accepted.</p>
        <span class="notification-item__time">2 hours ago</span>
    </div>
</div>
```

### 3.8 Empty States

```html
<div class="empty-state">
    <div class="empty-state__icon">📭</div>
    <h3 class="empty-state__title">No Applications Yet</h3>
    <p class="empty-state__text">You haven't applied to any opportunities yet. Browse available posts to get started.</p>
    <a href="opportunities.html" class="btn btn--primary">Browse Opportunities</a>
</div>
```

---

## 4. Dashboard Layout

### 4.1 HTML Structure

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — SkillBridge</title>
    <link rel="stylesheet" href="/assets/css/variables.css">
    <link rel="stylesheet" href="/assets/css/base.css">
    <link rel="stylesheet" href="/assets/css/layout.css">
    <link rel="stylesheet" href="/assets/css/components.css">
</head>
<body class="dashboard">
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar__brand">
            <img src="/assets/images/logo.svg" alt="SkillBridge">
            <span>SkillBridge</span>
        </div>
        <nav class="sidebar__nav">
            <a href="dashboard.html" class="sidebar__link sidebar__link--active">
                <span class="sidebar__icon">📊</span>
                <span class="sidebar__text">Dashboard</span>
            </a>
            <!-- More links... -->
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main">
        <!-- Header -->
        <header class="header">
            <button class="header__toggle" id="sidebar-toggle">☰</button>
            <div class="header__search">
                <input type="search" placeholder="Search...">
            </div>
            <div class="header__actions">
                <button class="header__notification" id="notification-bell">
                    🔔 <span class="header__badge" id="notification-count">3</span>
                </button>
                <div class="header__avatar">
                    <img src="/uploads/avatars/default.jpg" alt="User">
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="content">
            <div class="content__header">
                <h1 class="content__title">Dashboard</h1>
            </div>
            <div class="content__body">
                <!-- Page-specific content here -->
            </div>
        </main>
    </div>

    <script src="/assets/js/api.js"></script>
    <script src="/assets/js/auth.js"></script>
</body>
</html>
```

### 4.2 Layout CSS Structure

```css
.dashboard {
    display: flex;
    min-height: 100vh;
}

.sidebar {
    width: 260px;
    background: var(--color-surface);
    border-right: 1px solid var(--color-border);
    position: fixed;
    height: 100vh;
    overflow-y: auto;
}

.main {
    flex: 1;
    margin-left: 260px;
}

.header {
    height: 64px;
    background: var(--color-surface);
    border-bottom: 1px solid var(--color-border);
    display: flex;
    align-items: center;
    padding: 0 var(--space-lg);
    position: sticky;
    top: 0;
    z-index: 100;
}

.content {
    padding: var(--space-lg);
}
```

---

## 5. JavaScript Architecture

### 5.1 API Client (`api.js`)

Centralized HTTP client wrapping `fetch()`:

```javascript
const API_BASE = '/api';

async function apiRequest(endpoint, options = {}) {
    const url = `${API_BASE}${endpoint}`;
    const config = {
        headers: { 'Content-Type': 'application/json' },
        credentials: 'include',  // Send session cookie
        ...options,
    };

    const response = await fetch(url, config);
    const data = await response.json();

    if (!response.ok) {
        throw new Error(data.error || 'Request failed');
    }

    return data;
}

// Convenience methods
const api = {
    get: (endpoint) => apiRequest(endpoint),
    post: (endpoint, body) => apiRequest(endpoint, {
        method: 'POST', body: JSON.stringify(body)
    }),
    put: (endpoint, body) => apiRequest(endpoint, {
        method: 'PUT', body: JSON.stringify(body)
    }),
    patch: (endpoint, body) => apiRequest(endpoint, {
        method: 'PATCH', body: JSON.stringify(body)
    }),
    delete: (endpoint) => apiRequest(endpoint, { method: 'DELETE' }),
};
```

### 5.2 Auth State (`auth.js`)

```javascript
const auth = {
    async check() {
        try {
            const response = await api.get('/auth/me');
            sessionStorage.setItem('user', JSON.stringify(response.data));
            return response.data;
        } catch {
            sessionStorage.removeItem('user');
            window.location.href = '/pages/auth/login.html';
        }
    },

    getUser() {
        const user = sessionStorage.getItem('user');
        return user ? JSON.parse(user) : null;
    },

    requireRole(role) {
        const user = this.getUser();
        if (!user || user.role !== role) {
            window.location.href = `/pages/${user?.role || 'auth'}/dashboard.html`;
        }
    }
};
```

---

## 6. Responsive Breakpoints

```css
/* Tablet */
@media (max-width: 1024px) {
    .sidebar { width: 80px; }
    .sidebar__text { display: none; }
    .main { margin-left: 80px; }
}

/* Mobile */
@media (max-width: 768px) {
    .sidebar { transform: translateX(-100%); position: fixed; }
    .sidebar.open { transform: translateX(0); }
    .main { margin-left: 0; }
}
```

---

## 7. Page-Specific Content Guide

| Page | Primary Components | Data Source |
|------|-------------------|-------------|
| Student Dashboard | Stat cards, Feed list, Post cards | `/api/feed`, `/api/posts` |
| Certificates | Certificate cards, Add form | `/api/certificates` |
| Opportunities | Post cards, Filter bar, Pagination | `/api/posts` |
| Post Detail | Post card (full), Apply form | `/api/posts/{id}` |
| My Applications | Application cards with status badges | `/api/applications/my` |
| Company Dashboard | Stat cards, Recent applications | `/api/posts/my` |
| My Posts | Post cards with application counts | `/api/posts/my` |
| Application Inbox | Applicant cards, Accept/Reject buttons | `/api/applications/post/{id}` |
| Admin Dashboard | Stat cards, Charts | `/api/admin/analytics` |
| User Management | Users table, Ban/Unban buttons | `/api/admin/users` |
| System Logs | Log entries table | `/api/admin/logs` |
