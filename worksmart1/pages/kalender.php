<?php
require '../controllers/function.php';
checkAuth();

$events = getEvents();
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Kalender - WorkSmart</title>
  <meta content="WorkSmart" name="description">
  <meta content="WorkSmart" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/logo-worksmart.png" rel="icon">
  <link href="assets/img/logo-worksmart.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link href="assets/css/brand.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/brand.css" rel="stylesheet">

    <style>
        /* Custom styles for the calendar */
        #calendar {
            max-width: 100%;
            margin: 40px auto;
            height: auto !important;
        }
        
        .fc {
            font-size: 14px;
        }
        
        .fc-toolbar-title {
            font-size: 1.75em !important;
        }

        h2{
            color: #02396f!important;
        }
        
        /* Responsive styles */
        @media (max-width: 768px) {
            .fc {
                font-size: 12px;
            }
            
            .fc-toolbar-title {
                font-size: 1.2em !important;
            }
            
            .fc-toolbar {
                flex-direction: column;
                gap: 10px;
            }
            
            .fc-toolbar-chunk {
                display: flex;
                justify-content: center;
                width: 100%;
            }
            
            .fc-button {
                padding: 0.2em 0.4em !important;
            }
            
            .fc-event {
                font-size: 0.9em;
            }
            
            .fc-daygrid-event {
                white-space: normal !important;
            }
        }
        
        @media (max-width: 480px) {
            .fc {
                font-size: 10px;
            }
            
            .fc-toolbar-title {
                font-size: 1em !important;
            }
            
            .fc-header-toolbar {
                margin-bottom: 0.5em !important;
            }
            
            .fc-daygrid-day-number {
                padding: 2px !important;
            }
        }
        
        /* Event styles */
        .fc-event {
            margin: 2px 0;
            padding: 2px;
            cursor: pointer;
        }
        
        .fc-daygrid-event-dot {
            display: none;
        }
        
        .fc-event-time {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <?php require 'header.php'; ?>
    <?php require 'sidebar.php'; ?>

    <main id="main" class="main brand-bg-color">

        <div class="pagetitle">
            <h1 class="text-light">Kalender Kegiatan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active">Kalender</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <?php require 'alert.php'; ?>
<section class="section dashboard">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer brand-bg-color">
        <div class="copyright text-light">
            © Copyright <strong><span>WorkSmart</span></strong>. All Rights Reserved
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

    <script>
        const eventsData = <?= json_encode($events); ?>;
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: window.innerWidth < 768 ? 'dayGridDay' : 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                titleFormat: { 
                    month: 'long',
                    year: 'numeric'
                },
                events: eventsData,
                editable: true,
                selectable: true,
                displayEventTime: true,
                displayEventEnd: true,
                eventClassName: 'eventsStyle',
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },
                eventClick: function(info) {
                    const event = info.event;
                    const start = event.start;
                    const end = event.end;
                    
                    const eventDetails = `Detail Event:\nJudul: ${event.title}\nWaktu Mulai: ${start.toLocaleString()}\nWaktu Selesai: ${end.toLocaleString()}`;
                    
                    if (confirm(eventDetails + '\n\nApakah Anda ingin menyimpan event ini ke Google Calendar?')) {
                        const startDate = start.toISOString().replace(/-|:|\.\d+/g, '');
                        const endDate = end.toISOString().replace(/-|:|\.\d+/g, '');
                        
                        const googleCalendarUrl = `https://www.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(event.title)}&dates=${startDate}/${endDate}&details=${encodeURIComponent(event.title)}`;
                        
                        window.open(googleCalendarUrl, '_blank');
                    }
                },
                titleClassNames: 'brand-color',
                eventContent: function(arg) {
                    let timeText = '';
                    if (arg.event.start) {
                        timeText += arg.event.start.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit', hour12: false});
                    }
                    if (arg.event.end) {
                        timeText += ' - ' + arg.event.end.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit', hour12: false});
                    }
                    return {
                        html: '<div style="white-space: normal;">' + 
                              '<strong>' + timeText + '</strong><br>' +
                              arg.event.title + '</div>'
                    }
                },
                windowResize: function(view) {
                    if (window.innerWidth < 768) {
                        calendar.changeView('dayGridDay');
                    } else {
                        calendar.changeView('dayGridMonth');
                    }
                }
            });

            calendar.render();
        });
    </script>
</body>

</html>