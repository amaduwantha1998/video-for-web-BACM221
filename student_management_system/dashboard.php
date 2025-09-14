<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Include database connection
include 'includes/connect.php';

// Fetch student count and recent students
$student_count = 0;
$recent_students = [];
try {
    $stmt = $conn->query("SELECT COUNT(*) FROM students");
    $student_count = $stmt->fetchColumn();
    
    $stmt = $conn->query("SELECT name, class FROM students ORDER BY student_id DESC LIMIT 5");
    $recent_students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    error_log("Error fetching students: " . $e->getMessage());
}

// Fetch subject count and subjects
$subject_count = 0;
$subjects = [];
try {
    $stmt = $conn->query("SELECT COUNT(*) FROM subjects");
    $subject_count = $stmt->fetchColumn();
    
    $stmt = $conn->query("SELECT subject_name, subject_code FROM subjects ORDER BY subject_id LIMIT 5");
    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    error_log("Error fetching subjects: " . $e->getMessage());
}

// Fetch enrollment count and recent enrollments
$enrollment_count = 0;
$recent_enrollments = [];
try {
    $stmt = $conn->query("SELECT COUNT(*) FROM enrollments");
    $enrollment_count = $stmt->fetchColumn();
    
    $stmt = $conn->query("
        SELECT s.name as student_name, sub.subject_name, e.enrollment_date 
        FROM enrollments e 
        JOIN students s ON e.student_id = s.student_id 
        JOIN subjects sub ON e.subject_id = sub.subject_id 
        ORDER BY e.enrollment_id DESC LIMIT 5
    ");
    $recent_enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    error_log("Error fetching enrollments: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/script.js"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-6">
        <!-- Header with Logo and Navigation -->
        <div class="flex items-center justify-between bg-white border-b p-4 rounded-lg shadow-sm">
            <img src="public/nibm.png" class="w-48" alt="NIBM Logo">
            <nav class="space-x-4">
                <a href="students.php" class="text-blue-500 hover:underline">Students</a>
                <a href="subjects.php" class="text-blue-500 hover:underline">Subjects</a>
                <a href="enrollments.php" class="text-blue-500 hover:underline">Enrollments</a>
                <?php if ($_SESSION['role'] == 'Admin') { ?>
                    <a href="users.php" class="text-blue-500 hover:underline">Users</a>
                <?php } ?>
                <a href="logout.php" class="text-red-500 hover:underline">Logout</a>
            </nav>
        </div>

        <!-- Welcome Message -->
        <h1 class="text-3xl font-bold text-gray-800 mt-6 mb-4">Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?> (<?php echo htmlspecialchars($_SESSION['role'] ?? ''); ?>)</h1>

        <!-- Summaries and Video -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
            <!-- Student Summary -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Student Summary</h2>
                <p class="text-2xl font-bold text-blue-600"><?php echo $student_count; ?> Students</p>
                <h3 class="text-lg font-medium text-gray-600 mt-4">Recent Students</h3>
                <ul class="mt-2">
                    <?php foreach ($recent_students as $student) { ?>
                        <li class="text-gray-600"><?php echo htmlspecialchars($student['name'] ?? ''); ?> (<?php echo htmlspecialchars($student['class'] ?? ''); ?>)</li>
                    <?php } ?>
                </ul>
            </div>

            <!-- Subject Summary -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Subject Summary</h2>
                <p class="text-2xl font-bold text-blue-600"><?php echo $subject_count; ?> Subjects</p>
                <h3 class="text-lg font-medium text-gray-600 mt-4">Available Subjects</h3>
                <ul class="mt-2">
                    <?php foreach ($subjects as $subject) { ?>
                        <li class="text-gray-600"><?php echo htmlspecialchars($subject['subject_name'] ?? ''); ?> (<?php echo htmlspecialchars($subject['subject_code'] ?? ''); ?>)</li>
                    <?php } ?>
                </ul>
            </div>

            <!-- Enrollment Summary -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Enrollment Summary</h2>
                <p class="text-2xl font-bold text-blue-600"><?php echo $enrollment_count; ?> Enrollments</p>
                <h3 class="text-lg font-medium text-gray-600 mt-4">Recent Enrollments</h3>
                <ul class="mt-2">
                    <?php foreach ($recent_enrollments as $enrollment) { ?>
                        <li class="text-gray-600"><?php echo htmlspecialchars($enrollment['student_name']); ?> - <?php echo htmlspecialchars($enrollment['subject_name']); ?> (<?php echo $enrollment['enrollment_date']; ?>)</li>
                    <?php } ?>
                </ul>
            </div>

            <!-- Intro Video -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Introduction Video</h2>
                <div class="relative" style="padding-top: 56.25%;">
                    <iframe class="absolute top-0 left-0 w-full h-full" 
                            src="https://www.youtube.com/embed/Jv-an5ul_AE" 
                            title="Student Management System Intro" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
