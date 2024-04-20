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
    <h6>home > attendane management > detail</h6>
    <div class="text-center">
        <h5>My Class Name : 20-TCLC-DT5</h5>
    </div>
    <div class="col-md-2">
        <label for="statusSearch" class="form-label">Select Status</label>
        <select class="form-select form-select-sm" id="statusSearch">
            <option selected>All</option>
            <option value="1">Present</option>
            <option value="0">Absent</option>
        </select>
    </div>
    <table class="table">
        <caption class="caption-top">User List</caption>
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col" class="text-center">Name</th>
                <th scope="col" class="text-center">MSSV</th>
                <th scope="col" class="text-center">Phone</th>
                <th scope="col" class="text-center">Address</th>
                <th scope="col" class="text-center">Email</th>
                <th scope="col" class="text-center">Status</th>

                <th scope="col" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
            $stt = 0;
            @endphp
            @foreach($attendance_records as $record)
            <tr>
                <th scope="row">{{ ++$stt }}</th>
                <td class="text-center">{{ $record->name }}</td>
                <td class="text-center">{{ $record->identifi }}</td>
                <td class="text-center">{{ $record->phone }}</td>
                <td class="text-center">{{ $record->address }}</td>
                <td class="text-center">{{ $record->email }}</td>
                <td class="text-center">
                    @if($record->status)
                    <span class="badge bg-success">v</span> <!-- Label tích v (đã điểm danh) -->
                    @else
                    <span class="badge bg-danger">x</span> <!-- Label tích x (chưa điểm danh) -->
                    @endif
                </td>
                <td class="text-center">
                    <a href="{{ route('teacher.attendance_user') }}" data-id="{{ $record->id }}" class=" btn btn-primary">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>