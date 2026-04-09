# SkillBridge -- Stitch UI Design Prompts

> Comprehensive prompts for [stitch.withgoogle.com](https://stitch.withgoogle.com) to generate the full SkillBridge frontend.
>
> **How to use this file:** Copy each prompt one at a time into Stitch. Always paste Prompt 0 as a prefix before each screen prompt for consistency. Work through them in the recommended order at the bottom.

---

## PROMPT 0 -- Global Context (Paste this before every prompt)

```
You are designing "SkillBridge" -- a professional student-career networking platform (like LinkedIn but for students).

The platform has 3 user roles:
1. Students -- build profiles, add certificates, browse and apply to opportunities
2. Companies/HR -- post internships/jobs/challenges, review and accept/reject applications
3. Admins -- moderate users, view analytics, manage system logs

Design direction: Modern, clean, professional SaaS dashboard aesthetic. Think Linear, Notion, or modern LinkedIn. Use a blue-primary color system (#2563EB primary, #1D4ED8 hover, #DBEAFE light), with semantic colors -- green (#16A34A) for accepted/success, amber (#F59E0B) for pending/warnings, red (#DC2626) for rejected/errors/ban. Font: Inter. Background: #F8FAFC. Cards: white (#FFFFFF) with subtle shadows and #E2E8F0 borders. Rounded corners (8px). All dashboards use a fixed left sidebar (260px) + sticky top header (64px) + scrollable main content layout.
```

---

## PROMPT 1 -- Landing Page

```
Design a landing page for "SkillBridge" -- a student-career networking platform.

Layout (top to bottom):
1. NAVBAR: Logo "SkillBridge" (left), nav links "Home | About | Features" (center), "Login" text button and "Sign Up" filled blue button (right). White background, subtle bottom border.

2. HERO SECTION: Split layout. Left side: large heading "Bridge the Gap Between Education and Career", subtext "Build your professional profile, showcase certificates, and connect with companies offering internships, jobs, and challenges -- all in one platform designed for students.", two buttons -- "Get Started" (blue filled) and "Learn More" (outline). Right side: illustration or abstract mockup showing a dashboard preview.

3. FEATURES SECTION: Section title "Why SkillBridge?" centered. 3 feature cards in a row:
   - Card 1: icon (graduation cap), title "For Students", text "Build your professional profile, add certificates, browse opportunities, and track your applications."
   - Card 2: icon (building), title "For Companies", text "Post internships, jobs, and challenges. Review student applications and find the perfect candidates."
   - Card 3: icon (shield), title "Trusted Platform", text "Secure authentication, role-based access, and admin moderation keep the platform professional."

4. HOW IT WORKS: Section title "How It Works" centered. 3 steps in a horizontal timeline:
   - Step 1: "Create Your Account" -- "Sign up as a student or company in seconds."
   - Step 2: "Build Your Presence" -- "Complete your profile, add certificates, or post opportunities."
   - Step 3: "Connect and Grow" -- "Apply to opportunities or review candidates and make decisions."

5. CTA SECTION: Blue gradient background. Centered text "Ready to Start Your Journey?", subtext "Join SkillBridge today and take the first step toward your career.", "Sign Up Free" white button.

6. FOOTER: Dark background (#1E293B). Logo, quick links (About, Features, Contact), copyright text. Clean 3-column layout.

Style: Modern, professional, clean. White background. Blue (#2563EB) primary. Inter font. Subtle animations feel. Inspired by Stripe, Linear, or Vercel landing pages.
```

---

## PROMPT 2 -- Login Page

```
Design a login page for "SkillBridge" -- a student-career networking platform.

Layout: Centered card on a light gray background (#F8FAFC).

The login card (max-width 420px, white background, rounded-lg, subtle shadow):
1. Top: SkillBridge logo + "SkillBridge" text centered
2. Heading: "Welcome back" (large, bold), subtext "Sign in to your account" (gray)
3. Form fields:
   - "Email Address" label + text input with placeholder "you@example.com"
   - "Password" label + password input with placeholder (dots)
   - A "Show password" eye icon toggle inside the password field
4. Below fields: "Forgot password?" right-aligned link (small, blue)
5. Button: "Sign In" full-width, blue (#2563EB) filled, rounded, bold text
6. Divider: "or" with horizontal lines on each side
7. Bottom text: "Don't have an account?" + "Sign up" blue link
8. Error alert area (hidden by default): Red background (#FEE2E2) with red text showing "Invalid email or password" -- show this as a design variant

Also show a BANNED USER variant: Same form but with a red alert box at the top showing a shield icon and "Your account has been suspended. Contact support for assistance."

Style: Clean, centered, minimal. Soft shadow on card. Inter font. Consistent with SkillBridge blue brand.
```

---

## PROMPT 3 -- Registration Page

```
Design a registration page for "SkillBridge".

Layout: Centered card (max-width 480px) on light gray background (#F8FAFC).

The registration card (white, rounded-lg, shadow):
1. Top: SkillBridge logo + "SkillBridge" text centered
2. Heading: "Create your account" (large, bold), subtext "Join SkillBridge and start your journey" (gray)
3. ROLE SELECTOR (important): Two large selectable cards side by side:
   - Left card: Graduation cap icon, "Student", subtext "Build your profile and find opportunities" -- has a blue border and check icon when selected
   - Right card: Building icon, "Company / HR", subtext "Post opportunities and find candidates"
   One must be selected before registering. Use toggle/radio card style.
4. Form fields:
   - "Full Name" -- text input, placeholder "Ahmed Benali"
   - "Email Address" -- email input, placeholder "you@example.com"
   - "Password" -- password input, placeholder "Min. 8 characters"
   - "Confirm Password" -- password input, placeholder "Re-enter your password"
5. Terms checkbox: "I agree to the Terms of Service and Privacy Policy" (links in blue)
6. Button: "Create Account" full-width, blue filled
7. Bottom text: "Already have an account?" + "Sign in" blue link
8. Validation error state variant: Show inline red error messages below fields -- e.g., "Password must be at least 8 characters", "Email is already registered"

Style: Clean, minimal, same design language as the login page. The role selector cards should feel interactive and clearly indicate which role is selected.
```

---

## PROMPT 4 -- Student Dashboard (Main Overview)

```
Design the student dashboard home page for "SkillBridge".

Layout: Dashboard shell with fixed left sidebar (260px wide, white, full height) + sticky top header (64px, white, bottom border) + scrollable main content (#F8FAFC background).

LEFT SIDEBAR:
- Top: SkillBridge logo + "SkillBridge" text (blue)
- Navigation links (vertical, with icons):
  - Dashboard (active -- blue background, blue text) with chart icon
  - My Profile with user icon
  - Certificates with award icon
  - Opportunities with briefcase icon
  - My Applications with document icon
  - Notifications with bell icon
  - Settings with gear icon
- Bottom: User avatar (small circle) + name "Ahmed Benali" + "Student" badge, logout icon

TOP HEADER:
- Left: Hamburger menu icon (for mobile), breadcrumb "Dashboard"
- Center/Right: Search bar input
- Right: Notification bell icon with red badge showing "3", user avatar circle (32px)
- Avatar click shows dropdown: "View Profile", "Settings", "Logout"

MAIN CONTENT -- "Welcome back, Ahmed" heading:

Row 1: 4 STAT CARDS in a grid:
- Card 1: Blue icon, "5" large number, "Certificates" label
- Card 2: Green icon, "3" large number, "Applications" label
- Card 3: Amber icon, "2" large number, "Pending" label
- Card 4: Red icon, "1" large number, "Unread Notifications" label
Each card: white background, rounded-md, subtle shadow, colored left border (4px)

Row 2: Two columns (2/3 + 1/3):
LEFT COLUMN -- "Recent Activity" section:
- Feed list with 4 items, each showing:
  - User avatar (small), activity text "You added a new certificate: Web Development Fundamentals", timestamp "2 hours ago"
  - Different activity types: certificate_added, application_submitted
  - Each item separated by a light divider

RIGHT COLUMN -- "Recommended Opportunities" section:
- 3 compact post cards stacked:
  - Each card: Post title "Frontend Developer Intern", company name "TechCorp", badge "Internship" (blue), location "Algiers", deadline "Jun 30"
  - "View Details" link at bottom of each card
- "Browse All Opportunities" link below

Style: Clean dashboard. Cards with white background on #F8FAFC page. Blue accent color. Inter font. Subtle shadows. Spacious but information-dense.
```

---

## PROMPT 5 -- Student Profile Page

```
Design the student profile view page for "SkillBridge".

Use the same sidebar + header layout from the student dashboard.

MAIN CONTENT:

SECTION 1 -- Profile Header:
- Large cover area (subtle blue gradient, 200px tall)
- Profile avatar overlapping the cover bottom (96px circle, white border)
- Next to avatar: Name "Ahmed Benali" (h1), university "University of Science and Technology" (gray), field "Computer Science"
- Right side: "Edit Profile" button (outline, blue)
- Below name: Short bio "Passionate about web development and AI. Looking for internship opportunities in full-stack development."
- Tags row: Skill badges -- "PHP", "JavaScript", "MySQL", "Python" -- each as a small rounded pill with light blue background

SECTION 2 -- Info Cards Row (2 columns):
LEFT: "Academic Info" card:
  - University: University of Science and Technology
  - Field: Computer Science
  - Graduation: 2026
  - Resume: "View Resume" link
  - LinkedIn: "View LinkedIn" link

RIGHT: "Statistics" card:
  - Certificates: 5
  - Applications: 3
  - Accepted: 1
  - Member since: Jan 2026

SECTION 3 -- Certificates:
- Section title "Certificates" with count badge "(5)"
- Grid of certificate cards (2 per row):
  - Each card: Certificate icon, title "Web Development Fundamentals", issuer "Coursera", date "Dec 15, 2025", "View Credential" link
  - Clean white cards with subtle border

SECTION 4 -- Recent Activity:
- Last 5 feed activities listed vertically
- Each: icon, description, timestamp

Style: Profile page feeling like a professional resume. Clean, spacious. The cover gradient + avatar overlap gives it a LinkedIn-like premium feel.
```

---

## PROMPT 6 -- Student Edit Profile Page

```
Design the student edit profile form page for "SkillBridge".

Use the same sidebar + header layout. Active sidebar item: "My Profile".

MAIN CONTENT:

Page heading: "Edit Profile" with a "Back to Profile" link.

Form inside a white card (rounded, shadow):

SECTION 1 -- "Personal Information":
- Avatar upload: Current avatar preview (circle) + "Change Photo" button
- Full Name: text input (pre-filled "Ahmed Benali")
- Bio: textarea (pre-filled, max 2000 chars, char counter shown)

SECTION 2 -- "Academic Information":
- University: text input
- Field of Study: text input
- Graduation Year: number input or year dropdown (2020-2035)

SECTION 3 -- "Skills":
- Skills input: text input with tag-like chips showing current skills "PHP", "JavaScript", "MySQL" -- each chip has an x to remove. Type to add new skill.

SECTION 4 -- "Links":
- Resume URL: text input with link icon
- LinkedIn URL: text input with LinkedIn icon

SECTION 5 -- Footer:
- "Cancel" button (gray outline) and "Save Changes" button (blue filled)
- Success toast/notification: Green bar at top "Profile updated successfully"

Style: Clean form layout. Labels above inputs. Consistent spacing. Grouped in logical sections. Feels like a settings page.
```

---

## PROMPT 7 -- Certificates Management Page

```
Design the certificates management page for "SkillBridge" student dashboard.

Use the same sidebar + header layout. Active sidebar item: "Certificates".

MAIN CONTENT:

Page header: "My Certificates" (h1) with count "(5)" badge, and "Add Certificate" blue button on the right.

CERTIFICATE CARDS GRID (2 columns):
Each certificate card (white, rounded, subtle shadow):
- Top: Certificate/award icon in blue circle
- Title: "Web Development Fundamentals" (bold)
- Issuer: "Coursera" (gray)
- Date: "December 15, 2025" (small gray)
- Description: "Complete web development course covering HTML, CSS, and JavaScript." (if exists)
- Bottom actions: "View Credential" link (blue) | "Delete" link (red, small)
- Hover effect: subtle border color change

Show 5 certificate cards with varied titles:
1. "Web Development Fundamentals" -- Coursera
2. "Python for Data Science" -- IBM / edX
3. "Responsive Web Design" -- freeCodeCamp
4. "Database Management Systems" -- University Certificate
5. "Git and GitHub Mastery" -- Udemy

ADD CERTIFICATE MODAL (show as overlay):
- Modal title: "Add New Certificate"
- Fields:
  - Title* -- text input
  - Issuing Organization* -- text input
  - Issue Date* -- date picker
  - Credential URL -- URL input (optional)
  - Description -- textarea (optional)
- Footer: "Cancel" (gray) + "Add Certificate" (blue) buttons
- * indicates required fields

Also show: EMPTY STATE variant -- When no certificates exist: Illustration or icon, "No Certificates Yet", subtext "Add your first professional certificate to showcase your skills.", "Add Certificate" blue button.

Style: Card grid with clean visual hierarchy. The modal should have a dark overlay backdrop. Consistent with the dashboard design system.
```

---

## PROMPT 8 -- Opportunities Listing Page

```
Design the opportunities browsing page for "SkillBridge" student dashboard.

Use the same sidebar + header layout. Active sidebar item: "Opportunities".

MAIN CONTENT:

Page header: "Opportunities" (h1), subtext "Browse internships, jobs, and challenges from top companies"

FILTER BAR (white card, horizontal):
- Search input (left): "Search opportunities..." with search icon
- Type filter dropdown: "All Types" | "Internship" | "Job" | "Challenge"
- Sort dropdown: "Newest First" | "Deadline Soon"
- Results count: "Showing 25 opportunities"

POST CARDS LIST (vertical stack, one card per row, full width):
Each card (white, rounded, shadow, horizontal layout):
- LEFT: Company logo/avatar (48px circle)
- MIDDLE:
  - Row 1: Post title "Frontend Developer Intern" (bold, linked) + Type badge "Internship" (blue pill) or "Job" (green pill) or "Challenge" (purple pill)
  - Row 2: Company name "TechCorp Solutions" - Location "Algiers, Algeria" - optional "Remote" tag
  - Row 3: Short description preview (2 lines max, gray text, truncated with ...)
- RIGHT:
  - Deadline: "Jun 30, 2026" with calendar icon
  - "12 applicants" with people icon (small gray)
  - "View Details" blue link

Show 6 varied post cards:
1. "Frontend Developer Intern" -- TechCorp Solutions -- Internship -- Algiers
2. "Data Analyst" -- DataFlow Inc -- Job -- Remote
3. "Mobile App Challenge" -- StartupHub -- Challenge -- Open
4. "Backend Developer" -- CloudBase -- Job -- Oran
5. "Marketing Intern" -- AlgerBrand -- Internship -- Algiers
6. "AI Hackathon 2026" -- TechUnion -- Challenge -- Online

PAGINATION (bottom center):
- "Previous" | Page numbers "1  2  3" | "Next"
- Current page highlighted in blue

Style: Clean list view. Each card is scannable at a glance. Badges use distinct colors per type: Internship=blue, Job=green, Challenge=purple. The filter bar is sticky below the header. LinkedIn job listings feel.
```

---

## PROMPT 9 -- Post Detail Page (Student View)

```
Design the opportunity detail page for "SkillBridge" student dashboard.

Use the same sidebar + header layout. Active sidebar item: "Opportunities".

MAIN CONTENT:

Back link: "Back to Opportunities"

Two-column layout (2/3 + 1/3):

LEFT COLUMN -- Post Details Card (white, rounded):
- Type badge at top: "Internship" (blue pill)
- Title: "Frontend Developer Intern" (h1, bold)
- Meta row: "TechCorp Solutions" company name, "Algiers, Algeria", "On-site", "Posted Apr 1, 2026"
- Divider
- SECTION "Description":
  "Join our frontend team for a 3-month internship. You will work on building modern web interfaces using HTML, CSS, and JavaScript. You will collaborate with senior developers and contribute to real client projects."
- SECTION "Requirements":
  Bulleted list:
  - Proficiency in HTML, CSS, and JavaScript
  - Familiarity with Git and version control
  - Basic understanding of responsive design
  - Strong communication skills
  - Currently enrolled in a Computer Science program
- SECTION "Details":
  - Type: Internship
  - Duration: 3 months
  - Location: Algiers, Algeria
  - Remote: No
  - Deadline: June 30, 2026
  - Applications: 12

RIGHT COLUMN -- Sidebar widgets (stacked):

WIDGET 1 -- "Apply to this Position" card:
  - Cover letter textarea: "Why are you interested in this position? (optional)" -- 5 rows
  - "Submit Application" blue button (full width)
  -- OR if already applied: Green card showing "Application Submitted" with status badge "Pending" (amber) and date "Applied on Apr 5, 2026"

WIDGET 2 -- "About the Company" card:
  - Company logo (64px)
  - Company name "TechCorp Solutions" (bold)
  - Industry "Technology"
  - Size "51-200 employees"
  - Location "Algiers, Algeria"
  - "View Company Profile" link

Show both variants:
1. Default state: Application form visible
2. Already applied state: Green confirmation card instead of form

Style: Clean and informative. The apply widget is prominent and always visible. Similar to LinkedIn job detail pages.
```

---

## PROMPT 10 -- Student Applications Tracking Page

```
Design the applications tracking page for "SkillBridge" student dashboard.

Use the same sidebar + header layout. Active sidebar item: "My Applications".

MAIN CONTENT:

Page header: "My Applications" (h1), subtext "Track the status of your applications"

STATS ROW: 4 small stat pills:
- "Total: 5" (gray)
- "Pending: 2" (amber)
- "Accepted: 1" (green)
- "Rejected: 2" (red)

APPLICATION CARDS LIST (vertical stack):
Each card (white, rounded, shadow):
- LEFT: Company logo/avatar (40px)
- MIDDLE:
  - Post title "Frontend Developer Intern" (bold)
  - Company "TechCorp Solutions" - Type "Internship"
  - Applied date: "Applied on Apr 5, 2026"
- RIGHT: Status badge (large, prominent):
  - "Pending" -- amber/yellow background, dark text
  - "Accepted" -- green background, white text, checkmark icon
  - "Rejected" -- red background, white text, x icon

Show 5 applications:
1. "Frontend Developer Intern" -- TechCorp -- Pending (amber)
2. "Data Analyst Intern" -- DataFlow -- Accepted (green)
3. "Backend Developer" -- CloudBase -- Rejected (red)
4. "Marketing Intern" -- AlgerBrand -- Pending (amber)
5. "Mobile Dev Challenge" -- StartupHub -- Rejected (red)

EMPTY STATE variant: Illustration, "No Applications Yet", "You haven't applied to any opportunities yet.", "Browse Opportunities" blue button.

Style: Focus on scan-ability. Each card should be glanceable with the status badge as the most prominent visual element. The accepted card could have a subtle green left border.
```

---

## PROMPT 11 -- Notifications Page

```
Design the notifications page for "SkillBridge". This page is shared by Students and Companies (same layout, different content).

Use the same sidebar + header layout. Active sidebar item: "Notifications".

MAIN CONTENT:

Page header: "Notifications" (h1) with unread count badge "(3 unread)", and "Mark All as Read" text button (right).

NOTIFICATION LIST (vertical, full width):
Each notification item (horizontal, full width, separated by light borders):
- UNREAD indicator: Blue dot on the left (or light blue background for unread items)
- Icon circle (40px, colored based on type):
  - Green circle + checkmark: for accepted
  - Red circle + x mark: for rejected
  - Blue circle + document icon: for new application
  - Gray circle + bell: for system
- Content:
  - Title (bold): "Application Accepted"
  - Message: "Your application for Frontend Developer Intern has been accepted by TechCorp Solutions."
  - Timestamp: "2 hours ago" (gray, small)
- Click the item to mark as read (background changes from light blue to white)

Show 6 notifications with different types:
1. Accepted -- "Your application for Frontend Developer Intern has been accepted by TechCorp Solutions." -- 2 hours ago (UNREAD)
2. Rejected -- "Your application for Backend Developer was not selected by CloudBase." -- 5 hours ago (UNREAD)
3. New Application -- "Ahmed Benali applied to your post: Data Analyst" -- 1 day ago (UNREAD)
4. Accepted -- "Your application for Data Analyst Intern has been accepted by DataFlow Inc." -- 2 days ago (READ)
5. Rejected -- "Your application for Mobile Dev Challenge was not selected by StartupHub." -- 3 days ago (READ)
6. System -- "Welcome to SkillBridge! Complete your profile to get started." -- 1 week ago (READ)

Visual difference: Unread items have light blue (#EFF6FF) background. Read items have white background.

EMPTY STATE variant: Bell icon illustration, "No Notifications", "You are all caught up! Check back later.", no action button needed.

Style: Clean list. Each item is easily scannable. The colored icon gives instant visual context about the notification type. Inspired by GitHub notifications.
```

---

## PROMPT 12 -- Company Dashboard (Main Overview)

```
Design the company/HR dashboard home page for "SkillBridge".

Same dashboard shell: fixed left sidebar (260px, white) + sticky header (64px) + scrollable content (#F8FAFC).

LEFT SIDEBAR -- Company version:
- Top: SkillBridge logo + "SkillBridge"
- Navigation:
  - Dashboard (active) with chart icon
  - Company Profile with building icon
  - Create Post with plus icon
  - My Posts with list icon
  - Applications with inbox icon
  - Notifications with bell icon
  - Settings with gear icon
- Bottom: Company avatar + "Sarah Martin" + "Company" badge

TOP HEADER: Same as student -- search, notification bell (badge "2"), avatar dropdown.

MAIN CONTENT -- "Welcome back, TechCorp Solutions" heading:

Row 1: 4 STAT CARDS (same style as student but different data):
- Card 1: Blue icon, "5" large, "Active Posts" label
- Card 2: Green icon, "23" large, "Total Applications" label
- Card 3: Amber icon, "12" large, "Pending Review" label
- Card 4: Purple icon, "8" large, "Accepted" label

Row 2: Two columns (1/2 + 1/2):
LEFT -- "Recent Applications" section:
- List of 4 recent applications:
  - Each: Student avatar (small), "Ahmed Benali applied to Frontend Developer Intern", "2 hours ago", status badge "Pending"
  - "View All Applications" link at bottom

RIGHT -- "Your Active Posts" section:
- List of 3 posts summary:
  - Each: Post title, type badge, "12 applicants", deadline
  - "View All Posts" link at bottom

Quick action button floating or at top: "Create New Post" blue button.

Style: Same layout system as student dashboard. The company dashboard has a slightly more management feel -- focused on reviewing applications and managing posts.
```

---

## PROMPT 13 -- Company Create Post Page

```
Design the create post / opportunity page for "SkillBridge" company dashboard.

Use the same company sidebar + header layout. Active item: "Create Post".

MAIN CONTENT:

Page header: "Create New Opportunity" (h1), subtext "Post an internship, job offer, or challenge for students"

Form inside a large white card (rounded, shadow):

SECTION 1 -- "Post Type" (important, first choice):
Three selectable cards in a row:
- Card 1: Briefcase icon, "Internship", subtext "Short-term learning opportunity", blue border when selected
- Card 2: Building icon, "Job", subtext "Full or part-time position", green border when selected
- Card 3: Trophy icon, "Challenge", subtext "Competition or hackathon", purple border when selected
(Radio card selector -- one must be chosen)

SECTION 2 -- "Post Details":
- Title*: text input, placeholder "e.g., Frontend Developer Intern"
- Description*: rich textarea (large, 8 rows), placeholder "Describe the opportunity, responsibilities, and what candidates will learn...", char counter "0/5000"
- Requirements: textarea (4 rows), placeholder "List required skills, qualifications, and experience..."

SECTION 3 -- "Location and Working Mode":
- Location: text input, placeholder "e.g., Algiers, Algeria"
- Remote toggle: checkbox "This is a remote opportunity"
- Deadline: date input picker

SECTION 4 -- "Preview" (collapsible):
- Show how the post will appear to students as a card preview

Footer actions:
- "Save as Draft" gray outlined button (left)
- "Publish Post" blue filled button (right)

Validation state: Show inline red error if title or description is empty when trying to publish.

Style: Step-by-step form feel. The type selector cards should be visually prominent. Clean, spacious form. Similar to creating a job post on LinkedIn.
```

---

## PROMPT 14 -- Company Applications Inbox

```
Design the applications inbox page for "SkillBridge" company dashboard.

Use the same company sidebar + header layout. Active item: "Applications".

MAIN CONTENT:

Page header: "Applications Inbox" (h1), subtext "Review and manage incoming student applications"

POST SELECTOR: Dropdown or tab bar at top -- "Frontend Developer Intern (12)" | "Data Analyst (8)" | "Backend Developer (3)" -- to filter applications by post. Show currently selected post prominently.

STATS ROW for selected post:
- Total: 12 | Pending: 5 | Accepted: 4 | Rejected: 3

APPLICANT CARDS LIST (one card per applicant, vertical stack):
Each card (white, rounded, shadow):
- LEFT: Student avatar (48px circle)
- MIDDLE:
  - Name: "Ahmed Benali" (bold, linked to profile)
  - University: "University of Science and Technology -- Computer Science"
  - Skills preview: Tag pills "PHP", "JavaScript", "MySQL"
  - Cover letter preview: "I am excited to apply for this position because..." (2 lines, truncated)
  - Applied: "Apr 5, 2026"
- RIGHT:
  - For PENDING status: Two action buttons stacked:
    - "Accept" green button
    - "Reject" red outline button
  - For ACCEPTED status: Green badge "Accepted"
  - For REJECTED status: Red badge "Rejected"

Show 5 applicant cards:
1. Ahmed Benali -- University of Science and Technology -- Pending (show Accept/Reject buttons)
2. Yasmine Khelifi -- University of Algiers -- Pending (show Accept/Reject buttons)
3. Omar Bensaid -- University of Oran -- Accepted (green badge)
4. Sara Mehdaoui -- University of Constantine -- Rejected (red badge)
5. Mourad Tazi -- University of Blida -- Pending (show Accept/Reject buttons)

CONFIRMATION MODAL (show as variant):
When clicking Accept: "Confirm acceptance for Ahmed Benali's application to Frontend Developer Intern? The student will be notified.", "Cancel" and "Confirm Accept" (green) buttons.
When clicking Reject: same but red theme.

EMPTY STATE: "No applications for this post yet. Share your post to reach more students."

Style: Management/inbox feel. The accept/reject buttons should be prominent for pending applications. Inspired by ATS (Applicant Tracking System) interfaces.
```

---

## PROMPT 15 -- Admin Dashboard (Main Overview)

```
Design the admin dashboard home page for "SkillBridge".

Same dashboard shell but with a DARK sidebar variant: Sidebar background is #1E293B (dark navy), text is white, active item has blue (#2563EB) background. This visually distinguishes the admin panel from student/company dashboards.

LEFT SIDEBAR -- Admin version (dark theme):
- Top: SkillBridge logo + "SkillBridge" (white text) + "Admin" red badge
- Navigation (white text, icons):
  - Dashboard (active -- blue bg) with chart icon
  - Users with people icon
  - Posts with list icon
  - Analytics with trending-up icon
  - System Logs with file-text icon
  - Settings with gear icon
- Bottom: Admin avatar + "Platform Admin" + "Admin" badge (red)

TOP HEADER: Same style but shows "Admin Panel" text, search bar, notification bell, admin avatar.

MAIN CONTENT -- "Admin Dashboard" heading:

Row 1: 4 STAT CARDS (same card style):
- "150" -- Total Users -- Blue icon (people)
- "120" -- Students -- Green icon (graduation cap)
- "28" -- Companies -- Purple icon (building)
- "3" -- Banned Users -- Red icon (slash-circle)

Row 2: 4 MORE STAT CARDS:
- "45" -- Total Posts -- Blue icon
- "38" -- Active Posts -- Green icon
- "230" -- Total Applications -- Purple icon
- "19.5%" -- Acceptance Rate -- Amber icon (chart)

Row 3: Two columns (1/2 + 1/2):
LEFT -- "Recent Admin Actions" section:
- Log entries:
  1. "Banned user: spammer@test.com" -- Admin -- 2 hours ago
  2. "Deleted post: Fake Job Listing" -- Admin -- 1 day ago
  3. "Unbanned user: legitimate@user.com" -- Admin -- 2 days ago
  4. "System event: Database backup completed" -- System -- 3 days ago
- "View All Logs" link

RIGHT -- "Platform Activity" section:
- "12 new signups this week" with trend arrow up
- "8 new posts this week" with trend arrow up
- "Users by role" simple horizontal bar chart: Students (80%) | Companies (19%) | Admins (1%)

Style: Professional admin panel. The dark sidebar creates a clear distinction from user-facing dashboards. The stats are dense but organized. Think Vercel Dashboard or Stripe Admin.
```

---

## PROMPT 16 -- Admin User Management Page

```
Design the user management page for "SkillBridge" admin dashboard.

Use the admin dashboard layout (dark sidebar, same header).

MAIN CONTENT:

Page header: "User Management" (h1), subtext "View and moderate all platform users"

FILTER BAR (white card):
- Search input: "Search by name or email..." (left)
- Role filter dropdown: "All Roles" | "Student" | "Company" | "Admin"
- Status filter dropdown: "All Statuses" | "Active" | "Banned"
- Results count: "150 users found"

USERS TABLE (white card, rounded, shadow):
Table with columns:
| ID | User | Email | Role | Status | Registered | Actions |

Table rows:
1. ID 1 | [Admin avatar] Platform Admin | admin@skillbridge.com | Admin (red badge) | Active (green badge) | Jan 1, 2026 | -- (no action for admins)
2. ID 2 | [Avatar] Ahmed Benali | student@example.com | Student (blue badge) | Active (green badge) | Jan 10, 2026 | [Ban] red outline button
3. ID 3 | [Avatar] Sarah Martin | hr@techcorp.com | Company (purple badge) | Active (green badge) | Jan 15, 2026 | [Ban] red outline button
4. ID 7 | [Avatar] Spam Account | spammer@test.com | Student (blue badge) | Banned (red badge) | Mar 1, 2026 | [Unban] green outline button
5. ID 8 | [Avatar] Yasmine Khelifi | yasmine@university.dz | Student (blue badge) | Active (green badge) | Mar 10, 2026 | [Ban] red outline button
6. ID 9 | [Avatar] Omar Bensaid | omar@student.edu | Student (blue badge) | Active (green badge) | Mar 15, 2026 | [Ban] red outline button

Role badges: Student=blue, Company=purple, Admin=red
Status badges: Active=green, Banned=red

PAGINATION: Bottom center -- "Previous | 1 2 3 | Next"

BAN CONFIRMATION MODAL:
"Are you sure you want to ban Ahmed Benali (student@example.com)? This user will no longer be able to log in."
"Cancel" gray button, "Ban User" red button with warning icon.

UNBAN CONFIRMATION MODAL:
"Restore access for Spam Account (spammer@test.com)?"
"Cancel" gray button, "Unban User" green button.

Style: Clean admin table. Alternating row colors (subtle). Proper data alignment. Role and status badges provide instant visual classification.
```

---

## PROMPT 17 -- Admin Analytics Page

```
Design the analytics page for "SkillBridge" admin dashboard.

Use the admin layout (dark sidebar, header).

MAIN CONTENT:

Page header: "Platform Analytics" (h1), subtext "Detailed statistics and platform health overview"

Row 1: LARGE METRIC CARDS (2x3 grid or 3x2):
Each card has: Large number, label, small trend indicator
- Total Users: 150 (up 12 this week)
- Total Students: 120 (up 9 this week)
- Total Companies: 28 (up 3 this week)
- Total Posts: 45 (up 8 this week)
- Total Applications: 230 (up 32 this week)
- Acceptance Rate: 19.5%

Row 2: Two columns (1/2 + 1/2):

LEFT -- "Users by Role" card:
- Simple donut or pie chart OR horizontal bar chart:
  - Students: 120 (80%) -- blue bar
  - Companies: 28 (18.7%) -- purple bar
  - Admins: 2 (1.3%) -- red bar

RIGHT -- "Applications by Status" card:
- Simple donut chart or stacked bar:
  - Pending: 125 (54.3%) -- amber
  - Accepted: 45 (19.6%) -- green
  - Rejected: 60 (26.1%) -- red

Row 3: Two columns:

LEFT -- "Posts by Type" card:
- Horizontal bars or simple pie:
  - Internships: 20 (44%) -- blue
  - Jobs: 15 (33%) -- green
  - Challenges: 10 (22%) -- purple

RIGHT -- "Posts by Status" card:
  - Active: 38 -- green
  - Closed: 5 -- gray
  - Draft: 2 -- amber

Row 4: "Recent Activity" card:
- "Signups (Last 7 Days): 12"
- "New Posts (Last 7 Days): 8"
- "Applications (Last 7 Days): 32"
- Simple sparkline or trend bars showing daily activity

Style: Beautiful analytics dashboard. Use charts and visual data representation. Clean card-based layout. Numbers should be large and bold. Trends shown with colored arrows. Inspired by Vercel or Stripe analytics dashboards.
```

---

## PROMPT 18 -- Admin System Logs Page

```
Design the system logs page for "SkillBridge" admin dashboard.

Use the admin layout (dark sidebar, header).

MAIN CONTENT:

Page header: "System Logs" (h1), subtext "Audit trail of all admin moderation actions"

FILTER BAR:
- Action type dropdown: "All Actions" | "Ban User" | "Unban User" | "Delete Post" | "System Event"
- Date range: "Last 7 days" | "Last 30 days" | "All time"
- Results count: "24 log entries"

LOGS TABLE (white card):
Table columns: # | Admin | Action | Target | Description | Date

Table rows:
1. #24 | Platform Admin | Ban User (red badge) | User #7 | "Banned user: spammer@test.com for spam activity" | Apr 5, 2026 16:00
2. #23 | Platform Admin | Delete Post (orange badge) | Post #12 | "Removed post: Fake Job Listing -- inappropriate content" | Apr 4, 2026 10:30
3. #22 | Platform Admin | Unban User (green badge) | User #5 | "Restored access for: legitimate@user.com" | Apr 3, 2026 14:15
4. #21 | System | System Event (gray badge) | System | "Automated database backup completed" | Apr 3, 2026 02:00
5. #20 | Platform Admin | Ban User (red badge) | User #11 | "Banned user: troll@email.com for harassment" | Apr 1, 2026 09:45

Action badges with colors:
- Ban User: red badge
- Unban User: green badge
- Delete Post: orange badge
- System Event: gray badge

PAGINATION: Bottom -- page numbers

EMPTY STATE: "No log entries found for the selected filters."

Style: Clean audit log table with clear timestamps. Feels like a professional admin/monitoring tool. Each row provides full context at a glance.
```

---

## PROMPT 19 -- Toast Notifications and Alert Components

```
Design a set of toast/alert notification components for "SkillBridge".

These are temporary feedback messages that appear at the top-right of the screen after user actions.

Show all 4 variants stacked vertically (as a component showcase):

1. SUCCESS TOAST:
   - Green (#16A34A) left border (4px) or green background tint
   - Checkmark icon (green circle)
   - Title: "Success"
   - Message: "Your profile has been updated successfully."
   - x close button (right)
   - Auto-dismiss after 5 seconds

2. ERROR TOAST:
   - Red (#DC2626) left border or red background tint
   - x icon (red circle)
   - Title: "Error"
   - Message: "Failed to submit application. Please try again."
   - x close button

3. WARNING TOAST:
   - Amber (#F59E0B) left border or amber tint
   - Warning triangle icon (amber circle)
   - Title: "Warning"
   - Message: "Your session will expire in 5 minutes."
   - x close button

4. INFO TOAST:
   - Blue (#2563EB) left border or blue tint
   - Info icon (blue circle)
   - Title: "Info"
   - Message: "3 new opportunities match your profile."
   - x close button

Also show INLINE ALERT BANNERS (full-width, inside page content):

5. Error banner: Red background (#FEE2E2), red border, red text: "Your account has been suspended. Contact support for assistance."

6. Success banner: Green background (#DCFCE7), green border: "Application submitted successfully! The company will review your application."

7. Info banner: Blue background (#DBEAFE), blue border: "Complete your profile to increase your visibility to companies."

Style: Clean, minimal alerts. Each type has a distinct color. Toasts float in the top-right corner with subtle shadow. Banners are full-width inside the page content.
```

---

## PROMPT 20 -- Empty States and Loading States

```
Design a set of empty state and loading state components for "SkillBridge".

EMPTY STATES (show 4 variants in a 2x2 grid):

1. "No Certificates Yet"
   - Icon: Award/certificate illustration (simple line art or emoji style)
   - Title: "No Certificates Yet" (h3, bold)
   - Subtext: "Add your first professional certificate to showcase your skills and boost your profile."
   - CTA button: "Add Certificate" (blue)

2. "No Applications"
   - Icon: Document/folder illustration
   - Title: "No Applications Yet"
   - Subtext: "You haven't applied to any opportunities yet. Browse available posts to get started."
   - CTA button: "Browse Opportunities" (blue)

3. "No Notifications"
   - Icon: Bell with checkmark illustration
   - Title: "You're All Caught Up!"
   - Subtext: "No new notifications. Check back later."
   - No CTA button needed

4. "No Posts Found"
   - Icon: Search illustration
   - Title: "No Matching Opportunities"
   - Subtext: "Try adjusting your filters or search terms."
   - CTA button: "Clear Filters" (outline)

LOADING STATES (show below):

5. Card skeleton loader: 3 cards with animated shimmer/pulse effect on:
   - Avatar circle placeholder (gray, pulsing)
   - Title line placeholder (gray bar, pulsing)
   - Description lines placeholder (2 gray bars, shorter, pulsing)
   - Button placeholder (gray rounded rectangle, pulsing)

6. Table skeleton loader: Table with 5 rows of pulsing gray placeholder bars

Style: Empty states should be friendly and helpful, not dead-end. Skeleton loaders use gray animated placeholders. Light gray (#E2E8F0) animated pulse/shimmer effect. Centered layout for empty states.
```

---

## PROMPT 21 -- Company Profile View Page

```
Design the company profile view page for "SkillBridge" company dashboard.

Use the same company sidebar + header layout. Active sidebar item: "Company Profile".

MAIN CONTENT:

SECTION 1 -- Profile Header:
- Cover area: Subtle gradient (blue-to-indigo), 180px tall
- Company logo overlapping cover bottom (80px square, rounded-lg, white border, shadow)
- Right of logo: Company name "TechCorp Solutions" (h1, bold), industry "Technology" (gray badge)
- Right side: "Edit Profile" outline button
- Below: Company description paragraph "Leading software development company specializing in web and mobile applications. We pride ourselves on innovation, mentorship, and building products that matter."

SECTION 2 -- Company Info Cards (2 columns):

LEFT -- "Company Details" card:
  - Industry: Technology
  - Founded: 2015
  - Company Size: 51-200 employees
  - Location: Algiers, Algeria
  - Website: "techcorp.example.com" (blue link)

RIGHT -- "Recruitment Stats" card:
  - Active Posts: 5
  - Total Applications Received: 47
  - Accepted Candidates: 12
  - Member Since: January 2026

SECTION 3 -- "Active Opportunities" section:
- Section title with count: "Active Opportunities (5)"
- 3 post cards listed vertically (same card style as opportunities page):
  - "Frontend Developer Intern" -- Internship -- 12 applicants -- Deadline Jun 30
  - "Backend Developer" -- Job -- 8 applicants -- Deadline Jul 15
  - "AI Hackathon 2026" -- Challenge -- 23 applicants -- Open
- "View All Posts" link

Style: Professional company page. The cover gradient + logo overlap gives a LinkedIn company page feel.
```

---

## PROMPT 22 -- Company My Posts Management Page

```
Design the "My Posts" management page for "SkillBridge" company dashboard.

Use the same company sidebar + header layout. Active sidebar item: "My Posts".

MAIN CONTENT:

Page header: "My Posts" (h1), subtext "Manage your published opportunities", and "Create New Post" blue button (right).

FILTER/SORT BAR (white card, horizontal):
- Filter tabs: "All (8)" | "Active (5)" | "Closed (2)" | "Drafts (1)" -- tab style, active tab has blue underline
- Sort: "Newest First" dropdown

POST CARDS LIST (vertical stack, full width):
Each card (white, rounded, shadow):
- LEFT section:
  - Post title "Frontend Developer Intern" (bold, linked)
  - Type badge: "Internship" (blue pill)
  - Status badge: "Active" (green pill) or "Closed" (gray pill) or "Draft" (amber pill)
  - Created date: "Published Apr 1, 2026" (small gray)
  - Deadline: "Deadline: Jun 30, 2026" (small, with calendar icon)
- MIDDLE:
  - Applications count: "12 applications" with icon
  - Action breakdown: "5 pending, 4 accepted, 3 rejected" (small, colored text)
- RIGHT:
  - Action buttons: "View" blue link, "Edit" gray link, "Applications" blue link, "Delete" red link
  - Or a three-dot menu that opens a dropdown with these actions

Show 5 post cards:
1. "Frontend Developer Intern" -- Internship -- Active -- 12 apps -- Deadline Jun 30
2. "Backend Developer" -- Job -- Active -- 8 apps -- Deadline Jul 15
3. "AI Hackathon 2026" -- Challenge -- Active -- 23 apps -- Open deadline
4. "Data Entry Clerk" -- Job -- Closed -- 3 apps -- Expired Apr 1
5. "Marketing Strategy Challenge" -- Challenge -- Draft -- 0 apps -- No deadline set

EMPTY STATE: "You haven't created any posts yet. Publish your first opportunity to start receiving applications." with "Create Post" blue button.

DELETE CONFIRMATION MODAL: "Delete Frontend Developer Intern? This will also remove all 12 associated applications. This action cannot be undone." -- "Cancel" (gray) + "Delete Post" (red) buttons.

Style: Management/overview page. Each card gives a complete snapshot of the post status. Similar to a CMS content management interface.
```

---

## PROMPT 23 -- Admin Post Moderation Page

```
Design the post moderation page for "SkillBridge" admin dashboard.

Use the admin layout (dark sidebar, header). Active sidebar item: "Posts".

MAIN CONTENT:

Page header: "Post Moderation" (h1), subtext "Review and manage all platform posts"

FILTER BAR (white card):
- Search: "Search by title or company..." input
- Type filter: "All Types" | "Internship" | "Job" | "Challenge" dropdown
- Status filter: "All Statuses" | "Active" | "Closed" | "Draft" dropdown
- Results count: "45 posts found"

POSTS TABLE (white card, rounded):
Table columns: # | Title | Company | Type | Status | Applications | Created | Actions

Table rows:
1. #1 | Frontend Developer Intern | TechCorp Solutions | Internship (blue) | Active (green) | 12 | Apr 1, 2026 | [View] [Delete]
2. #2 | Backend Developer | CloudBase | Job (green badge) | Active (green) | 8 | Apr 3, 2026 | [View] [Delete]
3. #3 | AI Hackathon 2026 | TechUnion | Challenge (purple) | Active (green) | 23 | Apr 5, 2026 | [View] [Delete]
4. #4 | Data Entry Clerk | OldCorp | Job (green) | Closed (gray) | 3 | Mar 15, 2026 | [View] [Delete]
5. #5 | URGENT HIRING!!! | SuspiciousInc | Job (green) | Active (green) | 0 | Apr 8, 2026 | [View] [Delete] (highlighted -- looks suspicious)

The "Delete" button is red text or red outline button.

DELETE CONFIRMATION MODAL:
"Remove post URGENT HIRING!!! by SuspiciousInc? This will also delete all associated applications and notify the company."
"Reason (optional):" text input
"Cancel" + "Remove Post" (red) buttons

PAGINATION: Bottom center.

Style: Admin table view. Clean data presentation with proper badges and alignment. The delete action requires confirmation.
```

---

## PROMPT 24 -- About Page

```
Design the About page for "SkillBridge".

Use the same public navbar as the landing page (Logo, Home | About | Features, Login + Sign Up).

MAIN CONTENT:

HERO SECTION:
- Centered heading: "About SkillBridge" (large, bold)
- Subtext: "Empowering students to bridge the gap between education and career"
- Subtle blue gradient background accent

SECTION 1 -- "Our Mission" (centered, max-width 800px):
"SkillBridge was born from a simple idea: students deserve a dedicated platform to showcase their skills and connect with companies. Unlike generic professional networks, we focus exclusively on the student-to-career journey -- from building your first professional profile to landing your first internship or job."

SECTION 2 -- "What We Offer" (3 columns):
- Column 1: Icon (graduation cap), "For Students", "Build professional profiles, showcase certificates and skills, discover opportunities, and track your career applications -- all in one place."
- Column 2: Icon (building), "For Companies", "Publish internships, jobs, and challenges. Browse student profiles, review applications, and find the right talent for your team."
- Column 3: Icon (shield check), "Platform Trust", "Admin moderation, secure authentication, and role-based access control ensure a professional and trustworthy environment."

SECTION 3 -- "Project Context" card (white, centered, max-width 700px):
- Heading: "Academic Project"
- Text: "SkillBridge is developed as a final-year IT project by a team of 4 students. The project demonstrates full-stack web development skills using PHP, MySQL, HTML, CSS, and JavaScript with a focus on clean architecture, security best practices, and comprehensive documentation."
- Tech stack icons/badges: PHP, MySQL, HTML5, CSS3, JavaScript

SECTION 4 -- CTA:
- "Ready to get started?"
- "Join SkillBridge" blue button

FOOTER: Same footer as landing page.

Style: Clean, informative page. Professional but approachable. Consistent with the landing page design.
```

---

## PROMPT 25 -- Public Profile View

```
Design the public profile view page for "SkillBridge". This is what any logged-in user sees when viewing another user's profile.

Use the dashboard layout (sidebar + header for the viewing user's role).

MAIN CONTENT:

VARIANT A -- Viewing another STUDENT's profile:

Back link: "Back"

Profile card (white, rounded, full width):
- Cover area: Subtle gradient (200px)
- Avatar (80px circle) overlapping
- Name: "Yasmine Khelifi" (h1)
- University: "University of Algiers" (gray)
- Field: "Software Engineering" (gray)
- Bio: "Third year software engineering student passionate about mobile development and UI/UX design."
- Skills: Tag pills -- "Java", "Kotlin", "Figma", "React Native", "UI/UX"

Below the profile card:

"Certificates" section (read-only, no edit/delete buttons):
- Certificate cards (2 per row):
  - "Mobile App Development" -- Google / Coursera -- Oct 2025
  - "UI/UX Design Fundamentals" -- Interaction Design Foundation -- Dec 2025

"Activity" section:
- Recent feed entries (read-only):
  - "Yasmine added a new certificate: Mobile App Development" -- 3 months ago

No edit buttons, no settings, no private information shown. This is a read-only public view.

VARIANT B -- Viewing a COMPANY's profile:

Profile card:
- Company logo (80px, square rounded)
- Company name: "DataFlow Inc" (h1)
- Industry badge: "Data and Analytics"
- Description: "DataFlow specializes in data analytics solutions for businesses across North Africa..."
- Info: Founded 2018 - 11-50 employees - Algiers, Algeria
- Website: "dataflow.dz" (link)

"Active Opportunities" section:
- 2 post cards from this company visible to the viewer:
  - "Data Analyst Intern" -- Internship -- Deadline Jul 2026
  - "Business Intelligence Developer" -- Job -- Deadline Aug 2026

Style: Clean profile view. Read-only -- no action buttons except "Apply" on posts if viewing a company.
```

---

## PROMPT 26 -- Settings Page

```
Design the account settings page for "SkillBridge". This page is shared across all roles (student, company, admin) with the same layout.

Use the dashboard layout (sidebar + header). Active sidebar item: "Settings".

MAIN CONTENT:

Page header: "Account Settings" (h1)

SETTINGS TABS (horizontal tab bar at top):
- "Account" (active) | "Security" | "Preferences"

TAB 1 -- "Account" (default view):

Card 1 -- "Profile Information":
- Avatar: Current avatar preview + "Change Photo" button
- Full Name: text input (pre-filled "Ahmed Benali")
- Email: text input (pre-filled "student@example.com") -- shown as read-only with a lock icon and note "Email cannot be changed"
- Role: Badge showing "Student" -- read-only, informational
- Member since: "January 10, 2026" -- read-only
- "Save Changes" blue button

Card 2 -- "Danger Zone" (red-tinted border):
- "Delete Account": Warning text "Permanently delete your account and all associated data. This action cannot be undone."
- "Delete Account" red outline button

TAB 2 -- "Security":

Card 1 -- "Change Password":
- Current Password: password input
- New Password: password input + strength indicator (weak/medium/strong bar)
- Confirm New Password: password input
- "Update Password" blue button

Card 2 -- "Session Information":
- Current session: "Active -- logged in from Chrome on Windows - Apr 9, 2026"
- "Log Out All Sessions" red outline button

TAB 3 -- "Preferences":

Card 1 -- "Notification Preferences":
- Toggle switches:
  - "Application status updates" (on by default)
  - "New application alerts" (on by default -- company only)
  - "System announcements" (on by default)

Card 2 -- "Display":
- Language: "English" dropdown (only option for now)

DELETE ACCOUNT MODAL: "Are you sure? This will permanently delete your account, profile, certificates, applications, and all associated data. Type DELETE to confirm." -- text input for confirmation + "Cancel" (gray) + "Delete My Account" (red) buttons.

Style: Standard settings page. Clean form layout. The danger zone card should have red/warning styling. Tabs keep the page organized.
```

---

## PROMPT 27 -- Mobile Responsive Variants

```
Design mobile-responsive variants (375px width, iPhone-style) for the key "SkillBridge" pages. Show these as a mobile mockup set.

Show 6 mobile screens side by side or in a grid:

SCREEN 1 -- Mobile Landing Page:
- Stacked layout (single column)
- Hamburger menu replacing navbar links
- Hero text centered with button below
- Feature cards stacked vertically
- CTA section full width

SCREEN 2 -- Mobile Login:
- Login card takes full width with horizontal padding
- Form fields full width
- Button full width
- Centered layout

SCREEN 3 -- Mobile Student Dashboard:
- Sidebar is HIDDEN (off-canvas, hamburger menu in header)
- Header: hamburger icon (left), "SkillBridge" (center), bell + avatar (right)
- Stat cards: 2x2 grid (2 per row)
- Feed and recommendations stacked vertically (full width)
- Notification bell still visible in header

SCREEN 4 -- Mobile Opportunities:
- Filter bar: search full width, filter buttons below as horizontal scroll pills
- Post cards: full width, stacked vertically
- Each card: vertical layout (company info on top, title, badges, deadline)

SCREEN 5 -- Mobile Notifications:
- Full-width notification items
- Swipeable or tap to mark as read
- Clean vertical list

SCREEN 6 -- Mobile Navigation (Sidebar open):
- Full-screen overlay (dark backdrop)
- Sidebar slides in from left
- Full navigation links visible
- Close x button at top

All screens: Same color system (#2563EB primary), Inter font, consistent component styling scaled for mobile. Touch-friendly button sizes (min 44px tap targets).

Style: Clean mobile interface. No content is lost -- just reorganized for smaller screens.
```

---

## Prompt Coverage Map

Every page from the SkillBridge sitemap is covered:

| Page | Prompt | Type |
|------|--------|------|
| Landing Page | Prompt 1 | Public |
| About Page | Prompt 24 | Public |
| Login | Prompt 2 | Auth |
| Register | Prompt 3 | Auth |
| Public Profile | Prompt 25 | Shared |
| Student Dashboard | Prompt 4 | Student |
| Student Profile | Prompt 5 | Student |
| Student Edit Profile | Prompt 6 | Student |
| Certificates | Prompt 7 | Student |
| Opportunities | Prompt 8 | Student |
| Post Detail | Prompt 9 | Student |
| My Applications | Prompt 10 | Student |
| Notifications | Prompt 11 | Student/Company |
| Settings | Prompt 26 | All Roles |
| Company Dashboard | Prompt 12 | Company |
| Company Profile | Prompt 21 | Company |
| Create Post | Prompt 13 | Company |
| My Posts | Prompt 22 | Company |
| Applications Inbox | Prompt 14 | Company |
| Admin Dashboard | Prompt 15 | Admin |
| User Management | Prompt 16 | Admin |
| Post Moderation | Prompt 23 | Admin |
| Analytics | Prompt 17 | Admin |
| System Logs | Prompt 18 | Admin |
| Toast/Alerts | Prompt 19 | Components |
| Empty/Loading States | Prompt 20 | Components |
| Mobile Variants | Prompt 27 | Responsive |

**Total: 27 prompts covering 29 pages + components + mobile**

---

## Recommended Order in Stitch

1. **Prompt 0** (context prefix) + **Prompt 1** (Landing Page)
2. **Prompt 24** (About Page)
3. **Prompts 2 + 3** -- Auth pages (Login, Register)
4. **Prompt 4** -- Student Dashboard (establishes the dashboard layout)
5. **Prompts 5-11** -- All student pages in sequence
6. **Prompt 12** -- Company Dashboard
7. **Prompts 21, 13, 22, 14** -- Company profile, create post, my posts, applications
8. **Prompt 15** -- Admin Dashboard
9. **Prompts 16, 23, 17, 18** -- Admin user mgmt, posts, analytics, logs
10. **Prompt 25** -- Public Profile views
11. **Prompt 26** -- Settings page
12. **Prompts 19, 20** -- Toast/alert and empty state components
13. **Prompt 27** -- Mobile responsive variants

## Tips for Stitch

- **Always prefix with Prompt 0** for design consistency across all screens
- **If a prompt is too long**, split it: generate the layout shell first, then fill in the content areas
- **Iterate after generation**: "make the sidebar darker", "increase card padding", etc.
- **Export and compare**: Place generated screens side by side to check visual consistency
- **Reuse elements**: If Stitch generates a great sidebar in Prompt 4, reference it in later prompts
- **For variants**: Ask "show me this page with 0 items (empty state)" or "show the error state version"
- **If Stitch truncates**: Remove example data rows and keep the structural description
