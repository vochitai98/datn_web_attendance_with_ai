<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /* CSS for attendance form */
        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #007bff;
        }

        .preview-image {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
            max-height: 200px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .form-group label {
            font-weight: bold;
        }

        .form-group input[type="file"] {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 6px 12px;
            width: 100%;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .main-content h6 {
            font-weight: bold;
        }

        .main-content .text-center h5 {
            margin-bottom: 20px;
            color: #343a40;
        }
    </style>
</head>

<body>
    <!-- header -->
    @include('teacher.header')
    <div class="main-content">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Attendance Management</a></li>
                <li class="breadcrumb-item"><a href="#">Take attendance </a></li>
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
        @if(!isset($class))
        <div class="alert alert-danger">
            Teacher is not assigned to any class!
        </div>
        @else
        <div class="text-center">
            <h5>Class Name : {{session('className')}}</h5>
        </div>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="form-container">
                        <h2 class="form-title">Teacher Attendance Form</h2>
                        <form action="{{ route('teacher.process_attendance') }}" method="POST" enctype="multipart/form-data">
                            @csrf <!-- Laravel CSRF token -->
                            <input type="hidden" name="classId" value="{{$class->id}}">
                            <div class="form-group mb-3">
                                <label for="date">Date of Attendance:</label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="image">Image:</label>
                                <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required onchange="previewImage(event)">
                            </div>
                            <div class="form-group mb-3 text-center">
                                <img id="imagePreview" class="preview-image" src="#" alt="Preview Image"> <!-- Image preview -->
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary">Take Attendance</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    @include('footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const dateInput = document.getElementById('date');
            const today = new Date().toISOString().split('T')[0];
            dateInput.setAttribute('max', today);
        });

        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('imagePreview');
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>

</html>