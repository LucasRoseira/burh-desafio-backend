Ah! Got it 😄. Here's the **entire README in a single code block** ready to copy:

````markdown
# BURH Backend Challenge

## Introduction
This project is a job vacancies API, created for the Backend PHP Developer challenge at [Burh].

The API allows companies to create job postings and users to apply to them.

---

## Technologies

- **Laravel:** 9.52.20  
- **PHP:** 8.0.25  
- **Database:** MySQL (or any compatible SQL database)  
- **L5 Swagger:** API documentation  

---

## Entities and Rules

### Company
- Fields: `name`, `description`, `CNPJ`, `plan`
- Plans:
  - Free: up to 5 jobs
  - Premium: up to 10 jobs

### Job
- Fields: `title`, `description`, `type` (PJ, CLT, Internship), `salary`, `hours`
- Rules:
  - CLT: minimum salary R$1212.00
  - Internship: maximum hours 6
  - PJ: no minimum salary or hours restrictions

### User
- Fields: `name`, `email`, `CPF`, `age`
- Rules:
  - No duplicate users with same email or CPF
  - Users can apply to jobs

---

## Prerequisites

- PHP >= 8.0  
- Composer  
- MySQL (or any compatible SQL database)  
- PHP extensions: `pdo`, `pdo_mysql`, `mbstring`, `tokenizer`, `xml`, `ctype`  

---

## Local Setup

1. **Clone the project**
```bash
git clone <your-fork-url>
cd burh-desafio-backend
````

2. **Install dependencies**

```bash
composer install
```

3. **Configure `.env`**

```bash
cp .env.example .env
```

Edit `.env` to configure your database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=burh_db
DB_USERNAME=root
DB_PASSWORD=
```

4. **Create the database**

```sql
CREATE DATABASE burh_db;
```

5. **Run migrations and seeders (optional)**

```bash
php artisan migrate
php artisan db:seed
```

6. **Generate application key**

```bash
php artisan key:generate
```

7. **Install L5 Swagger**

```bash
# 1. Install L5 Swagger package via Composer
composer require "darkaonline/l5-swagger"

# 2. Publish the configuration and views
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"

# 3. Generate Swagger documentation
php artisan l5-swagger:generate
```

8. **Run the server**

```bash
php artisan serve
```

9. **Access API documentation**
   Open in your browser:

```
http://127.0.0.1:8000/api/documentation#
```

---

## API Endpoints Examples

### Companies

* `GET /api/companies` → List all companies
* `POST /api/companies` → Create a company
* `PUT /api/companies/{id}` → Update a company
* `DELETE /api/companies/{id}` → Delete a company

### Jobs

* `GET /api/jobs` → List all jobs
* `POST /api/jobs` → Create a job
* `POST /api/jobs/{id}/apply` → Apply to a job

### Users

* `GET /api/users/search?name=Lucas` → Search users by name/email/CPF and include jobs
* `POST /api/users` → Create a user

---

## Tests

To run tests:

```bash
php artisan test
```

All `User`, `Company`, and `Job` tests are already implemented and passing.

---

## Notes

* There is no authentication in this project; all routes are publicly accessible.
* Swagger is configured to document all API routes.
* You can use any REST client (Postman, Insomnia, etc.) to test the endpoints.

```

If you want, I can also **add sample request/response examples in the same block** so you can copy everything as one ready-to-use README.  

Do you want me to add that?
```
