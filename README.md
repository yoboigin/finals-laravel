# TaskDo - Task Management System

A Laravel final project for managing tasks with full CRUD operations (Create, Read, Update, Delete).

This project uses **SQLite** for the database (no MySQL server required).

## Requirements

- PHP 8.2 or higher (with SQLite extension enabled — included by default in Laragon)
- `https://getcomposer.org/`

## Setup Instructions

1. **Clone or extract** the project into your web directory (e.g. `c:\laragon\www\finals-laravel`).

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Environment file:**
   ```bash
   copy .env.example .env
   php artisan key:generate
   ```

4. **Create the SQLite database file** (if it does not exist yet):
   ```bash
   type nul > database\database.sqlite
   ```

5. **Run migrations** (and optional sample data):
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Start the development server:**
   ```bash
   php artisan serve
   ```

7. Open **http://127.0.0.1:8000/** in your browser.

## Environment Configuration Checklist

Copy `.env.example` to `.env`. For **SQLite**, use these settings:

```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

- Do **not** need `DB_HOST`, `DB_PORT`, `DB_USERNAME`, or `DB_PASSWORD` for SQLite.
- The file `database/database.sqlite` is created locally and is **not** included in Git (see `database/.gitignore`). Each machine must create it before migrating.
- `APP_URL` — optional; set to `http://127.0.0.1:8000` if needed.

## Database Summary

### Relationship Between Tasks and Categories Tables

The TaskDo application uses a **one-to-many relationship** between the `categories` and `tasks` tables:

- **Categories Table**: Stores category records (e.g., Work, Personal, Study) with a unique `name` constraint
- **Tasks Table**: Stores individual task records with a `category_id` foreign key that references `categories.id`
- **Foreign Key Constraint**: `onDelete('cascade')` - if a category is deleted, all its associated tasks are also deleted

### Model Relationships
- **Category Model** has many **Task** records (`hasMany(Task::class)`)
- **Task Model** belongs to one **Category** (`belongsTo(Category::class)`)

## Features

- Dashboard with statistics (pending tasks, urgent deadlines, completed tasks)
- Task list with categories (Work, Personal, Study)
- Add, edit, and delete tasks
- Toggle task completion status
- Due date tracking with overdue indicators
- Form validation
- Delete confirmation prompt
- Success messages after actions

## Submitted By

- Eldrian Aspa (Leader)
- Tristan Bugarin
- Nicollette Lasquite
- Mikyla Lanorio
- Katherine Igni 