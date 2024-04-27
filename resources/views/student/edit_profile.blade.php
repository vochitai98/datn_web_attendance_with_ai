</html>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Bootstrap demo</title>
</head>

<body>
    <!-- header -->
    @include('student.header')
    <!-- Nội dung trang Class Management -->
    <h6>Profile > Edit</h6>
    @include('edit_profile')

    @include('footer')
</body>

</html>