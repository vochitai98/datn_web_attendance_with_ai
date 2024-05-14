<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance Class With AI</title>
    <style>
        .calendar {
            font-family: Arial, sans-serif;
            margin: 20px auto;
            width: 50%;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        #monthYear {
            font-size: 20px;
            font-weight: bold;
        }

        button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        table {
            width: 100%;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            text-align: center;
            padding: 5px;
        }

        table th {
            background-color: #f2f2f2;
        }

        table td {
            cursor: pointer;
        }

        table td.today {
            background-color: #e0e0e0;
        }

        table td.selected {
            background-color: #2196f3;
            color: white;
        }
    </style>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <!-- header -->
    @include('student.header')
    <div class="main-content">
        <h6>Home > Home page </h6>
        <br>
        <div class="container">
            <h3 class="text-center">Student information</h3>
            <div class="row">

                <div class="col-md-6 offset-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Class information</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Class name:</strong> 20TCLC DT5</li>
                                <li class="list-group-item"><strong>Homeroom teacher:</strong> Teacher</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    @include('footer')
    <script>
        // JavaScript
        document.addEventListener("DOMContentLoaded", function() {
            const calendarBody = document.getElementById("calendarBody");
            const monthYear = document.getElementById("monthYear");
            const prevMonthBtn = document.getElementById("prevMonth");
            const nextMonthBtn = document.getElementById("nextMonth");

            let currentDate = new Date();
            let currentMonth = currentDate.getMonth();
            let currentYear = currentDate.getFullYear();

            renderCalendar(currentMonth, currentYear);

            function renderCalendar(month, year) {
                // Xóa các ô trong lịch trước khi render lại
                calendarBody.innerHTML = "";

                // Cập nhật tiêu đề tháng và năm
                monthYear.textContent = `${getMonthName(month)} ${year}`;

                // Tạo một ngày bắt đầu từ tháng và năm
                let firstDay = new Date(year, month, 1);

                // Điền các ô trống cho ngày bắt đầu
                for (let i = 0; i < firstDay.getDay(); i++) {
                    let cell = document.createElement("td");
                    calendarBody.appendChild(cell);
                }

                // Điền các ô với ngày trong tháng
                while (firstDay.getMonth() === month) {
                    let cell = document.createElement("td");
                    cell.textContent = firstDay.getDate();
                    calendarBody.appendChild(cell);

                    // Highlight ngày hiện tại
                    if (firstDay.toDateString() === currentDate.toDateString()) {
                        cell.classList.add("today");
                    }

                    // Nếu ngày là Chủ nhật thì kết thúc hàng và bắt đầu hàng mới
                    if (firstDay.getDay() === 6) {
                        calendarBody.appendChild(document.createElement("tr"));
                    }

                    firstDay.setDate(firstDay.getDate() + 1);
                }

                // Điền các ô trống ở cuối tháng
                while (calendarBody.children.length % 7 !== 0) {
                    let cell = document.createElement("td");
                    calendarBody.appendChild(cell);
                }
            }

            function getMonthName(month) {
                const monthNames = ["January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"
                ];
                return monthNames[month];
            }

            prevMonthBtn.addEventListener("click", function() {
                currentMonth--;
                if (currentMonth < 0) {
                    currentMonth = 11;
                    currentYear--;
                }
                renderCalendar(currentMonth, currentYear);
            });

            nextMonthBtn.addEventListener("click", function() {
                currentMonth++;
                if (currentMonth > 11) {
                    currentMonth = 0;
                    currentYear++;
                }
                renderCalendar(currentMonth, currentYear);
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>