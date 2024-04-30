<style>
    .dropdown-menu {
        font-size: 20px;
    }

    .navbar {
        background-color: #473C8B !important;
    }
</style>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('images/logo.png') }}" alt="Navbar" height="50">
        </a>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('teacher_home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('teacher.attendance_management') }}">Attendance Management</a>
                </li>

            </ul>
        </div>

        <!-- Profile dropdown -->
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="path/to/profile_image.jpg" alt="Profile" class="rounded-circle me-2" width="40">
                <div class="text-dark">{{ session('username') }}</div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="{{ route('teacher.edit_profile')}}">Edit Profile</a></li>
                <li><a class="dropdown-item" href="{{ route('teacher.change_password')}}">Change Password</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="{{ route('login') }}">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<!--end header -->