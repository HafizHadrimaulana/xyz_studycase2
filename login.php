<?php
session_start();
require_once 'config/database.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['user_id'] = 1;
        $_SESSION['username'] = 'Admin';
        header('Location: index.php');
        exit;
    } else {
        $error = 'Username atau password salah!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - XYZ System</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/xyz_studycase2/assets/vendor/adminlte/plugins/fontawesome-free/css/all.min.css">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="/xyz_studycase2/assets/vendor/adminlte/dist/css/adminlte.min.css">
    <!-- Cosmic Glassmorphism CSS -->
    <link rel="stylesheet" href="/xyz_studycase2/assets/css/login.css">
</head>
<body class="hold-transition login-page cosmic-login">
<div class="login-box">
    <!-- Logo -->
    <div class="login-logo">
        <a href="index.php"><b>XYZ</b> System</a>
    </div>

    <!-- Login Card -->
    <div class="card cosmic-card">
        <div class="card-body login-card-body">
            <p class="login-box-msg"><b>Sign in to start your session</b></p>
            
            <?php if ($error): ?>
            <div class="alert alert-danger cosmic-alert"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
            <form action="login.php" method="post" class="cosmic-form">
                <!-- Username Input -->
                <div class="input-group mb-4">
                    <input type="text" 
                           name="username" 
                           class="form-control cosmic-input" 
                           placeholder="Username" 
                           required
                           autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text cosmic-input-group">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                
                <!-- Password Input -->
                <div class="input-group mb-4">
                    <input type="password" 
                           name="password" 
                           class="form-control cosmic-input" 
                           placeholder="Password" 
                           required>
                    <div class="input-group-append">
                        <div class="input-group-text cosmic-input-group">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                
                <!-- Submit Button -->
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block cosmic-btn">
                            <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
    <!-- /.card -->
    
    <!-- Cosmic Footer -->
    <div class="cosmic-footer">
        <p class="mb-0">© <?= date('Y') ?> XYZ System</p>
    </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="/xyz_studycase2/assets/vendor/adminlte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/xyz_studycase2/assets/vendor/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/xyz_studycase2/assets/vendor/adminlte/dist/js/adminlte.min.js"></script>
<!-- Cosmic Effects -->
<script>
$(document).ready(function() {
    // Add parallax effect to nebula background
    $(document).mousemove(function(e) {
        const x = e.pageX / $(window).width();
        const y = e.pageY / $(window).height();
        $('body').css('background-position', x*50 + '% ' + y*50 + '%');
    });
    
    // Add focus effects to inputs
    $('.cosmic-input').focus(function() {
        $(this).parent().find('.cosmic-input-group').css({
            'border-color': '#8a5cf6',
            'box-shadow': '0 0 0 0.2rem rgba(138, 92, 246, 0.25)'
        });
    }).blur(function() {
        $(this).parent().find('.cosmic-input-group').css({
            'border-color': 'rgba(255, 255, 255, 0.2)',
            'box-shadow': 'none'
        });
    });
});
</script>
</body>
</html>