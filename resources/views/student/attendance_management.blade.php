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
    
    <h6>Home > Attendane management</h6>
    <br></br>
    <div class="text-center">
        <h3>My Class : {{$student->className}}</h3>
    </div>
    <br></br>
    <form id="filterForm" action="{{ route('student.attendance_management') }}" method="GET">
        <div class="row mb-6">
            <div class="col-md-2">
                <label for="dateSearch" class="form-label">Select Date</label>
                <input type="date" class="form-control" id="dateSearch" name="dateSearch" placeholder="Enter date" value="{{ isset($_GET['dateSearch']) ? $_GET['dateSearch'] : '' }}" style="height: 38px;">
            </div>
            <div class="col-md-2">
                <label for="statusSearch" class="form-label">Select Status</label>
                <select class="form-select form-select-sm" id="statusSearch" name="statusSearch" style="height: 38px;">
                    <option value="" {{ isset($_GET['statusSearch']) && $_GET['statusSearch'] === "" ? 'selected' : '' }}>All</option>
                    <option value="1" {{ isset($_GET['statusSearch']) && $_GET['statusSearch'] === "1" ? 'selected' : '' }}>Present</option>
                    <option value="0" {{ isset($_GET['statusSearch']) && $_GET['statusSearch'] === "0" ? 'selected' : '' }}>Absent</option>
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
                    <span class="badge bg-success">v</span>
                    @else
                    <span class="badge bg-danger">x</span>
                    @endif
                </td>
                <td class="text-center">
                    <a href="{{ $record->image_url }}" target="_blank" >
                        <span class="bi bi-eye"></span>
                    </a>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
    <div style="font-size: 20px;">Số buổi vắng : {{$absentCount}} </div>

    @include('footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>