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
  
<h3> 📁 Project Structure </h3>
<pre>
├── admin/                # Admin-related PHP files
├── includes/             # DB connection, auth, etc.
├── uploads/              # Uploaded project files
├── Dockerfile            # PHP + Apache container
├── docker-compose.yml    # Sets up app, MySQL, and phpMyAdmin
├── client_portal.sql     # DB dump
├── *.php, *.css          # Core app files
</pre>
<h3>⚙️ How to Run the Project (Using Docker)</h3>
<pre>
1. <b>Clone the repository</b>
   ```bash
   git clone https://github.com/yassinechk33/Task-Management.git
   cd Task-Management
2. <b>Start the containers</b>
    docker-compose up -d
3. <b>Access the application:</b>
    Web App: http://localhost:8080
    phpMyAdmin: http://localhost:8081
    Username: root
    Password: (leave empty)
4. <b>Import the database</b>
    Open phpMyAdmin
    Import client_portal.sql
</pre>
<h3>✅ Requirements</h3>
    Docker
    Docker Compose
    no need to install any mysql or php everything is inside the contaniers

<h3>📸 Screenshots</h3>
<prep>
  <b>Dashboard</b>
    later i will do that
  <b>Add Project Page</b>
    same for the reste
</prep>
<h3>📄 License</h3>
    This project is open-source and available for educational use.
