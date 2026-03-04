<?php
// FILE: web_dashboard/admin/header.php
if (session_status() == PHP_SESSION_NONE) { session_start(); }

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");
    exit;
}
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}

$page = $_GET['page'] ?? 'users';

function get_nav_class($button_page, $current_page) {
    return $button_page === $current_page ? 'text-white bg-slate-800' : 'text-slate-600 bg-slate-200 hover:bg-slate-300';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

</head>
<body class="bg-slate-100 font-sans">
    <nav class="bg-white border-b border-slate-200 shadow-sm sticky top-0 z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-8">
                    <span class="text-xl font-extrabold text-slate-900">Admin<span class="text-blue-600">.</span></span>
                    <div class="flex items-center space-x-2">
                        <a href="dashboard.php?page=overview" class="px-3 py-2 text-sm font-medium rounded-md transition-all <?= get_nav_class('overview', $page); ?>"><i class="fa-solid fa-chart-pie mr-2"></i>Overview</a>
                        <a href="dashboard.php?page=users" class="px-3 py-2 text-sm font-medium rounded-md transition-all <?= get_nav_class('users', $page); ?>"><i class="fa-solid fa-users mr-2"></i>Users</a>
                        <a href="dashboard.php?page=strategy" class="px-3 py-2 text-sm font-medium rounded-md transition-all <?= get_nav_class('strategy', $page); ?>"><i class="fa-solid fa-sack-dollar mr-2"></i>Strategy</a>
                        <a href="dashboard.php?page=faq" class="px-3 py-2 text-sm font-medium rounded-md transition-all <?= get_nav_class('faq', $page); ?>"><i class="fa-solid fa-circle-question mr-2"></i>FAQ</a>
                        <a href="dashboard.php?page=chat" class="px-3 py-2 text-sm font-medium rounded-md transition-all relative <?= get_nav_class('chat', $page); ?>"><i class="fa-solid fa-comments mr-2"></i>Live Chat</a>
                    </div>
                </div>
                <div class="flex items-center">
                    <span class="text-sm text-slate-600 mr-4">Welcome, <strong><?= htmlspecialchars($_SESSION['admin_username']); ?></strong></span>
                    <a href="dashboard.php?action=logout" class="text-xs bg-red-500 text-white px-3 py-2 rounded-lg font-bold hover:bg-red-600 transition">Logout</a>
                </div>
            </div>
        </div>
    </nav>
    <main class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
