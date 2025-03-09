@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Form Report Mingguan</h2>

    <form action="{{ route('reports.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="week" class="form-label">Minggu Ke</label>
            <input type="number" class="form-control" name="week" required>
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Tanggal Mulai</label>
            <input type="date" class="form-control" name="start_date" required>
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">Tanggal Selesai</label>
            <input type="date" class="form-control" name="end_date" required>
        </div>

        <div class="mb-3">
            <label for="call_data" class="form-label">Data Call Taker</label>
            <textarea class="form-control" name="call_data" rows="5" required></textarea>
            <small>Format: Nama, Normal Call, Prank Call, Ghost Call, Total, Keterangan</small>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Report</button>
    </form>
</div>
@endsection
