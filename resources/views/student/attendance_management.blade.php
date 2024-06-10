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
</head>

<body>
    <!-- header -->
    @include('student.header')
    <div class="main-content">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#"> Attendane management</a></li>
            </ol>
        </nav>
        <br>
        <div class="text-center">
            <h5>My Class : {{$student->className}}</h5>
        </div>
        <br></br>
        <form id="filterForm" action="{{ route('student.attendance_management') }}" method="GET">
            <div class="row mb-6">
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
                        <option value="">All</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Present</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Absent</option>
                    </select>
                </div>
                <div class="col-md-1 mt-auto d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" style="height: 40px;">Filter</button>
                </div>
            </div>
        </form>

        <table class="table">
            <caption class="caption-top">Attendance List</caption>
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col" class="text-center">Attendance Date</th>
                    <th scope="col" class="text-center">Status</th>
                    <th scope="col" class="text-center">View attendance image</th>
                </tr>
            </thead>
            <tbody>
                @php
                $perPage = 8;
                $totalRecords = count($attendance_records);
                $totalPages = ceil($totalRecords / $perPage);
                $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                $startDate = isset($_GET['startDate']) ? $_GET['startDate'] : null;
                $endDate = isset($_GET['endDate']) ? $_GET['endDate'] : null;
                $status = isset($_GET['status']) ? $_GET['status'] : null;
                $start = ($current_page - 1) * $perPage;
                $end = $start + $perPage - 1;
                @endphp
                @for($i = $start; $i <= $end; $i++) @if(isset($attendance_records[$i])) <tr>
                    <th scope="row">{{ $i + 1 }}</th>
                    <td class="text-center">{{ $attendance_records[$i]->attendance_date }}</td>
                    <td class="text-center">
                        @if($attendance_records[$i]->status)
                        <span class="badge bg-success">v</span>
                        @else
                        <span class="badge bg-danger">x</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ $attendance_records[$i]->image_url }}" target="_blank">
                            <span class="bi bi-eye"></span>
                        </a>
                    </td>
                    </tr>
                    @endif
                    @endfor

            </tbody>
        </table>
        <div class="pagination">
            @for($i = 1; $i <= $totalPages; $i++) <a href="?page={{ $i }}{{ $startDate ? '&startDate='.$startDate : '' }}{{ $endDate ? '&endDate='.$endDate : '' }}{{ $status ? '&status='.$status : '' }}" class="pagination-link @if($current_page==$i) active @endif">{{ $i }}</a>
                @endfor
        </div>
        <div style="font-size: 20px;">Absent count : {{$absent_count}} </div>
    </div>
    @include('footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>