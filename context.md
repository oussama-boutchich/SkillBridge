# SkillBridge — Project Context

## Project Overview
SkillBridge is a student-career networking platform inspired by LinkedIn, designed specifically for students, company owners / HR recruiters, and administrators.

The platform connects students with companies through internships, job offers, and challenges. It allows students to build a professional profile, showcase certificates, track activities, and apply to opportunities. Company owners / HR users can manage their company presence, publish opportunities, and review applications. Administrators oversee the platform, monitor activity, and manage moderation.

This project is intended to be a final-year IT academic project, so the codebase, folder structure, documentation, and development process must be clean, professional, modular, and easy to present to a teacher or jury.

## Main User Roles

### 1. Student
Students can:
- Sign up, log in, and log out
- Create, edit, and view their own profile
- View other users' profiles
- Add certificates to their profile
- See personal feed/activity timeline
- Browse company posts/opportunities
- Apply to internships, job offers, and challenges
- Receive notifications when applications are accepted or declined

### 2. Company Owner / HR
Company owners / HR users can:
- Sign up, log in, and log out
- Create, edit, and view their company profile
- View other profiles when relevant
- Publish posts/opportunities:
  - Internship
  - Job offer
  - Challenge
- Receive and manage applications from students
- Accept or decline applications
- Trigger student notifications based on application decisions

### 3. Admin
Admins can:
- Log in and log out
- View platform statistics and analytics
- View all posts and logs
- Ban and unban users
- Monitor platform health and activity
- Access moderation data and admin logs

## Core Functional Modules

### Authentication
- User registration
- Login
- Logout
- Role-based access control
- Session/token handling

### Profiles
- Student profile management
- Company profile management
- Public profile viewing
- Profile editing
- Avatar/logo support
- Resume support for students

### Certificates
- Students can add certificates
- Certificates appear as part of student professional data
- Certificate additions should generate feed activity entries

### Posts / Opportunities
- Companies can create opportunities
- Opportunity types:
  - Internship
  - Job offer
  - Challenge
- Students can browse these opportunities in their feed and listing pages

### Applications
- Students can submit applications to opportunities
- Company users can review incoming applications
- Company users can accept or decline applications
- Application status must be tracked clearly

### Notifications
- Students receive notifications for application decisions
- Platform-generated events should be visible in notification areas

### Feed / Activity Timeline
- Student actions such as adding certificates should generate feed events
- Company posts should appear in relevant student feeds
- Feed entries should be traceable and consistent

### Admin Monitoring
- User moderation
- View logs and admin actions
- Review posts and user activity
- Dashboard analytics and system summaries

## Suggested Tech Stack

### Frontend
- HTML
- CSS
- JavaScript

### Backend API
- PHP
- REST-like API design

### Database
- MySQL

## Architectural Direction
The project should follow a clean, modular structure with clear separation between:
- frontend
- backend
- database
- documentation
- phases
- prompts

The implementation should prioritize:
- readability
- maintainability
- documentation quality
- academic presentation quality
- scalable folder organization

## Expected Deliverables
Claude should generate:
- a clean project folder structure
- all key documentation files in Markdown
- project phase documents
- memory and status tracking files
- prompts for database, sitemap, frontend, backend, and UI generation
- implementation-ready documentation that can guide development step by step

## Important Quality Rules
- Use clear English for technical documentation
- Keep documentation professional and structured
- Write files as if they will be reviewed by a teacher
- Use consistent naming conventions
- Avoid placeholder text where a useful concrete description can be written
- Prefer practical and implementable decisions over vague descriptions
- Keep all generated Markdown files well formatted and easy to navigate
