# BURH Backend Challenge

## Requirements

-   PHP 8.0+
-   Laravel Framework 9.52.20
-   Composer
-   Docker and Docker Compose
-   L5 Swagger (for API documentation)

---

## Project Overview

You are required to build a RESTful API for job listings and user applications:

-   **Company**: name, description, CNPJ, plan
-   **Job**: title, description, job type, salary, hours
-   **User**: name, email, CPF, age

### Requirements:

-   Companies can create jobs.
-   Users can apply to jobs.
-   Unique email and CPF for users.
-   Unique CNPJ for companies.
-   Two company plans: `Free` (up to 5 jobs) and `Premium` (up to 10 jobs).
-   Job types: `PJ`, `CLT`, `Internship`.
-   CLT and Internship jobs require salary and hours.
-   CLT jobs must have minimum salary of R$1212.
-   Internship jobs maximum hours: 6.
-   Users search route returns jobs they applied to, filtering by name, email, or CPF.

No authentication is required. You are free to design database fields, extra tables, or relationships as needed.

---

## Docker Setup (Recommended)

### 1️⃣ Docker Structure
```

/root
├─ Dockerfile
└─ docker-compose.yml

```

### 2️⃣ Commands to Start

# Configuring .env.example

- Copy the .env.example file to .env
- Update the database credentials accordingly with the docker-compose file

`db`: burh_db
`user`: burh_user
`password`: secret

# Build and start containers
docker-compose up -d --build

# Enter the app container
docker exec -it laravel_app bash

# Inside container: install dependencies
composer install
php artisan key:generate
php artisan migrate --seed   # seeds run automatically

# Generate API documentation
- php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
- php artisan l5-swagger:generate

# Access documentation
http://127.0.0.1:8000/api/documentation#
```

## Running Tests

docker exec -it laravel_app bash
php artisan test

