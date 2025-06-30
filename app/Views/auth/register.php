<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="auth-container">
    <h2>Register</h2>
    <form action="/register" method="POST" id="registerForm">
        <input type="hidden" name="csrf_token" value="<?php echo generateCsrfToken(); ?>">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn">Register</button>
    </form>
    <p>Already have an account? <a href="/login">Login here</a></p>
</div>

<script src="/assets/js/script.js"></script>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>