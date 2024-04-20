<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: 0 auto;
            margin-top: 100px;
        }
    </style>
</head>

<body>
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <div class="container login-container">
        <h2 class="text-center mb-4">Login</h2>
        <form id="loginForm" action="{{ route('login_handle') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="rememberMe">
                <label class="form-check-label" for="rememberMe">Remember me</label>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
        <div class="text-center mt-3">
            <a href="#">Forgot password?</a>
        </div>
        <hr>
        <div class="text-center mt-3">
            <p>Don't have an account? <a href="{{ route('student.register') }}" id="showRegisterForm">Register here</a>.</p>
        </div>
    </div>

    </script>
</body>

</html>