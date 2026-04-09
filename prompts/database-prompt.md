# Database Prompt

Design the full **MySQL database architecture** for the SkillBridge project.

## Context
SkillBridge is a student-professional networking platform with 3 roles:
- student
- company owner / HR
- admin

Main modules:
- authentication
- student profiles
- company profiles
- certificates
- posts
- applications
- notifications
- feed activities
- admin logs

## Your Tasks
Generate:
1. The full database table list
2. Each table with fields and data types
3. Primary keys and foreign keys
4. Relationship explanations
5. Suggested indexes
6. Enum values where relevant
7. SQL schema draft in MySQL style
8. Notes about normalization and design choices

## Functional Rules
- Students can add certificates
- Certificate additions should create feed entries
- Companies can create internship, job, and challenge posts
- Students can apply to posts
- Companies can accept or decline applications
- Students receive notifications based on decisions
- Admin actions should be logged

## Output Format
- Start with a conceptual overview
- Then provide a table-by-table breakdown
- Then provide relationship explanations
- Then provide a draft MySQL schema
- Then list recommendations and risks
