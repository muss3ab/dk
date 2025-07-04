# Laravel Blogging Platform API
A comprehensive Laravel RESTful API for a blogging platform, implementing all core requirements and bonus features as specified in the test document.

---

## 🚀 Setup Instructions
1. **Clone the repository:**
    ```bash
    git clone https://github.com/muss3ab/dk
    cd blog-api
    ```

2. **Install PostgreSQL**  
   Ensure PostgreSQL is installed and running on your system.

3. **Install dependencies:**
    ```bash
    composer install
    ```

4. **Configure environment:**  
   Copy `.env.example` to `.env` and update database credentials for PostgreSQL.

5. **Run migrations, seeders, and tests:**
    ```bash
    php artisan migrate --seed
    php artisan test
    php artisan serve
    ```

---

## 📋 Key Features

- RESTful API with proper HTTP status codes
- Comprehensive validation and custom error messages
- Policy-based authorization
- Resource transformation for API responses
- Soft deletes for data integrity
- 100% feature test coverage
- Clean architecture following Laravel best practices

---

## 🧪 Postman Collection

A ready-to-use Postman collection is provided for testing all endpoints.

### Collection Features

- **Organized structure:** Auth, Posts, Comments, Categories, Validation, Test Scenarios
- **Environment variables:** `baseUrl`, `token`, `userId`, `postId`, `categoryId`
- **Automated testing:** Response validation, token management, error handling, performance checks
- **Security:** Bearer token authentication, authorization headers, unauthenticated/authorization policy testing

### How to Use

1. **Import the Collection:**
    - Copy the provided Postman collection JSON
    - Open Postman → Import → Raw text → Paste JSON

2. **Set Up Environment:**
    - Ensure your Laravel API is running at `http://localhost:8000`
    - Environment variables are auto-managed

---

## 📄 License

This project is open-source and available under the [MIT license](LICENSE).
