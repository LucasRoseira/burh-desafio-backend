Perfeito! Vou atualizar seu README incluindo **uma seção detalhada sobre seeds**, mostrando como rodar todos, específicos ou resetando o banco, para deixar o guia completo:

---

# BURH Backend Challenge

## Requirements

* PHP 8.0+
* Laravel Framework 9.52.20
* Composer
* Docker and Docker Compose
* L5 Swagger (for API documentation)

---

## Project Overview

You are required to build a RESTful API for job listings and user applications:

* **Company**: name, description, CNPJ, plan
* **Job**: title, description, job type, salary, hours
* **User**: name, email, CPF, age

### Features:

* Companies can create jobs.
* Users can apply to jobs.
* Unique email and CPF for users.
* Unique CNPJ for companies.
* Two company plans: `Free` (up to 5 jobs) and `Premium` (up to 10 jobs).
* Job types: `PJ`, `CLT`, `Internship`.

  * CLT and Internship jobs require salary and hours.
  * CLT jobs must have a minimum salary of R\$1212.
  * Internship jobs maximum hours: 6.
* Users search route returns jobs they applied to, filtering by name, email, or CPF.

No authentication is required. You are free to design database fields, extra tables, or relationships as needed.

---

## Docker Setup (Recommended)

### 1️⃣ Project Structure

```
/root
├─ Dockerfile
└─ docker-compose.yml
```

---

### 2️⃣ Configure `.env`

1. Copy `.env.example` to `.env`:

```bash
cp .env.example .env
```

2. Update database credentials to match `docker-compose.yml`:

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=burh_db
DB_USERNAME=burh_user
DB_PASSWORD=secret
```

---

### 3️⃣ Build and Start Docker Containers

```bash
docker-compose up -d --build
```

* `app` → PHP/Laravel container
* `web` → Nginx container on port 8000
* `db` → MySQL container on port 3306

---

### 4️⃣ Install Dependencies and Initialize Laravel

```bash
# Enter the app container
docker exec -it laravel_app bash

# Inside container: install dependencies
composer install

# Generate app key
php artisan key:generate

# Set permissions for storage and cache
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Clear cache
php artisan config:clear
php artisan cache:clear

# Run migrations
php artisan migrate
```

---

### 5️⃣ Run Seeds (Populate Database)

```bash
# Run all seeds
php artisan db:seed

# Run a specific seeder
php artisan db:seed --class=NomeDoSeeder

# Reset database and run migrations + seeds
php artisan migrate:fresh --seed
```

> The `--seed` flag ensures that the database is populated with default or test data after migration.

---

### 6️⃣ Generate API Documentation

```bash
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
php artisan l5-swagger:generate
```

Access documentation at:

```
http://127.0.0.1:8000/api/documentation#
```

---

## Running Tests

```bash
docker exec -it laravel_app bash
php artisan test
```

---

### Notes / Troubleshooting

* If you get **“Connection refused”** errors, make sure `.env` uses `DB_HOST=db` and the `db` container is running.
* If you get **“Permission denied”** errors for logs or views, fix with:

```bash
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

* The `vendor/` folder is required. If missing, run `composer install` inside the container.
* To ensure seeds work correctly, always set the correct database credentials in `.env` and clear cache if needed:

```bash
php artisan config:clear
php artisan cache:clear
```
