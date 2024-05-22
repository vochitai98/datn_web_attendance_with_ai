<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <!-- header -->
    @include('admin.header')
    <div class="main-content">
        @if(isset($class->id))
        <h6>Home > Class management > Edit</h6>
        @else
        <h6>Home > Class management > Add</h6>
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
        <br/>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        @if(isset($class->id))
                        <div class="card-header">
                            Edit Class
                        </div>
                        @else
                        <div class="card-header">
                            Add Class
                        </div>
                        @endif

                        <div class="card-body">
                            <form action="{{ route('admin.class_add_handle') }}" method="POST">
                                @csrf <!-- Sử dụng trong Laravel để chống CSRF attacks -->
                                @if(isset($class->id))
                                <input type="hidden" class="form-control" id="class_id" name="class_id" placeholder="Enter class name" value="{{$class->id}}" required>
                                @endif
                                <div class="mb-3">
                                    <label for="className" class="form-label">Class Name</label>
                                    <input type="text" class="form-control" id="className" name="className" placeholder="Enter class name" value="{{ isset($class->id) ? $class->name : '' }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="teacher_id" class="form-label">Teacher</label>
                                    <select class="form-select" id="teacher_id" name="teacher_id" required>
                                        <option selected disabled>Select Teacher</option>
                                        @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ isset($class->id) && $class->teacher_id == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if(isset($class->id))
                                <button type="submit" class="btn btn-primary me-2">Update</button>
                                @else
                                <button type="submit" class="btn btn-primary me-2">Add</button>
                                @endif

                                <button type="button" class="btn btn-secondary" onclick="window.history.back()">Cancel</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>