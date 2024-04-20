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
    @include('teacher.header')
    <!-- Nội dung trang Class Management -->
    <h6>home > attendane management</h6>
    @if(!$class)
    <p>Teacher is not attemp class .</p>
    @else
    <div class="text-center">
        <h5>My Class Name : {{$class->name}}</h5>
    </div>

    <div class="row mb-6">
        <div class="col-md-2">
            <label for="dateSearch" class="form-label">Select Date</label>
            <input type="date" class="form-control" id="dateSearch" placeholder="Enter date">
        </div>
        <div class="col-md-6 d-flex justify-content-end">
            <button type="button" id="filterButton" class="btn btn-primary">Filter</button>
        </div>
    </div>

    <table class="table">
        <caption class="caption-top">Attendance List</caption>
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col" class="text-center">Attendance Date</th>
                <th scope="col" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
            $stt = 0;
            @endphp
            @foreach($attendance_dates as $record)
            <tr>
                <th scope="row">{{ ++$stt }}</th>
                <td class="text-center">{{ $record->attendance_date }}</td>
                <td class="text-center">
                    <a href="{{ route('teacher.attendance_user_list',['attendance_date' => $record->attendance_date, 'class_id' => $class->id]) }}" class="btn btn-primary">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="container">
        <h2 class="my-4">Form Điểm danh</h2>
        <form action="{{route('teacher.process_attendance') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="date">Ngày điểm danh:</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="image">Attendance Date:</label>
                <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Điểm danh</button>
            </div>
        </form>
    </div>

    @endif
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>