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
    @include('admin.header')
    <!-- Nội dung trang Class Management -->
    <h6>Home > Class management</h6>

    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-sm-4 text-center" style="margin-left: 30%;">
                <form class="d-flex align-items-center" method="GET">
                    <input class="form-control me-2" type="search" name="search" value="{{isset($search) ? $search : ''}}" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
            <div class="col-sm-4 text-end">
                <a href="{{ route('admin.class_edit') }}">
                    <span class="bi bi-plus-circle" style="font-size: 2.5em; text-align:center"></span>
                </a>
            </div>
        </div>
    </div>
    <table class="table">
        <caption class="caption-top">List of Classes</caption>
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col" class="text-center">Name Lop</th>
                <th scope="col" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
            $stt = 0;
            @endphp
            @foreach($classes as $class)
            <tr>
                <th scope="row">{{ ++$stt }}</th>
                <td class="text-center">{{ $class->name }}</td>
                <td class="text-center">
                    <a href="{{ route('admin.class_edit',['class_id' => $class->id]) }}"><span class="bi bi-eye" style="margin-right:10px;"></span>
                    </a>
                    <a href="{{ route('admin.class_management',['class_id' => $class->id]) }}" onclick="return confirm('Bạn có chắc chắn muốn xóa?')"><span class="bi bi-trash"></span>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @include('footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>