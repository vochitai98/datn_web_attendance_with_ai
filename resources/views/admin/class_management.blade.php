</html>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <!-- header -->
    @include('admin.header')
    <!-- Nội dung trang Class Management -->
    <h6>home > class management</h6>
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-sm-4">
                <form class="d-flex align-items-center">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
            <div class="col-sm-4 text-end">
                <a href="{{ route('admin.class_edit') }}" class="btn btn-primary">Add Class</a>
            </div>
        </div>
    </div>
    <table class="table">
        <caption class="caption-top">Class List</caption>
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col" class="text-center">Name Lop</th>
                <th scope="col" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td class="text-center">20 TCLC DT5</td>
                <td class="text-center">
                    <button type="button" class="btn btn-primary">View</button>
                    <button type="button" class="btn btn-secondary">Edit</button>
                    <button type="button" class="btn btn-danger">Delete</button>
                </td>
            </tr>
        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>