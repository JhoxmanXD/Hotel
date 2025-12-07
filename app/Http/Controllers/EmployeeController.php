<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    // OJO: Solo uses este método si existe la columna 'estado' en la tabla.
    public function cambioestadoemployee(EmployeeRequest $request)
    {
        $employee = Employee::findOrFail($request->id);
        // Descomenta solo si tu tabla tiene 'estado'
        // $employee->estado = $request->estado;
        // $employee->save();
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(EmployeeRequest $request)
    {
        // Guarda únicamente los campos que existen en la tabla
        $data = $request->only(['name','documentNumber','address','phone','email']);
        Employee::create($data);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Empleado creado correctamente.');
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(EmployeeRequest $request, Employee $employee)
    {
        $data = $request->only(['name','documentNumber','address','phone','email']);
        $employee->update($data);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Empleado actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        try {
            $model = Employee::findOrFail($id);
            $model->delete();
            return redirect()->route('employees.index')->with('successMsg', 'El registro se eliminó exitosamente');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('employees.index')->withErrors('El registro que desea eliminar tiene información relacionada.');
        } catch (\Exception $e) {
            return redirect()->route('employees.index')->withErrors('Ocurrió un error inesperado al eliminar el registro.');
        }
    }
}