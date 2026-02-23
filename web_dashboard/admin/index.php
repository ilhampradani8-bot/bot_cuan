<?php
// Start session to handle potential login error messages
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - TradingSafe</title>
    <!-- Include Tailwind CSS for styling -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 flex items-center justify-center h-screen">

    <div class="w-full max-w-md p-8 space-y-6 bg-white shadow-lg rounded-xl border border-slate-200">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Admin Panel<span class="text-blue-600">.</span></h1>
            <p class="mt-2 text-sm text-slate-500">Please sign in to access the dashboard.</p>
        </div>

        <!-- Login Form -->
        <form class="space-y-6" action="auth.php" method="POST">
            <!-- Display login error if any -->
            <?php if (isset($_GET['error'])): ?>
            <div class="p-3 bg-red-50 text-red-700 text-sm rounded-lg border border-red-200">
                Invalid username or password. Please try again.
            </div>
            <?php endif; ?>
            
            <div>
                <label for="username" class="text-sm font-bold text-slate-700 sr-only">Username</label>
                <input type="text" name="username" id="username" placeholder="Username" required 
                       class="w-full px-4 py-3 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="password" class="text-sm font-bold text-slate-700 sr-only">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" required
                       class="w-full px-4 py-3 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <button type="submit" 
                        class="w-full px-4 py-3 font-bold text-white bg-slate-900 rounded-lg hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 transition">
                    Sign In
                </button>
            </div>
        </form>
    </div>

</body>
</html>
