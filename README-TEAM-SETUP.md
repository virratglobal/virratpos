
# VirratPOS — Team Setup & Workflow
 
This project is a UI/UX remaster of the StoreGo SaaS (Laravel/PHP/MySQL).
We are staying on this stack — no framework changes. This doc covers how to
get the project running locally, how we use Antigravity, and how we
collaborate on GitHub without overwriting each other's work.
 
Repo: `github.com/virratglobal/virratpos` (private)
 
---
 
## 1. First-Time Local Setup
 
Requirements: XAMPP (PHP + MySQL), Composer, Node.js/npm, Git, Antigravity IDE.
 
```bash
git clone https://github.com/virratglobal/virratpos.git
cd virratpos
 
composer install
cp .env.example .env
php artisan key:generate
```
 
Open `.env` and fill in your **own local** database credentials (DB name,
user, password) matching your XAMPP MySQL setup. Do not copy another
teammate's `.env`.
 
```bash
php artisan migrate
php artisan db:seed   # if seeders are set up, for demo/test data
npm install
npm run dev
```
 
Start Apache + MySQL in XAMPP, then confirm the app loads at your local URL
(e.g. `http://localhost/virratpos/public`).
 
---
 
## 2. GitHub Access
 
You'll be added as a Collaborator on the repo. GitHub no longer accepts
passwords for Git operations, so:
 
1. Go to GitHub → Settings → Developer Settings → Personal Access Tokens
2. Generate a token (fine-grained, scoped to this repo if possible)
3. Use this token in place of a password when Git asks for authentication,
   and in your Antigravity MCP config (see below)
Keep your token private — never share it, never commit it anywhere.
 
---
 
## 3. Connecting Antigravity to GitHub
 
Everyone uses their **own** PAT — do not share tokens between accounts.
 
1. Open Antigravity → "..." menu in the Agent panel → MCP Servers →
   Manage MCP Servers → View raw config
2. Add this to `mcp_config.json`:
```json
   {
     "mcpServers": {
       "github": {
         "serverUrl": "https://api.githubcopilot.com/mcp/",
         "headers": {
           "Authorization": "Bearer YOUR_GITHUB_PAT"
         }
       }
     }
   }
```
3. Save and restart Antigravity completely.
4. Confirm it's connected: open MCP Servers panel, you should see "github"
   listed with available tools.
When asking the Antigravity agent to do Git actions, always be explicit
about branch rules, e.g.:
 
```
Create a new branch feature/<page-name>-ui from dev, make the UI changes
for <page name>, commit with a clear message, and push to GitHub. Do NOT
push to main or dev directly.
```
 
---
 
## 4. Branching Rules
 
- `main` — always stable. Never push directly here.
- `dev` — integration branch. Never push directly here either.
- `feature/<page-name>-ui` — your working branch for a specific page/module.
Before starting any new task:
 
```bash
git checkout dev
git pull
git checkout -b feature/<page-name>-ui
```
 
Example branch names: `feature/pos-screen-ui`, `feature/staff-management-ui`,
`feature/customer-dashboard-ui`
 
**One branch = one page/module, one person.** Don't mix multiple unrelated
pages into a single branch, and don't let two people work on the same
page/component at the same time — it causes merge conflicts, including
between Antigravity agents working in parallel.
 
---
 
## 5. Committing & Pushing
 
Commit in small, logical chunks — not one giant commit at the end of the day.
 
```bash
git add .
git commit -m "Short, clear description of the change"
git push origin feature/<page-name>-ui
```
 
---
 
## 6. Pull Requests
 
1. Go to the repo on GitHub — you'll see a prompt to open a Pull Request for
   your recently pushed branch.
2. Open the PR **against `dev`** (not `main`).
3. Tag a reviewer. Don't merge your own PR without a review.
4. Once approved, merge into `dev` and delete the feature branch.
5. Periodically, once a batch of pages is stable and tested, `dev` gets
   merged into `main`.
---
 
## 7. Getting Teammates' Changes Into Your Local XAMPP
 
Pushed/merged code does **not** appear automatically in your local folder.
To bring it in:
 
```bash
git checkout dev
git pull
```
 
Notes:
- If you have uncommitted changes on your own branch, commit them first —
  otherwise `git pull` will conflict.
- If a teammate added a new database migration, pulling only brings the
  migration *file*. You still need to apply it locally:
```bash
  php artisan migrate
```
- You'll only see a teammate's work after it's been pushed **and** merged
  into `dev` via an approved PR — not while it's still sitting on their own
  feature branch.
---
 
## 8. Shared UI Components
 
Before redesigning individual pages, shared Blade components (buttons, cards,
tables, modals, form inputs) should be built and merged into `dev` first, so
everyone works from the same design system. If you think something you're
building should be a shared component, check before duplicating it in your
own page.
 
---
 
## 9. Daily Habit
 
Always pull the latest `dev` before starting new work:
 
```bash
git checkout dev
git pull
```
 
This avoids working on outdated code and reduces merge conflicts later.
 
---
 
## Quick Reference
 
| Action                         | Command                                                        |
|---------------------------------|-----------------------------------------------------------------|
| Start new task                  | `git checkout dev && git pull && git checkout -b feature/xyz`  |
| Save progress                   | `git add . && git commit -m "message"`                          |
| Push branch                     | `git push origin feature/xyz`                                   |
| Get teammates' merged changes   | `git checkout dev && git pull`                                  |
| Update local DB schema          | `php artisan migrate`                                           |
| Rebuild frontend assets         | `npm run dev`                                                    |
 
Questions or unsure about something before pushing — ask first. Better to
check than to break `dev` for everyone else.
 
