@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Add New Employee</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Errors:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employees.store') }}" method="POST" class="mt-3">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="employee_id" class="form-label">Employee ID</label>
                <input type="text" name="employee_id" id="employee_id" class="form-control" value="{{ old('employee_id') }}" required>
            </div>
            <div class="col-md-6">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="col-md-3">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" name="dob" id="dob" class="form-control" value="{{ old('dob') }}" required>
            </div>
            <div class="col-md-3">
                <label for="doj" class="form-label">Date of Joining</label>
                <input type="date" name="doj" id="doj" class="form-control" value="{{ old('doj') }}" required>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-success">Save Employee</button>
        </div>
    </form>
</div>
@endsection
