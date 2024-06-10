<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Attendance user </a></li>
            </ol>
        </nav>
        <br />
        <div class="text-center">
            <h5>My Class Name : {{session('className')}}</h5>
        </div>
        <br></br>
        <form id="filterForm" method="GET">
            <div class="row mb-6">
                <input type="hidden" name="student_id" value="{{$student->id}}">
                <input type="hidden" name="class_id" value="{{$class->id}}">
                <div class="col-md-2">
                    <label for="dateSearch" class="form-label">Start Date</label>
                    <input type="date" class="form-control" name="startDate" id="startDate" placeholder="Enter date" value="{{ request('startDate') }}">
                </div>
                <div class="col-md-2">
                    <label for="dateSearch" class="form-label">End Date</label>
                    <input type="date" class="form-control" name="endDate" id="endDate" placeholder="Enter date" value="{{ request('endDate') }}">
                </div>
                <div class="col-md-2">
                    <label for="statusSearch" class="form-label">Select Status</label>
                    <select class="form-select form-select-sm" id="status" name="status" style="height: 38px;">
                        <option value="" @if(request('status')=='' ) selected @endif>All</option>
                        <option value="1" @if(request('status')=='1' ) selected @endif>Present</option>
                        <option value="0" @if(request('status')=='0' ) selected @endif>Absent</option>
                    </select>
                </div>
                <div class="col-md-1 mt-auto d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" style="height: 40px;">Filter</button>
                </div>
            </div>
        </form>

        <table class="table">
            <caption class="caption-top">Student name : {{$student->name}}</caption>
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col" class="text-center">Attendance Date</th>
                    <th scope="col" class="text-center">Present</th>
                </tr>
            </thead>
            <tbody>
                @php
                $perPage = 8;
                $totalRecords = count($attendance_users);
                $totalPages = ceil($totalRecords / $perPage);
                $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                $start = ($current_page - 1) * $perPage;
                $end = $start + $perPage - 1;
                @endphp
                @for($i = $start; $i <= $end; $i++) @if(isset($attendance_users[$i])) <tr>
                    <th scope="row">{{ $i + 1 }}</th>
                    <td class="text-center">{{ $attendance_users[$i]->attendance_date }}</td>
                    <td class="text-center">
                        @if($attendance_users[$i]->status)
                        <span class="badge bg-success">v</span> <!-- Label tích v (đã điểm danh) -->
                        @else
                        <span class="badge bg-danger">x</span> <!-- Label tích x (chưa điểm danh) -->
                        @endif
                    </td>
                    </tr>
                    @endif
                    @endfor
            </tbody>
        </table>
        <!-- Pagination -->
        <div class="pagination">
            @for($i = 1; $i <= $totalPages; $i++) <a href="?page={{ $i }}&student_id={{ $student->id }}&class_id={{ $class->id }}&startDate={{ request('startDate') }}&endDate={{ request('endDate') }}&status={{ request('status') }}" class="pagination-link @if($current_page==$i) active @endif">{{ $i }}</a>
                @endfor
        </div>
        <div>Absent count : {{$absentCount}} </div>
    </div>
    @include('footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>