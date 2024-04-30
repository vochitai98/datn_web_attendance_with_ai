</html>
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
        <!-- Nội dung trang Class Management -->
        <h6>Home > User > attendance user</h6>
        <div class="text-center">
            <h5>My Class Name : {{$class->name}}</h5>
        </div>
        <br></br>
        <form id="filterForm" method="GET">
            <div class="row mb-6">
                <input type="hidden" name="student_id" value="{{$student->id}}">
                <input type="hidden" name="class_id" value="{{$class->id}}">
                <div class="col-md-2">
                    <label for="dateSearch" class="form-label">Start Date</label>
                    <input type="date" class="form-control" name="startDate" id="startDate" placeholder="Enter date">
                </div>
                <div class="col-md-2">
                    <label for="dateSearch" class="form-label">End Date</label>
                    <input type="date" class="form-control" name="endDate" id="endDate" placeholder="Enter date">
                </div>
                <div class="col-md-2">
                    <label for="statusSearch" class="form-label">Select Status</label>
                    <select class="form-select form-select-sm" id="status" name="status" style="height: 38px;">
                        <option value="">All</option>
                        <option value="1">Present</option>
                        <option value="0">Absent</option>
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
                    <th scope="col" class="text-center">Status</th>
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
            @if($current_page > 1)
            <a href="?page={{ $current_page - 1 }}" class="pagination-link">&lt;</a>
            @endif

            @for($i = 1; $i <= $totalPages; $i++) <a href="?page={{ $i }}" class="pagination-link @if($current_page==$i) active @endif">{{ $i }}</a>
                @endfor

                @if($current_page < $totalPages) <a href="?page={{ $current_page + 1 }}" class="pagination-link">&gt;</a>
                    @endif
        </div>
        <div>Số buổi vắng : 0 </div>
    </div>
    @include('footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>