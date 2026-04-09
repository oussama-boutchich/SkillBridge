# SkillBridge — Recommended Project Structure

```text
SkillBridge/
│
├── README.md
├── context.md
├── memory.md
├── status.md
├── project-structure.md
├── documentation-index.md
│
├── phases/
│   ├── phase-01-discovery.md
│   ├── phase-02-requirements.md
│   ├── phase-03-database-design.md
│   ├── phase-04-backend-architecture.md
│   ├── phase-05-frontend-architecture.md
│   ├── phase-06-authentication.md
│   ├── phase-07-student-dashboard.md
│   ├── phase-08-company-dashboard.md
│   ├── phase-09-admin-dashboard.md
│   ├── phase-10-testing.md
│   └── phase-11-finalization.md
│
├── prompts/
│   ├── master-prompt.md
│   ├── database-prompt.md
│   ├── sitemap-prompt.md
│   ├── frontend-prompt.md
│   ├── backend-prompt.md
│   └── stitch-ui-prompt.md
│
├── docs/
│   ├── product-vision.md
│   ├── functional-requirements.md
│   ├── non-functional-requirements.md
│   ├── user-roles-and-permissions.md
│   ├── sitemap.md
│   ├── user-flows.md
│   ├── database-schema.md
│   ├── api-specification.md
│   ├── frontend-guidelines.md
│   ├── backend-guidelines.md
│   ├── ui-ux-guidelines.md
│   ├── dashboard-specifications.md
│   ├── feed-notification-logic.md
│   ├── analytics-and-admin-logic.md
│   ├── testing-plan.md
│   └── deployment-notes.md
│
├── frontend/
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   ├── images/
│   │   └── icons/
│   ├── pages/
│   │   ├── auth/
│   │   ├── student/
│   │   ├── company/
│   │   ├── admin/
│   │   └── shared/
│   ├── components/
│   └── index.html
│
├── backend/
│   ├── api/
│   │   ├── auth/
│   │   ├── users/
│   │   ├── students/
│   │   ├── companies/
│   │   ├── posts/
│   │   ├── applications/
│   │   ├── notifications/
│   │   ├── feed/
│   │   └── admin/
│   ├── config/
│   ├── middleware/
│   ├── models/
│   ├── services/
│   ├── helpers/
│   └── index.php
│
├── database/
│   ├── schema.sql
│   ├── seed.sql
│   ├── migrations/
│   └── diagrams/
│
└── presentation/
    ├── screenshots/
    ├── report/
    └── defense-notes/
```

## Structure Principles
- Keep documentation at the top level for visibility
- Separate technical prompts from implementation docs
- Organize phases in chronological order
- Separate frontend, backend, and database clearly
- Prepare a presentation folder for the final defense
