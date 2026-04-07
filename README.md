# Lore

> An online video directory for entrepreneurs — discover real founder journeys, honest failures, and what actually works.

[![Live Demo](https://img.shields.io/badge/Live%20Demo-Visit%20Site-D4542A?style=for-the-badge)](DEPLOY_URL_HERE)
[![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.4%2B-777BB4?style=for-the-badge&logo=php)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-CSS-06B6D4?style=for-the-badge&logo=tailwindcss)](https://tailwindcss.com)

---

## Screenshots

> _Screenshots coming after deployment_

---

## Features

- **Authentication** — Email/password with verification + Google OAuth via Socialite
- **Role-based access** — Admin, Creator, and Viewer roles with middleware-gated routes
- **Pinterest-style masonry grid** — Editorial video browsing inspired by Pinterest
- **Video detail pages** — YouTube embeds with session-tracked view counts and related videos
- **Full-text search** — Search by title/description with category and tag filters
- **Entrepreneur profiles** — Public profiles with total view stats and video grids
- **Bookmarks / Watchlist** — Save videos to a personal watchlist on the dashboard
- **Admin CMS** — Dashboard with stats, video management (publish/feature/delete), user management
- **Marketing landing page** — Startup-grade welcome page with live stats and category explorer
- **Optional Google OAuth** — The Google sign-in CTA appears only when OAuth credentials are configured
- **Resilient empty states** — Public pages degrade gracefully before the catalog is seeded

---

## Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 12 |
| Runtime | PHP 8.4+ |
| Frontend | Blade Templates + Tailwind CSS |
| Fonts | Playfair Display + DM Sans + JetBrains Mono |
| Auth | Laravel Breeze + Google OAuth (Socialite) |
| Database | PostgreSQL (Render/Neon production) / SQLite or Postgres locally |
| Build | Vite 7 |
| Deploy | Render + Neon Postgres |

---

## Local Setup

```bash
# Clone the repository
git clone https://github.com/shash-hq/lore.git
cd lore

# Install PHP dependencies
composer install

# Install JS dependencies
npm install

# Set up environment
cp .env.example .env
php artisan key:generate

# For a quick local setup, switch these .env values:
# APP_ENV=local
# APP_DEBUG=true
# APP_URL=http://127.0.0.1:8000
# DB_CONNECTION=sqlite
# DB_DATABASE=/absolute/path/to/database/database.sqlite
# SESSION_SECURE_COOKIE=false

# Run migrations and seed demo data
php artisan migrate --seed

# Start the development servers
npm run dev        # Terminal 1 — Vite asset compiler
php artisan serve  # Terminal 2 — Laravel server
```

Visit `http://127.0.0.1:8000`

**Demo credentials:**
- Admin: `admin@lore.com` / `password`

---

## Free Deployment on Render + Neon

This repository is set up for a true `$0` demo deployment:

1. Create a free Neon Postgres project and copy the connection details.
2. Create a new Render web service from this repo.
3. Set the following Render environment variables:
   - `APP_NAME=Lore`
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - `APP_URL=https://your-service.onrender.com`
   - `APP_KEY=` from `php artisan key:generate --show`
   - `DB_CONNECTION=pgsql`
   - `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
   - `DB_SSLMODE=require`
   - `QUEUE_CONNECTION=sync`
   - `SESSION_DRIVER=database`
   - `CACHE_STORE=database`
4. Leave `MAIL_MAILER=log` for the first demo deploy unless you add a real mail provider.
5. Run `php artisan migrate --force --seed` after the first successful deploy.
6. If you want Google OAuth, also set:
   - `GOOGLE_CLIENT_ID`
   - `GOOGLE_CLIENT_SECRET`
   - `GOOGLE_REDIRECT=https://your-service.onrender.com/auth/google/callback`

Important notes:
- Render free services can cold-start, so the first request may be slower.
- Do not use SQLite in production on Render free web services because the filesystem is ephemeral.
- This deploy path does not require a separate queue worker because the app defaults to `QUEUE_CONNECTION=sync`.

---

## Project Structure

```
app/
├── Http/Controllers/
│   ├── AdminController       # Admin stats dashboard
│   ├── AdminVideoController  # Admin CRUD, publish/feature toggles
│   ├── HomeController        # Homepage + category filtering + pagination
│   ├── VideoController       # Video detail + session-based view tracking
│   ├── SearchController      # Full-text search + tag/category filters
│   ├── EntrepreneurController
│   ├── BookmarkController
│   ├── DashboardController
│   └── SocialiteController   # Optional Google OAuth
├── Models/
│   ├── User.php        # Roles + email verification
│   ├── Video.php       # Slug generation, YouTube normalization, featured guard
│   ├── Category.php
│   └── Tag.php
resources/views/
├── layouts/               # app.blade.php, admin.blade.php
├── admin/                 # Admin dashboard + video create/edit/index
├── videos/                # Video detail page
├── entrepreneurs/         # Creator profile pages
├── home.blade.php         # Masonry homepage with featured fallback
├── search.blade.php       # Search results + empty states
├── dashboard.blade.php    # User watchlist + recommendations
└── welcome.blade.php      # Marketing landing page
```

---

## Built By

**Shashank Ranjan** — B.Tech (CSE), Minor in Full-Stack Development

[GitHub](https://github.com/shash-hq) · [LinkedIn](https://www.linkedin.com/in/shash-hq/)

---

## Course Context

Built as the final project for **MVC Programming (PHP Laravel)** — INT221, demonstrating full-stack MVC architecture, authentication systems, role-based access control, and production deployment.
