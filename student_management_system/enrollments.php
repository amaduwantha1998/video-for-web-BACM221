<?php
session_start();
if (!isset($_SESSION['role'])) header("Location: index.php");
include 'includes/connect.php';

$role = $_SESSION['role'];

// Handle CRUD for Admin
if ($role == 'Admin' && $_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $stmt = $conn->prepare("INSERT INTO enrollments (student_id, subject_id, enrollment_date) VALUES (:student_id, :subject_id, :enrollment_date)");
        $stmt->execute([
            'student_id' => $_POST['student_id'],
            'subject_id' => $_POST['subject_id'],
            'enrollment_date' => $_POST['enrollment_date']
        ]);
    } elseif (isset($_POST['update'])) {
        $stmt = $conn->prepare("UPDATE enrollments SET student_id=:student_id, subject_id=:subject_id, enrollment_date=:enrollment_date WHERE enrollment_id=:id");
        $stmt->execute([
            'student_id' => $_POST['student_id'],
            'subject_id' => $_POST['subject_id'],
            'enrollment_date' => $_POST['enrollment_date'],
            'id' => $_POST['enrollment_id']
        ]);
    } elseif (isset($_POST['delete'])) {
        $stmt = $conn->prepare("DELETE FROM enrollments WHERE enrollment_id = :id");
        $stmt->execute(['id' => $_POST['enrollment_id']]);
    }
}

// Fetch enrollments (for Student role, show all for simplicity; enhance if needed)
$stmt = $conn->query("SELECT e.*, s.name AS student_name, sub.subject_name FROM enrollments e JOIN students s ON e.student_id = s.student_id JOIN subjects sub ON e.subject_id = sub.subject_id");
$enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch students and subjects for dropdowns
$students = $conn->query("SELECT student_id, name FROM students")->fetchAll(PDO::FETCH_ASSOC);
$subjects = $conn->query("SELECT subject_id, subject_name FROM subjects")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enrollments</title>
    <link rel="stylesheet" href="css/tailwind.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/script.js"></script>
</head>
<body>
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Enrollments</h1>
        <a href="dashboard.php" class="text-blue-500 hover:underline mb-4 inline-block">Back to Dashboard</a>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Student</th>
                        <th class="py-2 px-4 border-b">Subject</th>
                        <th class="py-2 px-4 border-b">Date</th>
                        <?php if ($role == 'Admin') { ?><th class="py-2 px-4 border-b">Actions</th><?php } ?>
                    </tr>
                </thead>
                <tbody id="enrollments-table">
                    <?php foreach ($enrollments as $enrollment) { ?>
                        <tr>
                            <td class="py-2 px-4 border-b"><?php echo $enrollment['enrollment_id']; ?></td>
                            <td class="py-2 px-4 border-b"><?php echo $enrollment['student_name']; ?></td>
                            <td class="py-2 px-4 border-b"><?php echo $enrollment['subject_name']; ?></td>
                            <td class="py-2 px-4 border-b"><?php echo $enrollment['enrollment_date']; ?></td>
                            <?php if ($role == 'Admin') { ?>
                                <td class="py-2 px-4 border-b">
                                    <button onclick="editEnrollment(<?php echo json_encode($enrollment); ?>)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-xs">Edit</button>
                                    <form method="post" style="display:inline;"><input type="hidden" name="enrollment_id" value="<?php echo $enrollment['enrollment_id']; ?>"><button type="submit" name="delete" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs ml-2">Delete</button></form>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
        <?php if ($role == 'Admin') { ?>
            <h2 class="text-2xl font-bold mt-8 mb-4">Add/Edit Enrollment</h2>
            <form id="enrollment-form" method="post" class="space-y-4">
                <input type="hidden" name="enrollment_id" id="enrollment_id">
                <div>
                    <label for="student_id" class="block text-gray-700 text-sm font-bold mb-2">Student:</label>
                    <select name="student_id" id="student_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <?php foreach ($students as $student) { ?>
                            <option value="<?php echo $student['student_id']; ?>"><?php echo $student['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div>
                    <label for="subject_id" class="block text-gray-700 text-sm font-bold mb-2">Subject:</label>
                    <select name="subject_id" id="subject_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <?php foreach ($subjects as $subject) { ?>
                            <option value="<?php echo $subject['subject_id']; ?>"><?php echo $subject['subject_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div>
                    <label for="enrollment_date" class="block text-gray-700 text-sm font-bold mb-2">Date:</label>
                    <input type="date" name="enrollment_date" id="enrollment_date" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <button type="submit" name="add" id="submit-btn" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Add</button>
            </form>
        <?php } ?>
    </div>
</body>
</html>
