@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Karyawan</h2>
    <form action="{{ route('employees.update', $employee) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" value="{{ $employee->name }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Role</label>
            <input type="number" name="role" value="{{ $employee->role }}" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('employees.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
