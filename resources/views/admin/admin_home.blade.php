<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance Class With AI</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        /* Center icon and text */
        .card-body {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Style for icon */
        .icon {
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <!-- header -->
    @include('admin.header')
    <div class="main-content">
        <h6>Home > Home page </h6>
        <br />
        <div class="container">
            <h1 class="text-center">Statistics</h1>
            <div class="row">
                <div class="col-md-4">
                    <div class=" card">
                        <div class="card-body">
                            <i class="fas fa-user-graduate fa-3x icon"></i> <!-- Font Awesome icon for students -->
                            <h5 class="card-title">Student Statistics</h5>
                            <p class="card-text">Total number of students: <span id="totalStudents">{{$studentCounts}}</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <i class="fas fa-chalkboard-teacher fa-3x icon"></i> <!-- Font Awesome icon for teachers -->
                            <h5 class="card-title">Teacher Statistics</h5>
                            <p class="card-text">Total number of teachers: <span id="totalTeachers">{{$teacherCounts}}</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <i class="fas fa-chalkboard fa-3x icon"></i> <!-- Font Awesome icon for classes -->
                            <h5 class="card-title">Class Statistics</h5>
                            <p class="card-text">Total number of classes: <span id="totalClasses">{{$classCounts}}</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </div>

    @include('footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>