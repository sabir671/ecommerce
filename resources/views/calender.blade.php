<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calendar</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.css">

    <style>
        .button-container {
            display: flex;
            justify-content: flex-end;
        }

        .current-day {
            background-color: rgb(121, 213, 121) !important;
            color: white !important;
        }

    </style>
</head>
<body>
                {{-- modal to show details of event  --}}
                <!-- Event Details Modal -->
<div class="modal fade" id="eventDetailsModal" tabindex="-1" aria-labelledby="eventDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventDetailsModalLabel">Event Details</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="eventDetailsTitle"></div>
                <div id="eventDetailsDescription"></div>
                <div id="eventDetailsStartDate"></div>
                <div id="eventDetailsEndDate"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>





    <div class="container mt-5" style="max-width: 700px">
        <h2 class="h2 text-center mb-5 border-bottom pb-3">FullCalendar</h2>
        <div class="button-container">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Create
            </button>
        </div>
        <br>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Title</label>
                                <input type="text" class="form-control" id="recipient-name" name="title">
                            </div>
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">Description:</label>
                                <textarea class="form-control" id="message-text" name="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="start-date">Start Date:</label>
                                <input type="date" class="form-control" id="start-date" name="start_date">
                            </div>

                            <div class="form-group">
                                <label for="date">End Date</label>
                                <input type="date" class="form-control" id="end-date" name="end_date">
                            </div>
                            <div class="form-group">
                                <label for="color">Event Color:</label>
                                <input type="color" class="form-control" id="eventColor" name="color">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="submitEvent">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        <div id='full_calendar_events'></div>
    </div>

    {{-- Scripts --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>

    <script>
     $(document).ready(function() {
    var SITEURL = window.location.origin;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var calendar = $('#full_calendar_events').fullCalendar({
        editable: true,
        events: SITEURL + "/calender-event",
        displayEventTime: true,
        viewRender: function(view, element) {
            var today = moment().format('YYYY-MM-DD');
            $('.fc-day').removeClass('current-day');
            $('.fc-day[data-date="' + today + '"]').addClass('current-day');
        },
        selectable: true,
        selectHelper: true,
        select: function(event_start, event_end, allDay) {
            var event_name = prompt('Event Name:');
            var event_color = $('#eventColor').val();

            if (event_name) {
                var event_start = $.fullCalendar.formatDate(event_start, "Y-MM-DD HH:mm:ss");
                var event_end = $.fullCalendar.formatDate(event_end, "Y-MM-DD HH:mm:ss");

                $.ajax({
                    url: SITEURL + "/calender-crude-ajax",
                    data: {
                        event_name: event_name,
                        event_start: event_start,
                        event_end: event_end,
                        event_color: event_color,
                        type: 'create'
                    },
                    type: "POST",
                    success: function(data) {
                        console.log("Data sent to server:", data); // Log the data sent to the server
                        displayMessage("Event created.");
                        calendar.fullCalendar('refetchEvents');
                        calendar.fullCalendar('unselect');
                    }
                });
            }
        },
        eventDrop: function(event, delta) {
            var event_start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
            var event_end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
            $.ajax({
                url: SITEURL + '/calender-crude-ajax',
                data: {
                    title: event.event_name,
                    start: event_start,
                    end: event_end,
                    id: event.id,
                    type: 'edit'
                },
                type: "POST",
                success: function(response) {
                    displayMessage("Event updated");
                }
            });
        },
        eventClick: function(event) {
            $('#eventDetailsTitle').text('Title: ' + event.title);
            // $('#eventDetailsDescription').text('Description: ' + event.description);
            // $('#eventDetailsStartDate').text('Start Date: ' + moment(event.start).format('YYYY-MM-DD'));
            // $('#eventDetailsEndDate').text('End Date: ' + moment(event.end).format('YYYY-MM-DD'));

            $('#eventDetailsModal').modal('show');
        },
        eventRender: function(event, element) {
            var start = moment(event.start);
            var end = moment(event.end);

            var duration = end.diff(start, 'days');

            element.css('background-color', event.color);
            element.addClass('custom-color-event');

            if (duration > 0) {
                for (var i = 1; i <= duration; i++) {
                    var date = start.clone().add(i, 'days').format('YYYY-MM-DD');
                    $('.fc-day[data-date="' + date + '"]').css('background-color', event.color);
                }
            }
        }
    });


    function displayMessage(message) {
        toastr.success(message, 'Event');
    }

    flatpickr("#date", {
        mode: "range",
        dateFormat: "Y-m-d"
    });

    // Modal submission
    $('#submitEvent').on('click', function() {
        var title = $('#recipient-name').val();
        var description = $('#message-text').val();
        var startDate = $('#start-date').val();
        var endDate = $('#end-date').val();
        var color = $('#eventColor').val();

        $.ajax({
            url: SITEURL + "/calender-crude-ajax",
            type: "POST",
            data: {
                title: title,
                description: description,
                start_date: startDate,
                end_date: endDate,
                color: color,
                type: 'create'
            },
            success: function(data) {
                displayMessage("Event created.");

                // Close the modal after successful submission
                $('#exampleModal').modal('hide');

                // Optionally, you can clear the form inputs here
                $('#recipient-name').val('');
                $('#message-text').val('');
                $('#start-date').val('');
                $('#end-date').val('');
                $('#eventColor').val('');

                // Refresh the calendar to fetch and display the latest events
                calendar.fullCalendar('refetchEvents');
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    });
});


    </script>
</body>
</html>
