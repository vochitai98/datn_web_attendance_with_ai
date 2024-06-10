<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance Class With AI</title>
    <style>
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
            /* Ensure the table borders collapse */
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody+tbody {
            border-top: 2px solid #dee2e6;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .table th {
            text-align: left;
        }
    </style>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <!-- header -->
    @include('teacher.header')
    <div class="main-content">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            </ol>
        </nav>
        <br />
        @if(!isset($class))
        <div class="alert alert-danger">
            Teacher is not assigned to any class!
        </div>
        @else
        <div class="text-center">
            <h5>Class Name : {{session('className')}}</h5>
        </div>
        <br />
        <div class="">
            <h3 class="text-center">Attendance Statistics</h3>
            <h5>Total : {{$studentCount}} students</h5>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr class="text-center">
                            <th class="text-center">Name</th>
                            <th class="text-center">Student ID</th>
                            <th class="text-center">Absent Count</th>
                            <th class="text-center">View detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $rs)
                        <tr>
                            <td class="text-center">{{ $rs->student_name }}</td>
                            <td class="text-center">{{ $rs->student_id }}</td>
                            <td class="text-center">{{ $rs->absent_count }}</td>
                            <td class="text-center">
                                <a href="{{ route('teacher.attendance_user',['student_id' => $rs->id, 'class_id' => $rs->class_id]) }}">
                                    <span class="bi bi-eye"></span>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
    @include('footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>