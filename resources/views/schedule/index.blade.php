@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Jadwal 112 - Bulanan</h2>

    <div class="d-flex justify-content-end gap-2 mb-3">
    <a href="{{ route('schedule.generate') }}" class="btn btn-primary">Generate Jadwal</a>
    <a href="{{ route('schedule.export') }}" class="btn btn-success">Export Laporan</a>
</div>

    <div id="calendar"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof FullCalendar !== 'undefined') {  // Cek apakah FullCalendar sudah dimuat
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,listWeek'
                },
                events: "{{ route('schedule.calendar') }}",
                eventDidMount: function(info) {
                    console.log(info.event.title);  // Debugging: Cek apakah event dimuat
                }
            });
            calendar.render();
        } else {
            console.error("FullCalendar gagal dimuat!");
        }
    });
</script>
@endsection
