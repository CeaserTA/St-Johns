# St-Johns — Project Analysis & Developer README

This README contains a comprehensive analysis of the St-Johns Laravel application found in this repository. It documents structure, configuration, routes, controllers, models, views, database schema, middleware, tests, dependencies, runtime flow, pain points, and recommended improvements.

> Note: This file is an automatically generated project analysis prepared to help developers onboard and prioritize next tasks.

---

## Summary
- Type: Laravel project (Laravel 12 / PHP ^8.2).
- Purpose: Church website with public pages, member registration, event/service registrations, and an admin dashboard for managing members, events, services, announcements, and groups.

Key areas: `app/`, `config/`, `database/`, `resources/views/`, `routes/`, `tests/`, `public/`.

---

## 1) Project Structure Overview

- Root files: `composer.json`, `package.json`, `artisan`, `README.md`.
- Key folders:
	- `app/` — application code (controllers, models, middleware, providers, view components).
	- `config/` — configuration files (`app.php`, `database.php`, `auth.php`, etc.).
	- `database/` — `migrations/`, `factories/`, `seeders/`.
	- `public/` — `index.php`, `script.js`, `styles.css`, `assets/`.
	- `resources/views/` — Blade templates and components.
	- `routes/` — `web.php`, `auth.php`, `console.php`.
	- `storage/`, `tests/`, `vendor/`.

Deviations / notes:
- Some migrations and code use camelCase column names (e.g., `dateOfBirth`) instead of Laravel's conventional snake_case. This should be standardized or documented to avoid confusion.
- Multiple migrations related to `groups` exist; check migration order for correctness.

---

## 2) Configuration Files

- `composer.json`: PHP ^8.2, `laravel/framework` ^12.0. Dev packages include `laravel/breeze`, `pestphp/pest`, `fakerphp/faker`.
- `config/app.php`: standard app settings (name, env, debug, timezone, locale, key).
- `config/database.php`: default `sqlite` connection, configs for mysql/mariadb/pgsql/sqlsrv, Redis settings.
- `config/auth.php`: default guard `web`, provider `users` -> `App\\Models\\User`.

Important env variables used:
- `APP_NAME`, `APP_ENV`, `APP_DEBUG`, `APP_KEY`, `APP_URL`
- `DB_CONNECTION`, `DB_DATABASE`, `DB_HOST`, `DB_USERNAME`, `DB_PASSWORD`
- Redis: `REDIS_HOST`, `REDIS_PASSWORD`, etc.

Impact: Default `sqlite` is convenient for local dev; production must use a persistent DB. `users` provider and `role` (added via migration) power admin authorization.

---

## 3) Routes

- Files: `routes/web.php`, `routes/auth.php`.
- Public routes: `/`, `/index`, `/home`, `/events`, `/services`, member registration `POST /members`, group join `POST /groups/join`, service registration `GET|POST /service-register`, event registration `POST /event-registrations` (AJAX-friendly).
- Auth routes: registration, login, password reset, email verification (Breeze-style controllers in `app/Http/Controllers/Auth`).
- Admin routes: prefixed/admin-like routes protected by `middleware('admin')` (requires `EnsureUserIsAdmin`). Admin CRUD endpoints for events, services, announcements, groups, members listing.

Request lifecycle (typical): `public/index.php` -> Kernel (global middleware) -> Router (route middleware) -> Controller -> Model -> View/JSON -> Response -> terminating middleware.

Note: Ensure `EnsureUserIsAdmin` is registered in `app/Http/Kernel.php` with alias `admin`.

---

## 4) Controllers (high level)

Controllers are in `app/Http/Controllers/` and `app/Http/Controllers/Admin/`.

- `MemberController`: member CRUD, dashboard metrics, file uploads (stores images to `public` disk), group attach via pivot.
- `EventController` / `ServiceController`: public listing and show actions.
- `EventRegistrationController` / `ServiceRegistrationController`: registration storage and admin listing; `EventRegistrationController@store` returns JSON (AJAX).
- `GroupJoinController`: public flow for joining a group by email; has `joinFromModal` optional helper.
- `Auth/*` controllers: Breeze-derived auth logic plus `AdminAuthenticatedSessionController` that enforces `role === 'admin'`.
- `Admin/*` controllers: CRUD for events, services, groups, announcements; use inline validation and redirect with flash messages.

Notes:
- Validation is performed inline (`$request->validate()`); consider `FormRequest` classes to centralize validation and authorization.
- Some admin index controllers return unpaginated `->get()` for lists — convert to pagination for large datasets.

---

## 5) Models

Located in `app/Models/`:
- `User`: `fillable` includes `role`, `casts()` defines `email_verified_at` and `password`.
- `Member`: `$fillable` uses camelCase fields; `groups()` belongsToMany via `group_member`; mutators normalize `gender` and `maritalStatus`.
- `Group`: `$fillable` + `members()` pivot.
- `Service`, `ServiceRegistration` (table `service_registrations`), `Event`, `EventRegistration` (table `event_registrations`), `Announcement`.

Recommendations:
- Add `$casts` for date/datetime fields.
- Add missing Eloquent relationships (e.g., `EventRegistration::event()` belongsTo `Event`).
- Standardize column naming (snake_case preferred) or provide accessors.

---

## 6) Views

- Blade templates are in `resources/views/` with layout files in `resources/views/layouts/` and admin pages in `resources/views/admin/`.
- Tailwind CSS is used (CDN and compiled `styles.css`).
- Some pages render full HTML while others extend layouts — standardize to `@extends` to avoid duplication.
- Client-side JS: modals and AJAX for event registrations in `events.blade.php` and registration UI in `index.blade.php`.

---

## 7) Database Layer

Migrations in `database/migrations/` include:
- `users` table (default) and `2025_11_30_add_role_to_users_table.php` to add `role` enum.
- `members` table (uses camelCase column names), `events`, `services`, `announcements`, `service_registrations`, `event_registrations`, `groups`, `group_member` pivot.

Notes:
- `group_member` pivot uses `foreignId(...)->constrained()` with cascading deletes.
- `event_registrations.event_id` is not constrained in migration — consider adding a `foreignId` constraint to maintain referential integrity.

Running migrations locally:
```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
npm install
npm run dev
```

---

## 8) Middleware & Authentication

- `app/Http/Middleware/EnsureUserIsAdmin.php` enforces `auth()->user()->role === 'admin'` and redirects non-admins.
- Auth uses Breeze-like controllers and Laravel's standard features (email verification, password reset).
- No policies found in the codebase — authorization is role-based at present.

Recommendation: register `admin` middleware alias in `app/Http/Kernel.php` and add resource policies for fine-grained control.

---

## 9) Services, Jobs, Helpers

- No dedicated `Services/` folder or queued jobs/events were found; business logic is implemented primarily in controllers.
- Blade components (Breeze) exist in `resources/views/components/`.

Recommendation: extract service classes for complex operations (member creation + group attach, file storage) for testability.

---

## 10) Testing

- `tests/` includes Pest & PHPUnit tests, primarily covering authentication and profile flows.
- Coverage for domain-specific flows (member registration, event/service registrations, admin CRUD) appears limited.

Recommendation: add feature tests for member registration, event registration (AJAX), admin CRUD, and pivot operations.

---

## 11) Dependencies (from `composer.json`)

- `laravel/framework` ^12.0
- `laravel/tinker`
- Dev: `laravel/breeze`, `pestphp/pest`, `fakerphp/faker`, `nunomaduro/collision`, `mockery`

---

## 12) How Everything Works Together (High-level)

1. HTTP request enters via `public/index.php`.
2. Laravel bootstrap -> HTTP Kernel -> Middleware -> Router selects a route.
3. Route middleware (`auth`, `admin`) run, then controller action executes.
4. Controller validates input, uses Eloquent models to read/write DB.
5. Controller returns a Blade view or JSON response.
6. Response passed to middleware and returned to the client.

Example: Event registration flow — user posts JSON to `/event-registrations`, `EventRegistrationController@store` validates and creates a DB record, returns JSON 201 for the UI.

---

## 13) Pain Points & Code Smells (observed)

- Inconsistent DB column naming using camelCase (possible source of bugs).
- Repeated validation rules across controllers; fat controllers with business logic.
- Unpaginated admin queries (`->get()` on large tables).
- Missing foreign key constraints (e.g., `event_registrations.event_id`).
- Minimal authorization beyond `role` checks; no policies/gates.
- Some views include complete HTML rather than extending a shared layout.

---

## 14) Improvements & Recommendations (prioritized)

1. Standardize DB column naming (or map attributes); prefer snake_case.
2. Create `FormRequest` classes for validation and authorization.
3. Move business logic to service classes and thin controllers.
4. Add foreign keys and indexes; paginate admin listings and eager-load relationships.
5. Expand tests to cover app-specific flows and add CI to run tests.
6. Harden security: CSP, rate limits, sanitize inputs, verify file upload restrictions.

---

## 15) Quick Action Checklist

- Confirm `admin` middleware alias in `app/Http/Kernel.php`.
- Add `foreignId()->constrained()` for `event_registrations.event_id` if safe.
- Convert admin controllers to use pagination and eager loading.
- Add `FormRequest` classes for `Member`, `Event`, `Service`, `Announcement` operations.
- Add/extend tests for registration and admin flows.

---

## 16) Next Steps I Can Do (choose any)

1. Confirm `admin` middleware registration in `app/Http/Kernel.php`.
2. Generate `FormRequest` classes and apply them to controllers.
3. Create a migration to add a foreign key constraint to `event_registrations.event_id`.
4. Add pagination to admin index methods and update views.
5. Add feature tests for `MemberController@store` and `EventRegistrationController@store`.

Tell me which of the above you'd like me to implement and I will proceed.

---

File references:
- `app/Http/Controllers/MemberController.php`
- `app/Http/Middleware/EnsureUserIsAdmin.php`
- `routes/web.php`
- `resources/views/events.blade.php`, `resources/views/services.blade.php`, `resources/views/index.blade.php`
- `database/migrations/*`

---

Generated on: 2026-01-03

