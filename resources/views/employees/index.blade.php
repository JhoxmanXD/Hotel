@extends('layouts.app')

@section('content')

    <div class="card mt-2">
        <div class="card-header">
            <a href="{{ route('employees.create') }}" class="btn btn-primary float-right" title="Nuevo">
                <i class="fas fa-plus nav-icon"></i>
            </a>
            <h3 class="card-title">Empleados</h3>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th width="10px">ID</th>
                        <th>Name</th>
                        <th>Document Number</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Acciones</th> </tr>
                </thead>
                <tbody>

                    @foreach($employees as $employee)
                        <tr>
                            <td>{{ $employee->id }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->documentNumber }}</td>
                            <td>{{ $employee->address }}</td>
                            <td>{{ $employee->phone }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>
                                @can('employees.edit')
                                    {{-- CORREGIDO: Cambié $ciudad->id por $employee->id --}}
                                    <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-info btn-sm"
                                        title="Editar"><i class="fas fa-pencil-alt"></i></a>
                                @endcan
                                @can('employees.destroy')
                                    <form class="d-inline delete-form" action="{{ route('employees.destroy', $employee) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Eliminar"><i
                                                class="fas fa-trash-alt"></i></button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
        </div>

@endsection
