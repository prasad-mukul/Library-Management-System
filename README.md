# 📚 Library Management System (PHP + MySQL)

A simple Library Management System built using **PHP**, **MySQL**, and **Bootstrap**.  
It allows users to register, login, search books, request book issues, and manage their issued books.  
Admins can manage users, approve issue requests, and monitor library activity.

---

## 🚀 Features

### 👤 User
- Register and login securely
- Search books by title, author, or category
- Request book issue (Pending → Approved flow)
- View issued books and return status

### 🧑‍💼 Admin
- Approve or reject issue requests
- Manage users (add/delete)
- Track issued books and penalties
- Add or remove books from the library

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
