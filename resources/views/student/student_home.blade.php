</html>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            margin-bottom: 20px;
        }

        .card-title {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border-radius: 5px 5px 0 0;
            margin: -20px -20px 10px -20px;
        }

        .list-group-item {
            border: none;
        }
    </style>
</head>

<body>
    <!-- header -->
    @include('student.header')
    <div class="main-content">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Home page</a></li>
            </ol>
        </nav>
        <br>
        <div class="container">
            <h3 class="text-center mb-4">Student Information</h3>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-title text-center">
                            Personal Information
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Name:</strong> {{$student_infor->name}}</li>
                            <li class="list-group-item"><strong>Date of Birth:</strong>{{$student_infor->dayofbirth}}</li>
                            <li class="list-group-item"><strong>Gender:</strong>Male</li>
                            <li class="list-group-item"><strong>Email:</strong>{{$student_infor->email}}</li>
                            <li class="list-group-item"><strong>Phone Number:</strong>{{$student_infor->phone}}</li>
                            <li class="list-group-item"><strong>Address:</strong>{{$student_infor->address}}</li>
                            <li class="list-group-item"><strong>Student ID:</strong>{{$student_infor->identification}}</li>
                        </ul>
                    </div>
                    <div class="card">
                        <div class="card-title text-center">
                            Class Information
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Class Name:</strong>{{$student_infor->className}}</li>
                            <li class="list-group-item"><strong>Homeroom Teacher:</strong>{{$student_infor->teacherName}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>