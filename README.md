# Job Portal Web Application

A **modern, responsive Job Portal** web application built with **PHP, MySQL, and Bootstrap 5**.  
This platform allows **job seekers** to create profiles and apply for jobs, **employers** to post and manage jobs, and **administrators** to manage the entire system. Fully modular, secure, and designed for scalability.

---

## 🚀 Features

### Job Seekers
- Register and login securely
- Create and edit personal profiles
- Upload CV / resume
- Browse, search, and filter jobs
- Apply to jobs and track application status
- Save/favorite jobs for later

### Employers
- Register and login securely
- Create, edit, and manage job listings
- View and manage applicants per job
- Edit company profile

### Admin
- Manage users (job seekers and employers)
- Manage jobs and categories
- Configure site settings
- Dashboard with live statistics

### Extra Features
- Secure authentication using **password hashing**
- Responsive design using **Bootstrap 5**
- Modular PHP structure with reusable components
- Prepared statements with PDO for secure database queries
- Pagination and search/filter for jobs
- Flash messages for notifications

---

## 📂 Project Structure

/job-portal
│
├── /config # Configuration files: DB, constants, ACL
├── /includes # PHP helper functions, auth, DB connection
├── /templates # Header, footer, navbar, alerts
├── /assets # CSS, JS, images
├── /public # Public pages: index, jobs, login, register, uploads
├── /user # Job seeker dashboard, profile, applications
├── /employer # Employer dashboard, jobs, applicants
├── /admin # Admin panel: users, jobs, categories, settings
├── /api # AJAX/JSON endpoints
├── /sql # Database schema
├── /tests # Basic test scripts
└── README.md


---

## 🛠 Technology Stack

- **Backend:** PHP 8+, PDO for database access  
- **Database:** MySQL / MariaDB  
- **Frontend:** Bootstrap 5, HTML5, CSS3, Vanilla JavaScript  
- **Architecture:** Modular PHP with reusable templates  
- **Authentication:** Secure login/register with password hashing  

---

## ⚙️ Installation

1. Clone the repository:

```bash
git clone https://github.com/smoook92/job-portal
cd job-portal

2. Set up your MySQL database:
CREATE DATABASE job_portal;
USE job_portal;

-- Import schema
SOURCE sql/schema.sql;

3. Configure database credentials in /config/config.php:
define('DB_HOST', 'localhost');
define('DB_NAME', 'job_portal');
define('DB_USER', 'root');
define('DB_PASS', '');

4. Ensure /public/uploads folder is writable for CV uploads:
chmod 755 public/uploads

5. Run the application via local server (e.g., XAMPP, Laragon, OSPanel):
http://localhost/job-portal/public/

📝 Usage

Job Seekers: Register → Edit profile → Browse jobs → Apply

Employers: Register → Create jobs → Manage applicants

Admin: Log in with admin user → Manage users, jobs, categories, settings

💡 Contributing

Contributions are welcome!
Feel free to submit issues, feature requests, or pull requests. Please ensure:

Code is clean and follows existing structure

New features include basic testing

Security best practices are maintained

📄 License

This project is open-source. You are free to use and modify it.

🌟 Demo

A working demo can be accessed after setup via your local server:
http://localhost/job-portal/public/