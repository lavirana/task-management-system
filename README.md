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

## 📝 Activity Logging

Every important action on a task is logged for tracking and transparency.
Example: “Ashish changed task status to Completed.”
Helps in understanding task history and user activity.

## 🔔 Email & System Notifications

Implemented using Laravel Notifications.
Users receive notifications when:
A task is assigned to them
A task due date is approaching
Notifications can be sent via email and displayed inside the application (bell icon).

## 📎 File Attachments

Users can upload relevant files (documents, images, screenshots) directly to a task.
Implemented using Laravel Media Library or basic file storage.
Supports multiple attachments per task for better collaboration.

## 📁 Project Grouping

Introduced a Projects module to organize tasks efficiently.
Each task can belong to a specific project (e.g., Website Redesign, Mobile App).
Improves clarity, scalability, and project-wise task management.

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

   
## Project Screenshots

<img width="1421" height="768" alt="Screenshot 2026-02-10 at 2 02 51 PM" src="https://github.com/user-attachments/assets/e8ebf442-425b-42e4-a9d1-a4d82c7cf34f" />

<img width="1427" height="768" alt="Screenshot 2026-02-10 at 2 02 57 PM" src="https://github.com/user-attachments/assets/9dcbb235-292a-4ca0-83c0-0e727c430fc7" />

<img width="1429" height="775" alt="Screenshot 2026-02-10 at 2 03 03 PM" src="https://github.com/user-attachments/assets/37fe32bc-1803-48bb-b411-3620dbc7c699" />

<img width="1427" height="773" alt="Screenshot 2026-02-10 at 2 03 10 PM" src="https://github.com/user-attachments/assets/14d20e08-a55c-4136-b4d8-1f300273bffb" />

<img width="1425" height="775" alt="Screenshot 2026-02-10 at 2 03 29 PM" src="https://github.com/user-attachments/assets/dc88bd1d-94c4-4c9d-8ba8-52ebf4b9e65d" />

<img width="1420" height="775" alt="Screenshot 2026-02-10 at 2 03 37 PM" src="https://github.com/user-attachments/assets/8bb4ac98-4f74-4ad1-920f-962609cbee2a" />

<img width="1440" height="783" alt="Screenshot 2026-02-20 at 3 19 15 PM" src="https://github.com/user-attachments/assets/b9958cdb-e09e-4a5d-b786-267003683517" />

