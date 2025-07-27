# 🔥 Laravel Firebase Task Viewer

This is a **Laravel 10** project that integrates **Firebase Authentication** and **Firestore** with a MySQL database to display user-specific tasks. Authenticated users can log in via Firebase (email/password) and view tasks assigned to them from Firestore in a dynamic, responsive UI.

---

## 🚀 Features

- 🔐 Firebase Authentication (Email/Password)
- 📦 Firestore for storing tasks
- 💾 MySQL integration for user roles and metadata
- ⚙️ AJAX-based task loading using jQuery
- 📋 Protected routes using Laravel middleware
- 🎨 Clean and responsive Bootstrap-based UI

---

## 📁 Folder Structure

firebase-task-viewer/
├── app/
├── public/
├── resources/
│ └── views/
│ ├── login.blade.php
│ └── dashboard.blade.php
├── routes/
│ └── web.php
├── database/
│ ├── migrations/
│ └── seeders/
├── .env
└── README.md

yaml
Copy
Edit

---

## 🛠️ Setup Instructions

Follow the steps below to set up and run the project:

### 1. Clone the Repository

```bash
git clone https://github.com/Bhaskar1308/firebase-task.git
cd firebase-task
2. Install Dependencies
composer install
npm install && npm run dev
3. Configure .env
Copy the .env.example to .env:


cp .env.example .env
Update the following variables:
env
APP_NAME=FirebaseTaskViewer
APP_URL=http://localhost:8000

DB_DATABASE=your_db_name
DB_USERNAME=root
DB_PASSWORD=

FIREBASE_API_KEY=your_firebase_api_key
FIREBASE_AUTH_DOMAIN=your_project.firebaseapp.com
FIREBASE_PROJECT_ID=your_project_id
🔐 Firebase credentials should also be configured in public/js/firebase.js.

4. Generate Application Key
php artisan key:generate

5. Run Migrations and Seeder

php artisan migrate --seed
🧩 Users Table Structure (MySQL)
The users table is used to store extra metadata about Firebase-authenticated users.

Field	Type	Description
id	BIGINT	Primary key (auto increment)
user_id	STRING	Firebase UID
name	STRING	Full name
email	STRING	Email address
role	ENUM	admin, user, or viewer
created_at	TIMESTAMP	Laravel default
updated_at	TIMESTAMP	Laravel default

🔥 Firestore Structure
Collection: tasks

Each document:

user_id (Firebase UID)

title

description

status (e.g., pending, completed)

due_date

🧪 How to Run the Project
php artisan serve
Visit: http://localhost:8000
