# Laravel + React E-Commerce

A personal full-stack learning project exploring e-commerce application development with **Laravel 11**, **React 18**, **TypeScript**, and **Inertia.js**.

> **Project status:** Work in progress. This repository is a learning and development project, not a production-ready online store. Some routes and features are incomplete.

## Project overview

The project combines a Laravel backend with a React frontend using Inertia.js. It focuses on modelling catalogue data, rendering product listings, and exploring common application concepts such as authentication, relational data, and media handling.

## Tech stack

| Area | Technologies |
| --- | --- |
| Backend | PHP 8.2+, Laravel 11, Eloquent ORM |
| Frontend | React 18, TypeScript, Inertia.js, Vite, Tailwind CSS |
| Authentication | Laravel Breeze; Laravel Sanctum is included as a dependency |
| Admin and permissions | Filament 3 and Spatie Laravel Permission (dependencies included) |
| Media | Spatie Media Library |
| Testing tools | Pest (development dependency) |
| Database | SQLite in the provided `.env.example`; Laravel supports other database configurations |

*Listed dependencies do not necessarily mean that all of their features are fully implemented.*

## Implemented in the codebase

- Product model with Eloquent relationships for users, departments, categories, and product variations.
- Query scopes for published products and vendor-owned products.
- Product listing controller that retrieves published products with pagination (12 per page) and passes data to an Inertia page.
- Media conversion definitions for product thumbnails and different image sizes.
- Authentication-related routes and profile-management routes.
- Database seeders for roles, users, departments, and categories.

## Work in progress

- Complete the product detail controller and page (the route exists, but the controller method is currently empty).
- Verify the end-to-end catalogue experience and prepare application screenshots.
- Expand and test e-commerce workflows before claiming a complete shopping or checkout experience.
- Add application-specific automated tests and document their results.

## Local setup

### Prerequisites

- PHP 8.2 or newer
- Composer
- Node.js and npm
- SQLite (for the default example configuration), or another database supported by your local Laravel setup

### Installation

```bash
git clone https://github.com/Nueseybe/laravel-react-ecommerce.git
cd laravel-react-ecommerce

composer install
npm install

cp .env.example .env
php artisan key:generate
```

On Windows PowerShell, use `Copy-Item .env.example .env` instead of `cp` if needed.

The repository's example configuration uses SQLite. Create the database file if necessary:

```bash
# macOS / Linux
mkdir -p database
touch database/database.sqlite
```

On Windows, create an empty `database/database.sqlite` file manually if it does not exist.

Then run:

```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
```

Start the backend and frontend in separate terminals:

```bash
php artisan serve
```

```bash
npm run dev
```

Visit the local URL printed by Laravel (commonly `http://127.0.0.1:8000`).

> **Setup note:** These are standard commands based on the repository's configuration. Installation and seed data have not been independently tested in a fresh environment. Adjust your `.env` database settings as necessary.

## Project structure

```text
app/                 Laravel models, controllers and application logic
database/            Database migrations, factories and seeders
resources/           React / Inertia frontend assets and views
routes/              Web routes and authentication routes
tests/               Test files
```

## Purpose

I created this project to practise connecting a Laravel backend to a modern React/TypeScript frontend and to deepen my understanding of Eloquent relationships, catalogue logic, routing, and full-stack application development.

## Author

[Nueseybe on GitHub](https://github.com/Nueseybe)
