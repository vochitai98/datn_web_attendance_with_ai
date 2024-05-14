<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance Class With AI</title>
    <style>
        .calendar {
            font-family: Arial, sans-serif;
            margin: 20px auto;
            width: 50%;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        #monthYear {
            font-size: 20px;
            font-weight: bold;
        }

        button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        table {
            width: 100%;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            text-align: center;
            padding: 5px;
        }

        table th {
            background-color: #f2f2f2;
        }

        table td {
            cursor: pointer;
        }

        table td.today {
            background-color: #e0e0e0;
        }

        table td.selected {
            background-color: #2196f3;
            color: white;
        }
    </style>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <!-- header -->
    @include('teacher.header')
    <div class="main-content">
        <h6>Home > Home page </h6>
        <div class="text-center">
            <h5>My Class Name : {{session('className')}}</h5>
        </div>
        <br>
        <div class="container">
            <h3 class="text-center">Attendance Statistics</h3>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Student ID</th>
                            <th>Absent Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $rs)
                        <tr>
                            <td>{{ $rs->student_name }}</td>
                            <td>{{ $rs->student_id }}</td>
                            <td>{{ $rs->absent_count }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>