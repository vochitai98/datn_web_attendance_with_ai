<style>
    .dropdown-menu {
        font-size: 20px;
    }

    .navbar {
        background-color: #2C3E50 !important;
    }

    .header-custom {
        color: #2C3E50 !important;
        ;
        /* Màu của nền trang */
    }

    .nav-link {
        color: white !important;
        font-family: Arial, Helvetica, sans-serif;
    }

    .nav-item {
        color: white !important;
        font-family: Arial, Helvetica, sans-serif;
    }
</style>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('images/logo.png') }}" alt="Navbar" height="50" style="filter: brightness(50);">
        </a>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('student_home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('student.attendance_management') }}">Attendance Management</a>
                </li>

            </ul>
        </div>

        <div class="dropdown">
            <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="http://localhost:8000/{{session('avt')}}" alt="Profile" class="rounded-circle me-2" height="40" width="40">
                <div class="text-dark" style="color:aliceblue !important;font-size:20px !important">{{ session('username') }}</div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="{{ route('student.edit_profile')}}">Edit Profile</a></li>
                <li><a class="dropdown-item" href="{{ route('student.change_password')}}">Change Password</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="{{ route('login') }}">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<!--end header -->