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

    @if(isset($student->id))
    <h6>Home > Student management > View</h6>
    @else
    <h6>Home > Student management > Add</h6>
    @endif

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    @if(isset($student->id))
                    <div class="card-header">
                        Username : {{$student->username}}
                    </div>
                    @else
                    <div class="card-header">
                        Add User
                    </div>
                    @endif

                    <div class="card-body">
                        <form action="{{ route('admin.student_edit_handle') }}" method="POST" enctype="multipart/form-data">
                            @csrf <!-- Sử dụng trong Laravel để chống CSRF attacks -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{ isset($student->id) ? $student->name : '' }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{ isset($student->id) ? $student->email : '' }}">
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone number" value="{{ isset($student->id) ? $student->phone : '' }}">
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Enter address" value="{{ isset($student->id) ? $student->address : '' }}">
                            </div>
                            <div class="mb-3">
                                <label for="dayofbirth" class="form-label">Day of Birth</label>
                                <input type="date" class="form-control" id="dayofbirth" name="dayofbirth" value="{{ isset($student->id) ? $student->dayofbirth : '' }}">
                            </div>
                            <div class="mb-3">
                                <label for="identification" class="form-label">User ID</label>
                                <input type="text" class="form-control" id="identification" name="identification" placeholder="Enter identification" value="{{ isset($student->id) ? $student->identification : '' }}" required>
                            </div>
                            @if(isset($student))
                            <div class="mb-3">
                                <label for="class_id" class="form-label">Class</label>
                                <select class="form-select" id="class_id" name="class_id" required>
                                    <option selected disabled>Select Class</option>
                                    @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ isset($student->id) && $student->class_id == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            @if(isset($student->id)||isset($teacher->id))
                            <button type="submit" class="btn btn-primary me-2">Update</button>
                            @else
                            <button type="submit" class="btn btn-primary me-2">Add</button>
                            @endif
                            <button type="button" class="btn btn-secondary" onclick="window.location.href='cancel-page-url'">Cancel</button>
                            <button type="button" class="btn btn-primary" onclick="window.location.href='cancel-page-url' " style="float: right;">
                                <i class=" fas fa-key"></i> Reset Password
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
    @include('footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>