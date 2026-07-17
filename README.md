# Hantar

A job application tracker built to stay on top of the job hunt — track applications through every stage, and get AI-powered feedback on how well your resume matches a job description.

## Features

- **Application Tracking** — Kanban-style board (Applied → Interview → Offer → Rejected) with a simple form for company, role, job description, notes, and application link.
- **Skill Gap Analysis** — Select any application, paste your resume, and get an AI-generated match score, matched/missing skills, and actionable recommendations, powered by the Anthropic API.
- **Analysis History** — Every analysis you run is saved so you can revisit past results.
- **Dashboard** — Application status breakdown, applications-over-time chart, average skill-gap score, and a recent activity feed.

## Tech Stack

- **Backend:** Laravel 13, PHP 8.4
- **Frontend:** Vue 3, Inertia.js, TypeScript
- **Styling:** Tailwind CSS, shadcn-vue
- **Database:** PostgreSQL (via Supabase)
- **AI:** Anthropic API (Claude Haiku) for resume/JD skill gap analysis
- **Charts:** Chart.js (vue-chartjs)
- **Hosting:** Railway

## Getting Started

### Prerequisites
- PHP 8.4+
- Composer
- Node.js 22+
- PostgreSQL database (or a Supabase project)

### Setup

```bash
git clone https://github.com/aiqalqasyaf/hantar-app.git
cd hantar-app

composer install
npm install

cp .env.example .env
php artisan key:generate
```

Configure your `.env`:
```env
DB_CONNECTION=pgsql
DATABASE_URL=your_postgres_connection_string

ANTHROPIC_API_KEY=your_anthropic_api_key
```

Run migrations:
```bash
php artisan migrate
```

Start the dev server:
```bash
composer run dev
```

Visit `http://localhost:8000`.

## Project Structure

- `app/Models` — `Application`, `SkillAnalysis`
- `app/Services/SkillAnalysisService.php` — Anthropic API integration for skill gap analysis
- `resources/js/pages` — Applications kanban, Analysis (index/history/show), Dashboard
- `resources/js/composables` — `useApplications`, `useAnalysis`, `useDashboard`

## Roadmap

- Gmail integration for auto-tracking applications
- Resume builder

## Author

Built by [Aiqal Qasyaf](https://github.com/aiqalqasyaf)
