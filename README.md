# 📚 Library Management System (PHP + MySQL)

A simple Library Management System built using **PHP**, **MySQL**, and **Bootstrap**.  
It allows users to register, login, search books, request book issues, and manage their issued books.  
Admins can manage users, approve issue requests, and monitor library activity.

---

## 🚀 Features

### 👤 User
- Register and login securely
- Search books by title, author, or category
- Request and issue available books instantly
- View all issued books with return date
- Update profile and change password

### 🧑‍💼 Admin
- Add, update, or remove books from the library
- Manage users (view or delete accounts)
- Track issued and returned books
- View fines or penalties for overdue books
- Dashboard overview with total users, books, and issued record

---

## ⚙️ Tech Stack
- **Frontend:** HTML, CSS, Bootstrap 5
- **Backend:** PHP 8
- **Database:** MySQL
- **Server:** XAMPP / Apache

---

## 🗂️ Database Setup

1. Open **phpMyAdmin**
2. Create a new database named `library_db`
3. Import the provided `library_db.sql` file
4. Update your `includes/db.php` file with correct credentials:
   ```php
   $conn = new mysqli('localhost', 'root', '', 'library_db');

## 💻 How to Run

1. Copy the project folder into your htdocs directory (C:\xampp\htdocs\).
2. Start Apache and MySQL from the XAMPP Control Panel.
3. Open your browser and go to:
👉 http://localhost/library_management_system/
4. Register a new user or log in using the sample credentials below.

## 🧑‍💻 Sample Login Credentials

### 🔹 Admin Login
| Email  | Username | Password |
|--------|-----------|-----------|
| admin@library.com | `admin`   | `admin123` |

### 🔹 User Login
| Email | Username | Password |
|------|-----------|-----------|
| user@gmail.com | `user`   | `user123` |

---

### ⚙️ Note

- Make sure to keep your includes/db.php file updated with your MySQL credentials.
- You can modify books, users, and issued_books tables in phpMyAdmin to test different scenarios.

