</html>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <!-- header -->
    @include('student.header')
    <!-- Nội dung trang Class Management -->
    <h6>home > attendane Management</h6>
    <div class="text-center">
        <h5>My Class Name : {{$student->className}}</h5>
    </div>
    <!-- Thẻ HTML -->
    <form id="filterForm" action="{{ route('student.attendance_management') }}" method="GET">
        <div class="row mb-6">
            <div class="col-md-2">
                <label for="dateSearch" class="form-label">Select Date</label>
                <input type="date" class="form-control" id="dateSearch" name="dateSearch" placeholder="Enter date" value="{{ isset($_GET['dateSearch']) ? $_GET['dateSearch'] : '' }}">
            </div>
            <div class="col-md-2">
                <label for="statusSearch" class="form-label">Select Status</label>
                <select class="form-select form-select-sm" id="statusSearch" name="statusSearch">
                    <option value="" {{ isset($_GET['statusSearch']) && $_GET['statusSearch'] === "" ? 'selected' : '' }}>All</option>
                    <option value="1" {{ isset($_GET['statusSearch']) && $_GET['statusSearch'] === "1" ? 'selected' : '' }}>Present</option>
                    <option value="0" {{ isset($_GET['statusSearch']) && $_GET['statusSearch'] === "0" ? 'selected' : '' }}>Absent</option>
                </select>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Filter</button>
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
            </tr>
        </thead>
        <tbody>
            @php
            $absentCount=0;
            $stt = 0;
            foreach($attendance_records as $record) {
            if(!$record->status) {
            $absentCount++;
            }
            }
            @endphp
            @foreach($attendance_records as $record)
            <tr>
                <th scope="row">{{ ++$stt }}</th>
                <td class="text-center">{{ $record->attendance_date }}</td>
                <td class="text-center">
                    @if($record->status)
                    <span class="badge bg-success">v</span> <!-- Label tích v (đã điểm danh) -->
                    @else
                    <span class="badge bg-danger">x</span> <!-- Label tích x (chưa điểm danh) -->
                    @endif
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
    <div>Số buổi vắng : {{$absentCount}} </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>