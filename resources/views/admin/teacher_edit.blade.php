<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <!-- header -->
    @include('admin.header')

    <div class="main-content">
        @if(isset($teacher->id))
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Teacher management</a></li>
                <li class="breadcrumb-item"><a href="#">Update</a></li>
            </ol>
        </nav>
        @else
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Teacher management</a></li>
                <li class="breadcrumb-item"><a href="#">Add</a></li>
            </ol>
        </nav>
        @endif
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
        <div class="container mt-5">
            <div class="row justify-content-center">
                <h3 class="text-center">Teacher Form</h3>
                <div class="col-md-6">
                    <div class="card">
                        @if(isset($teacher->id))
                        <div class="card-header">
                            Username : {{$teacher->username}}
                        </div>
                        @else
                        <div class="card-header">
                            Add Teacher
                        </div>
                        @endif

                        <div class="card-body">
                            <form action="{{ route('admin.teacher_edit_handle') }}" method="POST" enctype="multipart/form-data">
                                @csrf <!-- Sử dụng trong Laravel để chống CSRF attacks -->
                                <input type="hidden" class="form-control" id="id" name="id" value="{{ isset($teacher->id) ? $teacher->id : '' }}" required>
                                @if(!isset($teacher->id))
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="text" class="form-control" id="password" name="password" placeholder="Enter password" required>
                                </div>
                                @endif
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{ isset($teacher->id) ? $teacher->name : '' }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{ isset($teacher->id) ? $teacher->email : '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone number" value="{{ isset($teacher->id) ? $teacher->phone : '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" placeholder="Enter address" value="{{ isset($teacher->id) ? $teacher->address : '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="dayofbirth" class="form-label">Day of Birth</label>
                                    <input type="date" class="form-control" id="dayofbirth" name="dayofbirth" value="{{ isset($teacher->id) ? $teacher->dayofbirth : '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="identification" class="form-label">Teacher ID</label>
                                    <input type="text" class="form-control" id="identification" name="identification" placeholder="Enter identification" value="{{ isset($teacher->id) ? $teacher->identification : '' }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Gender</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="male" value="1" {{ isset($teacher->gender) && $teacher->gender == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="male">Male</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="female" value="0" {{ isset($teacher->gender) && $teacher->gender == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="female">Female</label>
                                    </div>
                                </div>
                                @if(isset($teacher->id))
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                @else
                                <button type="submit" class="btn btn-primary me-2">Add</button>
                                @endif
                                <button type="button" class="btn btn-secondary" onclick="window.history.back()">Cancel</button>
                                @if(isset($teacher->id))
                                <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route("reset_password", ['username' => $teacher->username, 'email' => $teacher->email]) }}' " style="float: right;">
                                    <i class=" fas fa-key"></i> Reset Password
                                </button>
                                @endif

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>