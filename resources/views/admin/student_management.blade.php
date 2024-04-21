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
    @include('admin.header')
    <!-- Nội dung trang Class Management -->
    <h6>home > student management</h6>

    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-sm-4">
                <form class="d-flex align-items-center">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <label for="statusSearch" class="form-label">Select Class</label>
        <select class="form-select form-select-sm" id="statusSearch">
            <option selected>All</option>
            <option value="1">20TCLCDT5</option>
            <option value="0">21TCLCDT5</option>
        </select>
    </div>
    <table class="table">
        <caption class="caption-top">User List</caption>
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col" class="text-center">Name</th>
                <th scope="col" class="text-center">Student ID</th>
                <th scope="col" class="text-center">Class</th>
                <th scope="col" class="text-center">Phone</th>
                <th scope="col" class="text-center">Address</th>
                <th scope="col" class="text-center">Email</th>
                <th scope="col" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
            $stt = 0;
            @endphp
            @foreach($students as $record)
            <tr>
                <th scope="row">{{ ++$stt }}</th>
                <td class="text-center">{{ $record->name }}</td>
                <td class="text-center">{{ $record->identification }}</td>
                <td class="text-center">{{ $record->className }}</td>
                <td class="text-center">{{ $record->phone }}</td>
                <td class="text-center">{{ $record->address }}</td>
                <td class="text-center">{{ $record->email }}</td>
                <td class="text-center">
                    <a href="{{ route('admin.student_edit',['student_id' => $record->id]) }}" class="btn btn-primary">View</a>
                    <a href="{{ route('admin.student_management',['student_id' => $record->id]) }}" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>