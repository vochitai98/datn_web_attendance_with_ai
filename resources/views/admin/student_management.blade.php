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

    </style>
</head>

<body>
    <!-- header -->
    @include('admin.header')
    <div class="main-content">
        <!-- Nội dung trang Class Management -->
        <h6>Home > Student management</h6>
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
        <br />
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-sm-4">
                    <form class="d-flex align-items-center">
                        <input class="form-control me-2" type="search" name="search" value="{{isset($search) ? $search : ''}}" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </div>
        <form id="filterForm" method="GET">
            <div class="row mb-6">
                <div class="col-md-2">
                    <label for="class_id" class="form-label">Select Class</label>
                    <select class="form-select" id="class_id" name="class_id">
                        <option value="" selected disabled>All</option>
                        @foreach($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1 mt-auto d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" style="height: 40px;">Filter</button>
                </div>
            </div>

        </form>

        <table class="table">
            <caption class="caption-top">List of Students</caption>
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
            <tbody id="yourTableBody">
                @php
                $perPage = 8;
                $totalRecords = count($students);
                $totalPages = ceil($totalRecords / $perPage);
                $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                $start = ($current_page - 1) * $perPage;
                $end = $start + $perPage - 1;
                @endphp
                @for($i = $start; $i <= $end; $i++) @if(isset($students[$i])) <tr>
                    <th scope="row">{{ $i + 1 }}</th>
                    <td class="text-center">{{ $students[$i]->name }}</td>
                    <td class="text-center">{{ $students[$i]->identification }}</td>
                    <td class="text-center">{{ $students[$i]->className }}</td>
                    <td class="text-center">{{ $students[$i]->phone }}</td>
                    <td class="text-center">{{ $students[$i]->address }}</td>
                    <td class="text-center">{{ $students[$i]->email }}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.student_edit',['student_id' => $students[$i]->id]) }}"><span class="bi bi-eye" style="margin-right:10px;"></span>
                        </a>
                        <a href="{{ route('admin.student_management',['student_id' => $students[$i]->id]) }}" onclick="return confirm('Bạn có chắc chắn muốn xóa?')"><span class="bi bi-trash text-danger"></span>
                        </a>
                        <a href="javascript:void(0);" class="toggle-active" data-student-id="{{ $students[$i]->id }}" data-active="{{ $students[$i]->active }}">
                            <span class="bi {{ $students[$i]->active ? 'bi-toggle-on text-success' : 'bi-toggle-off text-secondary' }}" style="font-size: 2em;"></span>
                        </a>
                    </td>
                    </tr>
                    @endif
                    @endfor
            </tbody>
        </table>
        <div class="pagination">
            @if($current_page > 1)
            <a href="?page={{ $current_page - 1 }}" class="pagination-link">&lt;</a>
            @endif

            @for($i = 1; $i <= $totalPages; $i++) <a href="?page={{ $i }}" class="pagination-link @if($current_page==$i) active @endif">{{ $i }}</a>
                @endfor

                @if($current_page < $totalPages) <a href="?page={{ $current_page + 1 }}" class="pagination-link">&gt;</a>
                    @endif
        </div>
    </div>
    @include('footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.toggle-active').click(function(e) {
                e.preventDefault();
                var toggleElement = $(this);
                var studentId = toggleElement.data('student-id');
                var active = toggleElement.data('active');

                console.log('Before AJAX call: ', studentId, active);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.toggle_active') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        student_id: studentId,
                        active: active
                    },
                    success: function(response) {
                        if (response.success) {
                            var iconElement = toggleElement.find('.bi');

                            console.log('Response active: ', response.active);

                            // Toggle icon classes and update data-active attribute
                            if (response.active) {
                                iconElement.removeClass('bi-toggle-off text-secondary').addClass('bi-toggle-on text-success');
                            } else {
                                iconElement.removeClass('bi-toggle-on text-success').addClass('bi-toggle-off text-secondary');
                            }

                            // Update data-active attribute based on response
                            toggleElement.data('active', response.active);

                            console.log('After update: ', toggleElement.data('active'));
                        } else {
                            console.error('Lỗi khi cập nhật trạng thái active.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>

</body>

</html>