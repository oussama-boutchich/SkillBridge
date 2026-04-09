# Phase 4 — Company Features

> Build the complete company experience: profile management, post creation, application review, and decision workflow.

---

## Goals

1. Implement company profile creation, viewing, and editing
2. Build the post/opportunity creation and management system
3. Implement the application review and accept/reject workflow
4. Build notification handling for companies
5. Build all company dashboard frontend pages

---

## Tasks

### 4.1 Backend — Company Profile
- [ ] Create `models/CompanyProfileModel.php`:
  - `getByUserId(int $userId): ?array`
  - `update(int $userId, array $data): void`
- [ ] Create `controllers/CompanyProfileController.php`:
  - `show($userId)` — return company profile with active post count
  - `update()` — update current company's profile
- [ ] Validate: company_name required, website URL format, company_size enum
- [ ] Register routes:
  - `GET /api/profiles/company/{id}` (auth)
  - `PUT /api/profiles/company` (company only)

### 4.2 Backend — Post Management
- [ ] Add to `models/PostModel.php`:
  - `getByCompanyId(int $companyId): array`
  - `create(array $data): int`
  - `update(int $id, array $data): void`
  - `delete(int $id): void`
  - `isOwnedBy(int $postId, int $userId): bool`
- [ ] Create `services/PostService.php`:
  - `createPost()` — validate, create post, log feed activity
  - `updatePost()` — verify ownership, update
  - `deletePost()` — verify ownership, delete (cascade removes applications)
- [ ] Add to `controllers/PostController.php`:
  - `myPosts()` — list company's posts with application counts
  - `store()` — create new post
  - `update($id)` — update own post
  - `destroy($id)` — delete own post
- [ ] Validate: title required, description min 50 chars, type enum, deadline future date
- [ ] Register routes:
  - `GET /api/posts/my` (company)
  - `POST /api/posts` (company)
  - `PUT /api/posts/{id}` (company)
  - `DELETE /api/posts/{id}` (company)

### 4.3 Backend — Application Review
- [ ] Add to `models/ApplicationModel.php`:
  - `getByPostId(int $postId): array` (with student details)
  - `updateStatus(int $id, string $status): void`
- [ ] Create `services/ApplicationService.php` (extend from Phase 3):
  - `getPostApplications(int $postId, int $companyId)` — verify ownership, return apps
  - `updateStatus(int $applicationId, string $status, int $companyId)` — verify ownership, update, notify student
- [ ] Add to `controllers/ApplicationController.php`:
  - `forPost($postId)` — list applications for a specific post
  - `updateStatus($id)` — accept or reject application
- [ ] Validate: status must be 'accepted' or 'rejected', can't change already-decided apps
- [ ] Register routes:
  - `GET /api/applications/post/{id}` (company)
  - `PATCH /api/applications/{id}/status` (company)

### 4.4 Side Effects — Notifications
- [ ] When company accepts application → create notification for student:
  - Title: "Application Accepted"
  - Message: "Your application for '{post.title}' has been accepted by {company_name}."
  - Type: `application_accepted`
- [ ] When company rejects application → create notification for student:
  - Title: "Application Rejected"
  - Message: "Your application for '{post.title}' was not selected by {company_name}."
  - Type: `application_rejected`
- [ ] When student applies → create notification for company:
  - Title: "New Application"
  - Message: "{student_name} applied to your post: {post.title}"
  - Type: `new_application`

### 4.5 Frontend — Company Dashboard Page
- [ ] Create `pages/company/dashboard.html`:
  - Welcome greeting with company name
  - Stat cards: active posts, total applications, pending applications, accepted
  - Recent applications preview (last 5)
  - Quick action: "Create New Post" button
- [ ] Create `assets/js/company-dashboard.js`

### 4.6 Frontend — Company Profile Pages
- [ ] Create `pages/company/profile.html`:
  - Company logo, name, industry, size
  - Description section
  - Website, location, founded year
  - Active posts count
- [ ] Create `pages/company/edit-profile.html`:
  - Form with all company fields
  - Company size dropdown
  - Save button with API call

### 4.7 Frontend — Post Management Pages
- [ ] Create `pages/company/create-post.html`:
  - Title input
  - Description textarea
  - Type selector (internship/job/challenge)
  - Requirements textarea
  - Location input
  - Remote checkbox
  - Deadline date picker
  - Submit button → `POST /api/posts`
- [ ] Create `pages/company/edit-post.html`:
  - Pre-filled form loaded from `GET /api/posts/{id}`
  - Save button → `PUT /api/posts/{id}`
  - Delete button with confirmation
- [ ] Create `pages/company/my-posts.html`:
  - Table/card list of all company posts
  - Each post shows: title, type, status, deadline, application count
  - Actions: edit, delete, view applications
  - Empty state for no posts

### 4.8 Frontend — Application Management Page
- [ ] Create `pages/company/applications.html`:
  - Filtered by post (via query param `?post_id=X`)
  - Post title header
  - List of applicant cards:
    - Student avatar, name, university
    - Cover letter (expandable)
    - Status badge
    - Accept/Reject buttons (for pending only)
  - Success feedback after accept/reject
  - Empty state for no applications
- [ ] Create `assets/js/applications-company.js`

### 4.9 Frontend — Company Notifications
- [ ] Create `pages/company/notifications.html`
  - Reuse same structure as student notifications
  - Show `new_application` type notifications
- [ ] Update notification badge component for company header

---

## Deliverables

| Deliverable | Verification |
|-------------|-------------|
| Company profile CRUD | View and edit company profile in browser |
| Post creation | Create post via form; appears in student opportunities page |
| Post editing/deletion | Edit and delete own posts |
| My posts listing | List all posts with application counts |
| Application inbox | View applications per post with student details |
| Accept/reject workflow | Click Accept → student gets notification; status updates |
| Notification integration | Company gets notified on new applications |
| 9 frontend pages | All company pages render and function correctly |

---

## Test Scenarios

| # | Scenario | Expected Result |
|---|----------|-----------------|
| 1 | Company creates post with all fields | 201, post visible to students |
| 2 | Company creates post without required fields | 400, validation error |
| 3 | Company edits own post | 200, changes reflected |
| 4 | Company edits another company's post | 403, access denied |
| 5 | Company deletes own post | 200, post and applications removed |
| 6 | Company views applications for own post | 200, list of applicants |
| 7 | Company views applications for another's post | 403, access denied |
| 8 | Company accepts application | 200, status = accepted, student notified |
| 9 | Company rejects application | 200, status = rejected, student notified |
| 10 | Student applies → company gets notification | Notification visible to company |

---

## Exit Criteria

- [ ] Company can view and edit their profile
- [ ] Company can create posts (all 3 types)
- [ ] Company can edit and delete their own posts
- [ ] Company can view all their posts with application counts
- [ ] Company can view applicant details for each post
- [ ] Company can accept or reject applications
- [ ] Application status changes trigger student notifications
- [ ] Student applications trigger company notifications
- [ ] All company dashboard pages are styled and functional

---

## Estimated Duration

**6–7 days** for the full team
