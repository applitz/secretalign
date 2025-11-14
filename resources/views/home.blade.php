@extends('layouts.app_base_horizontal')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18" >Dashboard</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Welcome to Secret Clear Aligner System.</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    @if (Auth::user()->role == 'doctor' || Auth::user()->role == 'staff' || Auth::user()->role == 'lab' || Auth::user()->role == 'advisor')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Tasks</h4>
                    <p class="card-title-desc">Unfinished Tasks</p>

                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="tech-companies-1" class="table table-striped">
                                <thead>
                                    <tr>
                                        @if (Auth::user()->role != 'doctor' && Auth::user()->role != 'lab')
                                        <th>Doctor</th>
                                        @endif
                                        @if(Auth::user()->role == 'doctor' || Auth::user()->role == 'staff' || Auth::user()->role == 'lab' || Auth::user()->role == 'advisor')
                                        <th>Patient</th>
                                        @endif
                                        <th>Task</th>
                                        @if(Auth::user()->role == 'staff')
                                        <th>From</th>
                                        @endif
                                        <th>{{Auth::user()->role == 'lab' ? 'Task Date' : 'Date'}}</th>
                                        @if(Auth::user()->role == 'lab')
                                        <th>Treatment Plan</th>
                                        @endif
                                        @if (Auth::user()->role == 'doctor')
                                        <th>Due Date</th>
                                        @endif
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($tasks) == 0)
                                    <tr>
                                        <td colspan="6" class="text-center"> No Tasks To Show </td>
                                    </tr>
                                    @else
                                    @foreach ($tasks as $task)
                                    <tr>
                                        @if (Auth::user()->role != 'doctor' && Auth::user()->role != 'lab')
                                        <td class="text-nowrap">{{ $task->first_name . ' ' . $task->last_name }}</td>
                                        @endif
                                        @if(Auth::user()->role == 'doctor' || Auth::user()->role == 'staff' || Auth::user()->role == 'lab' || Auth::user()->role == 'advisor')
                                        <td class="text-nowrap">{{ $task->p_first_name . ' ' . $task->p_last_name }}
                                        </td>
                                        @endif
                                        <td class="text-nowrap">
                                            <div class="font-sans-serif btn-reveal-trigger">
                                                @php
                                                    $badgeClass = 'badge-soft-info';
                                                    if (str_contains($task->task, 'Review Setup')) {
                                                        if(Auth::user()->role == 'lab')
                                                            $task->task = str_replace("Review Setup", "Production", $task->task);
                                                        $badgeClass = 'badge-soft-primary';
                                                    }
                                                    if (str_contains($task->task, 'Setup')) {
                                                        $badgeClass = 'badge-soft-warning';
                                                    }
                                                    if (str_contains($task->task, 'Modification Setup')) {
                                                        $badgeClass = 'badge-soft-danger';
                                                    }
                                                    if (str_contains($task->task, 'production')) {
                                                        $badgeClass = 'badge-soft-primary';
                                                    }
                                                @endphp
                                                <a class="btn btn-link {{ $badgeClass }} text-600 btn-sm btn-reveal-sm transition-none"
                                                href="{{ url('/patient/case-overview/' . $hashids->encode($task->treatment_plan_id)) }}"
                                                data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                                                    {{ $task->task }}
                                                </a>
                                            </div>
                                        </td>
                                        @if(Auth::user()->role == 'staff')
                                        <td class="text-nowrap">
                                        @if($task->previous_case_holder)
                                            {{ucfirst($task->previous_case_holder)}}
                                        @endif
                                        </td>
                                        @endif
                                        <td class="text-nowrap">{{ date('d/m/Y', strtotime($task->created_at)) }}
                                        </td>
                                        @if(Auth::user()->role == 'lab')
                                        <td class="text-nowrap">
                                            <span class="badge fw-semi-bold rounded-pill status badge-soft-info">Phase {{$task->phase}}</span>
                                        </td>
                                        @endif
                                        @if(Auth::user()->role == 'doctor')
                                        <td class="text-nowrap">
                                            @if(@$task->cancellation_date)
                                            {{date("Y-m-d", strtotime("-1 day", strtotime(date("Y-m-d",
                                            strtotime($task->cancellation_date)))))}}
                                            @endif
                                        </td>
                                        @endif
                                        {{-- <td class="text-nowrap"><span
                                                class="badge fw-semi-bold rounded-pill status badge-soft-primary">{{ 'Phase' .
                                                $task->phase }}</span>
                                        </td> --}}
                                        <td class="text-end text-nowrap">
                                            <div class="font-sans-serif btn-reveal-trigger">
                                                <a class="btn btn-link text-600 btn-sm btn-reveal-sm transition-none"
                                                    href="{{ url('/patient/case-overview/' . $hashids->encode($task->treatment_plan_id)) }}"
                                                    data-boundary="viewport" aria-haspopup="true" aria-expanded="false">Case
                                                    Overview</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif

                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12 ">
                                {{ $tasks->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endif



<div class="row">
    @foreach($events as $event)
    <div class="col-md-4 col-sm-6 col-12">
        <div
        @if($event->external_link)
        style="cursor:pointer;"
        onclick="window.location.href='{{$event->external_link}}'"
        @endif
        class="card border border-2 border-primary shadow">
            <div class="card-body p-3" >
                <h3 class="mt-0 mb-1 fw-bolder text-primary" style="text-transform: uppercase">{{$event->event_name}}</h3>
                <h4 class=" fw-bolder mb-1 mt-0">{{date("M d", strtotime($event->date))}}</h4>
                <div style="max-height: 95px;overflow: hidden">
                    <p class="card-title-desc mb-1 fs-9">{{$event->description}}</p>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>





    {{-- <div class="row">
        <div class="col-12">

            <div class="row mb-4">
                <div class="col-lg-3 d-none">
                    <div class="card mb-0  h-100">
                        <div class="card-body">
                            <button class="btn font-16 btn-primary w-100" id="btn-new-event"><i
                                    class="mdi mdi-plus-circle-outline"></i> Create
                                New Event</button>


                            <div id="external-events" class="m-t-20">
                                <br>
                                <p class="text-muted">Drag and drop your event or click in the calendar
                                </p>
                                <div class="external-event fc-event bg-success" data-class="bg-success">
                                    <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>New
                                    Event Planning
                                </div>
                                <div class="external-event fc-event bg-info" data-class="bg-info">
                                    <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Meeting
                                </div>
                                <div class="external-event fc-event bg-warning" data-class="bg-warning">
                                    <i
                                        class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Generating
                                    Reports
                                </div>
                                <div class="external-event fc-event bg-danger" data-class="bg-danger">
                                    <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Create
                                    New theme
                                </div>
                            </div>

                        </div>
                    </div>
                </div> <!-- end col-->

                <div class="col-lg-12">
                    <div class="card mb-0">
                        <div class="card-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div> <!-- end col -->

            </div>

            <div style='clear:both'></div>

            <!-- Add New Event MODAL -->
            <div class="modal fade" id="event-modal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">

                            <h5 class="modal-title" id="modal-title">Event</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <form class="needs-validation" name="event-form" id="form-event" novalidate>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Event Name</label>
                                            <input class="form-control" placeholder="Insert Event Name"
                                                type="text" name="title" id="event-title" required
                                                value="" />
                                            <div class="invalid-feedback">Please provide a valid event
                                                name</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">External Link</label>
                                            <input class="form-control" placeholder="Link"
                                                type="text" name="link" id="event-link" required
                                                value="" />
                                            <div class="invalid-feedback">External Link</div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Category</label>
                                            <select class="form-select" name="category" id="event-category">
                                                <option value="bg-danger" selected>Danger</option>
                                                <option value="bg-success">Success</option>
                                                <option value="bg-primary">Primary</option>
                                                <option value="bg-info">Info</option>
                                                <option value="bg-dark">Dark</option>
                                                <option value="bg-warning">Warning</option>
                                            </select>
                                            <div class="invalid-feedback">Please select a valid event
                                                category</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-danger"
                                            id="btn-delete-event">Delete</button>
                                    </div>
                                    <div class="col-6 text-end">
                                        <button type="button" class="btn btn-light me-1"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success"
                                            id="btn-save-event">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> <!-- end modal-content-->
                </div> <!-- end modal dialog-->
            </div>
            <!-- end modal-->
        </div>
    </div>
    <!-- end row --> --}}

    {{-- <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <h5><span class="text-primary">{{DB::table('blogs')->where('is_deleted', 0)->count()}}</span>+ Blogs & Tutorials</h5>
                    </div>
                    <div class="mb-3">
                        <i class="fas fa-quote-left h4 text-primary"></i>
                    </div>
                    <div id="reviewExampleControls" class="carousel slide review-carousel"
                        data-ride="carousel">

                        <div class="carousel-inner">
                            @foreach($blogs as $blog)
                            <div class="carousel-item {{$loop->iteration == 1 ? 'active' : ''}}">
                                <div>
                                    <p>{{substr($blog->description, 0, 200)}}</p>
                                    <div class="d-flex align-items-start mt-4">
                                        <div class="flex-1">
                                            <h5 class="font-size-16 mb-1">{{$blog->blog_name}}</h5>
                                            <p class="mb-2">{{date("M d", strtotime($blog->created_at))}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <a class="carousel-control-prev" href="#reviewExampleControls" role="button"
                            data-bs-slide="prev">
                            <i class="mdi mdi-chevron-left carousel-control-icon"></i>
                        </a>
                        <a class="carousel-control-next" href="#reviewExampleControls" role="button"
                            data-bs-slide="next">
                            <i class="mdi mdi-chevron-right carousel-control-icon"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>



    </div> --}}

</div>

@endsection


@section('javascript')
{{-- @php
$eventsArr = [];
foreach($events as $event) {
    array_push($eventsArr, (object) [
        "title" => $event->event_name,
                "start" => $event->date,
                "allDay" => true,
                "className" => $event->category,
                "extendedProps" => [
                    "eventId" => $event,
                    "eventLink" => $event->external_link,
                ]
    ]);
}
$eventsArr = json_encode($eventsArr);
@endphp --}}
  <!-- plugin js -->
  <script src="{{ asset('public') }}/qovex/assets/libs/moment/min/moment.min.js"></script>
  <script src="{{ asset('public') }}/qovex/assets/libs/jquery-ui-dist/jquery-ui.min.js"></script>
  <script src="{{ asset('public') }}/qovex/assets/libs/fullcalendar/index.global.min.js"></script>

  <!-- Calendar init -->
  {{-- <script src="{{ asset('public') }}/qovex/assets/js/pages/calendar.init.js"></script> --}}
  {{-- <script>
    // Wait for the DOM content to be fully loaded before executing the script
document.addEventListener("DOMContentLoaded", function () {
    // Initialize Bootstrap Modal
    var eventModal = new bootstrap.Modal(document.getElementById("event-modal"), { keyboard: !1 });

    // Get references to DOM elements
    var modalTitleElement = document.getElementById("modal-title");
    var formEventElement = document.getElementById("form-event");
    var calendarElement = document.getElementById("calendar");

    // Variables for event handling
    var selectedEvent = null;
    var currentDraggedEvent = null;

    // Get current date
    var currentDate = new Date();
    var currentDay = currentDate.getDate();
    var currentMonth = currentDate.getMonth();
    var currentYear = currentDate.getFullYear();

    // Define external events for dragging onto the calendar
    var externalEvents = new FullCalendar.Draggable(document.getElementById("external-events"), {
        itemSelector: ".external-event",
        eventData: function (eventElement) {
            return {
                title: eventElement.innerText,
                start: new Date(),
                className: eventElement.getAttribute("data-class"),
            };
        },
    });

    // Array of sample events
    var sampleEvents = JSON.parse(`<?php echo $eventsArr; ?>`) ?? [];

    // Initialize FullCalendar
    var calendar = new FullCalendar.Calendar(calendarElement, {
        timeZone: "local",
        editable: true,
        droppable: true,
        selectable: true,
        initialView: determineInitialView(),
        themeSystem: "bootstrap",
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth",
        },
        windowResize: function () {
            // Adjust the view when the window is resized
            var view = determineInitialView();
            calendar.changeView(view);
        },
        eventDidMount: function (eventInfo) {
            // Customize the appearance of events after they are rendered
            if (eventInfo.event.extendedProps.status === "done") {
                eventInfo.el.style.backgroundColor = "red";
                var eventDot = eventInfo.el.getElementsByClassName("fc-event-dot")[0];
                if (eventDot) {
                    eventDot.style.backgroundColor = "white";
                }
            }
        },
        eventClick: function (eventClickInfo) {
            // Handle click on an event
            showEditEventForm(eventClickInfo);
        },
        dateClick: function (dateClickInfo) {
            // Handle click on a date to add a new event
            showAddEventForm(dateClickInfo);
        },
        events: sampleEvents,
    });

    // Render the calendar
    calendar.render();

    // Event listener for form submission
    formEventElement.addEventListener("submit", function (event) {
        event.preventDefault();
        handleEventFormSubmission();
    });

    // Event listener for the delete button
    document.getElementById("btn-delete-event").addEventListener("click", function () {
        deleteSelectedEvent();
    });

    // Event listener for the "New Event" button
    document.getElementById("btn-new-event").addEventListener("click", function () {
        showAddEventForm({ date: new Date(), allDay: true });
    });

    // Function to determine the initial view based on window width
    function determineInitialView() {
        if (window.innerWidth >= 768 && window.innerWidth < 1200) {
            return "timeGridWeek";
        } else if (window.innerWidth <= 768) {
            return "listMonth";
        } else {
            return "dayGridMonth";
        }
    }

    // Function to show the form for adding a new event
    function showAddEventForm(dateInfo) {
        @if(Auth::user()->role != 'admin' && Auth::user()->role != 'superadmin')
        return false;
        @endif
        document.getElementById("btn-delete-event").style.display = "none";
        resetEventForm();
        selectedEvent = null;
        modalTitleElement.innerText = "Add Event";
        currentDraggedEvent = dateInfo;
        eventModal.show();
    }

    // Function to show the form for editing an existing event
    function showEditEventForm(eventClickInfo) {

        document.getElementById("btn-delete-event").style.display = "block";
        resetEventForm();
        selectedEvent = eventClickInfo.event;
        @if(Auth::user()->role != 'admin' && Auth::user()->role != 'superadmin')
        if(selectedEvent.extendedProps.eventLink != "" || selectedEvent.extendedProps.eventLink == null || selectedEvent.extendedProps.eventLink != undefined) {
            window.open(selectedEvent.extendedProps.eventLink, '_blank');
        }
        return false;
        @endif
        modalTitleElement.innerText = "Edit Event";
        document.getElementById("event-title").value = selectedEvent.title;
        document.getElementById("event-link").value = selectedEvent.extendedProps.eventLink;
        document.getElementById("event-category").value = selectedEvent.classNames[0];
        currentDraggedEvent = null;
        eventModal.show();
    }

    // Function to handle form submission for adding/editing events
    function handleEventFormSubmission() {
        var eventTitle = document.getElementById("event-title").value;
        var eventLink = document.getElementById("event-link").value;
        var eventCategory = document.getElementById("event-category").value;

        if (!validateForm()) {
            return;
        }

        if (selectedEvent) {
            $.ajax({
                type: "POST",
                url: "{{url('/events/update')}}",
                data: {
                    "_token" : "{{ csrf_token() }}",
                    "eventId" : selectedEvent._def.extendedProps.eventId.id,
                    "title" : eventTitle,
                    "link" : eventLink,
                    "category" : eventCategory,
                }
            }).done(function (response) {
// Edit existing event
selectedEvent.setProp("title", eventTitle);
            selectedEvent.setProp("classNames", [eventCategory]);
            selectedEvent.setExtendedProp("eventLink", eventLink);

            });
        } else {
            $.ajax({
                type: "POST",
                url: "{{url('/events/save')}}",
                data: {
                    "_token" : "{{ csrf_token() }}",
                    "date": moment(currentDraggedEvent.date).format("YYYY-MM-DD"),
                    "title": eventTitle,
                    "category" : eventCategory,
                    "link" : eventLink,
                }
            }).done(function (response) {
                // Add new event
            var newEvent = {
                title: eventTitle,
                start: currentDraggedEvent.date,
                allDay: currentDraggedEvent.allDay,
                className: eventCategory,
                extendedProps: {
                    eventId : response,
                    eventLink : eventLink,
                }
            };
            calendar.addEvent(newEvent);
            });
        }

        eventModal.hide();
    }

    // Function to reset the event form
    function resetEventForm() {
        formEventElement.classList.remove("was-validated");
        formEventElement.reset();
    }

    // Function to delete the selected event
    function deleteSelectedEvent() {
$.ajax({
    type: "POST",
    url: "{{url('/events/delete')}}",
    data: {
        "_token" : "{{ csrf_token() }}",
        "eventId" : selectedEvent._def.extendedProps.eventId.id
    }
}).done(function (response) {
    if (selectedEvent) {
            selectedEvent.remove();
            selectedEvent = null;
        }
        eventModal.hide();
});

    }

    // Function to validate the event form
    function validateForm() {
        var formIsValid = formEventElement.checkValidity();
        formEventElement.classList.add("was-validated");
        return formIsValid;
    }
});

  </script> --}}
@stop
