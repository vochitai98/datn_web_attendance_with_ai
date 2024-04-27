</html>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <!-- header -->
    @include('teacher.header')
    <!-- Nội dung trang Class Management -->
    <h6>Home > User > attendance user</h6>
    <div class="text-center">
        <h5>My Class Name : {{$class->name}}</h5>
    </div>
    <div class="row mb-6">
        <div class="col-md-2">
            <label for="dateSearch" class="form-label">Select Date</label>
            <input type="date" class="form-control" id="dateSearch" placeholder="Enter date">
        </div>
        <div class="col-md-2">
            <label for="statusSearch" class="form-label">Select Status</label>
            <select class="form-select form-select-sm" id="statusSearch">
                <option selected>All</option>
                <option value="1">Present</option>
                <option value="0">Absent</option>
            </select>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
            <button type="button" id="filterButton" class="btn btn-primary">Filter</button>
        </div>
    </div>

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
            $absentCount=0;
            $stt = 0;
            foreach($attendance_users as $user) {
            if(!$user->status) {
            $absentCount++;
            }
            }
            @endphp
            @foreach($attendance_users as $user)
            <tr>
                <th scope="row">{{ ++$stt }}</th>
                <td class="text-center">{{ $user->attendance_date }}</td>
                <td class="text-center">
                    @if($user->status)
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