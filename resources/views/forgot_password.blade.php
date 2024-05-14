<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
        <h2 class="text-center mb-4">Forgot Password</h2>
        <p class="card-text">Please contact us using the following information to request a password reset:</p>
        <p class="card-text">Phone: 0123456789</p>
        <p class="card-text">Email: <a href="mailto:admin@gmail.com?subject=Reset%20Password&body=title%20%3A%20Yêu%20cầu%20reset%20password%0Acontent%3A%20Họ%20tên%20%3A%20NVA%2C%20Chức%20vụ%20%3A%20teacher(student)%2CID%20teacher(student)%3A%201234324324">admin@gmail.com</a></p>
        <p class="card-text">Please use the following format in your email:</p>
        <p class="card-text">Title: Reset password</p>
        <p class="card-text">Content: Fullname : NVA, Position : Teacher(Student), ID teacher(student): 1234324324</p>
    </div>

    </script>
</body>

</html>