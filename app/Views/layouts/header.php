<?php 
if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <ul>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="/tasks">Tasks</a></li>
                        <li><a href="/logout">Logout (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a></li>
                    <?php else: ?>
                        <li><a href="/login">Login</a></li>
                        <li><a href="/register">Register</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert success">
                <?php echo htmlspecialchars($_SESSION['success_message']); ?>
                <?php unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert error">
                <?php echo htmlspecialchars($_SESSION['error_message']); ?>
                <?php unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>
    </div>