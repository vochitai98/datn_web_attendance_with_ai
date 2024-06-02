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
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Attendance Management</a></li>
                <li class="breadcrumb-item"><a href="#">Detail </a></li>
            </ol>
        </nav>
        <br />
        <div class="text-center">
            <h5>My Class : {{session('className')}}</h5>
        </div>
        <br></br>
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-sm-4">
                    <form class="d-flex align-items-center" method="GET">
                        <input type="hidden" name="attendance_date" value="{{$date}}">
                        <input type="hidden" name="class_id" value="{{$class->id}}">
                        <input class="form-control me-2" type="search" name="search" value="{{isset($search) ? $search : ''}}" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </div>

        <form id="filterForm" method="GET">
            <input type="hidden" name="attendance_date" value="{{$date}}">
            <input type="hidden" name="class_id" value="{{$class->id}}">
            <div class="row mb-6">
                <div class="col-md-2">
                    <label for="statusSearch" class="form-label">Select Status</label>
                    <select class="form-select form-select-sm" name="statusSearch" id="statusSearch">
                        <option value="" @if(request('statusSearch')=='' ) selected @endif>All</option>
                        <option value="1" @if(request('statusSearch')=='1' ) selected @endif>Present</option>
                        <option value="0" @if(request('statusSearch')=='0' ) selected @endif>Absent</option>
                    </select>
                </div>
                <div class="col-md-1 mt-auto d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" style="height: 40px;">Filter</button>
                </div>
            </div>
        </form>
        @php
        use Carbon\Carbon;
        $formattedDate = Carbon::parse($date)->format('F d, Y');
        @endphp
        <table class="table">
            <caption class="caption-top">Attendance Status Table for Students on {{$formattedDate}}</caption>
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col" class="text-center">Name</th>
                    <th scope="col" class="text-center">MSSV</th>
                    <th scope="col" class="text-center">Phone</th>
                    <th scope="col" class="text-center">Address</th>
                    <th scope="col" class="text-center">Email</th>
                    <th scope="col" class="text-center">Present</th>

                    <!-- <th scope="col" class="text-center">View Detail Attendance Records</th> -->
                </tr>
            </thead>
            <tbody>
                @php
                $perPage = 8;
                $totalRecords = count($attendance_records);
                $totalPages = ceil($totalRecords / $perPage);
                $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                $start = ($current_page - 1) * $perPage;
                $end = $start + $perPage - 1;
                @endphp

                @for($i = $start; $i <= $end; $i++) @if(isset($attendance_records[$i])) <tr>
                    <th scope="row">{{ $i + 1 }}</th>
                    <td class="text-center">{{ $attendance_records[$i]->name }}</td>
                    <td class="text-center">{{ $attendance_records[$i]->identification }}</td>
                    <td class="text-center">{{ $attendance_records[$i]->phone }}</td>
                    <td class="text-center">{{ $attendance_records[$i]->address }}</td>
                    <td class="text-center">{{ $attendance_records[$i]->email }}</td>
                    <td class="text-center">
                        @if($attendance_records[$i]->status)
                        <span class="badge bg-success">v</span> <!-- Label tích v (đã điểm danh) -->
                        @else
                        <span class="badge bg-danger">x</span> <!-- Label tích x (chưa điểm danh) -->
                        @endif
                    </td>
                    <!-- <td class="text-center">
                        <a href="{{ route('teacher.attendance_user',['student_id' => $attendance_records[$i]->id, 'class_id' => $class->id]) }}">
                            <span class="bi bi-eye"></span>
                        </a>
                    </td> -->
                    </tr>
                    @endif
                    @endfor
            </tbody>
        </table>
        <!-- Pagination -->
        <div class="pagination">
            @if($current_page > 1)
            <a href="?page={{ $current_page - 1 }}&attendance_date={{ $date }}&class_id={{ $class->id }}&statusSearch={{ request('statusSearch') }}&search={{ request('search') }}" class="pagination-link">&lt;</a>
            @endif

            @for($i = 1; $i <= $totalPages; $i++) <a href="?page={{ $i }}&attendance_date={{ $date }}&class_id={{ $class->id }}&statusSearch={{ request('statusSearch') }}&search={{ request('search') }}" class="pagination-link @if($current_page==$i) active @endif">{{ $i }}</a>
                @endfor

                @if($current_page < $totalPages) <a href="?page={{ $current_page + 1 }}&attendance_date={{ $date }}&class_id={{ $class->id }}&statusSearch={{ request('statusSearch') }}&search={{ request('search') }}" class="pagination-link">&gt;</a>
                    @endif
        </div>

    </div>
    @include('footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>