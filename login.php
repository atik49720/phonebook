<?php
session_start();
include 'include/header.php';
include 'config/db.php';
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
}
?>
<div class="container d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="card shadow-sm p-4" style="width: 100%; max-width: 400px;">
        <h3 class="text-center mb-3">Login</h3>
        <form method="POST" action="actions.php">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" id="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
            <p class="text-center mt-3">Don't have an account? <a href="register.php">Register here</a>.</p>
        </form>
    </div>
</div>

<?php include 'include/footer.php'; ?>