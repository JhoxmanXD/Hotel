@extends('layouts.app')

@section('content')

    <div class="card mt-2">
        <div class="card-header">
            <a href="{{ route('roomtypes.create') }}" class="btn btn-primary float-right" title="Nuevo">
                <i class="fas fa-plus nav-icon"></i>
            </a>
            <h3 class="card-title">Tipos de Habitación</h3>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>name</th>
                        <th>description</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roomtypes as $roomtype)
                        <tr>
                            <td>{{ $roomtype->name }}</td>
                            <td>{{ $roomtype->description }}</td>
                            <td>
                                <a href="{{ route('roomtypes.edit', $roomtype) }}" class="btn btn-info btn-sm" title="Editar">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form class="d-inline" action="{{ route('roomtypes.destroy', $roomtype) }}" method="POST"
                                      onsubmit="return confirm('¿Eliminar tipo de habitación?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection