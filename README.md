# CakePHP Student Information System

A beginner-friendly CakePHP 5 CRUD application using PostgreSQL.

## Features

- Student listing, search, and pagination
- Add, view, edit, and delete student records
- PostgreSQL migration and optional fictional sample seed
- Bootstrap 5 responsive UI

> Portfolio/demo application only. There is no authentication or authorization yet. Do not store real student personal information until access controls and privacy protections are implemented.

## Requirements

- PHP 8.2+
- Composer 2
- PostgreSQL
- PHP extensions: `intl`, `mbstring`, `pdo`, `pdo_pgsql`, `simplexml`

## Local setup

```powershell
Copy-Item .env.example .env
composer install
php bin/cake.php migrations migrate
php bin/cake.php migrations seed --seed StudentsSeed
php bin/cake.php server
```

Configure `.env` with a PostgreSQL `DATABASE_URL` (Neon connection strings should include `?sslmode=require`) or the individual `DB_*` variables.

## Deploy to Render (Docker + Neon PostgreSQL)

This repository includes `Dockerfile`, `docker/`, and `render.yaml`. Render builds the PHP/Apache container from GitHub.

### 1. Push the complete project to GitHub

Ensure the repository root contains `composer.json`, `Dockerfile`, `render.yaml`, `config/`, `src/`, `templates/`, and `webroot/`.

### 2. Create a Render web service

1. Sign in at https://dashboard.render.com/.
2. Select **New → Blueprint** if you want Render to read `render.yaml`, or **New → Web Service** and connect the GitHub repository.
3. For manual service creation, choose **Docker** as the runtime, Dockerfile path `./Dockerfile`, and the **Free** plan.
4. Select a region and create the service.

Render supports PHP using Docker. Free web services sleep after 15 minutes without traffic and can take about a minute to wake. Their local filesystem is ephemeral; use PostgreSQL for persistent data. Free services have no SSH/shell access and no persistent disk.

### 3. Add environment variables

In Render → service → **Environment**, set:

| Key | Value |
|---|---|
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_URL` | `https://YOUR-SERVICE.onrender.com` |
| `SECURITY_SALT` | Generate a long random secret |
| `DATABASE_URL` | Your Neon PostgreSQL connection string |
| `RUN_MIGRATIONS` | `true` for initial deployment |

For Neon, copy the connection string from the Neon dashboard. It should look like:

```text
postgresql://USER:PASSWORD@HOST/DBNAME?sslmode=require
```

Use the pooled connection string if appropriate for your Neon plan. Treat this string as a password: never commit it to GitHub or paste it into public issues.

`SECURITY_SALT` can be generated locally:

```powershell
php -r "echo bin2hex(random_bytes(32)), PHP_EOL;"
```

The included `render.yaml` generates a salt automatically when using a Blueprint; review the generated value in Render's Environment page.

### 4. Run the migration

The entrypoint runs pending migrations on container startup when `RUN_MIGRATIONS=true`. Keep this enabled for the first deployment so the `students` table is created. Once the first deployment succeeds, you may set it to `false` to avoid running migration checks at every restart. When you later add migrations, set it to `true` for that deployment again.

Do not enable the sample seed in production automatically. If you want demo rows, seed a development database locally or use a controlled one-off process.

### 5. Deploy and test

1. Trigger **Manual Deploy → Deploy latest commit**.
2. Check the deploy logs for Composer installation, Apache startup, and successful migration.
3. Open the `onrender.com` URL.
4. Test listing, adding, editing, searching, and deleting a fictional student.

## Important free-tier limitations

- Free web services spin down after 15 minutes idle and may take around one minute to wake.
- The filesystem is ephemeral. Do not save uploads or important files to local disk.
- Free web services have no SSH/shell access and no persistent disk.
- Render's free PostgreSQL database expires after 30 days. This project uses Neon instead, so keep the Neon database active and backed up.
- Free instances are intended for testing/hobby use, not production.

## Routes

| URL | Purpose |
|---|---|
| `/` or `/students` | Student directory |
| `/students/add` | Add student |
| `/students/view/1` | View student |
| `/students/edit/1` | Edit student |

IDs depend on your database.

## Security and privacy

This beginner portfolio application currently has no login/authentication or role-based access. Anyone who can reach the deployed URL may be able to view and modify student records. Use fictional data only until authentication, authorization, CSRF/security review, and privacy safeguards are added.
