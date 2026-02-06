# Task Management System (Laravel)

A simple and practical **Task Management System** built with **Laravel**, designed to manage tasks with status, priority, due dates, and assigned users.  
This project focuses on clean backend logic, CRUD operations, and AJAX-based updates without page reloads.

---

## 🚀 Features

- Create, edit, view, and delete tasks (CRUD)
- Assign tasks to users dynamically
- Change task status (Pending / In Progress / Completed)
- Change task priority (Low / Medium / High)
- Update assigned date using AJAX
- Filter tasks by status and priority
- Task count API (used for dashboard statistics)
- Authentication-based task creation (Admin)
- Clean and simple UI

---

## 🛠️ Tech Stack

- **Backend:** PHP, Laravel
- **Frontend:** Blade, HTML, CSS, JavaScript
- **AJAX:** Fetch API
- **Database:** MySQL
- **Authentication:** Laravel Auth

---

## 📂 Project Structure (Key Files)

- `TaskController.php` – Handles all task logic
- `Task` Model – Task database interactions
- Blade Views:
  - `tasks/index.blade.php`
  - `tasks/create.blade.php`
  - `tasks/edit.blade.php`
- Routes defined in `web.php`

---

## 🔄 Available Functionalities (API-style)

| Action | Route |
|------|------|
| Get tasks | `/tasks` |
| Create task | `/store` |
| Assign user | `/tasks/assign_user` |
| Change status | `/tasks/change_status` |
| Change priority | `/tasks/change_priority` |
| Update assigned date | `/tasks/update_assigned_date` |
| Task count | `/task_count/{status?}` |

---

## 🧠 What This Project Demonstrates

- Laravel MVC architecture
- Eloquent relationships
- Request validation
- REST-style controller methods
- AJAX updates without page refresh
- Clean and readable backend code
- Practical real-world task logic

---

## ⚙️ Setup Instructions

1. Clone the repository
   ```bash
   git clone https://github.com/lavirana/task-management-system.git


![alt text](<Screenshot 2026-02-03 at 10.48.19 AM.png>)

![alt text](<Screenshot 2026-02-04 at 5.06.33 PM.png>)

![alt text](<Screenshot 2026-02-05 at 11.47.32 AM.png>)

![alt text](<Screenshot 2026-02-06 at 11.58.19 PM.png>)