<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
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
        <h2 class="text-center mb-4">Registration Form 2</h2>
        <form action="{{ route('student.register_handle') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="fullname">Full name:</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter fullname" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone number:</label>
                <input type="phonenumber" class="form-control" id="phone" name="phone" placeholder="Enter phonenumber" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="phonenumber" class="form-control" id="address" name="address" placeholder="Enter address" required>
            </div>

            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" class="form-control" id="dob" name="dob" required>
            </div>
            <div class="form-group">
                <label for="identification">Student ID:</label>
                <input type="text" class="form-control" id="identification" name="identification" placeholder="Enter identifi" required>
            </div>
            <div class=" form-group">
                <label for="class">Class:</label>
                <select class="form-select" id="class_id" name="class_id" required>
                    <option selected disabled>Select Class</option>
                    @foreach($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="profile_pic">image:</label>
                <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
            </div>
            <div class="form-group d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" id="goBack">Back</button>
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
        </form>
    </div>
    <script>
        document.getElementById("goBack").addEventListener("click", function() {
            window.history.back();
        });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>