# Business Listing & Rating System

## 📌 Project Overview
This project is a Business Listing & Rating System developed using Core PHP, MySQL, jQuery, AJAX, and Bootstrap.

It allows users to manage businesses and submit ratings with real-time updates without page refresh.

---

## 🚀 Features

### ✅ Business Management (CRUD)
- Add new business using Bootstrap modal
- Edit business details with pre-filled data
- Delete business with confirmation
- Real-time updates using AJAX (no page reload)

### ⭐ Rating System
- Star rating using Raty jQuery plugin
- Supports half-star ratings (0–5 scale)
- Users can submit rating with name, email, or phone
- Existing user (same email or phone) → rating updated
- New user → new rating inserted

### ⚡ Real-Time Updates
- Business list updates instantly
- Ratings update instantly after submission
- No page refresh required

---

## 🛠️ Tech Stack

- PHP (Core PHP, no framework)
- MySQL
- jQuery
- AJAX
- Bootstrap 5
- Raty jQuery Plugin

---

## 🗄️ Database Structure

### businesses
- id (Primary Key)
- name
- address
- phone
- email
- created_at

### ratings
- id (Primary Key)
- business_id (Foreign Key)
- name
- email
- phone
- rating
- created_at

---

## ⚙️ Setup Instructions

1. Clone or download the project

2. Place project inside: 

   C:\xampp\htdocs\

3. Create database: 
   business_rating_system


4. Import the database:
- Open phpMyAdmin
- Import `database.sql`

5. Configure database:
- Go to `config/db.php`
- Update credentials if needed

6. Run project: 
   http://localhost/business-rating-system/


---

## 🔒 Validation

- Name is required
- Phone must be 10 digits
- Email must be valid format

Validation is implemented at:
- Frontend (HTML & JavaScript)
- Backend (PHP)

---

## 📌 Key Highlights

- Clean folder structure
- Modular code (header, footer, JS separation)
- AJAX-based CRUD operations
- Optimized database queries using AVG()
- Proper validation (frontend + backend)
- Real-time UI updates without page reload

---

## 📷 Screenshots (Optional)
### Business Listing Page
![Business Listing](image.png)

### Add Business
![Add Business](image-1.png)

### Edit Business
![Edit Business](image-2.png)

### Rating System
![Rating System](image-3.png)

---

## 👨‍💻 Author
Abhishek Bante