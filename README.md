<h1>🧩 Task Management Portal (PHP + MySQL + Docker)</h1>

A simple task management web application developed in PHP and MySQL, designed to help manage users, projects, and deadlines efficiently.
This project was built and containerized using Docker to ensure easy deployment (maybe in the future).

<h3>🚀 Features </h3>

- User registration & login
- Admin dashboard with project tracking
- Add/Edit/Delete/View projects
- File uploads(not yet)
- Client management system
- Dockerized with PHP, Apache, MySQL, and phpMyAdmin


<h3> 🛠️ Technologies Used </h3>

- PHP
- MySQL
- HTML5 + CSS3
- JavaScript
- XAMPP (for local development) *(just at the beginning the trasnformed fully to docker)
- Docker & Docker Compose
- phpMyAdmin
- 
<h3> 📁 Project Structure </h3>
├── admin/ # Admin-related PHP files
├── includes/ # DB connection, auth, etc.
├── uploads/ # Uploaded project files
├── Dockerfile # PHP + Apache container
├── docker-compose.yml # Sets up app, MySQL, and phpMyAdmin
├── client_portal.sql # DB dump
├── *.php, *.css # Core app files
