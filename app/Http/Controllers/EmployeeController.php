<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $this->authorize('admin-access');
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $this->authorize('admin-access');

        $request->validate([
            'employee_id' => 'required|unique:employees',
            'name' => 'required',
            'email' => 'required|email|unique:employees',
            'dob' => 'required|date',
            'doj' => 'required|date',
        ]);

        Employee::create($request->all());
        return redirect()->route('employees.index')->with('success', 'Employee created successfully');
    }

    public function edit(Employee $employee)
    {
        $this->authorize('admin-access');
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $this->authorize('admin-access');

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'dob' => 'required|date',
            'doj' => 'required|date',
        ]);

        $employee->update($request->all());
        return redirect()->route('employees.index')->with('success', 'Employee updated');
    }

    public function destroy(Employee $employee)
    {
        $this->authorize('admin-access');
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted');
    }
}
