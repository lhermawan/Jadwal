@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <h1 class="mb-4">Selamat Datang di Aplikasi Shift</h1>
    <p class="mb-4">Silakan pilih salah satu menu di bawah:</p>

    <div class="row justify-content-center">
        <div class="col-md-4">
            <a href="{{ route('schedule.index') }}" class="btn btn-primary btn-lg w-100">Lihat Jadwal Shift</a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('employees.index') }}" class="btn btn-secondary btn-lg w-100">Manajemen Karyawan</a>
        </div>
    </div>
</div>
@endsection
