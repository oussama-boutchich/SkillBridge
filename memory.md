# SkillBridge — Memory

## Long-Term Project Decisions

### Product Identity
- Project name: SkillBridge
- Product type: career networking platform for students and companies
- Academic context: final-year IT project

### Core Audience
- Students
- Company owners / HR recruiters
- Admins

### Primary Goal
Build a platform similar to LinkedIn, but focused on helping students showcase skills, certificates, and profiles while connecting them with companies for internships, job opportunities, and challenges.

### Approved Tech Stack
- Frontend: HTML, CSS, JavaScript
- Backend API: PHP
- Database: MySQL

### Main Functional Scope
- Authentication
- Student profiles
- Company profiles
- Certificates
- Opportunity posts
- Applications
- Notifications
- Feed activity
- Admin moderation and analytics

### Documentation Goal
All parts of the project must be well documented, clearly structured, and presentable for academic evaluation.

## Stable Product Rules
- Students can add certificates
- Certificate additions should create feed activity entries
- Companies can create internships, job offers, and challenges
- Students can apply to those posts
- Company users can accept or decline applications
- Students must receive notifications after a decision
- Admins can ban and unban users
- Admins can access platform logs and analytics

## Notes For Future Iterations
- Keep database naming consistent with role-based design
- Maintain separation between profile data and core user authentication data
- Prefer modular API endpoints
- Ensure dashboard UX differs by role
