# Job Portal

### Job Portal Web Application

Modern responsive веб-приложение для поиска и размещения вакансий, разработанное на PHP, MySQL и Bootstrap 5.

Система объединяет три основные группы пользователей — **соискателей, работодателей и администраторов** — и предоставляет каждой роли собственный набор функций и интерфейс управления.

Проект разработан с модульной структурой PHP, разделением функциональности по ролям и использованием PDO для безопасной работы с базой данных.

---

## Features

### Job Seekers

Соискатели могут:

* регистрироваться и авторизовываться;
* создавать и редактировать профиль;
* загружать CV / резюме;
* просматривать вакансии;
* искать вакансии;
* фильтровать вакансии;
* откликаться на вакансии;
* отслеживать статус откликов;
* сохранять вакансии в избранное.

### Employers

Работодатели могут:

* регистрироваться и авторизовываться;
* создавать вакансии;
* редактировать вакансии;
* управлять опубликованными вакансиями;
* просматривать отклики на конкретную вакансию;
* управлять кандидатами;
* редактировать профиль компании.

### Administration

Административная часть позволяет:

* управлять пользователями;
* управлять соискателями и работодателями;
* управлять вакансиями;
* управлять категориями;
* изменять настройки сайта;
* просматривать статистику через dashboard.

### Additional Features

* password hashing;
* PDO prepared statements;
* pagination;
* поиск и фильтрация;
* flash messages;
* AJAX / JSON endpoints;
* адаптивный интерфейс;
* переиспользуемые PHP-компоненты.

---

## Application Flow

Основные сценарии использования системы:

```text
Job Seeker
    │
    ├── Register
    ├── Create Profile
    ├── Upload CV
    ├── Browse Jobs
    ├── Search / Filter
    ├── Apply
    └── Track Applications


Employer
    │
    ├── Register
    ├── Create Company Profile
    ├── Create Job
    ├── Manage Jobs
    └── Manage Applicants


Admin
    │
    ├── Manage Users
    ├── Manage Jobs
    ├── Manage Categories
    ├── Site Settings
    └── Dashboard Statistics
```

---

## Architecture

Проект использует модульную архитектуру на чистом PHP без PHP-фреймворка.

Основные части приложения разделены по назначению:

```text
Request
   │
   ▼
Public Pages
   │
   ▼
Authentication / Helpers
   │
   ▼
Application Modules
   │
   ├── User
   ├── Employer
   └── Admin
   │
   ▼
PDO
   │
   ▼
MySQL / MariaDB
```

### Configuration

`config/` содержит конфигурационные файлы приложения, включая настройки базы данных, константы и ACL.

### Includes

`includes/` содержит общие PHP-компоненты:

* подключение к базе данных;
* authentication helpers;
* вспомогательные функции;
* общую логику приложения.

### Templates

`templates/` содержит переиспользуемые элементы интерфейса:

* header;
* footer;
* navbar;
* alerts.

### Public

`public/` содержит публичные страницы приложения:

* главную страницу;
* страницы вакансий;
* login;
* register;
* uploads.

### User

`user/` содержит функциональность кабинета соискателя:

* dashboard;
* профиль;
* отклики;
* связанные пользовательские операции.

### Employer

`employer/` содержит функциональность работодателя:

* dashboard;
* управление вакансиями;
* управление кандидатами.

### Admin

`admin/` содержит административную панель:

* пользователи;
* вакансии;
* категории;
* настройки;
* статистика.

### API

`api/` содержит AJAX / JSON endpoints для динамических операций приложения.

---

## Project Structure

```text
job-portal/
│
├── config/
│   ├── DB configuration
│   ├── Constants
│   └── ACL
│
├── includes/
│   ├── Database connection
│   ├── Authentication
│   └── Helper functions
│
├── templates/
│   ├── Header
│   ├── Footer
│   ├── Navbar
│   └── Alerts
│
├── assets/
│   ├── CSS
│   ├── JavaScript
│   └── Images
│
├── public/
│   ├── index
│   ├── jobs
│   ├── login
│   ├── register
│   └── uploads
│
├── user/
│   ├── Dashboard
│   ├── Profile
│   └── Applications
│
├── employer/
│   ├── Dashboard
│   ├── Jobs
│   └── Applicants
│
├── admin/
│   ├── Users
│   ├── Jobs
│   ├── Categories
│   └── Settings
│
├── api/
│   └── AJAX / JSON endpoints
│
├── sql/
│   └── Database schema
│
├── tests/
│   └── Basic test scripts
│
└── README.md
```

---

## Tech Stack

### Backend

* PHP 8+
* Pure PHP
* PDO
* Modular PHP architecture

### Database

* MySQL
* MariaDB

### Frontend

* HTML5
* CSS3
* Bootstrap 5
* Vanilla JavaScript

### Authentication & Security

* Password hashing
* Prepared statements
* Role-based access control

### Additional

* AJAX
* JSON endpoints
* Pagination
* Search
* Filtering
* Flash messages

---

## Database

Database schema находится в:

```text
sql/schema.sql
```

Проект использует реляционную базу данных для хранения информации, связанной с:

* пользователями;
* работодателями;
* вакансиями;
* категориями;
* откликами;
* профилями;
* настройками приложения.

---

## Installation

### Requirements

Для запуска проекта требуется:

* PHP 8+
* MySQL или MariaDB
* веб-сервер;
* Bootstrap 5 и frontend-зависимости проекта.

Для локальной разработки можно использовать:

* XAMPP;
* Laragon;
* OSPanel;
* другой локальный PHP-сервер.

### 1. Clone repository

```bash
git clone https://github.com/smoook92/job-portal.git
cd job-portal
```

### 2. Create database

Создайте базу данных:

```sql
CREATE DATABASE job_portal;

USE job_portal;
```

Затем импортируйте схему:

```sql
SOURCE sql/schema.sql;
```

### 3. Configure database

Откройте:

```text
config/config.php
```

и укажите параметры подключения:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'job_portal');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### 4. Configure uploads

Каталог:

```text
public/uploads
```

должен быть доступен для записи приложению.

В Linux:

```bash
chmod 755 public/uploads
```

### 5. Start application

Для локальной разработки используйте настроенный веб-сервер.

После запуска приложение будет доступно по адресу:

```text
http://localhost/job-portal/public/
```

---

## User Roles

Система построена вокруг трёх основных ролей:

| Role         | Responsibilities                                         |
| ------------ | -------------------------------------------------------- |
| `Job Seeker` | Профиль, CV, поиск вакансий, отклики                     |
| `Employer`   | Компания, вакансии, кандидаты                            |
| `Admin`      | Пользователи, вакансии, категории, настройки, статистика |

Разделение ролей позволяет каждой категории пользователей работать только с соответствующей частью приложения.

---

## Security

В проекте используются базовые механизмы защиты веб-приложения:

### Password Hashing

Пароли пользователей не должны храниться в базе данных в открытом виде.

### PDO Prepared Statements

Для запросов к базе данных используются подготовленные выражения PDO, что позволяет безопаснее работать с пользовательскими данными.

### Access Control

Различные разделы приложения разделены по ролям:

```text
Job Seeker
     │
     └── User Dashboard

Employer
     │
     └── Employer Dashboard

Admin
     │
     └── Administration Panel
```

---

## Application Modules

### Job Management

Работа с вакансиями включает:

* создание;
* редактирование;
* управление;
* поиск;
* фильтрацию;
* pagination.

### Application Management

Соискатели могут отправлять отклики и отслеживать их статус.

Работодатели могут просматривать отклики по своим вакансиям и управлять кандидатами.

### User Management

Администратор может управлять пользователями различных типов.

### Categories

Администратор может создавать и управлять категориями вакансий.

### Site Settings

Административная часть содержит раздел управления настройками сайта.

---

## Development

Проект построен таким образом, чтобы функциональность была разделена на отдельные модули.

При добавлении нового функционала рекомендуется:

```text
1. Определить необходимую роль пользователя
2. Добавить или изменить соответствующий модуль
3. Реализовать серверную логику
4. При необходимости добавить API endpoint
5. Обновить database schema
6. Добавить необходимые UI-компоненты
7. Проверить доступ согласно роли пользователя
```

---

## Tests

Базовые тестовые скрипты находятся в:

```text
tests/
```

---

## Project Status

Проект является полноценным практическим веб-приложением для работы с вакансиями и пользователями.

Основная цель разработки — практика создания модульного PHP-приложения с несколькими ролями пользователей, базой данных, административной панелью и разделением функциональности по модулям.

---

## License

Проект распространяется как open-source.

---

## Author

**smook92**

GitHub: [github.com/smoook92](https://github.com/smoook92)

Portfolio: [smoook.ru](https://smoook.ru)
