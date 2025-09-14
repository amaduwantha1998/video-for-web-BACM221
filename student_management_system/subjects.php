<?php
session_start();
if (!isset($_SESSION['role'])) header("Location: index.php");
include 'includes/connect.php';

$role = $_SESSION['role'];

// Handle CRUD for Admin
if ($role == 'Admin' && $_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $stmt = $conn->prepare("INSERT INTO subjects (subject_name, subject_code, description) VALUES (:subject_name, :subject_code, :description)");
        $stmt->execute([
            'subject_name' => $_POST['subject_name'],
            'subject_code' => $_POST['subject_code'],
            'description' => $_POST['description']
        ]);
    } elseif (isset($_POST['update'])) {
        $stmt = $conn->prepare("UPDATE subjects SET subject_name=:subject_name, subject_code=:subject_code, description=:description WHERE subject_id=:id");
        $stmt->execute([
            'subject_name' => $_POST['subject_name'],
            'subject_code' => $_POST['subject_code'],
            'description' => $_POST['description'],
            'id' => $_POST['subject_id']
        ]);
    } elseif (isset($_POST['delete'])) {
        $stmt = $conn->prepare("DELETE FROM subjects WHERE subject_id = :id");
        $stmt->execute(['id' => $_POST['subject_id']]);
    }
}

// Fetch subjects
$stmt = $conn->query("SELECT * FROM subjects");
$subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Subjects</title>
    <link rel="stylesheet" href="css/tailwind.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/script.js"></script>
</head>
<body>
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Subjects</h1>
        <a href="dashboard.php" class="text-blue-500 hover:underline mb-4 inline-block">Back to Dashboard</a>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Name</th>
                        <th class="py-2 px-4 border-b">Code</th>
                        <th class="py-2 px-4 border-b">Description</th>
                        <?php if ($role == 'Admin') { ?><th class="py-2 px-4 border-b">Actions</th><?php } ?>
                    </tr>
                </thead>
                <tbody id="subjects-table">
                    <?php foreach ($subjects as $subject) { ?>
                        <tr>
                            <td class="py-2 px-4 border-b"><?php echo $subject['subject_id']; ?></td>
                            <td class="py-2 px-4 border-b"><?php echo $subject['subject_name']; ?></td>
                            <td class="py-2 px-4 border-b"><?php echo $subject['subject_code']; ?></td>
                            <td class="py-2 px-4 border-b"><?php echo $subject['description']; ?></td>
                            <?php if ($role == 'Admin') { ?>
                                <td class="py-2 px-4 border-b">
                                    <button onclick="editSubject(<?php echo json_encode($subject); ?>)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-xs">Edit</button>
                                    <form method="post" style="display:inline;"><input type="hidden" name="subject_id" value="<?php echo $subject['subject_id']; ?>"><button type="submit" name="delete" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs ml-2">Delete</button></form>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
        <?php if ($role == 'Admin') { ?>
            <h2 class="text-2xl font-bold mt-8 mb-4">Add/Edit Subject</h2>
            <form id="subject-form" method="post" class="space-y-4">
                <input type="hidden" name="subject_id" id="subject_id">
                <div>
                    <label for="subject_name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                    <input type="text" name="subject_name" id="subject_name" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div>
                    <label for="subject_code" class="block text-gray-700 text-sm font-bold mb-2">Code:</label>
                    <input type="text" name="subject_code" id="subject_code" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div>
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                    <textarea name="description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                </div>
                <button type="submit" name="add" id="submit-btn" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Add</button>
            </form>
        <?php } ?>
    </div>
</body>
</html>
