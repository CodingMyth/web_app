<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="auth-container">
    <h2>Login</h2>
    <?php if (!empty($error)): ?>
    <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>
<?php if (!empty($errors)): ?>
    <div class="alert error">
        <?php foreach ($errors as $err): ?>
            <div><?php echo htmlspecialchars($err); ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
    <form action="/login" method="POST" id="loginForm">
        <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn">Login</button>
    </form>
    <p>Don't have an account? <a href="/register">Register here</a></p>
</div>

<script src="/assets/js/script.js"></script>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>