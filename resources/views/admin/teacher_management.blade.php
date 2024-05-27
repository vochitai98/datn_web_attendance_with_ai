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
    <style>
        /* Target the link */
        /* Custom button style */
        .btn-custom {
            display: inline-flex;
            align-items: center;
            background-color: #fff;
            /* Green background */
            color: white;
            /* White text color */
            padding: 10px 20px;
            /* Padding for the button */
            border: none;
            /* No border */
            border-radius: 5px;
            /* Rounded corners */
            text-decoration: none;
            /* Remove underline from the link */
            font-size: 1.2em;
            /* Increase font size */
            transition: background-color 0.3s ease;
            /* Smooth background color transition */
        }

        /* Icon within the button */
        .btn-custom .bi-person-plus {
            font-size: 1.5em;
            /* Icon size */
            margin-right: 10px;
            /* Space between icon and text */
        }

        /* Hover effect for the button */
        .btn-custom:hover {
            background-color: #fff;
            /* Darker green on hover */
            color: white;
            /* Ensure text color stays white on hover */
        }
    </style>
</head>

<body>
    <!-- header -->
    @include('admin.header')
    <div class="main-content">
        <!-- Nội dung trang Class Management -->
        <h6>Home > Teacher management</h6>
        <br />
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-sm-4 text-center" style="margin-left: 30%;">
                    <form class="d-flex align-items-center" method="GET">
                        <input class="form-control me-2" type="search" name="search" value="{{ isset($search) ? $search : '' }}" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
                <div class="col-sm-4 text-end">
                    <a href="{{ route('admin.teacher_edit') }}" class="btn btn-primary add-class-button">
                        <span class="bi bi-person-plus"></span> Add teacher
                    </a>
                </div>
            </div>
        </div>


        <table class=" table">
            <caption class="caption-top">List of Teachers</caption>
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col" class="text-center">Name</th>
                    <th scope="col" class="text-center">Teacher ID</th>
                    <th scope="col" class="text-center">Class</th>
                    <th scope="col" class="text-center">Phone</th>
                    <th scope="col" class="text-center">Address</th>
                    <th scope="col" class="text-center">Email</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                $perPage = 8;
                $totalRecords = count($teachers);
                $totalPages = ceil($totalRecords / $perPage);
                $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                $start = ($current_page - 1) * $perPage;
                $end = $start + $perPage - 1;
                @endphp
                @for($i = $start; $i <= $end; $i++) @if(isset($teachers[$i])) <tr>
                    <th scope="row">{{ $i + 1 }}</th>
                    <td class="text-center">{{ $teachers[$i]->name }}</td>
                    <td class="text-center">{{ $teachers[$i]->identification }}</td>
                    <td class="text-center">
                        @if($teachers[$i]->className)
                        {{ $teachers[$i]->className }}
                        @else
                        Not yet in charge
                        @endif
                    </td>
                    <td class="text-center">{{ $teachers[$i]->phone }}</td>
                    <td class="text-center">{{ $teachers[$i]->address }}</td>
                    <td class="text-center">{{ $teachers[$i]->email }}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.teacher_edit',['teacher_id' => $teachers[$i]->id]) }}"><span class="bi bi-eye" style="margin-right:10px;"></span>
                        </a>
                        <a href="{{ route('admin.teacher_management',['teacher_id' => $teachers[$i]->id]) }}" onclick="return confirm('Bạn có chắc chắn muốn xóa?')"><span class="bi bi-trash text-danger"></span>
                        </a>
                    </td>
                    </tr>
                    @endif
                    @endfor
            </tbody>
        </table>
        <div class="pagination">
            @if($current_page > 1)
            <a href="?page={{ $current_page - 1 }}&search={{ request()->search }}" class="pagination-link">&lt;</a>
            @endif

            @for($i = 1; $i <= $totalPages; $i++) <a href="?page={{ $i }}&search={{ request()->search }}" class="pagination-link @if($current_page == $i) active @endif">{{ $i }}</a>
                @endfor

                @if($current_page < $totalPages) <a href="?page={{ $current_page + 1 }}&search={{ request()->search }}" class="pagination-link">&gt;</a>
                    @endif
        </div>
    </div>
    @include('footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>