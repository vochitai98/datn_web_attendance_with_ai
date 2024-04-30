<style>
    .dropdown-menu {
        font-size: 20px;
    }

    .navbar {
        background-color: #473C8B !important;
    }
</style>
<div class="header-custom">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin_home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Navbar" height="50">
            </a>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('admin_home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.class_management') }}">Class Management</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            User Management
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.teacher_management') }}">Teacher Management</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.student_management') }}">Student Management</a></li>

                        </ul>
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
                    <li><a class="dropdown-item" href="{{ route('admin.edit_profile')}}">Edit Profile</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.change_password')}}">Change Password</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="{{ route('login') }}">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<!--end header -->