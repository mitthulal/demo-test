@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Employee List</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @can('admin-access')
        <div class="mb-3 text-end">
            <a href="{{ route('employees.create') }}" class="btn btn-primary">+ Create Employee</a>
        </div>
    @endcan

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Emp ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>DOB</th>
                <th>DOJ</th>
                @can('admin-access')
                    <th>Actions</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @forelse ($employees as $employee)
                <tr>
                    <td>{{ $employee->employee_id }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->dob }}</td>
                    <td>{{ $employee->doj }}</td>
                    @can('admin-access')
                        <td>
                            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')" type="submit">Delete</button>
                            </form>
                        </td>
                    @endcan
                </tr>
            @empty
                <tr>
                    <td colspan="@can('admin-access') 6 @else 5 @endcan" class="text-center">No employees found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
