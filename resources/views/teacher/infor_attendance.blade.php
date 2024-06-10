<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f5f5f5;
        }

        .class-image {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .attendance-list {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .attendance-list h4 {
            text-align: center;
            margin-bottom: 20px;
        }

        .student-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .student-item:last-child {
            border-bottom: none;
        }

        .student-image {
            width: 50%;
            height: auto;
            border-radius: 1%;
            margin-right: 20px;
            object-fit: cover;
        }

        .student-details {
            flex-grow: 1;
        }

        .student-name {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
        }

        .student-status {
            font-size: 16px;
            color: #6c757d;
        }

        .student-status.present {
            color: green;
        }

        .student-status.absent {
            color: red;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
    </style>
</head>

<body>
    <!-- header -->
    @include('teacher.header')
    <!-- Main content -->
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>Class Attendance</h1>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-md-8 text-center">
                <!-- Image Display -->
                <img src="data:image/jpeg;base64,{{ $base64Image }}" class="class-image" alt="Class Image" id="classImage">
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-md-10">
                <div class="attendance-list">
                    <h4>Attendance List</h4>
                    <div class="row">
                        @foreach($attendance_records as $record)
                        <div class="col-md-3">
                            <div class="student-item">
                                <img src="data:image/jpeg;base64,{{ $base64Image }}" alt="{{ $record->name }}" class="student-image">
                                <div class="student-details">
                                    <p class="student-name">{{ $record->name }}</p>
                                    <p class="student-status {{ $record->status ? 'present' : 'absent' }}">
                                        {{ $record->status ? 'Present' : 'Absent' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div style="text-align: center;">
                        <form action="{{route('teacher.attendance_management')}}" method="GET">
                            <input type="hidden" name="attendance_date" value="{{$attendance_date}}" />
                            <input type="submit" name="confirmed" value="Confirmed" class="btn btn-primary" />
                            <input type="button" name="cancel" value="Cancel" class="btn btn-secondary" onclick="window.location.href='{{ route('teacher.take_attendance') }}'" />
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @include('footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>