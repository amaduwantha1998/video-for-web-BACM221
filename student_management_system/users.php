<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'Admin') header("Location: index.php");
include 'includes/connect.php';

// Handle CRUD
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $password = md5($_POST['password']);
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
        $stmt->execute(['username' => $_POST['username'], 'password' => $password, 'role' => $_POST['role']]);
    } elseif (isset($_POST['update'])) {
        $password = !empty($_POST['password']) ? md5($_POST['password']) : $existing_password;  // Keep old if empty
        $stmt = $conn->prepare("UPDATE users SET username=:username, password=:password, role=:role WHERE user_id=:id");
        $stmt->execute(['username' => $_POST['username'], 'password' => $password, 'role' => $_POST['role'], 'id' => $_POST['user_id']]);
    } elseif (isset($_POST['delete'])) {
        $stmt = $conn->prepare("DELETE FROM users WHERE user_id = :id");
        $stmt->execute(['id' => $_POST['user_id']]);
    }
}

// Fetch users
$stmt = $conn->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Users</title>
    <link rel="stylesheet" href="css/tailwind.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/script.js"></script>
</head>
<body>
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Users</h1>
        <a href="dashboard.php" class="text-blue-500 hover:underline mb-4 inline-block">Back to Dashboard</a>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Username</th>
                        <th class="py-2 px-4 border-b">Role</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody id="users-table">
                    <?php foreach ($users as $user) { ?>
                        <tr>
                            <td class="py-2 px-4 border-b"><?php echo $user['user_id']; ?></td>
                            <td class="py-2 px-4 border-b"><?php echo $user['username']; ?></td>
                            <td class="py-2 px-4 border-b"><?php echo $user['role']; ?></td>
                            <td class="py-2 px-4 border-b">
                                <button onclick="editUser(<?php echo json_encode($user); ?>)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-xs">Edit</button>
                                <form method="post" style="display:inline;"><input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>"><button type="submit" name="delete" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs ml-2">Delete</button></form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
        <h2 class="text-2xl font-bold mt-8 mb-4">Add/Edit User</h2>
        <form id="user-form" method="post" class="space-y-4">
            <input type="hidden" name="user_id" id="user_id">
            <div>
                <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username:</label>
                <input type="text" name="username" id="username" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div>
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password:</label>
                <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"> (Leave blank to keep current)
            </div>
            <div>
                <label for="role" class="block text-gray-700 text-sm font-bold mb-2">Role:</label>
                <select name="role" id="role" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option>Admin</option>
                    <option>Teacher</option>
                    <option>Student</option>
                </select>
            </div>
            <button type="submit" name="add" id="submit-btn" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Add</button>
        </form>
    </div>
</body>
</html>
