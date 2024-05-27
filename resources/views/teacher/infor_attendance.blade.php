<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .form-container {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .preview-image {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
            max-height: 100px;
        }

        .attendance {
            text-align: right;
            margin-bottom: 20px;
        }

        .attendance a {
            display: inline-block;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .attendance a:hover {
            background-color: #0056b3;
        }

        .attendance a span {
            margin-left: 5px;
            font-size: 1.5em;
        }

        .class-image {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .attendance-list {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .attendance-list h5 {
            margin-top: 20px;
        }

        .attendance-lists {
            display: flex;
            justify-content: space-between;
        }

        .attendance-list-column {
            width: 48%;
        }
    </style>
</head>

<body>
    <!-- header -->
    @include('teacher.header')
    <!-- Main content -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>Class Attendance</h1>
                <p>Capture or upload an image to mark attendance</p>
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
                        <div class="col-md-6">
                            <h5>Present</h5>
                            <ul class="list-group mb-4" id="presentList">
                                @foreach($attendance_records as $record)
                                @if($record->status)
                                <!-- List of present students -->
                                <li class="list-group-item">{{ $record->name }}</li>
                                @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5>Absent</h5>
                            <ul class="list-group" id="absentList">
                                @foreach($attendance_records as $record)
                                @if(!$record->status)
                                <!-- List of absent students -->
                                <li class="list-group-item">{{ $record->name }}</li>
                                @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>