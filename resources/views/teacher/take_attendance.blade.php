</html>
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
            background-color: #f8f9fa;
            /* Form background color */
            padding: 20px;
            /* Spacing between content and form border */
            border-radius: 10px;
            /* Rounded corners of form */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Box shadow */
        }

        .form-title {
            text-align: center;
            /* Center-align title */
            font-size: 24px;
            /* Title font size */
            font-weight: bold;
            /* Bold title */
            margin-bottom: 20px;
            /* Spacing between title and form content */
        }

        .preview-image {
            max-width: 100%;
            /* Maximum width for image */
            height: auto;
            /* Maintain aspect ratio */
            margin-top: 10px;
            /* Spacing between image and form elements */
            max-height: 100px;
            /* Set maximum height for image */
        }
    </style>
</head>

<body>
    <!-- header -->
    @include('teacher.header')
    <div class="main-content">
        <!-- Nội dung trang Class Management -->
        <h6>Home > Attendane management</h6>
        @if(!isset($class))
        <div class="alert alert-danger">
            Teacher is not attemp class!
        </div>
        @else
        <div class="text-center">
            <h5>My Class Name : {{$class->name}}</h5>
        </div>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="form-container">
                        <h2 class="form-title">Teacher Attendance Form</h2> <!-- Title in English -->
                        <form action="{{ route('teacher.process_attendance') }}" method="POST" enctype="multipart/form-data">
                            @csrf <!-- Laravel CSRF token -->
                            <input type="hidden" name="classId" value="{{$class->id}}">
                            <div class="form-group">
                                <label for="date">Date of Attendance:</label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                            <div class="form-group">
                                <label for="image">Image:</label>
                                <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required onchange="previewImage(event)">
                            </div>
                            <div class="form-group">
                                <img id="imagePreview" class="preview-image" src="#" alt="Preview Image"> <!-- Image preview -->
                            </div>
                            <div class="form-group text-center"> <!-- Center-align attendance button -->
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
</body>

</html>