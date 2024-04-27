<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.0/main.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.0/main.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Tùy chỉnh CSS cho giao diện */
        .calendar-container {
            display: none;
            /* Ẩn lịch ban đầu */
            background-color: #f8f9fa;
            padding: 20px;
            border-top: 1px solid #dee2e6;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
        }

        .show-calendar {
            display: block;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#" onclick="showCalendar()">Home</a> <!-- Gọi hàm showCalendar() khi nhấn nút Home -->
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
                    <img src="path/to/profile_image.jpg" alt="Profile" class="rounded-circle me-2" width="40"> <!-- Thay đổi path/to/profile_image.jpg thành đường dẫn thực sự -->
                    <div class="text-dark">{{ session('username') }}</div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#">Edit Profile</a></li>
                    <li><a class="dropdown-item" href="#">Change Password</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="{{ route('login') }}">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!--end header -->

    <!-- Calendar -->
    <div class="calendar-container" id="calendarContainer">
        <!-- Đây là nơi để hiển thị lịch -->
        <div id="calendar"></div>
    </div>

    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showCalendar() {
            var calendarContainer = document.getElementById('calendarContainer');
            if (calendarContainer.classList.contains('show-calendar')) {
                calendarContainer.classList.remove('show-calendar');
            } else {
                calendarContainer.classList.add('show-calendar');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth', // Hiển thị lịch theo tháng
                events: [
                    // Danh sách các sự kiện trong lịch
                    {
                        title: 'Event 1',
                        start: '2024-04-23'
                    },
                    {
                        title: 'Event 2',
                        start: '2024-04-25',
                        end: '2024-04-27'
                    }
                ]
            });

            calendar.render();
        });
    </script>
</body>

</html>