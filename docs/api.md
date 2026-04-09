# SkillBridge — REST API Reference

> Complete endpoint documentation for the SkillBridge backend API.

---

## API Conventions

| Convention | Value |
|-----------|-------|
| Base URL | `/api` |
| Content Type | `application/json` |
| Authentication | PHP sessions (`$_SESSION`) |
| Error Format | `{ "success": false, "error": "message" }` |
| Success Format | `{ "success": true, "data": { ... } }` |
| Date Format | ISO 8601 (`YYYY-MM-DD` or `YYYY-MM-DDTHH:mm:ss`) |

### HTTP Status Codes

| Code | Meaning |
|------|---------|
| 200 | Success |
| 201 | Resource created |
| 400 | Bad request (validation error) |
| 401 | Unauthorized (not logged in) |
| 403 | Forbidden (wrong role) |
| 404 | Resource not found |
| 409 | Conflict (duplicate resource) |
| 500 | Internal server error |

---

## 1. Authentication

### POST `/api/auth/register`

Register a new student or company account.

**Access**: Public

**Request Body:**
```json
{
    "email": "user@example.com",
    "password": "securePassword123",
    "full_name": "Ahmed Benali",
    "role": "student"
}
```

| Field | Type | Required | Validation |
|-------|------|----------|------------|
| email | string | ✅ | Valid email format, unique |
| password | string | ✅ | Min 8 characters |
| full_name | string | ✅ | Min 2 characters, max 150 |
| role | string | ✅ | Must be `student` or `company` |

**Success Response (201):**
```json
{
    "success": true,
    "data": {
        "user_id": 5,
        "email": "user@example.com",
        "full_name": "Ahmed Benali",
        "role": "student"
    }
}
```

**Error Response (409):**
```json
{
    "success": false,
    "error": "An account with this email already exists."
}
```

---

### POST `/api/auth/login`

Authenticate a user and create a session.

**Access**: Public

**Request Body:**
```json
{
    "email": "user@example.com",
    "password": "securePassword123"
}
```

| Field | Type | Required | Validation |
|-------|------|----------|------------|
| email | string | ✅ | Valid email format |
| password | string | ✅ | Non-empty |

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "user_id": 5,
        "email": "user@example.com",
        "full_name": "Ahmed Benali",
        "role": "student",
        "is_banned": false
    }
}
```

**Error Responses:**
- 401: `"Invalid email or password."`
- 403: `"Your account has been suspended."`

---

### POST `/api/auth/logout`

Destroy the current session.

**Access**: Authenticated

**Request Body:** None

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "message": "Logged out successfully."
    }
}
```

---

### GET `/api/auth/me`

Get the current authenticated user's information.

**Access**: Authenticated

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "user_id": 5,
        "email": "user@example.com",
        "full_name": "Ahmed Benali",
        "role": "student",
        "avatar_url": "/uploads/avatars/5.jpg"
    }
}
```

**Error Response (401):**
```json
{
    "success": false,
    "error": "Not authenticated."
}
```

---

## 2. Student Profiles

### GET `/api/profiles/student/{user_id}`

Get a student's profile by user ID.

**Access**: Authenticated (any role)

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "user_id": 5,
        "full_name": "Ahmed Benali",
        "avatar_url": "/uploads/avatars/5.jpg",
        "university": "University of Science and Technology",
        "field_of_study": "Computer Science",
        "bio": "Passionate about web development and AI.",
        "skills": "PHP, JavaScript, MySQL, Python",
        "resume_url": "https://drive.google.com/...",
        "linkedin_url": "https://linkedin.com/in/ahmed",
        "graduation_year": 2026,
        "certificates": [
            {
                "id": 1,
                "title": "Web Development Fundamentals",
                "issuer": "Coursera",
                "issue_date": "2025-12-15"
            }
        ]
    }
}
```

---

### PUT `/api/profiles/student`

Update the current student's profile.

**Access**: Authenticated (student only)

**Request Body:**
```json
{
    "university": "University of Science and Technology",
    "field_of_study": "Computer Science",
    "bio": "Passionate about web development and AI.",
    "skills": "PHP, JavaScript, MySQL, Python",
    "resume_url": "https://drive.google.com/...",
    "linkedin_url": "https://linkedin.com/in/ahmed",
    "graduation_year": 2026
}
```

| Field | Type | Required | Validation |
|-------|------|----------|------------|
| university | string | ❌ | Max 255 characters |
| field_of_study | string | ❌ | Max 255 characters |
| bio | string | ❌ | Max 2000 characters |
| skills | string | ❌ | Comma-separated, max 1000 characters |
| resume_url | string | ❌ | Valid URL format |
| linkedin_url | string | ❌ | Valid URL format |
| graduation_year | integer | ❌ | Valid year (2020–2035) |

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "message": "Profile updated successfully."
    }
}
```

---

## 3. Company Profiles

### GET `/api/profiles/company/{user_id}`

Get a company's profile by user ID.

**Access**: Authenticated (any role)

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "user_id": 3,
        "full_name": "Sarah Martin",
        "avatar_url": "/uploads/avatars/3.jpg",
        "company_name": "TechCorp Solutions",
        "industry": "Technology",
        "description": "Leading software development company.",
        "website": "https://techcorp.example.com",
        "location": "Algiers, Algeria",
        "company_size": "51-200",
        "founded_year": 2015,
        "active_posts_count": 3
    }
}
```

---

### PUT `/api/profiles/company`

Update the current company's profile.

**Access**: Authenticated (company only)

**Request Body:**
```json
{
    "company_name": "TechCorp Solutions",
    "industry": "Technology",
    "description": "Leading software development company.",
    "website": "https://techcorp.example.com",
    "location": "Algiers, Algeria",
    "company_size": "51-200",
    "founded_year": 2015
}
```

| Field | Type | Required | Validation |
|-------|------|----------|------------|
| company_name | string | ✅ | Max 255 characters |
| industry | string | ❌ | Max 255 characters |
| description | string | ❌ | Max 5000 characters |
| website | string | ❌ | Valid URL format |
| location | string | ❌ | Max 255 characters |
| company_size | string | ❌ | One of: `1-10`, `11-50`, `51-200`, `201-500`, `500+` |
| founded_year | integer | ❌ | Valid year (1900–2026) |

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "message": "Company profile updated successfully."
    }
}
```

---

## 4. Certificates

### GET `/api/certificates`

Get all certificates for the current student.

**Access**: Authenticated (student only)

**Success Response (200):**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "title": "Web Development Fundamentals",
            "issuer": "Coursera",
            "issue_date": "2025-12-15",
            "credential_url": "https://coursera.org/verify/abc123",
            "description": "Complete web development course covering HTML, CSS, and JavaScript.",
            "created_at": "2026-01-10T14:30:00"
        }
    ]
}
```

---

### POST `/api/certificates`

Add a new certificate. Automatically creates a feed activity entry.

**Access**: Authenticated (student only)

**Request Body:**
```json
{
    "title": "React Developer Certificate",
    "issuer": "Meta",
    "issue_date": "2026-03-01",
    "credential_url": "https://coursera.org/verify/xyz789",
    "description": "Advanced React development course."
}
```

| Field | Type | Required | Validation |
|-------|------|----------|------------|
| title | string | ✅ | Max 255 characters |
| issuer | string | ✅ | Max 255 characters |
| issue_date | date | ✅ | Valid date, not in future |
| credential_url | string | ❌ | Valid URL format |
| description | string | ❌ | Max 1000 characters |

**Success Response (201):**
```json
{
    "success": true,
    "data": {
        "id": 2,
        "title": "React Developer Certificate",
        "message": "Certificate added successfully."
    }
}
```

**Side Effects:**
- Creates a `feed_activities` entry with type `certificate_added`

---

### DELETE `/api/certificates/{id}`

Delete a certificate owned by the current student.

**Access**: Authenticated (student only, own certificates)

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "message": "Certificate deleted successfully."
    }
}
```

---

## 5. Posts / Opportunities

### GET `/api/posts`

List all active posts with optional filtering.

**Access**: Authenticated (any role)

**Query Parameters:**
| Parameter | Type | Description |
|-----------|------|-------------|
| type | string | Filter by `internship`, `job`, or `challenge` |
| page | integer | Page number (default: 1) |
| limit | integer | Results per page (default: 10, max: 50) |
| search | string | Search in title and description |

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "posts": [
            {
                "id": 1,
                "title": "Frontend Developer Intern",
                "type": "internship",
                "company_name": "TechCorp Solutions",
                "company_avatar": "/uploads/avatars/3.jpg",
                "location": "Algiers, Algeria",
                "is_remote": false,
                "deadline": "2026-06-30",
                "created_at": "2026-04-01T10:00:00",
                "applications_count": 12
            }
        ],
        "pagination": {
            "current_page": 1,
            "total_pages": 3,
            "total_items": 25,
            "per_page": 10
        }
    }
}
```

---

### GET `/api/posts/{id}`

Get full details of a single post.

**Access**: Authenticated (any role)

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "title": "Frontend Developer Intern",
        "description": "Join our team for a 3-month internship...",
        "type": "internship",
        "requirements": "HTML, CSS, JavaScript, Git",
        "location": "Algiers, Algeria",
        "is_remote": false,
        "deadline": "2026-06-30",
        "status": "active",
        "created_at": "2026-04-01T10:00:00",
        "company": {
            "user_id": 3,
            "company_name": "TechCorp Solutions",
            "industry": "Technology",
            "avatar_url": "/uploads/avatars/3.jpg"
        },
        "has_applied": false,
        "applications_count": 12
    }
}
```

---

### POST `/api/posts`

Create a new opportunity post.

**Access**: Authenticated (company only)

**Request Body:**
```json
{
    "title": "Backend Developer",
    "description": "We are looking for a PHP developer...",
    "type": "job",
    "requirements": "PHP, MySQL, REST APIs, Git",
    "location": "Oran, Algeria",
    "is_remote": true,
    "deadline": "2026-07-15"
}
```

| Field | Type | Required | Validation |
|-------|------|----------|------------|
| title | string | ✅ | Max 255 characters |
| description | string | ✅ | Min 50 characters, max 5000 |
| type | string | ✅ | One of: `internship`, `job`, `challenge` |
| requirements | string | ❌ | Max 2000 characters |
| location | string | ❌ | Max 255 characters |
| is_remote | boolean | ❌ | Default: false |
| deadline | date | ❌ | Must be in the future |

**Success Response (201):**
```json
{
    "success": true,
    "data": {
        "id": 5,
        "title": "Backend Developer",
        "message": "Post created successfully."
    }
}
```

**Side Effects:**
- Creates a `feed_activities` entry with type `post_created`

---

### PUT `/api/posts/{id}`

Update an existing post.

**Access**: Authenticated (company only, own posts)

**Request Body:** Same as POST, all fields optional.

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "message": "Post updated successfully."
    }
}
```

---

### DELETE `/api/posts/{id}`

Delete a post. Also deletes all associated applications.

**Access**: Authenticated (company only, own posts) or Admin

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "message": "Post deleted successfully."
    }
}
```

---

### GET `/api/posts/my`

Get all posts created by the current company user.

**Access**: Authenticated (company only)

**Success Response (200):**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "title": "Frontend Developer Intern",
            "type": "internship",
            "status": "active",
            "deadline": "2026-06-30",
            "applications_count": 12,
            "created_at": "2026-04-01T10:00:00"
        }
    ]
}
```

---

## 6. Applications

### POST `/api/applications`

Submit an application to a post.

**Access**: Authenticated (student only)

**Request Body:**
```json
{
    "post_id": 1,
    "cover_letter": "I am excited to apply for this internship..."
}
```

| Field | Type | Required | Validation |
|-------|------|----------|------------|
| post_id | integer | ✅ | Must reference an active post |
| cover_letter | string | ❌ | Max 3000 characters |

**Success Response (201):**
```json
{
    "success": true,
    "data": {
        "id": 8,
        "post_id": 1,
        "status": "pending",
        "message": "Application submitted successfully."
    }
}
```

**Error Response (409):**
```json
{
    "success": false,
    "error": "You have already applied to this post."
}
```

**Side Effects:**
- Creates a `feed_activities` entry with type `application_submitted`
- Creates a `notifications` entry for the company (type: `new_application`)

---

### GET `/api/applications/my`

Get all applications submitted by the current student.

**Access**: Authenticated (student only)

**Success Response (200):**
```json
{
    "success": true,
    "data": [
        {
            "id": 8,
            "post_id": 1,
            "post_title": "Frontend Developer Intern",
            "company_name": "TechCorp Solutions",
            "status": "pending",
            "created_at": "2026-04-05T09:30:00"
        }
    ]
}
```

---

### GET `/api/applications/post/{post_id}`

Get all applications for a specific post.

**Access**: Authenticated (company only, own posts)

**Success Response (200):**
```json
{
    "success": true,
    "data": [
        {
            "id": 8,
            "student_id": 5,
            "student_name": "Ahmed Benali",
            "student_avatar": "/uploads/avatars/5.jpg",
            "university": "University of Science and Technology",
            "cover_letter": "I am excited to apply...",
            "status": "pending",
            "created_at": "2026-04-05T09:30:00"
        }
    ]
}
```

---

### PATCH `/api/applications/{id}/status`

Accept or reject an application.

**Access**: Authenticated (company only, own post's applications)

**Request Body:**
```json
{
    "status": "accepted"
}
```

| Field | Type | Required | Validation |
|-------|------|----------|------------|
| status | string | ✅ | One of: `accepted`, `rejected` |

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "message": "Application status updated to accepted."
    }
}
```

**Side Effects:**
- Creates a `notifications` entry for the student (type: `application_accepted` or `application_rejected`)

---

## 7. Notifications

### GET `/api/notifications`

Get all notifications for the current user.

**Access**: Authenticated (any role)

**Query Parameters:**
| Parameter | Type | Description |
|-----------|------|-------------|
| unread_only | boolean | If true, return only unread notifications |
| page | integer | Page number (default: 1) |
| limit | integer | Results per page (default: 20) |

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "notifications": [
            {
                "id": 3,
                "title": "Application Accepted",
                "message": "Your application for 'Frontend Developer Intern' has been accepted by TechCorp Solutions.",
                "type": "application_accepted",
                "reference_id": 8,
                "is_read": false,
                "created_at": "2026-04-06T14:00:00"
            }
        ],
        "unread_count": 2
    }
}
```

---

### PATCH `/api/notifications/{id}/read`

Mark a notification as read.

**Access**: Authenticated (own notifications only)

**Request Body:** None

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "message": "Notification marked as read."
    }
}
```

---

### PATCH `/api/notifications/read-all`

Mark all notifications as read.

**Access**: Authenticated

**Request Body:** None

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "message": "All notifications marked as read."
    }
}
```

---

## 8. Activity Feed

### GET `/api/feed`

Get the activity feed for the current user.

**Access**: Authenticated

**Query Parameters:**
| Parameter | Type | Description |
|-----------|------|-------------|
| page | integer | Page number (default: 1) |
| limit | integer | Results per page (default: 20) |

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "activities": [
            {
                "id": 1,
                "user_id": 5,
                "user_name": "Ahmed Benali",
                "user_avatar": "/uploads/avatars/5.jpg",
                "activity_type": "certificate_added",
                "description": "Ahmed Benali added a new certificate: Web Development Fundamentals",
                "reference_id": 1,
                "created_at": "2026-01-10T14:30:00"
            }
        ],
        "pagination": {
            "current_page": 1,
            "total_pages": 1,
            "total_items": 3
        }
    }
}
```

---

## 9. Admin Endpoints

### GET `/api/admin/users`

List all users with optional filtering.

**Access**: Authenticated (admin only)

**Query Parameters:**
| Parameter | Type | Description |
|-----------|------|-------------|
| role | string | Filter by `student`, `company`, or `admin` |
| status | string | Filter by `active` or `banned` |
| search | string | Search by name or email |
| page | integer | Page number (default: 1) |

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "users": [
            {
                "id": 5,
                "email": "user@example.com",
                "full_name": "Ahmed Benali",
                "role": "student",
                "is_banned": false,
                "created_at": "2026-01-01T10:00:00"
            }
        ],
        "pagination": {
            "current_page": 1,
            "total_pages": 2,
            "total_items": 15
        }
    }
}
```

---

### PATCH `/api/admin/users/{id}/ban`

Ban a user account.

**Access**: Authenticated (admin only)

**Request Body:** None

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "message": "User banned successfully."
    }
}
```

**Side Effects:**
- Creates an `admin_logs` entry with action `ban_user`

---

### PATCH `/api/admin/users/{id}/unban`

Unban a user account.

**Access**: Authenticated (admin only)

**Request Body:** None

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "message": "User unbanned successfully."
    }
}
```

**Side Effects:**
- Creates an `admin_logs` entry with action `unban_user`

---

### GET `/api/admin/posts`

List all posts across the platform.

**Access**: Authenticated (admin only)

**Query Parameters:**
| Parameter | Type | Description |
|-----------|------|-------------|
| type | string | Filter by post type |
| status | string | Filter by `active`, `closed`, `draft` |
| page | integer | Page number |

**Success Response (200):** Same format as `GET /api/posts` with all statuses included.

---

### DELETE `/api/admin/posts/{id}`

Delete any post (moderation action).

**Access**: Authenticated (admin only)

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "message": "Post removed by admin."
    }
}
```

**Side Effects:**
- Creates an `admin_logs` entry with action `delete_post`

---

### GET `/api/admin/analytics`

Get platform-wide analytics summary.

**Access**: Authenticated (admin only)

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "total_users": 150,
        "total_students": 120,
        "total_companies": 28,
        "total_admins": 2,
        "banned_users": 3,
        "total_posts": 45,
        "active_posts": 38,
        "total_applications": 230,
        "accepted_applications": 45,
        "rejected_applications": 60,
        "pending_applications": 125,
        "acceptance_rate": 19.57,
        "recent_signups_7d": 12,
        "recent_posts_7d": 8
    }
}
```

---

### GET `/api/admin/logs`

Get admin action logs.

**Access**: Authenticated (admin only)

**Query Parameters:**
| Parameter | Type | Description |
|-----------|------|-------------|
| action | string | Filter by action type |
| page | integer | Page number |
| limit | integer | Results per page (default: 50) |

**Success Response (200):**
```json
{
    "success": true,
    "data": {
        "logs": [
            {
                "id": 1,
                "admin_name": "Platform Admin",
                "action": "ban_user",
                "target_type": "user",
                "target_id": 7,
                "description": "Banned user: spammer@example.com",
                "created_at": "2026-04-05T16:00:00"
            }
        ],
        "pagination": {
            "current_page": 1,
            "total_pages": 1,
            "total_items": 5
        }
    }
}
```

---

## 10. Endpoint Summary Table

| Method | Route | Access | Description |
|--------|-------|--------|-------------|
| POST | `/api/auth/register` | Public | Register new account |
| POST | `/api/auth/login` | Public | Log in |
| POST | `/api/auth/logout` | Auth | Log out |
| GET | `/api/auth/me` | Auth | Get current user |
| GET | `/api/profiles/student/{id}` | Auth | Get student profile |
| PUT | `/api/profiles/student` | Student | Update own profile |
| GET | `/api/profiles/company/{id}` | Auth | Get company profile |
| PUT | `/api/profiles/company` | Company | Update own profile |
| GET | `/api/certificates` | Student | List own certificates |
| POST | `/api/certificates` | Student | Add certificate |
| DELETE | `/api/certificates/{id}` | Student | Delete certificate |
| GET | `/api/posts` | Auth | List active posts |
| GET | `/api/posts/{id}` | Auth | Get post detail |
| POST | `/api/posts` | Company | Create post |
| PUT | `/api/posts/{id}` | Company | Update own post |
| DELETE | `/api/posts/{id}` | Company/Admin | Delete post |
| GET | `/api/posts/my` | Company | List own posts |
| POST | `/api/applications` | Student | Submit application |
| GET | `/api/applications/my` | Student | List own applications |
| GET | `/api/applications/post/{id}` | Company | List post applications |
| PATCH | `/api/applications/{id}/status` | Company | Accept/reject |
| GET | `/api/notifications` | Auth | List notifications |
| PATCH | `/api/notifications/{id}/read` | Auth | Mark as read |
| PATCH | `/api/notifications/read-all` | Auth | Mark all as read |
| GET | `/api/feed` | Auth | Get activity feed |
| GET | `/api/admin/users` | Admin | List all users |
| PATCH | `/api/admin/users/{id}/ban` | Admin | Ban user |
| PATCH | `/api/admin/users/{id}/unban` | Admin | Unban user |
| GET | `/api/admin/posts` | Admin | List all posts |
| DELETE | `/api/admin/posts/{id}` | Admin | Delete any post |
| GET | `/api/admin/analytics` | Admin | Platform analytics |
| GET | `/api/admin/logs` | Admin | Admin action logs |
