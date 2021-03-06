<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Company;
use App\Models\Employee;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        return view('employees.index', [
            'employees' => Employee::query()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): \Illuminate\Contracts\View\View
    {
        return view('employees.create', [
            'companies' => Company::all(['id', 'name'])
                ->pluck('name', 'id')
                ->toArray()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EmployeeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(EmployeeRequest $request): \Illuminate\Http\RedirectResponse
    {
        Employee::create($request->validated());

        return redirect()->back()
            ->with(['response' => __('response.success.create')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Employee $employee
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Employee $employee): \Illuminate\Contracts\View\View
    {
        return view('employees.edit', [
            'companies' => Company::all(['id', 'name'])
                ->pluck('name', 'id')
                ->toArray(),
            'employee' => $employee,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EmployeeRequest $request
     * @param Employee $employee
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(EmployeeRequest $request, Employee $employee): \Illuminate\Http\RedirectResponse
    {
        $employee->update($request->validated());

        return redirect()->back()
            ->with(['response' => __('response.success.edit')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Employee $employee
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Employee $employee): \Illuminate\Http\RedirectResponse
    {
        $employee->delete();

        return redirect()->back()
            ->with(['response' => __('response.success.delete')]);
    }
}
