# 📘 Laravel Blog API

A simple **Blog Management System** built with **Laravel Version 10**, featuring:
- User authentication (login, logout, token-based auth with Sanctum)
- Blog CRUD (create, read, update, delete)
- Like/Unlike blogs
- Filters (latest blogs, most liked blogs)
- Seeder data for users & blogs

---

## ⚙️ Requirements
- PHP >= 8.1
- Composer
- MySQL (or any supported DB)
- Node.js & NPM (for frontend assets if using)

---

## 🚀 Installation

composer install

cp .env.example .env
php artisan key:generate
php artisan storage:link
composer require laravel/sanctum

DB_DATABASE=blog_management_api
DB_USERNAME=rot
DB_PASSWORD=

Blog Table Migration
Like Table Migration

php artisan migrate --seed

This will create:
Users:
10 dummy users
10 blogs with images


📡 API Endpoints
# Auth
POST /api/login → Login user
GET /api/logout → Logout current session
POST /api/logout-all → Logout from all devices

# Blogs
GET /api/blogs → List all blogs (filters: latest, most liked)
POST /api/blogs → Create a new blog (auth required)
GET /api/blogs/{id} → Show single blog
PUT /api/blogs/{id} → Update blog (owner only)
DELETE /api/blogs/{id} → Delete blog (owner only)

# Likes and Unlikes
POST /api/blogs/{id}/like → Like a blog
<<<<<<< HEAD
POST /api/blogs/{id}/unlike → Unlike a blog
=======
POST /api/blogs/{id}/unlike → Unlike a blog
>>>>>>> 3f93fe1d0e5103ae352c66f9520627c0b868fb1a
