# Lore

> An online video directory for entrepreneurs — discover real founder journeys, honest failures, and what actually works.

[![Live Demo](https://img.shields.io/badge/Live%20Demo-Visit%20Site-D4542A?style=for-the-badge)](DEPLOY_URL_HERE)
[![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.5-777BB4?style=for-the-badge&logo=php)](https://php.net)
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

---

## Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 12 (PHP 8.5) |
| Frontend | Blade Templates + Tailwind CSS |
| Fonts | Playfair Display + DM Sans + JetBrains Mono |
| Auth | Laravel Breeze + Google OAuth (Socialite) |
| Database | SQLite (local) / MySQL (production) |
| Build | Vite 7 |
| Deploy | Railway.app |

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

# Configure your database in .env
# DB_CONNECTION=sqlite (default, no setup needed)

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

## Project Structure

```
app/
├── Http/Controllers/
│   ├── Admin/          # AdminController, AdminVideoController
│   ├── HomeController       # Homepage + category filtering
│   ├── VideoController      # Video detail + view tracking
│   ├── SearchController     # Full-text search
│   ├── EntrepreneurController
│   ├── BookmarkController
│   ├── DashboardController
│   └── SocialiteController  # Google OAuth
├── Models/
│   ├── User.php        # Roles: admin/creator/viewer
│   ├── Video.php       # Slug auto-generation, relationships
│   ├── Category.php
│   └── Tag.php
resources/views/
├── layouts/            # app.blade.php, admin.blade.php
├── admin/              # Admin panel views
├── videos/             # Video detail page
├── entrepreneurs/      # Profile pages
├── home.blade.php      # Masonry homepage
├── search.blade.php    # Search results
├── dashboard.blade.php # User watchlist
└── welcome.blade.php   # Marketing landing page
```

---

## Built By

**Shashank Ranjan** — B.Tech (CSE), Minor in Full-Stack Development

[GitHub](https://github.com/shash-hq) · [LinkedIn](https://www.linkedin.com/in/shash-hq/)

---

## Course Context

Built as the final project for **MVC Programming (PHP Laravel)** — INT221, demonstrating full-stack MVC architecture, authentication systems, role-based access control, and production deployment.