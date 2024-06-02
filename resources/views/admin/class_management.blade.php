<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .add-class-button {
            color: #fff;
        }

        .add-class-icon {
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <!-- header -->
    @include('admin.header')
    <!-- Nội dung trang Class Management -->
    <div class="main-content">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Class management</a></li>
            </ol>
        </nav>
        <br />
        @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
        @endif
        @if (session('errors'))
        <div class="alert alert-danger">
            {{ session('errors') }}
        </div>
        @endif
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-sm-4 text-center" style="margin-left: 30%;">
                    <form class="d-flex align-items-center" method="GET">
                        <input class="form-control me-2" type="search" name="search" value="{{isset($search) ? $search : ''}}" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
                <div class="col-sm-4 text-end">
                    <a href="{{ route('admin.class_edit') }}" class="add-class-link">
                        <button class="btn btn-primary add-class-button">
                            <span class="bi bi-plus-circle add-class-icon"></span>
                            Add class
                        </button>
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
                $perPage = 8;
                $totalRecords = count($classes);
                $totalPages = ceil($totalRecords / $perPage);
                $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                $start = ($current_page - 1) * $perPage;
                $end = $start + $perPage - 1;
                @endphp
                @for($i = $start; $i <= $end; $i++) @if(isset($classes[$i])) <tr>
                    <th scope="row">{{ $i + 1 }}</th>
                    <td class="text-center">{{ $classes[$i]->name }}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.class_edit',['class_id' => $classes[$i]->id]) }}"><span class="bi bi-eye" style="margin-right:10px;"></span>
                        </a>
                        <a href="{{ route('admin.class_management',['class_id' => $classes[$i]->id]) }}" onclick="return confirm('Bạn có chắc chắn muốn xóa?')"><span class="bi bi-trash text-danger"></span>
                        </a>
                    </td>
                    </tr>
                    @endif
                    @endfor
            </tbody>
        </table>
        <div class="pagination">
            @if($current_page > 1)
            <a href="?page={{ $current_page - 1 }}&search={{ isset($search) ? $search : '' }}" class="pagination-link">&lt;</a>
            @endif

            @for($i = 1; $i <= $totalPages; $i++) <a href="?page={{ $i }}&search={{ isset($search) ? $search : '' }}" class="pagination-link @if($current_page==$i) active @endif">{{ $i }}</a>
                @endfor

                @if($current_page < $totalPages) <a href="?page={{ $current_page + 1 }}&search={{ isset($search) ? $search : '' }}" class="pagination-link">&gt;</a>
                    @endif
        </div>
    </div>
    @include('footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>