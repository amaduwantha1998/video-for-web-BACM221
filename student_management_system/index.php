<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Management System - Login</title>
    <link rel="stylesheet" href="css/tailwind.css">
</head>
<body class="bg-gray-100 flex h-screen justify-center items-center">
    

    <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
        <img src="public/nibm.png" class="w-10 mx-auto mb-6" style="width: 200px;" alt="">
        <h1 class="text-2xl font-bold mb-2 text-center">Student Management System</h1>
         <h2 class="text-sm text-gray-600 font-medium mb-6 text-center">This application is for the NIBM BACM221 Badge Video for Web Module.</h2>
        <form action="login_process.php" method="post" class="space-y-4">
            <label for="username" class="block text-gray-700 text-sm font-bold ">Username:</label>
            <input type="text" id="username" name="username" required class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            
            <label for="password" class="block text-gray-700 text-sm font-bold ">Password:</label>
            <input type="password" id="password" name="password" required class="shadow appearance-none border  rounded-lg w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline">
            
            
            
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mt-4 rounded-lg focus:outline-none focus:shadow-outline w-full">Login</button>
        </form>

        <div class="mt-4 p-6 border rounded-lg border-gray-300">
            <p class="text-gray-600 text-sm mb-3 ">This application is built with PHP, Tailwind, and SQL. Please ensure everything is running smoothly.</p>
            <p class="text-gray-600 text-sm  ">Username: admin</p>
            <p class="text-gray-600 text-sm  ">Password: password</p>
        </div>
   
</div>

</body>
</html>
