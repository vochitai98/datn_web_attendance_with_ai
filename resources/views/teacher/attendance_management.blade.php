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
    </style>
</head>

<body>
    <!-- header -->
    @include('teacher.header')
    <div class="main-content">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Attendance Management</a></li>
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
        <div class="attendance">
            <a href="{{ route('teacher.take_attendance') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-circle"></i>
                <span>Take Attendance</span>
            </a>
        </div>
        <form id="filterForm" method="GET">
            <div class="row mb-6">
                <div class="col-md-2">
                    <label for="startDate" class="form-label">Start Date</label>
                    <input type="date" class="form-control" name="startDate" id="startDate" value="{{ request('startDate') }}" placeholder="Enter date">
                </div>
                <div class="col-md-2">
                    <label for="endDate" class="form-label">End Date</label>
                    <input type="date" class="form-control" name="endDate" id="endDate" value="{{ request('endDate') }}" placeholder="Enter date">
                </div>
                <div class="col-md-1 mt-auto d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" style="height: 40px;">Filter</button>
                </div>
            </div>
        </form>

        <table class="table">
            <caption class="caption-top">Attendance Records </caption>
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col" class="text-center">Attendance Date</th>
                    <th scope="col" class="text-center">View Image</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                $perPage = 8;
                $totalRecords = count($attendance_dates);
                $totalPages = ceil($totalRecords / $perPage);
                $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                $startDate = request('startDate');
                $endDate = request('endDate');
                $start = ($current_page - 1) * $perPage;
                $end = $start + $perPage - 1;
                @endphp
                @for($i = $start; $i <= $end; $i++) @if(isset($attendance_dates[$i])) <tr>
                    <th scope="row">{{ $i + 1 }}</th>
                    <td class="text-center">{{ $attendance_dates[$i]->attendance_date }}</td>
                    <td class="text-center">
                        <a href="{{ $attendance_dates[$i]->image_url }}" target="_blank">
                            <span class="bi bi-eye"></span>
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('teacher.attendance_user_list',['attendance_date' => $attendance_dates[$i]->attendance_date, 'class_id' => $class->id]) }}" style="margin-right:10px;">
                            <span class="bi bi-eye"></span>
                        </a>
                        <a href="{{ route('teacher.attendance_management',['image_id' => $attendance_dates[$i]->image_id]) }}" onclick="return confirm('Are you sure you want to delete?')">
                            <span class="bi bi-trash text-danger"></span>
                        </a>
                    </td>
                    </tr>
                    @endif
                    @endfor
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            @for($i = 1; $i <= $totalPages; $i++) <a href="?page={{ $i }}{{ $startDate ? '&startDate='.$startDate : '' }}{{ $endDate ? '&endDate='.$endDate : '' }}" class="pagination-link @if($current_page==$i) active @endif">{{ $i }}</a>
                @endfor
        </div>
        @endif
    </div>

    @include('footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>