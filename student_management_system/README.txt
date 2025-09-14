Student Management System

This directory contains the files for a simple student management system.

Directory Structure:
- css/: Contains CSS stylesheets (e.g., style.css)
- js/: Contains JavaScript files (e.g., script.js)
- includes/: Contains PHP include files (e.g., connect.php for database connection)

Main Files:
- index.php: Login page
- dashboard.php: Main dashboard after successful login
- students.php: Page for managing student records
- subjects.php: Page for managing subjects
- enrollments.php: Page for managing student enrollments in subjects
- users.php: Page for managing system users
- login_process.php: Handles the login authentication logic
- logout.php: Handles user logout
- README.txt: This file, providing an overview of the project.

How to Run:
1. Ensure you have PHP and a web server (e.g., XAMPP, WAMP, MAMP) installed on your machine.
2. Place the 'student_management_system' directory inside your web server's root directory (e.g., 'htdocs' for XAMPP).
3. Create a MySQL database and import the required tables (refer to any provided SQL files or create tables as needed).
4. Update 'includes/connect.php' with your database credentials.
5. Start your web server and navigate to 'http://localhost/student_management_system/index.php' in your browser.
6. Log in using the provided credentials or create a new user via the 'users.php' page.
