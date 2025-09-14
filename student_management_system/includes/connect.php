<?php
// This file would contain database connection logic.
// For now, we'll use an in-memory SQLite database for demonstration.

try {
    $conn = new PDO("sqlite::memory:");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create students table if it doesn't exist
    $conn->exec("CREATE TABLE IF NOT EXISTS students (
        student_id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        age INTEGER,
        gender TEXT,
        class TEXT,
        email TEXT,
        phone TEXT
    )");

    // Create subjects table if it doesn't exist
    $conn->exec("CREATE TABLE IF NOT EXISTS subjects (
        subject_id INTEGER PRIMARY KEY AUTOINCREMENT,
        subject_name TEXT NOT NULL,
        subject_code TEXT NOT NULL UNIQUE,
        description TEXT,
        credits INTEGER
    )");

    // Insert some mock data if the subjects table is empty
    $count = $conn->query("SELECT COUNT(*) FROM subjects")->fetchColumn();
    if ($count == 0) {
        $conn->exec("INSERT INTO subjects (subject_name, subject_code, description, credits) VALUES ('Mathematics', 'MATH101', 'Introduction to basic mathematical concepts', 3)");
        $conn->exec("INSERT INTO subjects (subject_name, subject_code, description, credits) VALUES ('Physics', 'PHY101', 'Fundamentals of classical mechanics and thermodynamics', 4)");
        $conn->exec("INSERT INTO subjects (subject_name, subject_code, description, credits) VALUES ('Chemistry', 'CHE101', 'Basic principles of chemistry and chemical reactions', 3)");
    }

    // Insert some mock data if the students table is empty
    $count = $conn->query("SELECT COUNT(*) FROM students")->fetchColumn();
    if ($count == 0) {
        $conn->exec("INSERT INTO students (name, age, gender, class, email, phone) VALUES ('Alice Smith', 20, 'Female', 'Computer Science', 'alice@example.com', '123-456-7890')");
        $conn->exec("INSERT INTO students (name, age, gender, class, email, phone) VALUES ('Bob Johnson', 22, 'Male', 'Software Engineering', 'bob@example.com', '098-765-4321')");
    }

    // Create enrollments table if it doesn't exist
    $conn->exec("CREATE TABLE IF NOT EXISTS enrollments (
        enrollment_id INTEGER PRIMARY KEY AUTOINCREMENT,
        student_id INTEGER NOT NULL,
        subject_id INTEGER NOT NULL,
        enrollment_date TEXT NOT NULL,
        FOREIGN KEY (student_id) REFERENCES students(student_id),
        FOREIGN KEY (subject_id) REFERENCES subjects(subject_id)
    )");

    // Insert some mock data if the enrollments table is empty
    $count = $conn->query("SELECT COUNT(*) FROM enrollments")->fetchColumn();
    if ($count == 0) {
        $conn->exec("INSERT INTO enrollments (student_id, subject_id, enrollment_date) VALUES (1, 1, '2023-09-01')");
        $conn->exec("INSERT INTO enrollments (student_id, subject_id, enrollment_date) VALUES (1, 2, '2023-09-01')");
        $conn->exec("INSERT INTO enrollments (student_id, subject_id, enrollment_date) VALUES (2, 1, '2023-09-05')");
    }

    // Create users table if it doesn't exist
    $conn->exec("CREATE TABLE IF NOT EXISTS users (
        user_id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL,
        role TEXT NOT NULL
    )");

    // Insert some mock data if the users table is empty
    $count = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
    if ($count == 0) {
        $conn->exec("INSERT INTO users (username, password, role) VALUES ('admin', '" . md5('adminpass') . "', 'Admin')");
        $conn->exec("INSERT INTO users (username, password, role) VALUES ('teacher', '" . md5('teacherpass') . "', 'Teacher')");
        $conn->exec("INSERT INTO users (username, password, role) VALUES ('student', '" . md5('studentpass') . "', 'Student')");
    }

} catch(PDOException $e) {
    error_log("Connection failed: " . $e->getMessage());
    die("Connection failed: " . $e->getMessage());
}
?>
