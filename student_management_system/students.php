<?php
session_start();
if (!isset($_SESSION['role'])) header("Location: index.php");
include 'includes/connect.php';

$role = $_SESSION['role'];

// Handle CRUD for Admin
if ($role == 'Admin' && $_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $stmt = $conn->prepare("INSERT INTO students (name, age, gender, class, email, phone) VALUES (:name, :age, :gender, :class, :email, :phone)");
        $stmt->execute($_POST);
    } elseif (isset($_POST['update'])) {
        $stmt = $conn->prepare("UPDATE students SET name=:name, age=:age, gender=:gender, class=:class, email=:email, phone=:phone WHERE student_id=:id");
        $stmt->execute(array_merge($_POST, ['id' => $_POST['student_id']]));
    } elseif (isset($_POST['delete'])) {
        $stmt = $conn->prepare("DELETE FROM students WHERE student_id = :id");
        $stmt->execute(['id' => $_POST['student_id']]);
    }
}

// Fetch students
$stmt = $conn->query("SELECT * FROM students");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Students</title>
    <link rel="stylesheet" href="css/tailwind.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/script.js"></script>
</head>
<body>
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Students</h1>
        <a href="dashboard.php" class="text-blue-500 hover:underline mb-4 inline-block">Back to Dashboard</a>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Name</th>
                        <th class="py-2 px-4 border-b">Age</th>
                        <th class="py-2 px-4 border-b">Gender</th>
                        <th class="py-2 px-4 border-b">Class</th>
                        <th class="py-2 px-4 border-b">Email</th>
                        <th class="py-2 px-4 border-b">Phone</th>
                        <?php if ($role == 'Admin') { ?><th class="py-2 px-4 border-b">Actions</th><?php } ?>
                    </tr>
                </thead>
                <tbody id="students-table">
                    <?php foreach ($students as $student) { ?>
                        <tr>
                            <td class="py-2 px-4 border-b"><?php echo $student['student_id']; ?></td>
                            <td class="py-2 px-4 border-b"><?php echo $student['name']; ?></td>
                            <td class="py-2 px-4 border-b"><?php echo $student['age']; ?></td>
                            <td class="py-2 px-4 border-b"><?php echo $student['gender']; ?></td>
                            <td class="py-2 px-4 border-b"><?php echo $student['class']; ?></td>
                            <td class="py-2 px-4 border-b"><?php echo $student['email']; ?></td>
                            <td class="py-2 px-4 border-b"><?php echo $student['phone']; ?></td>
                            <?php if ($role == 'Admin') { ?>
                                <td class="py-2 px-4 border-b">
                                    <button onclick="editStudent(<?php echo json_encode($student); ?>)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-xs">Edit</button>
                                    <form method="post" style="display:inline;"><input type="hidden" name="student_id" value="<?php echo $student['student_id']; ?>"><button type="submit" name="delete" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs ml-2">Delete</button></form>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
        <?php if ($role == 'Admin') { ?>
            <h2 class="text-2xl font-bold mt-8 mb-4">Add/Edit Student</h2>
            <form id="student-form" method="post" class="space-y-4">
                <input type="hidden" name="student_id" id="student_id">
                <div>
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                    <input type="text" name="name" id="name" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div>
                    <label for="age" class="block text-gray-700 text-sm font-bold mb-2">Age:</label>
                    <input type="number" name="age" id="age" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div>
                    <label for="gender" class="block text-gray-700 text-sm font-bold mb-2">Gender:</label>
                    <select name="gender" id="gender" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option>Male</option>
                        <option>Female</option>
                    </select>
                </div>
                <div>
                    <label for="class" class="block text-gray-700 text-sm font-bold mb-2">Class:</label>
                    <input type="text" name="class" id="class" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div>
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                    <input type="email" name="email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div>
                    <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone:</label>
                    <input type="text" name="phone" id="phone" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <button type="submit" name="add" id="submit-btn" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Add</button>
            </form>
        <?php } ?>
    </div>
</body>
</html>
